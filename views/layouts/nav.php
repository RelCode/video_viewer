<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarToggler">
        <a class="navbar-brand d-sm-inline-block d-none" href="?page=home">Video Viewer</a>
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <form class="form-inline my-2 my-lg-0">
                    <div class="input-group">
                        <input type="text" name="query" class="form-control" placeholder="Search For Video" aria-label="Search For Video" aria-describedby="basic-addon1">
                        <div class="input-group-append">
                            <button type="submit" name="submit" class="btn btn-dafault bg-light input-group-text"><span class="fa fa-search"></span></button>
                        </div>
                    </div>
                </form>
            </li>
            <?php
            if (isset($_SESSION['loggedIn'])) {
                ?>
                    <ul class="d-block d-sm-none pl-0 list-unstyled">
                        <?php include './views/layouts/menu.options.php'; ?>
                    </ul>
                <?php
            } else {
            ?>
                <li class="nav-item">
                    <a href="?page=login" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a href="?page=register" class="nav-link">Register</a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>