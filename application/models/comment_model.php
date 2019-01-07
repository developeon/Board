<?php
class Comment_model extends CI_Model {
    function _construct() 
    {
        parent::_construct();
    }
    
    public function gets($post_id) //게시물 별 등록된 댓글 출력
    {
        $query = $this->db->order_by('root, seq')->get_where('comment', array('post_id'=>$post_id, 'comment_check'=>false));
        if ($query->num_rows() > 0) 
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    public function getByCommentId($comment_id) //프로필에서 유저가 작성한 댓글 출력
    {
        $query = $this->db->get_where('comment', array('comment_id' => $comment_id, 'comment_check'=>false));
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    public function getsById($user_id) //프로필에서 유저가 작성한 댓글 출력
    {
        $query = $this->db->get_where('comment', array('user_id' => $user_id, 'comment_check'=>false));
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    public function getCount($user_id) //프로필에서 유저가 작성한 댓글의 수 출력
    {
        $query = $this->db->get_where('comment', array('user_id' => $user_id, 'comment_check'=>false));
        if ($query->num_rows() > 0)
        {
            return $query->num_rows();
        }
        else
        {
            return 0;
        }
    }
    
    public function writeComment($content, $post_id, $user_id) //댓글 작성
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

    public function writeReply($content, $post_id, $user_id, $root, $depth, $seq) //답글 작성
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

    public function getTotalRows($post_id) //게시물 별 댓글 수 출력
    {
        $query = $this->db->get_where('comment', array('post_id'=>$post_id, 'comment_check'=>false));
        return $query->num_rows();
    }

    public function getSeq($root) 
    {
        $result =  $this->db->get_where('comment', array('root'=>$root));
        return $result->num_rows();
    }

    public function updateSeq($root, $seq) //답글 insert 후 순서 업데이트
    {
        //root가 같고 파라미터로 들어온 seq보다 크거나 같은 값들을 모두 +1
        $array = array('root' => $root, 'seq >=' => $seq, 'comment_check'=>false);
        $this->db->where($array);
        $this->db->set('seq', 'seq+1', FALSE); //FALSE로 하면 쿼리를 자동으로 이스케이프 하지 않음. 
        // TRUE일 경우 INSERT INTO post (views) VALUES ('views+1')
        // FALSE일 경우 INSERT INTO post (views) VALUES (views+1)
        $this->db->update('comment');
    }

    public function delete($comment_id) //댓글 삭제
    {
        // try
        // {
        //     $this->db->where('comment_id', $comment_id);
        //     return $this->db->delete('comment');
        // } catch(Exception $e)
        // {
        //     //log_message('error: ',$e->getMessage());
        //     return false;
        // }
        $this->db->where(array('comment_id' => $comment_id));
        $this->db->set('comment_check', 'true', FALSE);
        $this->db->update('comment');
        return $this->db->affected_rows();
    }

    public function deleteByPost($post_id) //게시물 삭제시 해당 게시물에 달린 댓글 모두 삭제
    {
        $this->db->where(array('post_id' => $post_id));
        $this->db->set('comment_check', 'true', FALSE);
        $this->db->update('comment');
        return $this->db->affected_rows();
    }

    public function test($root, $depth, $seq)
    {
        $query = $this->db->get_where('comment', array('root' => $root, 'depth'=>$depth, 'seq >='=>$seq,'comment_check'=>false));
        if ($query->num_rows() > 0)
        {
            return $query->num_rows();
        }
        else
        {
            return 0;
        }
    }

    // public function test2($root, $depth)
    // {
    //     $sql = "SELECT max(seq) FROM comment WHERE root= ? AND depth = ?";
    //     return $this->db->query($sql, array($root, $depth))->result_array();
    // }

    public function getsTest($root,$seq) //게시물 별 등록된 댓글 출력
    {
        $query = $this->db->order_by('root, seq')->get_where('comment', array('root'=>$root, 'seq >='=>$seq, 'comment_check'=>false));
        if ($query->num_rows() > 0) 
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }
}