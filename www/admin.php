<?php
session_start();
ob_start();
require_once("config.php");
$message="";
$password="";
if(isset($_POST['password'])){
    $password = trim($_POST['password']);
}

//prepared statement
$stmt = $conn->prepare("SELECT * FROM `admin` WHERE `username` = 'admin' and `password` = ?;");
$stmt->bind_param("s",$password);
$stmt->execute();
$result = $stmt->get_result();


if(isset($_POST['password'])){
try {
    $row = mysqli_fetch_array($result);   
    
    if($row){
        $_SESSION['adminID']=$row['username'];
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
<?php if(isset($_SESSION['adminID'])){ ?>
        <span>Welcome,</span>
        <span><?php echo "admin"?></span>
        <form method="POST" action="change_title.php">
        <input type="text" class="form-control" id="new_title" name="new_title" placeholder="請輸入新的網站標題"/>
        <input type="submit" name="submit" value="更改">
        </form>
<?php }?>

<?php if(!isset($_SESSION['adminID'])){ ?>
    <span> 帳號: admin </span>
    <form method="POST" action="">
        <div class="edit input-group input-group-md">
            <span class="input-group-addon" id="sizing-addon2">
                <i class="glyphicon glyphicon-lock"></i></span>
            <input type="password" class="form-control" id="password" name="password" placeholder="請輸入密碼"/>
        </div>
        <br/>
        <button type="submit" class="btn btn-success btn-block">登入</button>
    </form>
<?php }?>
<?php
ob_end_flush();
?>