<?php
namespace Library;
class Controller {

    public function model($model,$db){//$db is passed as parameter when the class is instantiated
        require_once('./models/' . ucfirst($model) . '.php');
        $model = new $model($db);//this is an instance of the class model with the same name as the directory/action
        return $model;
    }

    public function view($view, $data = []){
        require_once($view);
    }

    public function subpage(){
        if(isset($_GET['subpage'])){
            return $_GET['subpage'];
        }
        return 'view';
    }
}