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
            <h3 class="m-0">이메일 인증</h3>
        </div>
        <div class="card-body">
            <input type="text" class="form-control" id="email" placeholder="이메일을 입력해주세요" value="<?=$user->email?>">
            <?php
            if ($user->email_checked)
            { ?>
                <p class="text-muted" style="margin-top: 0.5rem;margin-bottom: 0.5rem;"><small><?=$user->email?>로 인증 되어 있습니다. 변경하시려는 이메일 주소를 작성 후 버튼을 눌러주세요.</small></p>
                <button id="auth" class="btn btn-primary" type="button">변경하기</button>
            <?php
            }
            else
            { ?>

                <p class="text-muted" style="margin-top: 0.5rem;margin-bottom: 0.5rem;"><small>이메일 인증 후 글쓰기, 댓글달기 기능을 이용하실 수 있습니다.</small></p>
                <button id="auth" class="btn btn-primary" type="button">인증하기</button>
            <?php
            } ?>
        </div>
    </div> <!-- 이메일 인증 -->
    <br/>
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
                                <input type="text" class="form-control" id="name" name="name" placeholder="이름을 입력해주세요" value="<?=$user->name?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="register_date" class="col-sm-2 col-form-label">가입일</label>
                            <div class="col-sm-10">
                                <div class="form-control text-muted"><?=$user->register_date?></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">패스워드</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password" name="password" placeholder="패스워드를 입력해주세요">
                            </div>
                        </div>
                        <p class="text-right">
                            <button class="btn btn-primary" type="submit">다 했어요</button>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div> <!-- 프로필 수정 -->
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
            $.ajax({
                url: '/mypage/sendEmail',
                type: 'POST',
                data: {
                    user_id: <?=$user->user_id?>,
                    email: email
                },
                dataType: 'json',
                error: function() {
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