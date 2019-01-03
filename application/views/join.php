<link rel="stylesheet" type="text/css" href="/includes/css/auth.css?">
<style>
  body {
    margin-bottom: 0;
  }
</style>
  
  <form class="form-sign" action="<?=site_url('/auth/join');?>" method="post">
    <h1 class="h3 mb-3 font-weight-normal">반갑습니다!</h1>
    <?php echo "<p>".validation_errors()."</p>"; ?>
    <div class="form-group">
      <input type="text" class="form-control" placeholder="이름" name="name" value="<?=set_value('name')?>">
    </div>
    <div class="form-group">
      <input type="text" class="form-control" placeholder="이메일" name="email" value="<?=set_value('email')?>">
    </div>
    <div class="form-group">
      <input type="password" class="form-control" placeholder="패스워드" name="password" value="<?=set_value('password')?>">
    </div>
    <div class="form-group">
      <input type="password" class="form-control" placeholder="패스워드 확인" name="re_password" value="<?=set_value('re_password')?>">
    </div>
    <div class="form-group">
      <p class="tt-welcome-join-arg pub_join_p_color">* 가입 버튼을 클릭하면, 더팀스 <a href="#" target="_blank" class="pub_join_underbar"> 이용약관</a>에 동의하며 더팀스로부터 이메일 및 SMS 알림을 받을 수 있으며, 알림 수신을 원하지 않을 경우 언제든지 설정을 변경할 수 있습니다.</>
      <!-- TODO: 이용약관 페이지 생성 -->
    </div>
    <button class="btn btn-lg btn-submit btn-block" type="submit">가입하기</button>
  </form>

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