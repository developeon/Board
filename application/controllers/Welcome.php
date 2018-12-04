<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		if ($this->session->userdata('is_login'))
		{
            	redirect('/board');
		}
		else 
		{
			$this->load->view('welcome_message');
		}
	}
}