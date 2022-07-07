<?php
session_start();
include './../config/database.php';
$database = new Database();
$db = $database->getConnection();
$user = $_SESSION['user']['id'];

    $action = isset($_POST['action']) ? $_POST['action'] : '';
    if ($action == 'pressedPlay') {
        $videoId = $_POST['videoId'];
        if($_SESSION['loggedIn']){//if user is signed in, add this as video watched by user
            userWatched($db,$user,$videoId);
        }
        $query = 'UPDATE video_info SET views = views + 1 WHERE video_id = :id';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $videoId);
        $stmt->execute();
        echo json_encode('done');
    } elseif ($action == 'like') {
        $video = $_POST['videoId'];
        $liked = videoLiked($db, $user, $video);
        $disliked = videoDisliked($db, $user, $video);
        if ($liked) { //if video already liked, we remove the like
            removeLike($db, $user, $video);
            updateLikes($db, $video, 'minus');
            $getCounts = getCount($db, $video, 'likes');
            echo $getCounts;
            exit; //then exit the script
        }
        if ($disliked) { //if the video already disliked, we remove the dislike, if it has been disliked before
            removeDislike($db, $user, $video);
            updateDislikes($db, $video, 'minus');
        }
        //insert like and update video likes
        insertReaction($db, $user, $video, 'likes');
        updateLikes($db, $video, 'add');
        //select updated likes/dislikes value
        $getCounts = getCount($db, $video, 'likes');
        echo $getCounts;
        exit;
    } elseif ($action == 'dislike') {
        $video = $_POST['videoId'];
        $liked = videoLiked($db, $user, $video);
        $disliked = videoDisliked($db, $user, $video);
        if ($liked) { //if video already liked, we remove the like
            removeLike($db, $user, $video);
            updateLikes($db, $video, 'minus');
        }
        if ($disliked) { //if the video already disliked, we remove the dislike, if it has been disliked before
            removeDislike($db, $user, $video);
            updateDislikes($db, $video, 'minus');
            $getCounts = getCount($db, $video, 'dislikes');
            echo $getCounts;
            exit; //then exit the script
        }
        //insert like and update video likes
        insertReaction($db, $user, $video, 'dislikes');
        updateDislikes($db, $video, 'add');
        //select updated likes/dislikes value
        $getCounts = getCount($db, $video, 'dislikes');
        echo $getCounts;
        exit;
    } elseif($action == 'comment'){
        $video = $_POST['video'];
        $body = $_POST['body'];
        $query = 'INSERT INTO comments (body, user, video) VALUES (:body, :user, :video)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':body',$body);
        $stmt->bindParam(':user',$user);
        $stmt->bindParam(':video',$video);
        $stmt->execute();
        exit;
    }elseif($action == 'addToPlaylist'){
        $video = $_POST['video'];
        $added = alreadyAddedToPlaylist($db,$user,$video);
        if($added){
            echo 'added';
            exit();
        }
        $query = 'INSERT INTO playlist (user, video) VALUES (:user, :video)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user',$user);
        $stmt->bindParam(':video',$video);
        $stmt->execute();
        echo 'added';
        exit();
    }
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'getComments'){
        $data = [];
        $video = $_GET['video'];
        $query = 'SELECT comments.id, comments.body, comments.user, comments.video, UNIX_TIMESTAMP(comments.created_at) as created_at, users.name  FROM comments INNER JOIN users ON users.id = comments.user WHERE video = :video ORDER BY comments.created_at DESC';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':video',$video);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $row['delete'] = $row['user'] == $_SESSION['user']['id'] ? 'yes' : 'no';
                array_push($data,$row);
            }
        }
        echo json_encode($data);
        exit;
    }elseif($action == 'deleteComment'){
        $id = $_GET['id'];
        $owner = userOwnsComment($db,$id,$user);
        if($owner){
            $query = 'DELETE FROM comments WHERE id = :id';
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            echo 'deleted';
        }
        exit;
    }