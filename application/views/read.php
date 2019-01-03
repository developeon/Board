<style>
    .card-header .row * {
        margin: 0;
    }

    .media {
        border-radius: 0.25rem;
        padding: 1rem;
        /* padding-bottom: 0; */
    }
</style>
<div class="container">
    <div class="card text-center">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-10"><h5 class="text-left m-0"><?=$post->title?></h5></div>
                <div class="col-lg-2"><p class="text-right m-0"><?=$post->register_date?></p></div>
            </div>
        </div>
        <div class="card-body">
            <p class="text-left">
                <img class="mr-1 rounded-circle" src="/includes/img/profile_picture/<?=$post->user_profile_picture?>" alt="profile picture" style="width:32px;height:32px;">
                <a href="<?=site_url('/profile')?>/<?=$post->user_id?>"><?=$post->user_name?></a>
            </p>
            <p class="text-left"><?=$post->content?></p>
            <div class="row">
                <div class="col text-right">
                <?php
                if ($this->session->userdata('user_id') === $post->user_id)
                { ?>
                    <a href="<?=site_url('/board/update/'.$post->post_id)?>" class="btn btn-primary">수정</a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmModal">
                        삭제
                    </button>
                <?php
                } ?>
                </div>
            </div>
        </div>
        <div class="card-footer text-muted">
            <form action="<?=site_url('/board/write_comment')?>" method="post">
                <input type="hidden" name="post_id" value="<?=$post->post_id?>">
                <div class="row" style="margin-bottom: 1rem;">
                    <div class="col-10">
                        <textarea class="form-control" name="content" required></textarea>
                    </div>
                    <div class="col-2 pl-0">
                        <?php
                        if ($this->session->userdata('is_login'))
                        { ?>
                            <button class="btn btn-default w-100 h-100" type="submit">등록</button>
                        <?php
                        }
                        else
                        { ?>
                            <button class="btn btn-default w-100 h-100" type="button" data-toggle="modal" data-target="#loginModal">
                                등록
                            </button>
                        <?php
                        } ?>
                    </div>
                </div>
            </form>
            <p class="text-left">
                <b>댓글 (<span id="count">0</span>) | 조회수 (<?=$post->views?>)</b>
            </p>
            <hr/>
            <div id="comments">댓글을 불러오는 중입니다.</div>
        </div>
    </div>
</div>

<!-- 로그인 modal -->
<div class="modal fade" id="loginModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">THE TEAMS</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="<?=site_url('/auth/authentication/comment/'.$post->post_id)?>" method="post">
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

<!-- 삭제 confirm modal -->
<div class="modal fade" id="confirmModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">알림 메세지</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                정말 삭제하시겠습니까?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                <a href="<?=site_url('/board/delete/'.$post->post_id)?>" class="btn btn-primary">삭제</a>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> <!-- Google CDN -->
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script> <!-- Microsoft CDN -->
<script>
    $(document).ready(function(){
        readComment();
    });
    
    function readComment() {
        $.ajax({
            url: '/board/readComment',
            type: 'POST',
            data: { post_id: <?=$post->post_id?> },
            dataType: 'json',
            error: function() {
                alert('댓글 정보를 불러오지 못했습니다.');
            },
            success: function(data) {
                var user_id = <?=$this->session->userdata('user_id')?>;
                var html = '';
                if (data['count'] > 0) {
                data['comments'].forEach(function(comment) {
                    html += `
                        <div id="media${comment.comment_id}" class="media" style="margin-left:${comment.depth}rem;">
                        
                            <img class="mr-3 rounded-circle" src="/includes/img/profile_picture/${comment.user_profile_picture}" alt="profile picture" style="width:48px;height:48px;">
                            <div class="media-body" style="text-align: left;">
                                <div class="row">
                                    <div class="col-10">
                                        <h6 class="mt-0" style="margin-bottm: 0;">
                                            <a href="/profile/${comment.user_id}">${comment.user_name}</a> | ${comment.register_date}
                                        </h6>
                                    </div>
                                    <div class="col-2 text-right">
                                        
                    `;
                    if(user_id === Number(comment.user_id))
                        html += `<span style="cursor: pointer;" onclick="deleteComment(${comment.comment_id});">X</span>`;
                    html += `
                                    </div>
                                   
                                </div>
                                <div class="row container">
                                    ${comment.content}
                                </div>
                                <div class="row container">
                                        <button type="button" onclick="showReplyBox(${comment.comment_id}, ${comment.root}, ${comment.depth}, ${comment.seq})">답글</button>
                                </div>
                            </div>
                        </div>
                    `;
                });
                $("#comments").html(html);
                } else {
                    $("#comments").html('작성된 댓글이 없습니다.');
                }
                $('#count').html(data['count']);
            }
        });
    }

    function deleteComment(comment_id) {
        $.ajax({
            url: '/board/deleteComment',
            type: 'POST',
            data: { comment_id: comment_id},
            error: function() {
                alert('댓글을 삭제하지 못했습니다.');
            },
            success: function(data) {
                if(!data) {
                    alert('댓글을 삭제하지 못했습니다.');
                } else {
                    alert('댓글이 삭제되었습니다.');
                    readComment();
                }
            }
        });
    }

    function showReplyBox(comment_id, root, depth, seq) { //답글 작성 textarea 출력
        $( ".replaybox" ).remove();
        var replybox = `
            <div class="row replaybox" style="margin-bottom: 1rem;margin-left:${depth}rem">
                    <div class="col-10">
                        <textarea class="form-control" id="reply"></textarea>
                    </div>
                    <div class="col-2 pl-0">
                        <button class="btn btn-default w-100 h-100" type="button" onclick="writeReply(${root}, ${depth}, ${seq})">등록</button>
                    </div>
            </div>
        `;
        $(replybox).insertAfter("#media" + comment_id);
    }

    function writeReply(root, depth, seq) { //답글 작성
        $.ajax({
            url: '/board/wrtie_reply',
            type: 'POST',
            data: { 
                content: document.getElementById("reply").value,
                post_id: <?=$post->post_id?>,
                root: root,
                depth: depth,
                seq: seq
            },
            error: function(request,status,error) {
                alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            },
            success: function(data) {
                //답글 작성에 성공하면 comment_id값이 넘어옴 
                if(!data) {
                    alert('답글을 작성하지 못했습니다.');
                }
                else {
                    readComment();
                }
            }
        });
    }
</script>

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