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
	mysqli_query($con,"UPDATE student_list SET gid = 0 WHERE allotted = 0"); //reset student data
	mysqli_query($con,"DELETE FROM wing_pref WHERE allotted_wing='0'");
	setcookie("resetdone","1");
	header("location:admin.php");
?>

