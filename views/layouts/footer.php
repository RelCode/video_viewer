    <script src="./assets/js/app.js"></script>
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/bootstrap-4.6.1/bootstrap.min.js"></script>
    <script src="./assets/sweetalert/sweetalert.min.js"></script>
    <?php
        if($_GET['page'] == 'watch'){
            echo '<script src="./assets/videojs/zencdn-videojs.js"></script>';
            echo '<script src="./assets/js/watch.js"></script>';
        }
    ?>
    </body>

    </html>