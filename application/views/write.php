<div class="container">
    <?=validation_errors();?>
    <form action="<?=site_url('/board/write')?>" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="title" placeholder="제목을 작성해주세요.">
        </div>
        <div class="form-group">
            <textarea class="form-control" name="content"></textarea>
        </div>
        <div class="text-right">
            <button class="btn btn-primary">등록하기</button>
        </div>
    </form>
</div>