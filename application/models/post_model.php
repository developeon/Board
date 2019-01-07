<?php
class Post_model extends CI_Model {
    function _construct() 
    {
        parent::_construct();
    }

    public function gets($limit, $start, $search_type, $search_text)
    {
        $this->db->where('post_check', false);
        
        if ($search_type && $search_text) 
        {
            switch ($search_type) {
                case 'both':
                    $this->db->like('title', $search_text); 
                    $this->db->or_like('content', $search_text);
                    break;
                case 'title':
                case 'content':
                    $this->db->like($search_type, $search_text);
                    break;
                case 'user_id':
                    $this->db->where('user_id', $search_text);
                default:
                    break;
            }
        }

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

    public function getsById($user_id)
    {
        $query = $this->db->get_where('post', array('user_id' => $user_id, 'post_check'=>false));
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    public function getCount($user_id)
    {
        $query = $this->db->get_where('post', array('user_id' => $user_id, 'post_check'=>false));
        if ($query->num_rows() > 0)
        {
            return $query->num_rows();
        }
        else
        {
            return 0;
        }
    }

    public function getTotalRows()
    {
        $query = $this->db->get_where('post', array('post_check'=>false));
        return $query->num_rows();
    }

    public function get($post_id)
    {
        return $this->db->get_where('post', array('post_id'=>$post_id, 'post_check'=>false));
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
       // $sql = 'update post set views=views+1 where post_id='.$post_id;
        //$this->db->query($sql);
        $this->db->where('post_id', $post_id);
        $this->db->set('views', 'views+1', FALSE); //FALSE로 하면 쿼리를 자동으로 이스케이프 하지 않음. 
        // TRUE일 경우 INSERT INTO post (views) VALUES ('views+1')
        // FALSE일 경우 INSERT INTO post (views) VALUES (views+1)
        $this->db->update('post');
    }

    public function update($post_id, $titile, $content)
    {
        //$sql = "UPDATE post set title=?, content=? WHERE post_id=?";
        //return $this->db->query($sql, array($titile, $content, $post_id));
        $data = array(
            'title'=>$titile,
            'content'=>$content
        );
        $this->db->update('post', $data, 'post_id='.$post_id);
        return $this->db->affected_rows();
    }

    public function delete($post_id)
    {
        // $this->db->where('post_id', $post_id);
        // return $this->db->delete('post');
        $this->db->where(array('post_id' => $post_id));
        $this->db->set('post_check', 'true', FALSE);
        $this->db->update('post');
        return $this->db->affected_rows();
    }
}