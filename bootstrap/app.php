<?php
    //include config files
    require_once('./config/core.php');
    require_once('./config/database.php');
    //include default view layouts (header)
    include './views/layouts/header.php';
    //we check if the page indicated points to a working directory
    if(in_array($page,$pages)){
        //if page is login or register, controller is in auth, else is in controllers folder
        if($page == 'login' || $page == 'register' || $page == 'logout'){
            $ctrlUrl = './controllers/auth/'.ucfirst($page).'Controller.php';
        }else{
            $ctrlUrl = './controllers/'.ucfirst($page).'Controller.php';
        }
        //fetch the controller with the matching name
        require_once($ctrlUrl);
        //create an instance of the controller class
        $ctrl = ucfirst($page) . 'Controller';
        $controller = new $ctrl($db);
        //return the view
        $controller->callMethod();
    }else{
        include './views/404.php';
    }
    // $_SESSION['loggedIn'] = true;
    //include default view layouts (footer)
    include './views/layouts/footer.php';
    include './config/session.helper.php';
?>