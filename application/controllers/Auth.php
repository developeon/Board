<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

        public function index()	
        {
            //TODO: 로그인, 회원가입 유도 화면 출력
        }

        public function join()
        {
            $this->_header();
            $this->load->view('join');
            $this->_footer();
        }

        public function login()
        {
            $this->_header();
            $this->load->view('login');
            $this->_footer();
        }
}
