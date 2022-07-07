<?php
require_once('./library/VideoInterface.php');
class Liked implements Library\VideoInterface
{
    public $user, $video, $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function userVideoStats()
    {
        $this->user = $_SESSION['user']['id'];
        $data = [];
        $query = 'SELECT vl.id, vl.user, vl.video,  v.title, v.description, v.duration, v.thumbnail, vi.views, u.name FROM video_likes AS vl INNER JOIN videos AS v ON vl.video = v.id INNER JOIN users AS u ON u.id = :id INNER JOIN video_info AS vi ON vl.video = vi.video_id WHERE vl.user = :user ORDER BY vl.action_date DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->user);
        $stmt->bindParam(':user', $this->user);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($data, $row);
            }
        }
        return $data;
    }
}
