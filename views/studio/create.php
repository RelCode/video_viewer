<div class="container-fluid p-0" id="main-container">
    <div class="row">
        <?php include './views/layouts/sidebar.menu.php'; ?>
        <div class="col-xs-12 col-md-9 p-3 sub-container">
            <a href="?page=studio&subpage=view" class="btn btn-primary col-xs-12"><i class="fa fa-arrow-left"></i> Go Back</a>
            <form action="" method="post" enctype="multipart/form-data" class="row" id="form">
                <div class="col-xs-12 col-md-6 offset-md-6 p-2">
                    <h6 class="text-primary">Video Title</h6>
                    <input type="text" name="title" class="form-control must-fill" value="<?= isset($_SESSION['old']['title']) ? $_SESSION['old']['title'] : '' ?>">
                    <?= isset($_SESSION['validation']['title']) ? '<span class="text-danger">' . $_SESSION['validation']['title'] . '</span>' : '' ?>
                </div>
                <div class="col-xs-12 col-md-6 offset-md-6 p-2">
                    <h6 class="text-primary">Video Description</h6>
                    <input type="text" name="description" class="form-control must-fill" value="<?= isset($_SESSION['old']['description']) ? $_SESSION['old']['description'] : '' ?>">
                    <?= isset($_SESSION['validation']['description']) ? '<span class="text-danger">' . $_SESSION['validation']['description'] . '</span>' : '' ?>
                </div>
                <div class="col-xs-12 col-md-6 offset-md-6 p-2">
                    <h6 class="cat-header">Select Video Category</h6>
                    <?php
                    $inlineCheck = '';
                    for ($i = 0; $i < count($data); $i++) {
                        $inlineCheck .= '<div class="form-check form-check-inline">';
                        $inlineCheck .= '<input type="checkbox" class="form-check-input" id="' . $data[$i] . '" value="' . $data[$i] . '" onchange="catChange(this.value)">';
                        $inlineCheck .= '<label for="' . $data[$i] . '" class="form-check-label">' . $data[$i] . '</label>
                            </div>';
                    }
                    echo $inlineCheck;
                    ?>
                    <input type="hidden" id="categories" name="categories" class="must-fill">
                    <br /><?= isset($_SESSION['validation']['categories']) ? '<span class="text-danger">' . $_SESSION['validation']['categories'] . '</span>' : '' ?>
                </div>
                <div class="col-xs-12 col-md-6 offset-md-6 p-2">
                    <h6 class="text-primary">Pick Video To Upload</h6>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input must-fill" id="video" name="video" accept=".mp4,.webm,.mov,.mkv" onchange="fileUploaded(this)">
                        <label for="video" class="custom-file-label">Choose file</label>
                    </div>
                    <?= isset($_SESSION['validation']['video']) ? '<span class="text-danger">' . $_SESSION['validation']['video'] . '</span>' : '' ?>
                </div>
                <div class="col-xs-12 col-md-6 offset-md-6 p-2">
                    <h6 class="text-primary">Choose Video Thumbnail</h6>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input must-fill" id="thumbnail" name="thumbnail" accept=".jpeg,.jpg,.png" onchange="fileUploaded(this)">
                        <label for="thumbnail" class="custom-file-label">Choose file</label>
                    </div>
                    <?= isset($_SESSION['validation']['thumbnail']) ? '<span class="text-danger">' . $_SESSION['validation']['thumbnail'] . '</span>' : '' ?>
                </div>
                <div class="col-xs-12 col-md-6 offset-md-6 p-2">
                    <input type="submit" name="create" class="form-control btn btn-primary" />
                </div>
                <div class="col-xs-12 col-md-6 offset-md-6 p-2 mb-2">
                    <?= isset($_SESSION['alert']) ? '<h6 class="alert ' . $_SESSION['alert']['class'] . ' text-center">' . $_SESSION['alert']['studio'] . '</h6>' : '' ?>
                </div>
            </form>
        </div>
    </div>
</div>