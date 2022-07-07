<div class="container-fluid p-0" id="main-container">
    <div class="row">
        <?php include './views/layouts/sidebar.menu.php'; ?>
        <div class="col-xs-12 col-md-9 p-lg-2">
            <?php
            if (count($data) > 0) {
            ?>
                <div class="row m-0">
                    <?php
                    $div = '';
                    foreach ($data as $video) {
                        $div .= '<a href="?page=watch&id=' . $video['video'] . '" class="col-xs-12 col-md-3 p-3 press-to-video">';
                        $div .= '<div class="card">';
                        $div .= '<img class="card-image-top" src="./uploads/pictures/' . $video['thumbnail'] . '" height="175px"/>';
                        $div .= '<div class="card-body p-2">';
                        $div .= '<h5 class="card-title video-title mb-1" title="' . $video['title'] . '">' . $video['title'] . '</h5>';
                        $div .= '<div class="d-flex justify-content-between" style="font-size:12px"><span>Duration: ' . $video['duration'] . '</span><span>Views: ' . $video['views'] . '</span></div>';
                        $div .= '<div class="d-flex justify-content-between" style="font-size:14px"><span>Uploaded By: ' . $video['name'] . '</span></div>';
                        $div .= '</div>';
                        $div .= '</div>';
                        $div .= '</a>';
                    }
                    echo $div;
                    ?>
                </div>
            <?php
            } else {
            ?>

            <?php
            }
            ?>
        </div>
    </div>
</div>