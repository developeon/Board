<?php
class MY_Controller extends CI_Controller {

    function _construct() {
        parent::_construct();
    }

    function _header() {
        $this->load->view('header');
    }

    function _footer() {
        $this->load->view('footer');
    }

}