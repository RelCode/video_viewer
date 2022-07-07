<div class="container auth-container">
    <h5 class="alert text-center">Create User Account</h5>
    <form action="" method="POST" class="row mt-5 p-3 shadow rounded m-xs-2" id="form" autocomplete="off">
        <div class="col-xs-12 col-md-3 offset-md-3 p-3 mb-3">
            <input type="text" name="name" value="<?= isset($_SESSION['old']['name']) ? $_SESSION['old']['name'] : '' ?>" class="form-control must-fill" placeholder="Name" autocomplete="off">
            <?= isset($_SESSION['validation']['name']) ? '<span class="text text-danger">' . $_SESSION['validation']['name'] . '</span>' : '' ?>
        </div>
        <div class="col-xs-12 col-md-3 p-3 mb-3">
            <input type="text" name="email" value="<?= isset($_SESSION['old']['email']) ? $_SESSION['old']['email'] : '' ?>" class="form-control must-fill" placeholder="Email" autocomplete="off">
            <?= isset($_SESSION['validation']['email']) ? '<span class="text text-danger">' . $_SESSION['validation']['email'] . '</span>' : '' ?>
        </div>
        <div class="col-xs-12 col-md-3 offset-md-3 p-3 mb-3">
            <input type="password" name="password" class="form-control must-fill" placeholder="Create Password" autocomplete="off">
            <?= isset($_SESSION['validation']['password']) ? '<span class="text text-danger">' . $_SESSION['validation']['password'] . '</span>' : '' ?>
        </div>
        <div class="col-xs-12 col-md-3 p-3 mb-3">
            <input type="password" name="confirm" class="form-control must-fill" placeholder="Repeat Password">
        </div>
        <div class="col-xs-12 col-md-6 offset-md-3 p-3 mb-3">
            <button type="submit" name="submit" class="btn btn-primary form-control">Create</button>
        </div>
        <div class="col-xs-12 col-md-6 offset-md-3 p-3 mb-3">
            <?= isset($_SESSION['alert']) ? '<h6 class="alert '.$_SESSION['alert']['class'].' text-center">'.$_SESSION['alert']['register'].'</h6>' : '' ?>
        </div>
    </form>
</div>