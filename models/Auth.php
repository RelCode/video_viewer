<?php
class Auth {
    public $conn, $id, $name, $email, $password, $confirm;
    public function __construct($db) //the db object comes from the creation of the model in Controller.php
    {
        $this->conn = $db;
    }

    public function emailExists($email){
        $query = 'SELECT * FROM users WHERE email = :email';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email',$email);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }
        return false;
    }

    public function createUser($user){
        $this->id = 'user_' . uniqid();
        $this->name = $user['name'];
        $this->email = $user['email'];
        $this->password = password_hash($user['password'],PASSWORD_DEFAULT);
        $query = 'INSERT INTO users (id, name, email, password) VALUES (:id, :name, :email, :password)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id',$this->id);
        $stmt->bindParam(':name',$this->name);
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':password',$this->password);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function loginAttempt($email,$pass){
        $query = 'SELECT * FROM users WHERE email = :email';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email',$email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if(password_verify($pass, $user['password'])){
            return $user;
        }
        return false;
    }
}