<?php
require_once('config.php');
session_start();
$post_id = $_GET['post_id'];
$user_id = $_SESSION['userID'];
$stmt = $conn->prepare("DELETE FROM `posts` WHERE `id`= ? and `author_id`=?;");
$stmt->bind_param("ii",$post_id,$user_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
// $sql = "DELETE FROM `posts` WHERE `id`= $post_id and `author_id`=$user_id;";
// $result=mysqli_query($conn,$sql);
// mysqli_close($conn);
header('Location: '.'board.php');
die();
?>