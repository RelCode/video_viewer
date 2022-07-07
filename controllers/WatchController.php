<?php
require_once('./library/Controller.php');
class WatchController extends Library\Controller {
    public function __construct($db)
    {
        $this->watchModel = $this->model('watch',$db);
    }

    public function callMethod(){
        return $this->index();
    }

    public function index(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $data = $this->watchModel->fetchVideo($id);
        // var_dump($data);
        return $this->view('./views/watch.php',$data);
    }
}