<?php
class Post_model extends CI_Model {
    function _construct() 
    {
        parent::_construct();
    }

    public function gets($limit, $start)
    {
        $this->db->order_by('post_id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('post');
        if ($query->num_rows() > 0) 
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    public function getTotalRows()
    {
        $query = $this->db->query('SELECT * FROM post');
        return $query->num_rows();
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