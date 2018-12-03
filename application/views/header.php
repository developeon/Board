<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>더팀스(THE TEAMS)</title>
    <link rel="shortcut icon" href="/includes/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/includes/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/includes/css/sticky-footer-navbar.css">
    <style>
        @media (max-width: 768px) {
            .dropdown-menu-right {
                right: auto;
            }
        }
        .navbar {
            background: #fff;
            border-bottom: 1px solid #dedede;
            box-shadow: 0px 2px 2px -2px rgba(0,0,0,0.15);
        }

        .nav-link {
            color: #606060;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/board"><img src="/includes/img/logo.png" alt="theteams logo" style="width: 125px;"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                    <a class="nav-link" href="/board">게시물 보기 <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <form class="form-inline mt-2 mt-md-0">
                    <div class="dropdown">
                        <img src="/includes/img/profile_picture/<?=$profile_picture?>" class="rounded-circle dropdown-toggle" data-toggle="dropdown" width="38px" height="38px" alt="profile picture"> 
                        <div class="dropdown-menu dropdown-menu-right">
                        <?php
                        if ($this->session->userdata('is_login'))
                        { ?>
                            
                            <a class="dropdown-item" href="/board"><img src="/includes/img/material_icons/edit.svg" alt="" style="width:18px;"> 게시물 보기</a>
                            <a class="dropdown-item" href="#"><img src="/includes/img/material_icons/dashboard.svg" alt="" style="width:18px;"> 나의 활동</a>
                            <a class="dropdown-item" href="/profile"><img src="/includes/img/material_icons/face.svg" alt="" style="width:18px;"> 내 정보 관리</a>
                            <a class="dropdown-item" href="/auth/logout"><img src="/includes/img/material_icons/logout.svg" alt="" style="width:18px;"> 로그아웃</a>
                        <?php
                        }
                        else
                        { ?>
                            <a class="dropdown-item" href="/board"><img src="/includes/img/material_icons/edit.svg" alt="" style="width:18px;"> 게시물 보기</a>
                            <a class="dropdown-item" href="/auth/login"><img src="/includes/img/material_icons/login.svg" alt="" style="width:18px;"> 로그인</a>
                            <a class="dropdown-item" href="/auth/join"><img src="/includes/img/material_icons/person_add.svg" alt="" style="width:18px;"> 회원가입</a>
                        <?php
                        } ?>
                        </div>
                    </div>
                </form>
            </div>
         </div>
    </nav>