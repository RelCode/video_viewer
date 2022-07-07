<?php
    session_start();
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
    $subpage = isset($_GET['subpage']) ? $_GET['subpage'] : '';
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $item = isset($_GET['item']) ? $_GET['item'] : '';

    $pages = ['home','playlist','preferences', 'watch', 'search', 'studio', 'login', 'register','logout'];
?>