<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

	public function index()
	{
        // TODO: 로그인 안된 유저의 접근 막기
        $this->_header();
        $this->load->view('profile');
        $this->_footer();
	}
}