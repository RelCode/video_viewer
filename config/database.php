<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'video_viewer';
    private $user = 'root';
    private $password = '';
    public $conn;

    public function getConnection(){
        try{
            $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname,$this->user,$this->password);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $exception){
            echo 'ERROR: ' . $exception;
        }
        return $this->conn;
    }
}
date_default_timezone_set('Africa/Johannesburg');
//create a DB instance
$database = new Database();
//create a DB connection
$db = $database->getConnection();

function userWatched($db,$user,$video){
    $query = 'INSERT INTO viewed_videos (user, video) VALUES (:user, :video)';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user',$user);
    $stmt->bindParam(':video',$video);
    $stmt->execute();
    return true;
}

function videoLiked($db,$user,$video){
    $query =  'SELECT * FROM video_likes WHERE user = :user AND video = :video';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user',$user);
    $stmt->bindParam(':video',$video);
    $stmt->execute();
    if($stmt->rowCount() > 0){
        return true;
    }
    return false;
}

function removeLike($db,$user,$video){
    $query = 'DELETE FROM video_likes WHERE user = :user AND video = :video';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user',$user);
    $stmt->bindParam(':video',$video);
    $stmt->execute();
    return true;
}

function updateLikes($db,$video,$action){
    if($action == 'minus'){
        $query = 'UPDATE video_info SET likes = likes - 1 WHERE video_id = :video';
    }else{
        $query = 'UPDATE video_info SET likes = likes + 1 WHERE video_id = :video';
    }
    $stmt = $db->prepare($query);
    $stmt->bindParam(':video',$video);
    $stmt->execute();
    return true;
}

function videoDisliked($db,$user,$video){
    $query =  'SELECT * FROM video_dislikes WHERE user = :user AND video = :video';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':video', $video);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return true;
    }
    return false;
}

function removeDislike($db,$user,$video){
    $query = 'DELETE FROM video_dislikes WHERE user = :user AND video = :video';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user',$user);
    $stmt->bindParam(':video',$video);
    $stmt->execute();
    return true;
}

function updateDislikes($db,$video,$action){
    if ($action == 'minus') {
        $query = 'UPDATE video_info SET dislikes = dislikes - 1 WHERE video_id = :video';
    } else {
        $query = 'UPDATE video_info SET dislikes = dislikes + 1 WHERE video_id = :video';
    }
    $stmt = $db->prepare($query);
    $stmt->bindParam(':video',$video);
    $stmt->execute();
    return true;
}

function insertReaction($db,$user,$video,$action){
    if($action == 'likes'){
        $query = 'INSERT INTO video_likes (user, video) VALUES (:user, :video)';
    }else{
        $query = 'INSERT INTO video_dislikes (user, video) VALUES (:user, :video)';
    }
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':video', $video);
    $stmt->execute();
    return true;
}

function getCount($db,$video){
    $query = 'SELECT * FROM video_info WHERE video_id = :video';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':video', $video);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['likes'] . ',' . $row['dislikes'];
    }
    return '0,0';
}

function userOwnsComment($db,$id,$user){
    $query = 'SELECT * FROM comments WHERE id = :id AND user = :user';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id',$id);
    $stmt->bindParam(':user',$user);
    $stmt->execute();
    if($stmt->rowCount() > 0){
        return true;
    }
    return false;
}

function alreadyAddedToPlaylist($db,$user,$video){
    $query = 'SELECT * FROM playlist WHERE user = :user AND video = :video';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user',$user);
    $stmt->bindParam(':video',$video);
    $stmt->execute();
    if($stmt->rowCount() > 0){
        return true;
    }
    return false;
}