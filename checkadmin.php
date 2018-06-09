<?php
require "global_vars.php";
// Connect to server and select database.
$con = connect_2_db();
// Define $myusername and $mypassword 
$myusername=$_POST['login']; 
$mypassword=$_POST['password']; 

// To protect MySQL injection
//sanitize_input(string) defined in functions.php
$myusername = sanitize_input($myusername); 
$mypassword = sanitize_input($mypassword);

$result = mysqli_query($con, "SELECT uid, password FROM adminlogin WHERE uid='$myusername' and password='$mypassword'");
// Mysql_num_row is counting table row
$count=mysqli_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1) {
	session_start();
	$_SESSION["admusername"]=$myusername;
	header("location:admin.php");
} else {
	setcookie("error","1");
	header("location:adminlogin.php");
}
?>