<?php
class Comment_model extends CI_Model {
    function _construct() 
    {
        parent::_construct();
    }
    
    public function gets($post_id)
    {
        $query = $this->db->order_by('root, seq')->get_where('comment', array('post_id'=>$post_id));
        if ($query->num_rows() > 0) 
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    public function getAligned()
    {
        $query = $this->db->get('comment');
        return $query->result_array();
        //TODO: try-catch 
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
    
    public function writeComment($content, $post_id, $user_id)
    {
        $this->db->insert('comment', array(
            'content'=>$content,
            'post_id'=>$post_id,
            'user_id'=>$user_id
        ));
        
        $comment_id = $this->db->insert_id();
        $this->db->where('comment_id', $comment_id);
        $this->db->set('root', $comment_id);
        $this->db->update('comment');

        echo $comment_id;
    }

    public function writeReply($content, $post_id, $user_id, $root, $depth, $seq)
    {
        $this->db->insert('comment', array(
            'content'=>$content,
            'post_id'=>$post_id,
            'user_id'=>$user_id,
            'root'=>$root,
            'depth'=>$depth,
            'seq'=>$seq
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

    public function getSeq($root)
    {
        $result =  $this->db->get_where('comment', array('root'=>$root));
        return $result->num_rows();
    }

    public function updateSeq($root, $seq) //답글 insert 후 순서 업데이트
    {
        //root가 같고 파라미터로 들어온 seq보다 크거나 같은 값들을 모두 +1
        $array = array('root' => $root, 'seq >=' => $seq);
        $this->db->where($array);
        $this->db->set('seq', 'seq+1', FALSE); //FALSE로 하면 쿼리를 자동으로 이스케이프 하지 않음. 
        // TRUE일 경우 INSERT INTO post (views) VALUES ('views+1')
        // FALSE일 경우 INSERT INTO post (views) VALUES (views+1)
        $this->db->update('comment');
    }

    public function delete($comment_id) //댓글 삭제
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