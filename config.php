<?php 
ob_start(); 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$timezone = date_default_timezone_set("Asia/Dhaka");
$con = mysqli_connect("localhost", "root", "", "pciu");
if(mysqli_connect_errno())
{
 echo "Failed to connect" . mysqli_connect_errno();
}
?>