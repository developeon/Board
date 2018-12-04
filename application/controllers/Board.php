<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends MY_Controller {
        public function __construct() {
                parent::__construct();
                $this->load->model('post_model');
                $this->load->model('user_model');
                $this->load->model('comment_model');
        }

        public function index()
        {
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
                $page = $this->uri->rsegment(3,0);
                $data['pagination'] = $this->pagination->create_links();

                $data['posts'] = $this->post_model->gets($config['per_page'], $page);
                
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

        public function write_comment()
        {
                //TODO :없는 게시글 번호 입력했을때 DB에 등록되면 안됨!!
                
                checkIsLogin();
                $post_id = $this->input->post('post_id');
                $content = $this->input->post('content');
                if (!$post_id) //주소창 직접 접근
                {
                        $this->session->set_flashdata('message', '잘못된 접근입니다.');
                        redirect('/board');
                }
                if (!$content) //required 지운 경우 또는 name값을 수정한경우
                {
                        $this->session->set_flashdata('message', '댓글 내용을 입력하세요.');
                        redirect('/board/read/'.$post_id);
                }
               
                $this->comment_model->write($content, $post_id, $this->session->userdata('user_id'));
                redirect('/board/read/'.$post_id);
        }

        public function read($post_id)
        {
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
                
                $this->load->view('read', $data);
                $this->_footer();
        }

        public function update($post_id)
        {
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

        //TODO: 게시물 삭제 함수 생성
        public function delete()
        {
                $post_id = $this->uri->segment(3);
                $data['post'] = $this->post_model->get($post_id)->row();
                if (!$data['post'])
                {
                        $this->session->set_flashdata('message', '존재하지 않는 게시글입니다.');
                        redirect('/board');
                }
                checkWriter($data['post']->user_id);
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
}
