<?php
	require 'global_vars.php';
	$con = connect_2_db();
	session_start();
	if (!isset($_SESSION['myusername'])) {
		header("location: index.php");
		exit();
	}
	else {
		$uid = $_SESSION["myusername"];
	}
	$q0 = mysqli_query($con, "SELECT progress FROM login WHERE uid='$uid'");
	if (mysqli_num_rows($q0) != 0) {
		$row0 =	mysqli_fetch_assoc($q0);
		$pstr = $row0['progress'];
		if($pstr[2] == "0") {
			mysqli_query($con, "DELETE FROM login WHERE uid='$uid'");
			mysqli_query($con, "DELETE FROM wing_pref WHERE gid='$uid'");
			mysqli_query($con, "UPDATE student_list SET gid='0' WHERE gid='$uid'");		
		}
	}
	header("location:logout.php");
?>