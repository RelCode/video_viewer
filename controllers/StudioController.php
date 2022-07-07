<?php
require_once('./library/Controller.php');
class StudioController extends Library\Controller {
    public $user_id, $vid_id, $title, $description, $category, $path, $thumbnail;
    public function __construct($db){
        $this->studioModel = $this->model('studio',$db);
    }

    public function callMethod(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['create'])){
                if(!$this->create($_POST, $_FILES)){
                    $_SESSION['old']['title'] = $_POST['title'];
                    $_SESSION['old']['description'] = $_POST['description'];
                }
            }
        }
        return $this->index();
    }

    public function index(){
        $data = [];
        if($this->subpage() == 'view'){
            $data = $this->studioModel->myVideos($_SESSION['user']['id']);
        }elseif($this->subpage() == 'create'){
            $data = $this->studioModel->fetchCategories();
        }
        return $this->view('./views/studio/'.$this->subpage().'.php',$data);
    }

    public function create($post,$file){
        //validate file formats
        if(!$this->validateFormats($file['video'],$file['thumbnail'])){
            return false;
        }
        //validate file size
        if(!$this->validateSizes($file['video'],$file['thumbnail'])){
            return false;
        }
        $id = uniqid();
        //rename files as type_uniqid.format e.g: vid_12341234.mp4
        $file['video']['name'] = $this->renameFile($file['video'],'vid_',$id);
        $file['thumbnail']['name'] = $this->renameFile($file['thumbnail'],'img_',$id);
        //upload files
        $err1 = $this->fileUpload($file['video'],'./uploads/videos','video');//err will be 0 if successful
        $err2 = $this->fileUpload($file['thumbnail'],'./uploads/pictures','thumbnail');//err will be 1 if unsuccessful
        //move files into appropriate directories
        if($err1 == 1 || $err2 == 1){
            return false;
        }
        //get video duration
        $post['duration'] = $this->studioModel->analyze('./uploads/videos/'. $file['video']['name'])['playtime_string'];
        //insert the video
        if(!$this->studioModel->submitUploadData($id,$post,$file,$_SESSION['user']['id'])){
            $_SESSION['alert']['studio'] = "Upload Failed, Try Again";
            $_SESSION['alert']['class'] = "alert-danger";
            return false;
        }
        $_SESSION['alert']['studio'] = "Video Uploaded Successfully";
        $_SESSION['alert']['class'] = "alert-success";
        return true;
    }

    public function renameFile($file,$type,$id){
        return $type . $id . '.' . strtolower(pathinfo(basename($file['name']), PATHINFO_EXTENSION));
    }

    public function fileUpload($file,$dir,$type){
        if(!move_uploaded_file($file['tmp_name'],$dir . '/' . $file['name'])){
            $_SESSION['validation'][$type] = $type . ' uploading failed';
            return 1;
        }
        return 0;
    }

    public function validateFormats($video,$thumb){
        $err = 0;
        //get file format of the uploaded vid
        $vidFormat = strtolower(pathinfo(basename($video['name']), PATHINFO_EXTENSION));
        $vidAllowed = ['mp4', 'webm', 'mov']; //array of supported file formats
        if(!in_array($vidFormat,$vidAllowed)){//if video format is not supported, create error flash
            $_SESSION['validation']['video'] = "Supported Formats: .mp4, .webm, .mov";
            $err = 1;
        }
        $imgFormat = strtolower(pathinfo(basename($thumb['name']), PATHINFO_EXTENSION));
        $imgAllowed = ['jpeg', 'jpg', 'png'];
        if(!in_array($imgFormat,$imgAllowed)){
            $_SESSION['validation']['thumbnail'] = "Supported Formats: jpeg, jpg, png";
            $err = 1;
        }
        return $err == 0 ? true : false;//if err == 0 it means no  format validation error were found
    }

    public function validateSizes($video,$thumb){
        $err = 0;
        //size is in kilobytes. 500000 == 500KB
        $vidSize = $video['size'];
        if($vidSize > 50000000){ //if file size is greater than 50MB
            $_SESSION['validation']['video'] = "Video Size exceeds 50MB";
            $err = 1;
        }
        $imgSize = $thumb['size'];
        if($imgSize > 500000){
            $_SESSION['validation']['thumbnail'] = "Image Size exceeds 500KB";
            $err = 1;
        }
        return $err == 0 ? true : false;
    }   
}