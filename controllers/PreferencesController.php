<?php
require_once('./library/Controller.php');
require_once('./library/SubpageTrait.php');
class PreferencesController extends Library\Controller{
    use Library\getUserPref;
    public $subpage;
    public function __construct($db){
        $this->subpage = $this->currentSubpage();
        $this->prefModel = $this->model($this->subpage,$db);
    }
    public function callMethod(){
        $this->index();
    }
    public function index(){
        $data = $this->prefModel->userVideoStats();
        return $this->view('./views/'.$this->subpage.'.php',$data);
    }
}