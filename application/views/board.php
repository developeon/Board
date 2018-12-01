<div class="container">
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
    </div> <!-- end of Search Box flex -->
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
                <td><a href="/board/read/<?=$post->post_id?>" target="_blank"><?=$post->title?></a></td>
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
            <?php echo $pagination; ?>
        </nav> <!-- end of page navigation -->
    </div> <!-- end of page navigation flex-->
</div> <!-- end of Container -->