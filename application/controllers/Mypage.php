<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mypage extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

	public function index()
	{
        $this->load->model('user_model');

        checkIsLogin();

        $data['user'] = $this->user_model->get($this->session->userdata('user_id'))->row();

        $this->_header();
        $this->load->view('mypage', $data);
        $this->_footer();
    }
    
    public function update()
    {
        $this->load->model('user_model');

        checkIsLogin();

        $name = $this->input->post('name');
        $password = $this->input->post('password');
        if (empty($password)) 
        {
            $hash = $this->user_model->get($this->session->userdata('user_id'))->result()[0]->password;
        }
        else
        {
            $hash = password_hash($password, PASSWORD_BCRYPT);
        }
        
        //password가 null일경우 업뎃 x 하거나 $hash값을 원래 db에서 가져와서 덮어쓰기
        
        if (empty($_FILES['profile_picture']['name'])) 
        {
            $result = $this->user_model->update($this->session->userdata('user_id'), $name, $hash);
        }
        else 
        {
            $config['upload_path'] = './includes/img/profile_picture';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 100;
            $config['max_width'] = 1024;
            $config['max_height'] = 768;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload("profile_picture"))
            {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data["upload_data"]["file_name"];
                $result = $this->user_model->updateBoth($this->session->userdata('user_id'), $name, $hash, $file_name);
            }
            else
            {
                $this->session->set_flashdata('message', $this->upload->display_errors('', ''));
                redirect('/mypage');
                exit;
            }
        }
        
        if (empty($result))
        {
            $this->session->set_flashdata('message', '프로필 수정에 실패했습니다.');
        }
        else
        {
            $this->session->set_flashdata('message', '프로필이 수정되었습니다.');
        }
        redirect('/mypage');
    }

    public function sendEmail() //TODO: emailSend 또는 .. email_send
    {
        $this->load->model('email_auth_model');
        
        $email = $this->input->post('email');
        $email_hash = md5($email.date("Y-m-d H:i:s"));
        $expired_time = date("Y-m-d H:i:s", strtotime("+30 minutes"));
        $user_id = $this->input->post('user_id');

        $result = $this->email_auth_model->replace($email, $email_hash, $expired_time, $user_id);
        if (empty($result))
        {
            echo json_encode("failure");
        }
        $config = array(        
            'protocol' => "smtp",
            'smtp_host' => "ssl://smtp.gmail.com",
            'smtp_port' => "465",//"587", // 465 나 587 중 하나를 사용
            'smtp_user' => "your email",
            'smtp_pass' => "your password",
            'charset' => "utf-8",
            'mailtype' => "html",
            'smtp_timeout' => 10,
        ); //TODO :덮어쓰지 말고 라이브러리 찾아서 수정

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->clear();
        $this->email->from("your email", "THE TEAMS");
        $this->email->to($email);
        $this->email->subject($email.'님 THE TEAMS 이메일 변경/인증 메일입니다.');
        $message = '
            <html>
                <head>
                    <title>'.$email.'님 THE TEAMS 이메일 변경/인증 메일입니다.'.'</title>
                </head>
            <body>
                <h2>안녕하세요. '.$email.'님</h2>
                <p>이메일 변경/인증 안내 메일 입니다.</p>
                <a href="http://localhost/mypage/email_change/'.$email_hash.'">이메일 변경/인증하기</button>
            </body>
            </html>
        ';
        $this->email->message($message);
        if ($this->email->send()) 
        {
            echo json_encode("success");
        } 
        else
        {
            echo json_encode("failure");
        }
    }

    public function email_change()
    {
        $this->load->model('email_auth_model');
        $this->load->model('user_model');

        checkIsLogin();

        $result = $this->email_auth_model->selectByEmailHash($this->uri->segment(3,0));
        if (empty($result))
        {
            // DB에 없는 해시값이거나 링크에 해시값 정보가 없을 경우
            echo "<script>
            alert('잘못 들어 오신 거 같아요. 다른 주소로 접속해주시겠어요?');
            window.location.href='/board';
            </script>";
        }
        else 
        {
            $expired_time = $result->expired_time;
            $now = date("Y-m-d H:i:s");
            if (strtotime($expired_time)-strtotime($now) > 0)
            {
                //TODO: 모든 기기에서 로그아웃하기
                $current_user = $this->session->userdata('user_id');
                if ($this->user_model->get($result->user_id)->row()->user_id === $current_user)
                {
                    if ($this->user_model->updateEmailStatus($current_user, $result->email) > 0)
                    {
                        echo "<script>
                        alert('이메일이 변경되었습니다. 로그인 되어있는 다른 기기들에서 모두 로그아웃 되었습니다.');
                        window.location.href='/board';
                        </script>";
                    }
                    else
                    {
                        echo "<script>
                        alert('이메일 인증 과정에서 오류가 발생했습니다.');
                        window.location.href='/board';
                        </script>";
                    }
                }
                else
                {
                    echo "<script>
                    alert('잘못 들어 오신 거 같아요. 다른 주소로 접속해주시겠어요?');
                    window.location.href='/board';
                    </script>";
                }
            }
            else
            {
                echo "<script>
                alert('잘못 들어 오신 거 같아요. 다른 주소로 접속해주시겠어요?');
                window.location.href='/board';
                </script>";
            }
        }
    }
}


