<?php
require_once('config.php');
session_start();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
<?php if(!isset($_SESSION['userID'])){
      echo "<a class=\"nav-link\" href=\"index.php\">請先登入</a>";
  }
?>
<?php if(isset($_SESSION['userID'])){ ?>
  <div class="table-responsive">
    <table class="table table-hover">
      <tr>
        <th>標題</th>
        <th>作者</th>
        <th>日期</th>
        </tr>
    <table>
    <?php $sql = "SELECT posts.id AS post_id,`title`,`created_time`,`author_id`,`username` FROM `posts` INNER JOIN users ON posts.author_id=users.id;";
          mysqli_query($conn,"SET NAMES UTF8");
          $result=mysqli_query($conn,$sql);
          mysqli_close($conn);
    ?>
   <tr> 
   <?php
      while ($row = mysqli_fetch_array($result)) {
            $post_id = $row['post_id'];
           ?>
           <tr>
               <td><?php 
                      $title = $row['title'];
                      echo "<a type=\"seepost\" class=\"btn btn-link btn-block\" href='seepost.php?post_id=$post_id'>$title</a>"; ?>
                </td> 
               <td><?php echo $row['username']; ?></td> 
               <td><?php echo $row['created_time']; ?></td>
               <td><?php if($_SESSION['userID']==$row['author_id']){
                     echo "<a type=\"delete\" class=\"btn btn-link btn-block\" href='delete_post.php?post_id=$post_id'>刪除</a>";
               }
               ?><td>
           </tr>
           <?php       }
   ?>
  <tr>

<?php }?>



</body>
</html>