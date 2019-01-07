<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends MY_Controller {
        public function __construct() {
                parent::__construct();
                // $this->load->model('post_model');
                // $this->load->model('user_model');
                // $this->load->model('comment_model');
        }

        public function index()
        {
                $this->load->model('post_model');
                $this->load->model('user_model');

                $this->_header();

                $this->load->library('pagination');

                $config['base_url'] = '/board/index/';
                $config['total_rows'] = $this->post_model->getTotalRows();
                $config['per_page'] = 10; //한 페이지당 n개 출력

                $config['full_tag_open'] = '<ul class="pagination">';
                $config['full_tag_close'] = '</ul>';

                $config['first_link'] = '처음';
                $config['first_tag_open'] = '<li class="page-item">';
                $config['first_tag_close'] = '</li>';
                $config['last_link'] = '끝';
                $config['last_tag_open'] = '<li class="page-item">';
                $config['last_tag_close'] = '</li>';

                $config['prev_link'] = '&lt;';
                $config['prev_tag_open'] = '<li class="page-item">';;
                $config['prev_tag_close'] = '</li>';
                $config['next_link'] = '&gt;';
                $config['next_tag_open'] = '<li class="page-item">';
                $config['next_tag_close'] = '</li>';
                
                $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
                $config['cur_tag_close'] = '</a></li>';
                $config['num_tag_open'] = '<li class="page-item">';
                $config['num_tag_close'] = '</li>';

                $config['attributes'] = array('class' => 'page-link');

                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();

                $page = $this->uri->rsegment(3,0);
                $data['search_type'] = $this->input->post('search_type'); //$data['search_type']
                $data['search_text'] = $this->input->post('search_text');
                if ($data['search_type'] === 'user_id')
                {
                        $user_id = $this->user_model->getByName($data['search_text'])->user_id;
                        $data['search_text'] =  $user_id ? $user_id : -1;
                }

                $data['posts'] = $this->post_model->gets($config['per_page'], $page, $data['search_type'], $data['search_text']);
                
                $data['search_text'] = $this->input->post('search_text');

                if ($data['posts'])
                {
                        foreach ($data['posts'] as $post)
                        {
                                $post->user_name = $this->user_model->get($post->user_id)->row()->name;
                        }
                }
               
                $this->load->view('board', $data);
                $this->_footer();
        }

        public function write()
        {
                $this->load->model('post_model');

                checkIsLogin();
                $this->_header();
                $this->load->library('form_validation');
                $this->form_validation->set_rules('title', '제목', 'required');
                $this->form_validation->set_rules('content', '본문', 'required');
                if ($this->form_validation->run() == FALSE)
                {
                        $this->load->view('write');
                }
                else
                {
                      $post_id = $this->post_model->write($this->input->post('title'), $this->input->post('content'), $this->session->userdata('user_id'));
                      redirect('/board/read/'.$post_id);
                 }
                $this->_footer();
        }

        public function write_comment() //댓글 작성
        {
                //TODO :없는 게시글 번호 입력했을때 DB에 등록되면 안됨!!
                $this->load->model('comment_model');

                checkIsLogin();

                $post_id = $this->input->post('post_id');
                $content = $this->input->post('content');
                // if (!$post_id) //주소창 직접 접근
                // {
                //         $this->session->set_flashdata('message', '잘못된 접근입니다.');
                //         redirect('/board');
                // }
                // if (!$content) //required 지운 경우 또는 name값을 수정한경우
                // {
                //         $this->session->set_flashdata('message', '댓글 내용을 입력하세요.');
                //         redirect('/board/read/'.$post_id);
                // }
               
                // $this->comment_model->writeComment($content, $post_id, $this->session->userdata('user_id'));
                // redirect('/board/read/'.$post_id);
                echo $this->comment_model->writeComment($content, $post_id, $this->session->userdata('user_id'));
        }

        public function wrtie_reply() // 답글 작성
        {
                $this->load->model('comment_model');

                checkIsLogin();

                $content = $this->input->post('content');
                $post_id = $this->input->post('post_id');
                $root = $this->input->post('root');
                $depth = $this->input->post('depth') + 1;
                $seq = $this->input->post('seq') + 1;

                if ($depth===1)
                {
                        $seq = $this->comment_model->getSeq($root);
                }
                else
                {
                //         //만약 root와 depth가 같은게 있다면? 그 다음으로 가야함. 중간에 끼워넣는게 아니라. seq를 정해줘야할
                //       if($this->comment_model->test($root, $depth))
                //       {
                //               $max_seq = $this->comment_model->test2($root, $depth);
                //               //root와 depth가 같은 컬럼의 seq 최대값 +1로 insert를 하고 그 뒤에 있는 컬럼의 seq는 다 +1씩
                //               $seq =$max_seq[0]["max(seq)"] + 1;
                //       }
                //       else
                //       {
                        
                //       }

                      if($this->comment_model->test($root, $depth, $seq))
                      {
                        $count = 0;
                        $comments = $this->comment_model->getsTest($root, $seq);
                        //echo var_dump($comments);
                        //exit;
                        //while
                        foreach ($comments as $comment){
                                if($comment->depth < $depth) break;
                                $count++;
                                $seq = $comment->seq;
                        }
                        if($count > 0) $seq = $seq +1;
                      }
                      $this->comment_model->updateSeq($root, $seq); //끼워 넣기 전에 seq 업데이트
                }
                $insert_id = $this->comment_model->writeReply($content, $post_id, $this->session->userdata('user_id'), $root, $depth, $seq);
                echo $insert_id;

        } 
            
        public function read()
        {
                $this->load->model('post_model');
                $this->load->model('user_model');
                $this->load->model('bookmark_model');

                $post_id = $this->uri->segment(3,0);

                $this->post_model->increaseViews($post_id);
                $this->_header();
                $data['post'] = $this->post_model->get($post_id)->row();
                if (!$data['post'])
                {
                        $this->session->set_flashdata('message', '존재하지 않는 게시글입니다.');
                        redirect('/board');
                }
                $post_data = $this->user_model->get($data['post']->user_id)->row();
                $data['post']->user_name = $post_data->name;
                $data['post']->user_profile_picture = $post_data->profile_picture;

                $data['bookmark'] = $this->bookmark_model->getStatus($this->session->userdata('user_id'), $post_id) ? true : false;

                $this->load->view('read', $data);
                $this->_footer();
        }

        public function readComment()
        {
                $this->load->model('user_model');
                $this->load->model('comment_model');

                $post_id = $this->input->post('post_id');
                $data['comments'] = $this->comment_model->gets($post_id);
                $data['count'] = $this->comment_model->getTotalRows($post_id);
                if ($data['comments'])
                {
                        foreach ($data['comments'] as $comment) {
                                $comment_data = $this->user_model->get($comment->user_id)->row();
                                $comment->user_name = $comment_data->name;
                                $comment->user_profile_picture = $comment_data->profile_picture;
                        }
                }
                echo json_encode($data);
        }

        public function update($post_id)
        {
                $this->load->model('post_model');

                $data['post'] = $this->post_model->get($post_id)->row();
                if (!$data['post'])
                {
                        $this->session->set_flashdata('message', '존재하지 않는 게시글입니다.');
                        redirect('/board');
                }
                checkWriter($data['post']->user_id);
                $this->_header();
                $this->load->view('update', $data);
                $this->_footer();
        }

        public function update_proc($post_id)
        {
                $this->load->model('post_model');

                $data['post'] = $this->post_model->get($post_id)->row();
                if (!$data['post'])
                {
                        $this->session->set_flashdata('message', '존재하지 않는 게시글입니다.');
                        redirect('/board');
                }
                checkWriter($data['post']->user_id);
                if (!($this->input->post('title') && $this->input->post('content'))) { //비정상접근 또는 required 삭제 후 접근
                        $this->session->set_flashdata('message', '잘못된 접근입니다.');
                        redirect('/board/update/'.$post_id);
                }
                $result = $this->post_model->update($post_id, $this->input->post('title'), $this->input->post('content'));
                if ($result)
                {
                        $this->session->set_flashdata('message', '게시글이 수정되었습니다.'); 
                }
                else
                {
                        $this->session->set_flashdata('message', '게시글 수정에 실패했습니다.');
                }
                redirect('/board/read/'.$post_id);
        }

        public function delete()
        {     
                $this->load->model('post_model');
                $this->load->model('comment_model');
                $this->load->model('bookmark_model');

                $post_id = $this->uri->segment(3);
                $data['post'] = $this->post_model->get($post_id)->row();
                if (!$data['post'])
                {
                        $this->session->set_flashdata('message', '존재하지 않는 게시글입니다.');
                        redirect('/board');
                }
                checkWriter($data['post']->user_id);

                //해당 게시물에 대한 댓글이랑 북마크 다 지워주기 
                $this->comment_model->deleteByPost($post_id);
                $this->bookmark_model->deleteByPost($post_id);

                if ($this->post_model->delete($post_id))
                {
                        $this->session->set_flashdata('message', '게시글이 삭제되었습니다.'); 
                        redirect('/board');
                }
                else
                {
                        $this->session->set_flashdata('message', '게시글 삭제에 실패했습니다.');
                        redirect('/board/read/'.$post_id);
                }
        }

        public function deleteComment()
        {
                //TODO: 댓글 작성자가 맞는지 확인
                $this->load->model('comment_model');

                $comment_id = $this->input->post('comment_id');
                $result = $this->comment_model->delete($comment_id);
                echo $result;
        }

        public function comment() //댓글 주소를 복사해서 접속한경우(복사된 댓글과 댓글의 답글들을 출력)
        {
                $this->load->model('comment_model');
                $this->load->model('user_model');

                $comment_id = $this->uri->rsegment(3,0);
                //comment_id로 댓글 검색하고 없는경우 main으로 redirect
                //있는경우 view로 출력. 그리고 해당 댓글이 작성된 게시물로 돌아가기 버튼도 만들기
                // $data['comments'] = $this->comment_model->getAligned();
                
                $comment = $this->comment_model->getByCommentId($comment_id);
      
                // $data["comments"][0] = $comment;
                // $comment_data = $this->user_model->get($data["comments"][0][0]->user_id)->row();
                // $data["comments"][0][0]->user_name = $comment_data->name;
                // $data["comments"][0][0]->user_profile_picture = $comment_data->profile_picture;
               
                if(!empty($comment))
                {
                        $comments = $this->comment_model->getsTest($comment[0]->root, $comment[0]->seq);
                       
                        $depth = $comment[0]->depth;
                        $count = 0;
                        $flag = 0;
                        foreach ($comments as $comment){
                                $count++;
                                if($comment->depth <= $depth) {
                                        if($flag > 0) break;
                                        $flag++;
                                }
                                $comment_data = $this->user_model->get($comment->user_id)->row();
                                $comment->user_name = $comment_data->name;
                                $comment->user_profile_picture = $comment_data->profile_picture;
                                $data["comments"][$count] = $comment;
                        }
                }
                else
                {
                        $this->session->set_flashdata('message', '존재하지 않는 댓글입니다.');
                        redirect('/board');
                }

               
                //array받아온거 foreach 돌면서 자식 답글이 맞는지 확인하면서 새로운 array만들기
                $this->_header();
                $this->load->view('comment', $data);
                $this->_footer();
        }

        public function update_bookmark() //북마크 등록/해제
        {
                $this->load->model('bookmark_model');

                $user_id = $this->session->userdata('user_id');
                $post_id = $this->input->post('post_id');

                $bookmark = $this->bookmark_model->getStatusWithoutCheck($user_id, $post_id) ? true : false;
                if ($bookmark) 
                {
                        $bookmark_id = $this->bookmark_model->update($user_id, $post_id);
                }
                else
                {
                        $bookmark_id = $this->bookmark_model->insert($user_id, $post_id);
                }
                echo $bookmark_id;
        }
}
