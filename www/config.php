<?php
include "autoload.php";

define('DB_SERVER', env('DB_SERVER'));
define('DB_USERNAME', env('DB_USERNAME'));
define('DB_PASSWORD', env('DB_PASSWORD'));
define('DB_NAME', env('DB_NAME'));
 
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>