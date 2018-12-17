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

    public function getsById($user_id)
    {
        $query = $this->db->get_where('comment', array('user_id' => $user_id));
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }
    
    public function write($content, $post_id, $user_id)
    {
        $this->db->insert('comment', array(
            'content'=>$content,
            'post_id'=>$post_id,
            'user_id'=>$user_id
        ));
        return $this->db->insert_id();
    }

    public function getTotalRows($post_id)
    {
        $query = $this->db->get_where('comment', array('post_id'=>$post_id));
        return $query->num_rows();
    }

    public function getCount($user_id)
    {
        $query = $this->db->get_where('comment', array('user_id' => $user_id));
        if ($query->num_rows() > 0)
        {
            return $query->num_rows();
        }
        else
        {
            return 0;
        }
    }

    public function delete($comment_id)
    {
        try
        {
            $this->db->where('comment_id', $comment_id);
            return $this->db->delete('comment');
        } catch(Exception $e)
        {
            //log_message('error: ',$e->getMessage());
            return false;
        }
    }
}