<div class="container auth-container">
    <h5 class="alert text-center">User Login</h5>
    <form action="" method="post" class="row mt-5 p-3 shadow rounded m-xs-2" id="form">
        <div class="col-xs-12 col-md-6 offset-md-3 p-3 mb-3">
            <input type="text" name="email" value="<?= isset($_SESSION['old']['email']) ? $_SESSION['old']['email'] : '' ?>" class="form-control must-fill" placeholder="Email" autocomplete="off">
            <?= isset($_SESSION['validation']['email']) ? '<span class="text text-danger">' . $_SESSION['validation']['email'] . '</span>' : '' ?>
        </div>
        <div class="col-xs-12 col-md-6 offset-md-3 p-3 mb-3">
            <input type="password" name="password" class="form-control must-fill" placeholder="Create Password" autocomplete="off">
            <?= isset($_SESSION['validation']['password']) ? '<span class="text text-danger">' . $_SESSION['validation']['password'] . '</span>' : '' ?>
        </div>
        <div class="col-xs-12 col-md-6 offset-md-3 p-3 mb-3">
            <button type="submit" name="submit" class="btn btn-primary form-control">Login</button>
        </div>
        <div class="col-xs-12 col-md-6 offset-md-3 p-3 mb-3">
            <?= isset($_SESSION['alert']) ? '<h6 class="alert ' . $_SESSION['alert']['class'] . ' text-center">' . $_SESSION['alert']['auth'] . '</h6>' : '' ?>
        </div>
    </form>
</div>