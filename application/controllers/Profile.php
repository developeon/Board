<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {
    public function index()
	{
        $this->load->model('user_model');
        $this->load->model('post_model');
        $this->load->model('comment_model');
        $this->load->model('bookmark_model');

        $this->_header();

        $user_id = $this->uri->rsegment(3, 0);
        $query = $this->user_model->get($user_id);
        if ($query->num_rows() < 1)
        {
            $this->session->set_flashdata('message', '접근 권한이 없습니다.');
            $this->load->helper('url');
            redirect('/');
            
        }
        $data['user'] = $query->result();
        $post_count = $this->post_model->getCount($user_id);
        $comment_count = $this->comment_model->getCount($user_id);
        $bookmark_count = $this->bookmark_model->getCount($user_id);
        $data['count'] = array("post" => $post_count, "comment" => $comment_count, "bookmark" => $bookmark_count);
        
        $this->load->view('profile', $data);

        $this->_footer();
    }

    public function getPosts()
    {
        $this->load->model('post_model');

        //echo $this->input->post('user_id');
        //TODO: user_id에 맞는 post 모두 출력!
        $result = $this->post_model->getsById($this->input->post('user_id'));
        echo json_encode($result);
    }

    public function getComments()
    {
        $this->load->model('comment_model');

        $result = $this->comment_model->getsById($this->input->post('user_id'));
        echo json_encode($result);
    }

    public function getBookmarks()
    {
        $this->load->model('bookmark_model');
        $this->load->model('post_model');

        $result = $this->bookmark_model->getsById($this->input->post('user_id'));
        //여기서 foreach돌면서 제목 추가하기
        //$this->post_model->get($post_id);

        if ($result)
        {
            foreach ($result as $bookmark) {
                    $bookmark->title = $this->post_model->get($bookmark->post_id)->row()->title;
            }
        }

        echo json_encode($result);
    }
}