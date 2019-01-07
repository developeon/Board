<div class="container">
    <div class="jumbotron" style="padding: 2rem 2rem;">
        <div class="media">
            <img class="mr-3 rounded-circle" src="/includes/img/profile_picture/<?=$user[0]->profile_picture?>" alt="profile picture" style="width:120px;height:120px;">
            <div class="media-body">
                <h5 class="mt-0"><?=$user[0]->name?></h5>
                총 게시글 <?=$count['post']?>개 | 총 댓글 <?=$count['comment']?>개 | 총 북마크 <?=$count['bookmark']?>개
            </div>
        </div>
    </div>
    
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <button class="nav-link active" id="post" onclick="showPost()">작성글</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="comment" onclick="showComment()">댓글</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="bookmark" onclick="showBookmark()">북마크</button>
        </li>
    </ul>
    <table class="table">
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
            <tr>
                <th scope="row" colspan="5"><p class="text-center">데이터를 불러오는 중입니다.</p></th>
            </tr>
        </tbody>
    </table>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> <!-- Google CDN -->
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script> <!-- Microsoft CDN -->
<script>
    $(document).ready(function(){
        showPost();
    });

    function showPost() {
        $( "#comment" ).removeClass("active");
        $( "#bookmark" ).removeClass("active");
        $( "#post" ).addClass("active");
        $.ajax({
            url: '/profile/getPosts',
            type: 'POST',
            data: { user_id: <?=$user[0]->user_id?>},
            dataType: 'json',
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {
                $("thead").html(`
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">제목</th>
                        <th scope="col">작성일</th>
                        <th scope="col">조회수</th>
                    </tr>
                `);
                if (!data) {
                    $("tbody").html(`
                        <tr>
                            <th scope="row" colspan="5"><p class="text-center">작성한 게시글이 없습니다.</p></th>
                        </tr>
                    `);
                    return false;
                }
                var html = '';
                for (i=0; i<data.length; i++)
                {
                    html += `
                        <tr>
                            <th scope="row">${data[i].post_id}</th>
                            <td><a href="<?=site_url('/board/read/')?>${data[i].post_id}" target="_blank">${data[i].title}</a></td>
                            <td>${data[i].register_date}</td>
                            <td>${data[i].views}</td>
                        </tr>
                    `;
                }
                $("tbody").html(html);
            }
        });
    }

    function showComment() {
        $( "#post" ).removeClass("active");
        $( "#bookmark" ).removeClass("active");
        $( "#comment" ).addClass("active");
        $.ajax({
            url: '/profile/getComments',
            type: 'POST',
            data: { user_id: <?=$user[0]->user_id?>},
            dataType: 'json',
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {
                $("thead").html(`
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">내용</th>
                        <th scope="col">작성일</th>
                    </tr>
                `);
                if (!data) {
                    $("tbody").html(`
                        <tr>
                            <th scope="row" colspan="5"><p class="text-center">작성한 댓글이 없습니다.</p></th>
                        </tr>
                    `);
                    return false;
                }
                var html = '';
                for (i=0; i<data.length; i++)
                {
                    html += `
                        <tr>
                            <th scope="row">${data[i].comment_id}</th>
                            <td><a href="<?=site_url('/board/read/')?>${data[i].post_id}" target="_blank">${data[i].content}</a></td>
                            <td>${data[i].register_date}</td>
                        </tr>
                    `;
                }
                $("tbody").html(html);
            }
        });
    }

    function showBookmark() {
        $( "#comment" ).removeClass("active");
        $( "#post" ).removeClass("active");
        $( "#bookmark" ).addClass("active");

        $.ajax({
            url: '/profile/getBookmarks',
            type: 'POST',
            data: { user_id: <?=$user[0]->user_id?>},
            dataType: 'json',
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {
                $("thead").html(`
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">제목</th>
                        <th scope="col">등록일</th>
                    </tr>
                `);
                if (!data) {
                    $("tbody").html(`
                        <tr>
                            <th scope="row" colspan="5"><p class="text-center">북마크한 글이 없습니다.</p></th>
                        </tr>
                    `);
                    return false;
                }
                var html = '';
                for (i=0; i<data.length; i++)
                {
                    html += `
                        <tr>
                            <th scope="row">${data[i].bookmark_id}</th>
                            <td><a href="<?=site_url('/board/read/')?>${data[i].post_id}" target="_blank">${data[i].title}</a></td>
                            <td>${data[i].register_date}</td>
                        </tr>
                    `;
                }
                $("tbody").html(html);
            }
        });
    }
</script>