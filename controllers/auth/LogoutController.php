<?php
abstract class Logout {
    abstract public function userLogout();
}

class LogoutController extends Logout {
    public function userLogout(){
        session_destroy();
        header('location:?page=home');
    }
    public function callMethod(){
        $this->userLogout();
    }
}