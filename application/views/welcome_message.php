<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>더팀스(THE TEAMS)</title>
    <link rel="shortcut icon" href="/includes/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/includes/css/bootstrap.min.css">
	<style type="text/css">
		video {
			position: fixed; 
			left: 0; 
			bottom: 0;
			min-width: 100%; 
			min-height: 100%;
			width: auto; 
			height: auto; 
			z-index: -100;
		}
		html,
body {
  height: 100%;
}

body {
  display: flex;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  text-align: center;
}
	</style>
</head>
<body>
<!-- <div class="container-fluid main_nav_first_position">
			<div class="row">
				<div class="col-xs-5">
					<a href="/"><img src="https://www.theteams.kr/includes/img/logo.png" alt="theteams logo" style="width: 125px;"></a>
				</div>
				<div class="col-xs-7 text-right main_side_menu">
					<ul class="main_side_ul_wrap pull-right">
						<li><a href="" class="">로그인</a></li>
					</ul>
				</div>
			</div>
		</div> -->
		<nav class="navbar navbar-expand fixed-top">
		<div class="container">
      <a class="navbar-brand" href="#"><img src="/includes/img/logo.png" alt="theteams logo" style="width: 125px;"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
        </ul>
        <form class="form-inline mt-2 mt-md-0">
            <a class="nav-link" href="<?=site_url('/auth/login')?>">로그인</a>
            <a class="nav-link" href="<?=site_url('/auth/join')?>">회원가입</a>
        </form>
      </div>
	  </div>
    </nav>
	<div class="container">
		<h1>끌리다. 만나다. 일하다.</h1>
		<p>더팀스는 함께 일하는 '팀'에 초점을 맞춘 소셜 채용 서비스입니다.</p>
		<div class="container">
  			<div class="row justify-content-md-center">
				<div class="col col-lg-2">
				</div>
				<div class="col-md-auto">
					<a href="<?=site_url('/auth/login')?>" class="btn btn-primary btn-lg">로그인</a>
					<a href="<?=site_url('/auth/join')?>" class="btn btn-secondary btn-lg">EMAIL로 회원가입</a>
				</div>
				<div class="col col-lg-2">
				</div>
  			</div>
		</div>
	</div>
<video autoplay="" loop="" muted="" style="opacity: 0.2;">
	<source src="/includes/video/main7.mp4" type="video/mp4">
</video>
<script type="text/javascript" src="/includes/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="/includes/js/popper.min.js"></script>
    <script type="text/javascript" src="/includes/js/bootstrap.min.js"></script>
</body>
</html>