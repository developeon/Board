<?php
class Post_model extends CI_Model {
    function _construct() 
    {
        parent::_construct();
    }

    public function gets()
    {
        return $this->db->query('SELECT * FROM post')->result();
    }
}