<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends MY_Controller {

	public function index()	{
                $this->_header();
                $this->load->view('board');
                $this->_footer();
        }
        
}
