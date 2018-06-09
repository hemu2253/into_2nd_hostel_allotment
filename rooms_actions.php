<?php
	require 'global_vars.php';
	$con = connect_2_db();
	session_start();
	if(!isset($_SESSION['myusername'])) {
		header("location: index.php");
		exit();
	} else {
		$gid = $_SESSION["myusername"];
		$gsize = $_SESSION["gsize"];
	}
	$q0 = mysqli_query($con, "SELECT progress FROM login WHERE uid='$gid'");
	if (mysqli_num_rows($q0) == 0) {
		header("location:logout.php");
	}
	$row0 =	mysqli_fetch_assoc($q0);
	$pstr = $row0['progress'];
	if ($pstr[2] == "1"  && $pstr[3] == "0") {
		$q = mysqli_query($con, "SELECT * FROM student_list WHERE gid='$gid'");
		echo "<br><br>".mysqli_error($con);
		$error_flag = false;
		while($r = mysqli_fetch_assoc($q)) {
			if(!isset($_POST[$r['uid']])) {
				$error_flag = true;
			}
		}
		if(!$error_flag) {
			mysqli_data_seek($q,0);
			while($r = mysqli_fetch_assoc($q)) {
				$uid = $r['uid'];
				$name = $r['name'];
				$room = sanitize_input($_POST[$uid]);
				mysqli_query($con, "UPDATE room_list SET name='$name', uid='$uid' WHERE room_num='$room'");
				echo "<br><br>".mysqli_error($con);
			}
			mysqli_query($con, "UPDATE student_list SET allotted=1 WHERE gid='$gid'");
			echo "<br><br>".mysqli_error($con);
			mysqli_query($con, "UPDATE login SET progress='11110000' WHERE uid='$gid'");
			echo "<br><br>".mysqli_error($con);
		}
	}
	header("location: main.php");
?>