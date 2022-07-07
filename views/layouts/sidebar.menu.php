<!-- this is a column that will be used to display options for logged in users.
it will appear as a sidebar menu on larger devices and a nav item list on mobile -->
<div class="col-md-3 d-none d-md-block p-0" id="sidebar">
    <ul class="list-unstyled sidebar-menu">
        <?php
        if (isset($_SESSION['loggedIn'])) {
            include './views/layouts/menu.options.php';
        } else {
            echo '<li class="nav-item h-100 d-flex justify-content-center align-items-center">';
            echo '<a href="?page=login" class="nav-link">Login To See Data</a>';
            echo '</li>';
        }
        ?>
    </ul>
</div>