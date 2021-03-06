<?php
class User_model extends CI_Model {
    function _construct() 
    {
        parent::_construct();
    }

    function register($option)
    {
        $this->db->set('name', $option['name']);
        $this->db->set('email', $option['email']);
        $this->db->set('password', $option['password']);
        $this->db->insert('user');
        $result = $this->db->insert_id();
        return $result;
    }

    function getByEmail($option)
    {
        $result = $this->db->get_where('user', array('email'=>$option['email']));
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

    function getByName($name)
    {
        $this->db->like('name', $name); 
        $query = $this->db->get('user');
        return $query->row();
    }

    function get($user_id)
    {
        return $this->db->get_where('user', array('user_id' => $user_id));
    }

    function updateEmailStatus($user_id, $email)
    {
        $data = array(
            'email'=>$email,
            'email_checked'=>1
        );
        $this->db->update('user', $data, 'user_id='.$user_id);
        return $this->db->affected_rows();
    }

    function update($user_id, $name, $password)
    {
        $data = array(
            'name'=>$name,
            'password'=>$password
        );
        return $this->db->update('user', $data, 'user_id='.$user_id);
    }

    function updateBoth($user_id, $name, $password, $file_name)
    {
        $data = array(
            'name'=>$name,
            'password'=>$password,
            'profile_picture'=>$file_name
        );
        return $this->db->update('user', $data, 'user_id='.$user_id);
    }
}