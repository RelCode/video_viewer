<?php
class Watch {
    public $conn, $video, $viewer, $uploader;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function fetchVideo($id){
        $data = [];
        $query = 'SELECT videos.id as video_id, videos.title, videos.description, videos.duration, videos.categories, videos.path, videos.thumbnail, videos.created_at, video_info.views, video_info.likes, video_info.dislikes, users.id as user_id, users.name, (SELECT COUNT(video) FROM comments WHERE video = :id) as comments_count, (SELECT video FROM playlist WHERE user = :user AND video = :video) as playlisted FROM videos INNER JOIN video_info ON videos.id = video_info.video_id INNER JOIN users ON videos.created_by = users.id WHERE videos.id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':user',$_SESSION['user']['id']);
        $stmt->bindParam(':video',$id);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $data['created_at'] = $this->time_elapsed_string($data['created_at']);
        }
        return $data;
    }
    public function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}