<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {
    public function index()
	{
        $this->load->model('user_model');

        $this->_header();

        $data['user_id'] = $this->uri->rsegment(3, 0);
        if ($this->user_model->get($data['user_id'])->num_rows() > 0)
        {
            $this->load->view('profile', $data);
        }
        else
        {
            $this->session->set_flashdata('message', '접근 권한이 없습니다.');
            $this->load->helper('url');
            redirect('/');
        }

        $this->_footer();
    }

    public function getPosts()
    {
        $this->load->model('post_model');

        //echo $this->input->post('user_id');
        //TODO: user_id에 맞는 post 모두 출력!
        //페이징 관련 config가 덮어쓰는거랬는데 이거 깊게 파보기
        $result = $this->post_model->getsById($this->input->post('user_id'));
        echo json_encode($result);
    }

    public function getComments()
    {
        $this->load->model('comment_model');

        $result = $this->comment_model->getsById($this->input->post('user_id'));
        echo json_encode($result);
    }
}