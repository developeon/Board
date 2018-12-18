<style>
    img.profile-page {
        border-color: #C9CDD2;
        border-style: solid;
        border-width: 2px;
        width: 140px;
        height: 140px;
        display: block;
        margin: auto;
        margin-bottom: 1rem;
    }

    .btn-file {
        position: relative;
        overflow: hidden;
    }

    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        opacity: 0;
        outline: none;
        cursor: inherit;
    }

    .form-group {
        border-bottom: 1px solid #EDEDED;
        padding-bottom: 1rem;
    }
</style>
<div class="container">
    <div class="card">
        <div class="card-header">
        <h3 class="m-0">프로필 수정</h3>
        </div>
        <div class="card-body">
            <form id="form1" action="<?=site_url('/mypage/update')?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-4 text-center" style="padding: 1rem;">
                        <img id="blah" src="/includes/img/profile_picture/<?=$user->profile_picture?>" class="rounded-circle profile-page" alt="profile picture">
                        <span class="btn btn-primary btn-file">
                            바꾸기 <input id="imgInp" type="file" name="profile_picture">
                        </span>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">이름</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" placeholder="이름을 입력해주세요" value="<?=$user->name?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="register_date" class="col-sm-2 col-form-label">가입일</label>
                            <div class="col-sm-10">
                                <div class="form-control text-muted"><?=$user->register_date?></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">이메일</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" placeholder="이메일을 입력해주세요" value="<?=$user->email?>">
                                <p class="text-muted" style="margin-top: 0.5rem;margin-bottom: 0.5rem;"><small>이메일 인증 후 글쓰기, 댓글달기 기능을 이용하실 수 있습니다.</small></p>
                                <button id="auth" class="btn btn-primary" type="button">인증하기</button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">패스워드</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password" placeholder="패스워드를 입력해주세요">
                            </div>
                        </div>
                        <p class="text-right">
                            <button class="btn btn-primary" type="submit">다 했어요</button>
                        </p>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-default" type="button">탈퇴</button>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> <!-- Google CDN -->
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script> <!-- Microsoft CDN -->
<script>
    $(document).ready(function(){
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function(){
            readURL(this);
        });
    
        $( "#auth" ).click(function() {
            var email = $('#email').val();
        //TODO: controller에서 sendEmail 함수 만들고 거기서는 인증번호 발생, 메일 전송 작업 진행. 그리고 메일 전송이 성공적으로 되면(success(data)) 
        //인증번호를 입력하세요라는 modal창 띄움. 인증번호를 입력하면 checkNumber 함수에 갔다오고 success면 인증 완료로 바꿈
        $.ajax({
            url: '/mypage/sendEmail',
            type: 'POST',
            data: {
                user_id: <?=$user->user_id?>,
                email: email
            },
            dataType: 'json',
            error: function(e) {
                console.log(e);
                alert('Something is wrong');
            },
            success: function(data) {
                if (data ==='success') 
                {
                    alert(`${email}로 이메일을 보냈습니다. 확인 해보시겠어요?`);
                }
                else
                {
                    alert('이메일 전송에 실패했습니다. 다시 시도해주세요.');
                }
            }
        });
    });
    
    });
</script>

<?php
  if ($this->session->flashdata('message'))
  {
?>
    <script>
      alert("<?=$this->session->flashdata('message')?>");
    </script>
<?php
  }
?>

<!-- TODO: 이제 프로필 수정 -->