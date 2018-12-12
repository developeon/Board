<div class="container">
    <div class="jumbotron">
        <div class="media">
            <img class="mr-3" src=".../64x64" alt="Generic placeholder image">
            <div class="media-body">
                <h5 class="mt-0">이름</h5>
                리스트
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
            <button class="nav-link" id="bookmark">북마크</button>
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
            data: { user_id: <?=$user_id?>},
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
                            <td>${data[i].title}</td>
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
            data: { user_id: <?=$user_id?>},
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
                console.log("여기로옴");
                var html = '';
                for (i=0; i<data.length; i++)
                {
                    html += `
                        <tr>
                            <th scope="row">${data[i].comment_id}</th>
                            <td>${data[i].content}</td>
                            <td>${data[i].register_date}</td>
                        </tr>
                    `;
                }
                $("tbody").html(html);
            }
        });
    }
</script>