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
        $result = $this->db->get_where('user', array('email'=>$option['email']))->row();
        return $result;
    }

    function get($user_id)
    {
        return $this->db->get_where('user', array('user_id' => $user_id));
    }

    public function updateProfilePicture($file_name)
    {
        
        $sql = "UPDATE user set profile_picture=? WHERE user_id=?";
        return $this->db->query($sql, array($file_name, $this->session->userdata('user_id')));
    }
}