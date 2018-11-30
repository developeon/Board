<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends MY_Controller {

        public function index()	
        {
                $this->load->database();
                $this->load->model('post_model');
                $data = $this->post_model->gets();
                $this->_header();
                $this->load->view('board', array('posts'=>$data));
                $this->_footer();
        }

        public function write()
        {
                $this->_header();
                $this->load->view('write');
                $this->_footer();
        }

        public function write_action()
        {
                $this->_header();
                echo $this->input->post('title');
                echo $this->input->post('content');
                $this->_footer();
        }
}
