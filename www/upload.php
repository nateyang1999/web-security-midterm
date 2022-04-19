<?php
session_start();
// Include the database configuration file
require_once('config.php');
$statusMsg = '';

// File upload path
$targetDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $userID = $_SESSION['userID'];
            $save_url = "https://webdemo.nateyang1999.works/".$targetFilePath;
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
            $stmt->close();
        }else{
            $statusMsg = "上傳失敗";
        }
    }else{
        $statusMsg = '只能上傳.jpeg , .jpg, .png 格式';
    }
}else{
    $statusMsg = '請選擇一個圖片檔';
}

// Display status message
echo $statusMsg;
?>