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
        
        //TODO: 이 모든 작업은 파일 업로드를 했을때만 실행해야함!!!! 그거 체크하기 
        $config['upload_path'] = './includes/img/profile_picture';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 100;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload("profile_picture"))
        {
                $error = array('error' => $this->upload->display_errors());
                //$this->load->view('upload_form', $error);
                echo var_dump($error);
        }
        else
        {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data["upload_data"]["file_name"];
                $result = $this->user_model->updateProfilePicture($file_name);
                
                if (!$result)
                {
                    $this->session->set_flashdata('message', '프로필 수정에 실패했습니다.');
                }
                else
                {
                    $this->session->set_flashdata('message', '프로필이 수정되었습니다.');
                }
                redirect('/mypage');
               
        }
    }

    public function sendEmail() //emailSend로 변경. 주소도 email_send
    {
        $this->load->model('email_auth_model');
        
        $email = $this->input->post('email');
        $email_hash = md5($email); //단방향 암호화. 결함이 발견되어 보안용도로는 사용하지 않는 알고리즘
        $expired_time = date("Y-m-d H:i:s", strtotime("+30 minutes"));
        $user_id = $this->input->post('user_id');

        //TODO: DB에 insert, 메일전송 try-catch 하나로 묶기. 에러 발생시 delete문 실행
        $result = $this->email_auth_model->insert($email_hash, $expired_time, $user_id);
        
        $config = array(        
            'protocol' => "smtp",
            'smtp_host' => "ssl://smtp.gmail.com",
            'smtp_port' => "465",//"587", // 465 나 587 중 하나를 사용
            'smtp_user' => "your email",
            'smtp_pass' => "your password!",
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
                <a href="localhost/mypage/email_change/'.$email_hash.'">이메일 변경/인증하기</button>
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
    //1. 메일 발송, DB에 insert를 하나의 try로 묶고 둘중 하나라도 실패하면 catch에서 잡기.
    //1-1) 만약 DB에 해당 유저의 데이터가 있고, 시간초과가 되지 않았다면 몇분후 다시 시도하세요.
    //1-2_ 만약 DB에 해당 유저의 데이터가 있는데 시간이 초과되었다면 update(버튼 두번클릭했을경우)
    //1-3 만약 DB에 해당 유저의 데이터가 없다면 insert
    //2. 메일에서 링크 클릭 //처리후 alert('인증되었습니다. 해당창을 닫고 저장버튼을 클릭해주세요');
    //3. 해당 해시값이 DB에 있고 시간 초과되지 않았으면 session에 이메일 인증: 1 저장하고 email_auth에서 해당 행 삭제.
    //이후로는 email박스안의 값을 건들이지 못하게 해야함. 아니면 session에 이메일값도 넣어 놓고 그걸 DB에 업데이트
    //4. 저장 버튼 누르면 세션의 이메일 인증이 1일경우 email을 업데이트하고 email_checked를 true로 변경해주기

    public function email_change()
    {
        echo $this->uri->segment(3,0);
    }
}