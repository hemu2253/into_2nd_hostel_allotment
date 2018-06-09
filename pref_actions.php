<?php
	require 'global_vars.php';
	$con = connect_2_db();
	session_start();
	if(!isset($_SESSION['myusername'])) {
		header("location: index.php");
		exit();
	}
	else {
		$uid = $_SESSION["myusername"];
		$gsize = $_SESSION["gsize"];
	}
	if(isset($_POST['pref1']) && isset($_POST['pref2']) && isset($_POST['pref3'])) {
		$query1 = mysqli_query($con, "SELECT progress FROM login WHERE uid='$uid'");
		if (mysqli_num_rows($query1) == 0) {
			header("location:logout.php");
		} else {
			$row1 = mysqli_fetch_assoc($query1);
			$pstr = $row1['progress'];
			if ($pstr[1] == "1") {
				header("location:main.php#wingpref");
			} else {
				$pref1 = sanitize_input($_POST['pref1']);
				$pref2 = sanitize_input($_POST['pref2']);
				$pref3 = sanitize_input($_POST['pref3']);
				mysqli_query($con, "INSERT INTO wing_pref (gid, pref1, pref2, pref3, allotted_wing) VALUES ('$uid','$pref1','$pref2','$pref3', '0')");	
				echo mysqli_error($con);
				$pstr[1] = "1";
				mysqli_query($con, "UPDATE login SET progress = '$pstr' WHERE uid = '$uid'");
			}
		}
	}
	header("location:main.php#wingpref");
?>