<?php
class Home {
    public $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function fetchAllVideos(){
        $data = [];
        $query = 'SELECT videos.id, videos.title, videos.description, videos.duration, videos.categories, videos.thumbnail, video_info.views, video_info.likes, video_info.dislikes, users.name FROM videos INNER JOIN video_info ON videos.id = video_info.video_id INNER JOIN users ON videos.created_by = users.id ORDER BY videos.created_at DESC';
        $stmt = $this->conn->query($query);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($data,$row);
            }
        }
        return $data;
    }
}
