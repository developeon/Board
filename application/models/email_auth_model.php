<?php
class Email_auth_model extends CI_Model {
    function _construct() 
    {
        parent::_construct();
    }

    public function replace($email, $email_hash, $expired_time, $user_id)
    {
        return $this->db->replace('email_auth', array(
            'email'=>$email,
            'email_hash'=>$email_hash,
            'expired_time'=>$expired_time,
            'user_id'=>$user_id
        ));
    }

    public function selectByEmailHash($email_hash)
    {
        $result = $this->db->get_where('email_auth', array('email_hash'=>$email_hash))->row();
        return $result;
    }
}