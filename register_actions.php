<?php
	require 'global_vars.php';
	$con = connect_2_db();
	if(isset($_POST['userid']) && isset($_POST['phone']) && !empty(trim($_POST['password'])) && isset($_POST['gsize']))
	{
		$uid = sanitize_input($_POST['userid']);
		$phone = sanitize_input($_POST['phone']);
		$pwd = sanitize_input($_POST['password']);
		$gsize = sanitize_input($_POST['gsize']);
		$progress = "00000000";
		mysqli_query($con,"INSERT INTO login (uid, password, phone, gsize, progress) VALUES ('$uid','$pwd','$phone','$gsize','$progress')");
		mysqli_query($con,"UPDATE student_list SET gid='$uid' WHERE uid='$uid'");
		setcookie("error","2");
	} else {
		setcookie("error", "4");
	}
	header("location: index.php");
?>