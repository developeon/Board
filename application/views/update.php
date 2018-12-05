<div class="container">
    <form action="<?=site_url('/board/update_proc/'.$post->post_id)?>" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="title" placeholder="제목을 작성해주세요." value="<?=$post->title?>" required>
        </div>
        <div class="form-group">
            <textarea class="form-control" name="content" placeholder="내용을 작성해주세요." required><?=$post->content?></textarea>
        </div>
        <div class="text-right">
            <button class="btn btn-primary">수정완료</button>
        </div>
    </form>
</div>

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