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
            <button class="nav-link active" id="post">작성글</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="comment">댓글</button>
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
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            </tr>
            <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
            </tr>
            <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
            </tr>
        </tbody>
    </table>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> <!-- Google CDN -->
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script> <!-- Microsoft CDN -->
<script>
    $(document).ready(function(){
        $("#post").click(function(){
            $.ajax({
                url: '/profile/getPosts',
                type: 'POST',
                data: { user_id: <?=$user_id?>},
                error: function() {
                    alert('Something is wrong');
                },
                success: function(data) {
                    alert(data);
                    // $("thead").html(`
                    //     <tr>
                    //         <th scope="col">#</th>
                    //         <th scope="col">제목</th>
                    //         <th scope="col">작성자</th>
                    //         <th scope="col">작성일</th>
                    //         <th scope="col">조회수</th>
                    //     </tr>
                    // `);
                }
            });
        });
        $("#comment").click(function(){
            alert("comment");
        });
        $("#bookmark").click(function(){
            alert("bookmark");
        });
    });
</script>