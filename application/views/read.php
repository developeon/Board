<style>
    .card-header .row * {
        margin: 0;
    }

    .media {
        border-radius: 0.25rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }
</style>
<div class="container">
    <div class="card text-center">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-8"><h5 class="text-left"><?=$post->title?></h5></div>
                <div class="col-sm-4"><p class="text-right">작성일 <?=$post->register_date?> | 작성자 <?=$post->user_id?> | 조회수 <?=$post->views?></p></div>
            </div>
        </div>
        <div class="card-body">
            <p class="card-text"><?=$post->content?></p>
            <p class="text-right">
                <a href="#" class="btn btn-primary">수정</a>
                <a href="#" class="btn btn-primary">삭제</a>
            </p>
        </div>
        <div class="card-footer text-muted">
            <form action="/board/write_comment" method="post">
                <input type="hidden" name="post_id" value="<?=$post->post_id?>">
                <div class="row" style="margin-bottom: 1rem;">
                    <div class="col-10">
                        <textarea class="form-control" name="content"></textarea>
                    </div>
                    <div class="col-2 pl-0">
                        <button class="btn btn-default w-100 h-100" type="submit">등록</button>
                    </div>
                </div>
            </form>
            <p class="text-left">
                <b>댓글 (<?=$count?>)</b>
            </p>
            <hr/>
            <?php
            if ($comments)
            {
                foreach ($comments as $comment) {
            ?>
                <div class="media">
                    <img class="mr-3 rounded-circle" src="/includes/img/dummy_profile.jpg" alt="profile picture" style="width:48px;height:48px;">
                    <div class="media-body" style="text-align: left;">
                        <h6 class="mt-0" style="margin-bottm: 0;"><?=$comment->user_id?> | <?=$comment->register_date?></h6>
                        <?=$comment->content?>
                    </div>
                </div>
            <?php
                }
            }
            ?>
              
        </div>
    </div>
</div>