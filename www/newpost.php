<?php
session_start();
require_once('config.php');
$title="";
$body="";
$a_id="";
?>
<?php if(!isset($_SESSION['userID'])){
      echo "<a class=\"nav-link\" href=\"index.php\">請先登入</a>";
  }
?>
<?php if(isset($_SESSION['userID'])){ ?>
<html>
<head>
    <meta charset="UTF-8">
    <title>張貼留言</title>
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
<div class="container mt-3">
  <h2>輸入留言</h2>
  <p></p>
  <form method="POST" action="upload_post.php" enctype="multipart/form-data">
    <div class="mb-3 mt-3">
      <input type="text" class="form-control" id="title" name="title" placeholder="請輸入標題"/>
    </div>
    <div class="mb-3 mt-3">
      <textarea class="form-control" rows="20" cols="30" id="body" name="body" placeholder="請輸入內文"></textarea>
    </div>
    <input type="file" name="file">
    <input type="submit" class="btn btn-primary" value="張貼留言">
  </form>
</div>

</body>
</html>
<?php } ?>