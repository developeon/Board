<?php
class Comment_model extends CI_Model {
    function _construct() 
    {
        parent::_construct();
    }

    public function gets($post_id)
    {
        $query = $this->db->order_by('comment_id', 'desc')->get_where('comment', array('post_id'=>$post_id));
        if ($query->num_rows() > 0) 
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }
    
    public function write($content, $post_id)
    {
        $this->db->insert('comment', array(
            'content'=>$content,
            'post_id'=>$post_id,
            'user_id'=>1
        ));
        return $this->db->insert_id();
    }

    public function getTotalRows($post_id)
    {
        $query = $this->db->get_where('comment', array('post_id'=>$post_id));
        return $query->num_rows();
    }
}