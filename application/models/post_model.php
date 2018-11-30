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

    public function get($post_id)
    {
        return $this->db->get_where('post', array('post_id'=>$post_id))->row();
    }

    public function write($title, $content)
    {
        $this->db->insert('post', array(
            'title'=>$title,
            'content'=>$content,
            'user_id'=>1
        ));
        return $this->db->insert_id();
    }
}