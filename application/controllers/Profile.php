<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('user_model');
    }

	public function index()
	{
        // TODO: 로그인 안된 유저의 접근 막기, userdata넘겨주고 찍기
        $this->_header();
        $this->load->view('profile');
        $this->_footer();
    }
    
    public function update()
    {
        //TODO: 이 모든 작업은 파일 업로드를 했을때만 실행해야함!!!! 그거 체크하기 
        $config['upload_path'] = './includes/img/profile_picture';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 100;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload("profile_picture"))
        {
                $error = array('error' => $this->upload->display_errors());
                //$this->load->view('upload_form', $error);
                echo var_dump($error);
        }
        else
        {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data["upload_data"]["file_name"];
                $result = $this->user_model->updateProfilePicture($file_name);
                
                if (!$result)
                {
                    $this->session->set_flashdata('message', '프로필 수정에 실패했습니다.');
                }
                else
                {
                    $this->session->set_flashdata('message', '프로필이 수정되었습니다.');
                }
                $this->load->helper('url');
                redirect('/profile');
               
        }
    }
}