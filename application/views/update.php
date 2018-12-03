<div class="container">
    <form action="/board/update_proc/<?=$post->post_id?>" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="title" placeholder="제목을 작성해주세요." value="<?=$post->title?>">
        </div>
        <div class="form-group">
            <textarea class="form-control" name="content" placeholder="내용을 작성해주세요."><?=$post->content?></textarea>
        </div>
        <div class="text-right">
            <button class="btn btn-primary">수정완료</button>
        </div>
    </form>
</div>