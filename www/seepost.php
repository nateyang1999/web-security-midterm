<?php
require_once('config.php');
session_start();
$post_id = $_GET['post_id'];
mysqli_query($conn,"SET NAMES UTF8");
// $sql = "SELECT posts.id AS post_id,`title`,`created_time`,`attachment`,`body`,`author_id`,`username`,`avatar` FROM `posts` INNER JOIN users ON posts.author_id=users.id WHERE posts.id = $post_id;";
// $result=mysqli_query($conn,$sql);
// $row = mysqli_fetch_array($result);

//prepared statement
$stmt = $conn->prepare("SELECT posts.id AS post_id,`title`,`created_time`,`attachment`,`body`,`author_id`,`username`,`avatar` FROM `posts` INNER JOIN users ON posts.author_id=users.id WHERE posts.id = ?;");
$stmt->bind_param("i",$post_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();
mysqli_close($conn);


$title=$row['title'];
$body = $row['body'];
$created_time = $row['created_time'];
$avatar = $row['avatar'];
$attachment = $row['attachment'];
$author = $row['username'];
function replaceBBcodes($text)
{
    // $text = strip_tags($text);
	// BBcode array
	$find = array(
		'~\[b\](.*?)\[/b\]~s',
		'~\[i\](.*?)\[/i\]~s',
		'~\[u\](.*?)\[/u\]~s',
		'~\[color=([^"><]*?)\](.*?)\[/color\]~s',
		'~\[img\](https?://[^"><]*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
	);
	// HTML tags to replace BBcode
	$replace = array(
		'<b>$1</b>',
		'<i>$1</i>',
		'<span style="text-decoration:underline;">$1</span>',
		'<span style="color:$1;">$2</span>',
		'<img src="$1" alt="" />'
	);
		// Replacing the BBcodes with corresponding HTML tags
		return preg_replace($find, $replace, $text);
	}
?>
<?php if(isset($_SESSION['userID'])) {?>
<html>
    <meta charset="UTF-8">
    <title>查看貼文</title>
    <?php 
        echo "<h3>$title</h3>";
        echo "<span>作者: $author <img src = $avatar height=40 width=40></span><br>";
        echo "<span>發布時間: $created_time </span><br>";
        echo "<p>".replaceBBcodes($body)."</p>";
        echo "<br>";
        if($attachment){
            echo "<a href=$attachment>查看附加檔案</a>";
        }
    ?>
    <a href="board.php">回到留言列表</a>
<html>
<?php }?>
<?php if(!isset($_SESSION['userID'])) {

	echo "<a class=\"nav-link\" href=\"index.php\">請先登入</a>";
}
?>