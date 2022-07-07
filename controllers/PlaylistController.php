<?php
require_once('./library/Controller.php');
class PlaylistController extends Library\Controller {
    public function __construct($db){
        $this->playlistModel = $this->model('playlist',$db);
    }
    public function callMethod(){
        return $this->index();
    }
    public function index(){
        $data = $this->playlistModel->myPlaylist();
        return $this->view('./views/playlist.php',$data);
    }
}