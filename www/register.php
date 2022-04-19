<?php
// if( !isset($_POST['username']) || !isset($_POST['password']) || $_POST['username']=="" || $_POST['password']=="" ){
//     header("Location: index.php");
// }
require_once('config.php');
$username = "";
$password = "";
$confirm_password="";
if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['confirm_password'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $message = "";

//   // $new_id_result=mysqli_query($conn,"SELECT id FROM users ORDER BY id DESC LIMIT 1;")->fetch_array();
//   // $new_id = intval($new_id_result[0])+1;
//   $sql = "INSERT INTO `users`(`username`, `password`, `avatar`) VALUES ('$username','$password',DEFAULT);";
//   echo($sql);

//   if ($conn->query($sql) === TRUE) {
//     echo "<p>註冊成功</p>";
//   } 
//   else {
//     echo "<p>Error: " . $sql . "<br>" . $conn->error."</p>";
//   }

// // mysqli_close($conn);
}


?>
<html>
<head>
    <meta charset="UTF-8">
    <title>註冊</title>
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
    <div class="d-flex justify-content-end">
    <a class="nav-link" href="index.php">登入</a>
    <a class="nav-link" href="register.php">註冊</a>
    </div>
  </div>
</nav>
<div class="container">
        <div class="row row-centered">
            <div class="col-xs-6 col-md-4 col-center-block">
                <h1 class="textcolor">註冊</h1>
                
                <form method="POST" action="">
                    <div class="mb-3 mt-3">
                        <label for="username" class="form-label">使用者名稱:</label>
                            <input type="username" class="form-control" id="username" placeholder="英數組成(15個字元內)" name="username">
                    </div>
                    <?php if(isset($_POST['username'])){
                      $username = trim($_POST['username']);;
                      $new_username = mysqli_query($conn,"SELECT * FROM users WHERE username = '$username';");
                      // echo "SELECT * FROM users WHERE username = '$username';";
                      $duplicate = mysqli_fetch_array($new_username);
                        if($duplicate){
                          echo "<p>該名稱已被使用過</p>";
                          unset($_POST['username']);
                        }
                        if($username==""){
                          echo "<p>欄位不可空白</p>";
                        }
                      }
                    ?>
                    <div class="mb-3">
                        <label for="password" class="form-label">密碼:</label>
                            <input type="password" class="form-control" id="password" placeholder="英數或特殊符號" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">確認密碼:</label>
                            <input type="password" class="form-control" id="confirm_password" placeholder="再次輸入密碼" name="confirm_password">
                    </div>
                    <?php if(isset($_POST['password'])&&isset($_POST['confirm_password'])){
                        $password = trim($_POST['password']);
                        $confirm_password = trim($_POST['confirm_password']);
                        if($confirm_password!==$password)
                        {
                          echo "<p>確認密碼和密碼不同，請重新輸入</p>";
                          unset($_POST['password']);
                          unset($_POST['confirm_password']);
                        }
                        if($password==""||$confirm_password==""){
                          echo "<p>欄位不可空白</p>";
                        }
                      }
                    ?>
                    <button type="submit" class="btn btn-primary">註冊</button>

                <?php if($username!=""&&$password!=""&&$confirm_password!=""&&$confirm_password==$password){
                          $sql = "INSERT INTO `users`(`username`, `password`, `avatar`) VALUES ('$username','$password','');";
                          // echo($sql);
                          if ($conn->query($sql) === TRUE) {
                            echo "<p>註冊成功</p>";
                            echo "<a class=\"nav-link\" href=\"index.php\">前往登入</a>";
                          } 
                          else {
                            echo "<p>Error: " . $sql . "<br>" . $conn->error."</p>";
                          }
                      }
                      mysqli_close($conn);
                ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>