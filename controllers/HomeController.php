<?php
require_once('./library/Controller.php');
class HomeController extends Library\Controller {
    public function __construct($db)
    {
        $this->homeModel = $this->model('home', $db);
    }
    public function callMethod(){
        $this->index();
    }
    public function index(){
        $data = $this->homeModel->fetchAllVideos();
        return $this->view('./views/home.php',$data);
    }
}
