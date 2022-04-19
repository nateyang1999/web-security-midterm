<?php
session_start();
require_once('config.php');

if(isset($_POST['get_image']))
{
    $url=$_POST['img_url'];
    $data = file_get_contents($url);
    $time_str = strval(time());
    $new = 'uploads/'.$time_str.'.jpg';
    file_put_contents($new, $data);
    
    $userID = $_SESSION['userID'];
    $save_url = "https://webdemo.nateyang1999.works/".$new;
    // echo $save_url;
    $stmt = $conn->prepare("UPDATE `users` SET `avatar` = ? WHERE id = ?;");
    $stmt->bind_param("si",$save_url,$userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $nrows = $stmt->affected_rows;
    if (!$nrows) {
        $statusMsg = "上傳失敗";
    }
    else{
        // echo "success";
        header("location:account.php");
        die();
    }    
    // echo "<img src=$new>";
}
?>