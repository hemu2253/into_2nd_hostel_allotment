<?php
	require 'global_vars.php';
	$con = connect_2_db();
	session_start();
	if (!isset($_SESSION["admusername"])) {
		header("location:adminlogin.php");
		exit();
	}
	else {
		if ($_SESSION["admusername"] != "admin") {
			header("location:index.php");
			exit();
		}
	}
?>
<html>
	<head>
		<title>Hostel Allotments</title>
		<link rel="stylesheet" type="text/css" href="css/ha.css" />
		<link rel="stylesheet" type="text/css" href="css/elements.css" />
		<link rel='shortcut icon' href='favicon.ico' type='image/x-icon'/ >
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	</head>
	<body>
		<header>
			<a href='admin.php'><div class='bits-logo'>
				<img src='img/bitslogo.png' class='bits-logo' style = "width:60px;" />
				<span>BITS Pilani<br><p>Hyderabad Campus</p></span>
			</div></a>
			<div class='menu'><a href='logout.php'><span class='icon-switch'> Logout</span></a></div>
			<div class='menu'><a href='admin.php'><span class='icon-home'> Admin Home</span></a></div>
		</header>
		<div class='container'>
			<div class='commons'>
				<h1>Hostel Allotments</h1>
				<h2 style='padding-top: 10px;'>ERASE ACCOUNT</h2>
				<div class='contents'><br>
					<form name='form1' action='erase.php' method='POST'>
						<input type='hidden' name='erasing' value='destroyit'>
						Enter ID: <input type='text' name='delid' id='delid' placeholder='Ex: f2013001' required='required'>
						<br><br><input type='submit' value='Erase' class='button'>
					</form>
					<br><br>
					<?php
						if($_SERVER["REQUEST_METHOD"] == "POST")
						{
							if(isset($_POST['erasing'])	&& $_POST['erasing']=="destroyit")
							{
								$uid = sanitize_input($_POST['delid']);
								$q0 = mysqli_query($con, "SELECT gid FROM wing_list WHERE gid='$uid'");
								if (mysqli_num_rows($q0) > 0) {
									echo "<br>Cannot Erase after Allotment.<br>";
								} else {
									mysqli_query($con, "DELETE FROM login WHERE uid='$uid'");
									mysqli_query($con, "DELETE FROM wing_pref WHERE gid='$uid'");
									mysqli_query($con, "UPDATE student_list SET gid='0' WHERE gid='$uid'");
									echo "<br>All details of ".$uid." have been deleted.<br>";
								}
							}
						}
					?>
				</div>
			</div>
		</div>
	</body>
</html>