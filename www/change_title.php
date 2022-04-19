<?php
session_start();
ob_start();
require_once('config.php');

if(isset($_POST['new_title'])&&isset($_POST["submit"])){
        $conn->query("SET NAMES utf8");
        $stmt = $conn->prepare("UPDATE site_title SET `title`= ? WHERE 1;");
        $new_t = $_POST['new_title'];
        $stmt->bind_param("s",$new_t);
        $stmt->execute();
        $nrows = $stmt->affected_rows;
        if (!$nrows) {
            echo "上傳失敗";
        }
        else{
            unset($_SESSION['adminID']);
            header("location:index.php");
            die();
        }
    $stmt->close();                       
}
ob_flush();
?>