<?php	
	session_start();
	if(!isset($_SESSION["admusername"])) {
		header("location:adminlogin.php");
		exit();
	} else {
		if($_SESSION["admusername"] != "admin") {
			header("location:index.php");
			exit();
		}
	}
	
	$myfile = fopen("files/status.txt", "r") or die("Unable to open file!");
	$state = fgets($myfile);
	fclose($myfile);
	if($state == 'OFF') {
		$myfile = fopen("files/status.txt", "w") or die("Unable to open file!");
		$write1 = "ON";
		fwrite($myfile,$write1);
		fclose($myfile);
	} else {
		$myfile = fopen("files/status.txt", "w") or die("Unable to open file!");
		$write1 = "OFF";
		fwrite($myfile,$write1);
		fclose($myfile);
	}	
	header("location:admin.php");
?>
	