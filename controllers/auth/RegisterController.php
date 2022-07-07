<?php
require_once('./library/Controller.php');
class RegisterController extends Library\Controller {
    public function __construct($db){
        if (isset($_SESSION['loggedIn'])) {
            header('location:?page=home');
        }
        $this->registerModel = $this->model('auth',$db);
    }

    public function callMethod(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->register($_POST);
        }
        return $this->index();
    }

    public function index(){
        return $this->view('./views/auth/register.php');
    }

    public function register($post){
        //cvalidate user input
        if(!$this->validation($post['name'], $post['email'], $post['password'], $post['confirm'])){
            return false;
        }
        //check if provided email address is not alrady registered
        if ($this->registerModel->emailExists($post['email'])) {
            $this->emailRegistered();
            return false;
        }
        //run the method to create user
        if (!$this->registerModel->createUser($post)) {
            //if false is returned::run the create user error method
            $this->registerFailed();
            return false;
        }
        //if true is returned::run the create user success method
        $this->registerSuccessful();
        return true;
    }

    public function validation($name,$email,$password,$confirm){
        $_SESSION['validation']['name'] = (!preg_match("/^[a-zA-Z\s]+$/", $name)) ? "Name Must Be Letters Only" : "";
        $_SESSION['validation']['email'] = (!filter_var($email, FILTER_VALIDATE_EMAIL)) ? "Invalid Email Address"  : "";
        $_SESSION['validation']['password'] = $password !== $confirm ? "Password Don't Match" : "";
        if(!empty($_SESSION['validation']['name']) || !empty($_SESSION['validation']['email']) || !empty($_SESSION['validation']['password'])){
            $_SESSION['old']['name'] = !empty($name) ? $name : '';
            $_SESSION['old']['email'] = !empty($email) ? $email : '';
            return false;
        }
        return true;
    }

    public function registerFailed(){
        $_SESSION['alert']['auth'] = "User Creation Failed";
        $_SESSION['alert']['class'] = "alert-danger";
        return;
    }

    public function registerSuccessful(){
        $_SESSION['alert']['auth'] = "User Successfully Registered";
        $_SESSION['alert']['class'] = "alert-success";
        return;
    }

    public function emailRegistered(){
        $_SESSION['alert']['auth'] = "Email Address Already Registered";
        $_SESSION['alert']['class'] = "alert-danger";
        return;
    }
}