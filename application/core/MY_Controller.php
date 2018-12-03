<?php
class MY_Controller extends CI_Controller {

    function _construct() 
    {
        parent::_construct();
    }

    function _header() 
    {
        $this->load->database();
        $this->load->model('user_model');
        if ($this->session->userdata('user_id'))
        {
            $data['profile_picture'] = $this->user_model->get($this->session->userdata('user_id'))->row()->profile_picture;
        }
        else 
        {
            $data['profile_picture'] = "dummy_profile.jpg";
        }
       
        $this->load->view('header', $data);
    }

    function _footer() 
    {
        $this->load->view('footer');
    }
}