<?php
class Bookmark_model extends CI_Model {
    function getStatus($user_id, $post_id) 
    {
        $result = $this->db->get_where('bookmark', array('user_id'=>$user_id, 'post_id'=>$post_id, 'bookmark_check'=>false));

        try {
			$result = ($result) ? $result : false;
			if ($result) {
				return $result->result_array();
			} else {
				return 0;
			}
		} catch (Exception $e) {
			return 0;
		}
    }

    function getStatusWithoutCheck($user_id, $post_id) 
    {
        $result = $this->db->get_where('bookmark', array('user_id'=>$user_id, 'post_id'=>$post_id));

        try {
			$result = ($result) ? $result : false;
			if ($result) {
				return $result->result_array();
			} else {
				return 0;
			}
		} catch (Exception $e) {
			return 0;
		}
    }

    function update($user_id, $post_id)
    {
        $this->db->where(array('user_id' => $user_id, 'post_id'=>$post_id));
        $this->db->set('bookmark_check', '!bookmark_check', FALSE);
        $this->db->set('register_date', 'now()', FALSE);
        $this->db->update('bookmark');
        return $this->db->affected_rows();
    }
    
    function insert($user_id, $post_id)
    {
        $data = array(
            'user_id' => $user_id,
            'post_id' => $post_id,
        );
        $this->db->insert('bookmark', $data);
        $bookmark_id = $this->db->insert_id();
        return $bookmark_id;
    }

    public function getsById($user_id) //유저의 북마크 정보 출력 
    {
        $query = $this->db->get_where('bookmark', array('user_id' => $user_id));
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    public function getCount($user_id) //유저의 총 북마크 수 출력
    {
        $query = $this->db->get_where('bookmark', array('user_id' => $user_id));
        if ($query->num_rows() > 0)
        {
            return $query->num_rows();
        }
        else
        {
            return 0;
        }
    }
}