<?php
class Playlist {
    public $conn, $user, $video;
    public function __construct($db)
    {
        $this->user = $_SESSION['user']['id'];
        $this->conn = $db;
    }

    public function myPlaylist(){
        $data = [];
        //fetch video_id, title, duration, uploader, views
        $query = 'SELECT p.video, v.title, v.duration, v.thumbnail, vi.views, u.name FROM playlist AS p INNER JOIN videos AS v ON p.video = v.id INNER JOIN video_info AS vi ON p.video = vi.video_id INNER JOIN users AS u ON p.user = u.id WHERE p.user = :user';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user',$this->user);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                array_push($data,$row);
            }
        }
        return $data;
    }
}