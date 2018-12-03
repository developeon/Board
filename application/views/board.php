<style>
    table.posts {
        text-align: center;
    }
    .title {
        max-width: 300px;
        min-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: left;
    }
</style>
<div class="container">
    <div class="d-flex justify-content-end">
        <form>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <select class="form-control">
                        <option  value="" selected>제목+내용</option>
                        <option value="">제목만</option>
                        <option value="">내용만</option>
                        <option value="">글 작성자</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-primary">검색</button>
                </div>
            </div>
        </form>
    </div> <!-- end of Search Box flex -->
    <table class="table table-hover posts">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">제목</th>
                <th scope="col">작성자</th>
                <th scope="col">작성일</th>
                <th scope="col">조회수</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($posts as $post) {
        ?>
            <tr>
                <th scope="row"><?=$post->post_id?></th>
                <td class="title"><a href="/board/read/<?=$post->post_id?>" target="_blank"><?=$post->title?></a></td>
                <td><?=$post->user_name?></td>
                <td><?=$post->register_date?></td>
                <td><?=$post->views?></td>
            </tr>
        <?php
        } 
        ?>
        </tbody>
    </table> 
    <p class="text-right">
    <?php
    if ($this->session->userdata('is_login'))
    { ?>
        <a href="/board/write" class="btn btn-primary">글쓰기</a>
    <?php
    }
    else
    { ?>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
            글쓰기
        </button>
    <?php
    } ?>
        
    </p>
    <div class="d-flex justify-content-center">
        <nav aria-label="Page navigation example">
            <?php echo $pagination; ?>
        </nav> <!-- end of page navigation -->
    </div> <!-- end of page navigation flex-->
</div> <!-- end of Container -->

<!-- 로그인 modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">THE TEAMS</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="/auth/authentication/post" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="이메일" name="email">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="패스워드" name="password">
                    </div>
                    <button class="btn btn-lg btn-submit btn-block" type="submit">로그인</button>
                </form>
            </div>
        </div>
    </div>
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