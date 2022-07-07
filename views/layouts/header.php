<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Viewer</title>
    <link rel="stylesheet" href="./assets/css/app.css">
    <?php
        if($page == 'watch'){
            echo '<link rel="stylesheet" href="./assets/css/watch.css"/>';
            echo '<link rel="stylesheet" href="./assets/ionicons/ionicons.min.css"/>';
        }
    ?>
    <!-- bootstrap css -->
    <link rel="stylesheet" href="./assets/bootstrap-4.6.1/bootstrap.min.css">
    <!-- fontawesome5 css -->
    <link rel="stylesheet" href="./assets/fontawesome-5.14.4/css/all.css">
</head>
<body>
    <!-- include the header layout -->
    <?php include './views/layouts/nav.php'; ?>