<div class="container">
<?php
    if ($comments)
    {
        foreach ($comments as $comment) 
        {
            // echo $comment->comment_id;
            // echo "<br>";
            // echo $comment->content;
            // echo "<hr>";
?>
<div class="media" style="margin-left:<?=($comment->depth)*2?>rem;">
        <img class="mr-3 rounded-circle" src="/includes/img/profile_picture/<?=$comment->user_profile_picture?>" alt="profile picture" style="width:48px;height:48px;">
        <div class="media-body" style="text-align: left;">
            <div class="row">
                <div class="col-12">
                    <h6 class="mt-0" style="margin-bottm: 0;">
                        <a href="/profile/<?=$comment->user_id?>"><?=$comment->user_name?></a> | <?=$comment->register_date?>
                    </h6>
                </div>
            </div>
            <div class="row container">
            <?=$comment->content?>
            </div>
        </div>
    </div>
<?php
        }
    }
    else {
       echo " 댓글 정보가 없습니다.";
    }
?>
</div>

