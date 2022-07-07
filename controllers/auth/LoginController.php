<?php

use Library\Controller;

require_once('./library/Controller.php');
class LoginController extends Controller{
    public function __construct($db){
        if(isset($_SESSION['loggedIn'])){
            header('location:?page=home');
        }
        $this->loginModel = $this->model('auth',$db);
    }

    public function callMethod(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->login($_POST);
        }
        return $this->index();
    }

    public function index(){
        return $this->view('./views/auth/login.php');
    }

    public function login($post){
        //validate user input
        if (!$this->validation($post['email'])) {
            return false;
        }
        //check if provided email address is not alrady registered
        if (!$this->loginModel->emailExists($post['email'])) {
            $this->emailNotRegistered();
            return false;
        }
        //attempt a login... if valid, user objec is returned, else we get a false boolean value
        $attempt = $this->loginModel->loginAttempt($post['email'], $post['password']);
        if($attempt == false){
            $this->loginFailed();
            return false;
        }
        $this->successfulLogin($attempt);
        header('location:?page=home');
    }

    public function validation($email){
        $_SESSION['validation']['email'] = (!filter_var($email, FILTER_VALIDATE_EMAIL)) ? "Invalid Email Address"  : "";
        if(!empty($_SESSION['validation']['email'])){
            $_SESSION['old']['email'] = !empty($email) ? $email : '';
            return false;
        }
        return true;
    }

    public function emailNotRegistered(){
        $_SESSION['alert']['auth'] = "Email Address Not Registered";
        $_SESSION['alert']['class'] = "alert-danger";
        return;
    }

    public function loginFailed(){
        $_SESSION['alert']['auth'] = "Login Attempt Failed. Incorrect Login Details Provided";
        $_SESSION['alert']['class'] = "alert-danger";
    }

    public function successfulLogin($user){
        $_SESSION['user'] = $user;
        $_SESSION['loggedIn'] = true;
        return true;
    }
}