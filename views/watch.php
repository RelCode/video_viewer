<div class="container-fluid p-0" id="main-container">
    <div class="row p-3">
        <div class="col-xs-12 col-md-8 p-0 view-container">
            <?php
            if (count($data) > 0) { ?>
                <video id="my-video" class="video-js" controls preload="auto" poster="./uploads/pictures/<?= $data['thumbnail'] ?>" data-setup='' oncontextmenu="return false;">
                    <source src="./uploads/videos/<?= $data['path'] ?>" type='video/mp4'>
                </video>
                <h5><?= $data['title'] ?></h5>
                <span><i class="fa fa-eye" title="Views"></i> <?= $data['views'] ?></span>
                <?php
                if (isset($_SESSION['loggedIn'])) { ?>
                    <div class="d-flex justify-content-between">
                        <span><i class="fas fa-thumbs-up video-like" title="Like This Video"></i> <i class="video-like-count"><?= $data['likes'] ?></i> &nbsp;&nbsp; <i class="fas fa-thumbs-down video-dislike" title="Dislike This Video"></i> <i class="video-dislike-count"><?= $data['dislikes'] ?></i></span>
                    </div>
                <?php }
                ?>
                <h6><?= $data['description'] ?></h6>
                <span class="d-flex justify-content-between align-items-center"><i>Posted By: <strong><a href="#"><?= $data['name'] ?></a></strong></i><?= isset($_SESSION['loggedIn']) && is_null($data['playlisted']) ? '<button class="btn btn-secondary add-to-playlist"><i class="fa fa-plus"></i> Add To Playlist</button>' : '' ?></span>
                <i style="font-size: 12px;"><?= $data['created_at']; ?></i>
            <?php
            } else {
                echo '<img src="./uploads/pictures/video-not-found.png" alt="Video Not Found" srcset="" style="width:100%;height:100%">';
            }
            ?>
        </div>
        <div class="col-xs-12 col-md-4 p-0 pl-md-3 comments-container">
            <h5 class="alert alert-default text-center border" id="view-comments">Comments <?= $data['comments_count'] ?></h5>
            <button class="btn btn-primary form-control" data-toggle="collapse" data-target="#write-comment"><i class="fas fa-plus"></i> Write Comment</button>
            <div class="collapse pt-3" id="write-comment">
                <div class="input-group" id="write-comment">
                    <textarea id="comment-body" rows="3" class="form-control" placeholder="Type comment"></textarea>
                    <div class="input-group-append">
                        <button class="btn btn-primary d-flex justify-content-center align-items-center" id="post-comment"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="pt-3" id="comment-section">

            </div>
        </div>
    </div>
</div>