<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends MY_Controller {
        public function __construct() {
                parent::__construct();
                $this->load->database();
                $this->load->model('post_model');
        }

        public function index()
        {
                $this->_header();

                $this->load->library('pagination');

                $config['base_url'] = '/board/index/';
                $config['total_rows'] = $this->post_model->getTotalRows(); //sample
                $config['per_page'] = 10; //한 페이지당 n개 출력

                $this->pagination->initialize($config);
                $page = $this->uri->rsegment(3,0);
                $data['pagination'] = $this->pagination->create_links();

                $data['posts'] = $this->post_model->gets($config['per_page'], $page);
                $this->load->view('board', $data);
                
                $this->_footer();
        }

        public function write()
        {
                $this->_header();
                $this->load->library('form_validation');
                $this->form_validation->set_rules('title', '제목', 'required');
                $this->form_validation->set_rules('content', '본문', 'required');
                if ($this->form_validation->run() == FALSE)
                {
                        $this->load->view('write');
                }
                else
                {
                      $post_id = $this->post_model->write($this->input->post('title'), $this->input->post('content'));
                      $this->load->helper('url');
                      redirect('board/read/'.$post_id);
                 }
                $this->_footer();
        }

        public function read($post_id){
                $this->_header();
                $post = $this->post_model->get($post_id);
                $this->load->view('read', array('post'=>$post));
                $this->_footer();
        }
}
