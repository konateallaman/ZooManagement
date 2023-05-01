<?php
$dbhost = 'localhost';
$dbusername = 'root';
$dbpassword = 'M$edio3108';
$dbname = 'safariha_zoodb';
$conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
if (!$conn) {
    die("Could not connect to:" . mysqli_connect_error());
//} else {
    //  echo '<br>Successfully connected';
}

?>


