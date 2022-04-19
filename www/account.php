<?php 
    session_start();
    require_once('config.php');
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>帳戶管理</title>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-light navbar-light">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
      <a class="nav-link active" href="index.php"><?php 
            $conn->query("SET NAMES utf8");
            $stmt = $conn->prepare("SELECT * FROM `site_title`;");
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            echo $row['title'];       
        ?></a>
      </li>
     <li class="nav-item">
        <a class="nav-link" href="newpost.php">張貼留言</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="board.php">查看留言板</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="account.php">帳戶管理</a>
      </li>
    </ul>
  </div>
</nav>
<?php if(!isset($_SESSION['userID'])){
      echo "<a class=\"nav-link\" href=\"index.php\">請先登入</a>";
  }
?>
<?php if(isset($_SESSION['userID'])){?>
      <div class="container-fluid">
      <?php 
        $user_id = $_SESSION['userID'];
        $sql = "SELECT `username` FROM `users` WHERE `id` = $user_id";
        $result=mysqli_query($conn,$sql);
        $name=mysqli_fetch_array($result);
        echo "<p>使用者名稱: ".$name[0]."</p>";
      ?>
      </div>
      <div>


      </div>
      <div>
        <p>大頭貼:</p>
        <?php 
           $stmt = $conn->prepare("SELECT `avatar` FROM `users` WHERE `id` = ?;");
           $stmt->bind_param("i",$_SESSION['userID']);
           $stmt->execute();
           $result = $stmt->get_result();
           $row = $result->fetch_array();
           $img = $row['avatar'];
           $stmt->close();
           if($row) {
             echo "<img src= $img height=100 width=100>";
           }
        ?>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
          <input type="file" name="file">
          <input type="submit" name="submit" value="上傳檔案">
        </form>
      </div>
      <div id="text_div">
        <form method="POST" action="upload_url.php">
          <input type="text" name="img_url" placeholder="輸入圖片網址">
          <input type="submit" name="get_image" value="上傳">
        </form>
      </div>
      <a type="register" class="btn btn-link btn-block" href='logout.php'>登出</a>
<?php }?>

</html>
