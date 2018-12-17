<?php
class Email_auth_model extends CI_Model {
    function _construct() 
    {
        parent::_construct();
    }

    public function insert($email_hash, $expired_time, $user_id)
    {
        $this->db->insert('email_auth', array(
            'email_hash'=>$email_hash,
            'expired_time'=>$expired_time,
            'user_id'=>$user_id
        ));
        return $this->db->insert_id();
    }
}