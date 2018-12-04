<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('checkWriter'))
{
    function checkWriter($user_id)
    {
        $CI =& get_instance();
        if ($CI->session->userdata('user_id') != $user_id)
        {
            $CI->session->set_flashdata('message', '접근 권한이 없습니다.');
            redirect('/board');
        }
    }
}

if (!function_exists('checkIsLogin'))
{
    function checkIsLogin()
    {
        $CI =& get_instance();
        if(!$CI->session->userdata('is_login'))
        {
            $CI->session->set_flashdata('message', '로그인이 필요합니다.');
            redirect('/auth/login');
        }
    }
}

