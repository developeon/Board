<?php
class Post_model extends CI_Model {
    function _construct() 
    {
        parent::_construct();
    }

    public function gets($limit, $start, $search_type, $search_text)
    {
        if ($search_type && $search_text) 
        {
            switch ($search_type) {
                case 'both':
                    $this->db->like('title', $search_text); 
                    $this->db->or_like('content', $search_text);
                    break;
                case 'title':
                case 'content':
                    $this->db->like($search_type, $search_text, 'both');
                    break;
                case 'user_id':
                    //TODO: case는 user_id지만 유저가 검색한건 name. 
                    // name like '%?%' 해서 얻은 id들 모두 select * from post where user_id like in(id들) 이런식으로 해야할듯. 아니면 조인하거나
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
        $query = $this->db->get_where('post', array('user_id' => $user_id));
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

    public function delete($post_id)
    {
        $this->db->where('post_id', $post_id);
        return $this->db->delete('post');
    }
}