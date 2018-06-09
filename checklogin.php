<?php
	require "global_vars.php";

	$con = connect_2_db();
	$myusername=$_POST['login']; 
	$mypassword=$_POST['password']; 

	// To protect MySQL injection
	$myusername = sanitize_input($myusername); 
	$mypassword = sanitize_input($mypassword);

	$result = mysqli_query(
		$con, 
		"SELECT uid, gsize, progress FROM login WHERE uid='$myusername' and password='$mypassword'"
	);

	// Mysql_num_row is counting table row
	$count=mysqli_num_rows($result);
	// If result matched $myusername and $mypassword, table row must be 1 row
	if($count == 1)
	{
		$row = mysqli_fetch_array($result);
		session_start();
		$_SESSION["myusername"] = $myusername;
		$_SESSION["gsize"] = $row['gsize'];
		$_SESSION["progress"] = $row['progress'];
		header("location:main.php");
	}
	else
	{
		setcookie("error","1");
		header("location:index.php");
	}
?>