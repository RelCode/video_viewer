<?php
require_once('./library/VideoInterface.php');
class Viewed implements Library\VideoInterface {
    public $user, $video, $conn;
    public function __construct($db){
        $this->conn = $db;
    }
    public function userVideoStats(){
        $this->user = $_SESSION['user']['id'];
        $data = [];
        $query = 'SELECT vv.id, vv.user, vv.video,  v.title, v.description, v.duration, v.thumbnail, vi.views, u.name FROM viewed_videos AS vv INNER JOIN videos AS v ON vv.video = v.id INNER JOIN users AS u ON u.id = :id INNER JOIN video_info AS vi ON vv.video = vi.video_id WHERE vv.user = :user GROUP BY vv.video ORDER BY vv.action_date DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id',$this->user);
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