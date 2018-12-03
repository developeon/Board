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
        return $this->db->get_where('post', array('post_id'=>$post_id));
    }

    public function write($title, $content, $user_id)
    {
        $this->db->insert('post', array(
            'title'=>$title,
            'content'=>$content,
            'user_id'=>$user_id
        ));
        return $this->db->insert_id();
    }

    public function increaseViews($post_id)
    {
        $sql = 'update post set views=views+1 where post_id='.$post_id;
        $this->db->query($sql);
    }

    public function update($post_id, $titile, $content)
    {
        
        $sql = "UPDATE post set title=?, content=? WHERE post_id=?";
        return $this->db->query($sql, array($titile, $content, $post_id));
    }
}