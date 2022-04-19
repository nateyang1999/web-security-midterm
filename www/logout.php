<?php
session_start();
session_destroy();
header("location:index.php");
exit();
// echo "登出成功";
// echo "<a type=\"register\" class=\"btn btn-link btn-block\" href='index.php'>回首頁</a>";
exit;
