<link rel="stylesheet" type="text/css" href="/includes/css/auth.css">
<style>
  body {
    margin-bottom: 0;
  }
</style>
<form class="form-sign" action="/auth/authentication" method="post">
  <h1 class="h3 mb-3 font-weight-normal">바른 채용을 위한 키워드, 더팀스</h1>
  <div class="form-group">
    <input type="text" class="form-control" placeholder="이메일" name="email">
  </div>
  <div class="form-group">
    <input type="password" class="form-control" placeholder="패스워드" name="password">
  </div>
  <button class="btn btn-lg btn-submit btn-block" type="submit">로그인</button>
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