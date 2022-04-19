<?php
session_start();
require_once('config.php');
$message="";
$username="";
$password="";
if(isset($_POST['username']))
{
    $username = trim($_POST['username']);
}
if(isset($_POST['password'])){
    $password = trim($_POST['password']);
}

// $sql = "SELECT * FROM `users` WHERE `username` = '$username' and `password` = '$password';";
// $result=mysqli_query($conn,$stmt);
// mysqli_close($conn);

//prepared statement
$stmt = $conn->prepare("SELECT * FROM `users` WHERE `username` = ? and `password` = ?;");
$stmt->bind_param("ss",$username,$password);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();


if(isset($_POST['username'])&&isset($_POST['password'])){
try {
    $row = mysqli_fetch_array($result);   
    
    if($row){
        $_SESSION['userID']=$row['id'];
        $_SESSION['username']=$row['username'];
        $message="登入成功";
    }else{
        $message="登入失敗";
    }
    
    // if(isset($_SESSION["userID"])) {
    //     header("Location:index.php");
    // }
    
}
catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), '<br>';
    echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
}
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php 
        $conn->query("SET NAMES utf8");
        $stmt = $conn->prepare("SELECT * FROM `site_title`;");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        echo $row['title'];       
    ?></title>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-light navbar-light">
  <div class="container-fluid">
    <ul class="navbar-nav">
     <li class="nav-item">
        <a class="nav-link" href="newpost.php">張貼留言</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="board.php">查看留言板</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="account.php">帳戶管理</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin.php">管理員頁面</a>
      </li>
    </ul>
    <?php if(!isset($_SESSION['userID'])){ ?>
    <div class="d-flex justify-content-end">
    <a class="nav-link" href="index.php">登入</a>
    <a class="nav-link" href="register.php">註冊</a>
    </div>
    <?php } ?>
  </div>
</nav>
    <div class="container">
        <div>
            <div>
                <h1 class="textcolor"><?php 
                    $conn->query("SET NAMES utf8");
                    $stmt = $conn->prepare("SELECT * FROM `site_title`;");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    echo $row['title'];       
                ?></h1>
                <?php if(isset($_SESSION['userID'])){ ?>
                    <span>Welcome,</span>
                    <span><?php echo $_SESSION['username']?></span>
                <?php }?>
                <?php if(!isset($_SESSION['userID'])){ ?>
                <form method="POST" action="">
                    <div class="input-group input-group-md">
                        <span class="input-group-addon" id="sizing-addon1">
                            <i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" id="username" name="username" placeholder="請輸入使用者名稱"/>
                    </div>
                    <div class="edit input-group input-group-md">
                        <span class="input-group-addon" id="sizing-addon2">
                            <i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="請輸入密碼"/>
                    </div>
                    <br/>
                    <button type="submit" class="btn btn-success btn-block">登入</button>
                    <a type="register" class="btn btn-link btn-block" href='register.php'>註冊</a>
                </form>
                <?php } ?>
                <?php if(isset($_SESSION['userID'])){ ?>
                    <a type="register" class="btn btn-link btn-block" href='logout.php'>登出</a>
                <?php }?>
            </div>
        </div>
        <div class="message"><?php if($message!="登入成功") { echo $message; } ?></div>

    </div>
</body>
</html>