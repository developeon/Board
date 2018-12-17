<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mypage extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

	public function index()
	{
        $this->load->model('user_model');

        checkIsLogin();

        $data['user'] = $this->user_model->get($this->session->userdata('user_id'))->row();

        $this->_header();
        $this->load->view('mypage', $data);
        $this->_footer();
    }
    
    public function update()
    {
        $this->load->model('user_model');

        checkIsLogin();
        
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
                redirect('/mypage');
               
        }
    }

    public function sendEmail()
    {
        $this->load->model('email_auth_model');
        
        $email_hash = password_hash($this->input->post('email'), PASSWORD_BCRYPT);
        $expired_time = date("Y-m-d H:i:s", strtotime("+30 minutes"));
        $user_id = $this->input->post('user_id');

        $result = $this->email_auth_model->insert($email_hash, $expired_time, $user_id);
        //TODO: DB insert 에러 처리 후 메일 발송
    }
}