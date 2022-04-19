<?php
session_start();
ob_start();
require_once('config.php');

if(isset($_POST['title'])&&isset($_POST['body'])){
    
    $title=$_POST['title'];
    $body = $_POST['body'];
    $a_id = $_SESSION['userID'];
    $conn->query("SET NAMES utf8");

    $targetDir = "uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    echo $targetFilePath;
    if(!empty($_FILES["file"]["name"])){
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            $save_url = "https://webdemo.nateyang1999.works/".$targetFilePath;          
        }
        echo $save_url;
        $stmt = $conn->prepare("INSERT INTO `posts`(`title`, `body`,`author_id`,`attachment`) VALUES (?,?,?,?);");
        $stmt->bind_param("ssis",$title,$body,$a_id,$save_url);
        $stmt->execute();
        $result = $stmt->get_result();
        $nrows = $stmt->affected_rows;
        if (!$nrows) {
            echo "上傳失敗";
        }
        else {
            header('Location: success_newpost.php');
            die();
        }        
    }
    // $sql = "INSERT INTO `posts`(`title`, `body`,`author_id`) VALUES ('$title','$body','$a_id');";
    else{
        $stmt = $conn->prepare("INSERT INTO `posts`(`title`, `body`,`author_id`) VALUES (?,?,?);");
        $stmt->bind_param("ssi",$title,$body,$a_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $nrows = $stmt->affected_rows;
        if (!$nrows) {
            echo "上傳失敗";
        }
        else {
            header('Location: success_newpost.php');
            die();
        }
    }
}
else
{   
    if(!isset($_POST['title'])){
        echo "<p>標題不可空白</p>";
    }
    if(!isset($_POST['body'])){
        echo "<p>內文不可空白</p>";
    }
}
ob_end_flush();
?>