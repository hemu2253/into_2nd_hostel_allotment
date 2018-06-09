<?php
	require 'global_vars.php';
	$con = connect_2_db();
	session_start();
	if(!isset($_SESSION['myusername'])) {
		header("location: index.php");
		exit();
	} else {
		$uid = $_SESSION["myusername"];
		$gsize = $_SESSION["gsize"];
	}
	if(isset($_POST['plist'])) {
		$plist = $_POST['plist'];
		if(sizeof($plist) == ($gsize-1)) {
			$gid = sanitize_input($uid);
			$query1 = mysqli_query($con, "SELECT progress FROM login WHERE uid='$gid'");
			if (mysqli_num_rows($query1) == 0) {
				echo "Unauthorized Access. Please Log Out";
				exit();
			} else {
				$row1 = mysqli_fetch_assoc($query1);
				$pstr = $row1['progress'];
				if ($pstr[0] == "0") {
					foreach($plist as $memid) {
						$memid = sanitize_input($memid);
						mysqli_query($con, "UPDATE student_list SET gid = '$gid' WHERE uid = '$memid'");
					}
					$query1 = mysqli_query($con, "SELECT progress FROM login WHERE uid='$gid'");
					$row1 = mysqli_fetch_assoc($query1);
					$pstr = $row1['progress'];
					$pstr[0] = "1";
					mysqli_query($con, "UPDATE login SET progress = '$pstr' WHERE uid = '$gid'");
					echo "Your group has been registered! To make any changes, you have to delete you account and register again.";
				} else {
					echo "You have already selected your group. Please refresh this page.";
				}
			}
		} else {
			echo "Data mismatch. Please delete your account and start the process again.";
		}
	}
	else {
		exit();
	}
?>