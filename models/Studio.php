<?php
require_once('./library/getid3/getid3/getid3.php');
require_once('./library/getid3/getid3/getid3.lib.php');
class Studio extends getID3{
    public $conn, $title, $description, $categories, $path, $thumbnail, $user;
    public function __construct($db){
        $this->conn = $db;
    }

    public function myVideos($id){
        $data = [];
        $query = 'SELECT videos.id as video_id, videos.title, videos.description, videos.duration, videos.categories, videos.path, videos.thumbnail, videos.created_at, video_info.views, video_info.likes, video_info.dislikes, users.id as user_id, users.name FROM videos INNER JOIN video_info ON videos.id = video_info.video_id INNER JOIN users ON videos.created_by = users.id WHERE videos.created_by = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                array_push($data,$row);
            }
        }
        return $data;
    }

    public function fetchCategories(){
        $data = [];
        $query = 'SELECT * FROM categories ORDER BY name ASC';
        $stmt = $this->conn->query($query);
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                array_push($data,$row['name']);
            }
            return $data;
        }
    }

    public function submitUploadData($id,$post,$file,$user){
        $query = 'INSERT INTO videos (id, title, description, duration, categories, path, thumbnail, created_by) VALUES (:id, :title, :description, :duration, :categories, :path, :thumbnail, :user)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':title',$post['title']);
        $stmt->bindParam(':description',$post['description']);
        $stmt->bindParam(':categories',$post['categories']);
        $stmt->bindParam(':duration',$post['duration']);
        $stmt->bindParam(':path',$file['video']['name']);
        $stmt->bindParam(':thumbnail',$file['thumbnail']['name']);
        $stmt->bindParam(':user',$user);
        if($stmt->execute()){
            $this->insertVideoInfo($id);
            return true;
        }
        return false;
    }

    public function insertVideoInfo($id){
        $query = 'INSERT INTO video_info (video_id) VALUES (:id)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        return true;
    }
}