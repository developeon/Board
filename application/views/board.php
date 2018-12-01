<div class="container">
    <?php echo $pagination; ?>
    <div class="d-flex justify-content-end">
        <form>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <select id="inputState" class="form-control">
                        <option selected>Choose...</option>
                        <option>...</option>
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
    </div> <!-- end of Search Box -->
    <table class="table table-hover">
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
                <td><a href="/board/read/<?=$post->post_id?>"><?=$post->title?></a></td>
                <td><?=$post->user_id?></td>
                <td><?=$post->register_date?></td>
                <td><?=$post->views?></td>
            </tr>
        <?php
        } 
        ?>
        </tbody>
    </table> 
    <p class="text-right">
        <a href="/board/write" class="btn btn-primary">글쓰기</a>
    </p>
    <div class="d-flex justify-content-center">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">처음</a></li>
                <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">이전</span>
                </a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">다음</span>
                </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">끝</a></li>
            </ul>
        </nav>
    </div> <!-- end of Page navigation -->
</div> <!-- end of Container -->