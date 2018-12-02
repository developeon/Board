<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('user_model');
    }


        public function index()	
        {
            //TODO: 로그인, 회원가입 유도 화면 출력
        }

        public function join()
        {
            if($this->session->userdata('is_login'))
            {
                $this->load->helper('url');
                $this->session->set_flashdata('message', '잘못된 접근입니다.');
                redirect('/board');
            }

            $this->_header();
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', '이름', 'required|max_length[20]');
            $this->form_validation->set_rules('email', '이메일', 'required|valid_email'); //TODO: |is_unique[user.email] 에러(중복안됐는데 중복됐다고 함). 고치기
            $this->form_validation->set_rules('password', '패스워드', 'required|min_length[8]|max_length[20]|matches[re_password]');
            $this->form_validation->set_rules('re_password', '패스워드 확인', 'required');
            if ($this->form_validation->run()===FALSE) 
            {
                $this->load->view('join');
            }
            else
            {
                $hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
                $result = $this->user_model->register(array(
                    'name'=>$this->input->post('name'),
                    'email'=>$this->input->post('email'),
                    'password'=>$hash
                ));
                if ($result > 0)
                {
                    //TODO :alert창 띄우고 로그인페이지로
                    $this->load->helper('url');
                    redirect('/auth/login');
                }
                else
                {
                    $this->load->helper('url');
                    $this->session->set_flashdata('message', '회원가입에 실패했습니다.');
                    redirect('/auth/join');
                }
            }
            $this->_footer();
        }

        public function login()
        {
            if($this->session->userdata('is_login'))
            {
                $this->load->helper('url');
                $this->session->set_flashdata('message', '잘못된 접근입니다.');
                redirect('/board');
            }
            $this->_header();
            $this->load->view('login');
            $this->_footer();
        }

        public function logout(){
            $this->session->sess_destroy();
            $this->load->helper('url');
            redirect('/');
        }

        public function authentication()
        {
           
            $user = $this->user_model->getByEmail(array('email'=>$this->input->post('email')));
            if ($this->input->post('email') === $user->email && password_verify($this->input->post('password'), $user->password))
            {
                $this->session->set_userdata('is_login', true);
                $this->load->helper('url');
                if($this->uri->segment(3,0)=='login') //로그인 페이지에서 로그인한 경우
                {
                    redirect('/board');
                }
                if($this->uri->segment(3,0)=='write') //글쓰기 버튼을 통해 로그인한 경우
                {
                    redirect('/board/write');
                }
            }
            else
            {
                $this->session->set_flashdata('message', '로그인에 실패했습니다.');
                $this->load->helper('url');
                redirect('/auth/login');
            }
        }
}
