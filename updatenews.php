<?php

	session_start();
	if(!isset($_SESSION["admusername"])) {
		header("location:adminlogin.php");
		exit();
	} else {
		if($_SESSION["admusername"] != "admin")
		{
			header("location:index.php");
			exit();
		}
	}
	
	require 'global_vars.php';
	$con = connect_2_db();
	if (!empty($_POST['gardaddress'])) {
		$gardaddress = sanitize_input($_POST['gardaddress']);
		$today = date("Y-m-d H:i:s");
		mysqli_query($con,"INSERT INTO updates(`time`, `msg`) VALUES ('$today', '$gardaddress')");
	}
	
	header("location:admin.php");
?>
	
	
	