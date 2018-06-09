<?php
	session_start();
	if(!isset($_SESSION["admusername"])) {
		header("location:adminlogin.php");
		exit();
	}
	else {
		if($_SESSION["admusername"] != "admin") {
			header("location:index.php");
			exit();
		}
	}
	$myfile = fopen("files/status.txt", "r") or die("Unable to open file!");
	$state = fgets($myfile);
	fclose($myfile);
	$buttonText = $state == "OFF" ? "CLICK HERE TO START PROCESS" : "CLICK HERE TO STOP PROCESS";
?>
<html>
	<head>
		<title>Hostel Allotments</title>
		<link rel="stylesheet" type="text/css" href="css/ha.css" />
		<link rel="stylesheet" type="text/css" href="css/elements.css" />
		<link rel="stylesheet" type="text/css" href="css/admin.css" />
		<link rel='shortcut icon' href='favicon.ico' type='image/x-icon'/ >
	</head>
	<body>
		<header>
			<a href='admin.php'><div class='bits-logo'>
				<img src='img/bitslogo.png' class='bits-logo' style = "width:60px;" />
				<span>BITS Pilani<br><p>Hyderabad Campus</p></span>
			</div></a>
			<div class='menu'><a href='adminlogout.php'><span class='icon-switch'> Logout</span></a></div>
			<div class='menu'><a href='erase.php'><span class='icon-pencil2'> Erase</span></a></div>
		</header>
		<div class='container'>
			<div class='commons'>
				<h2 style='padding-top: 25px;'>ADMIN PANEL</h2>
				<div class='contents'>
					<h2>Allotment</h2>
					<table class='center-table' align='center' border=1>
						<tr><td colspan="3"><a href='start_stop.php' name="start" id="start"><?php echo $buttonText;?></a></td></tr>
						<tr></tr><tr>
							<?php
								if ($state == 'OFF') {
									echo "<td><a href='reset_data.php' name='reset' id='reset'>START NEW ROUND</a></td>";
									echo "<td><a href='allot.php' name='allot' id='allot'>DO ALLOTMENTS</a></td>";
								} else {
									echo "<td>STOP PROCESS FOR NEW ROUND</td>";
									echo "<td>STOP PROCESS TO ALLOT</td>";
								}
							?>
						</tr>
						<tr></tr>
						<tr><td colspan='3'>
							<a href='dwnld.php' name="dwnld" id="dwnld">DOWNLOAD RESULTS</a></td>
						</tr>
					</table>
				</div>
				<div class = 'contents'>
					<h2>Add Update</h2>
					<form name='stuform' action ='updatenews.php' method='post'>
						<textarea rows='15' cols='120' name='gardaddress' maxlength='400' placeholder='Enter Update Message Here!'></textarea>
						<br>
						<input type="submit" value="ADD" name="submitupdate" id='updatebtn' class='button'>
					</form>
				</div>
				<div class='contents'>
					<h2>Import Student Data</h2>
					<table>
						<tr><th><h3>Student List<h3></th></tr>
						<ul>
							<tr><td><li>Any Line should NOT have titles.</li></td></tr>
							<tr><td><li>First Row: Student ID, Second Row: Student Name</li></td></tr>
							<tr><td><li>Ex: f2011408, Mayank Dharwa</li></td></tr>
						</ul>
					</table><br>
					<form action="upload_stud.php" method="post" enctype="multipart/form-data">
						<input type="file" name="studlist" id="list" accept=".csv" required='required'>
						<input type="submit" value="Upload Student List" name="submitstu" class="stulist">
					</form>
					<br><br>
					<table>
						<tr><th><h3>Room Wing List<h3></th></tr>
						<ul>
							<tr><td><li>Any Line should NOT have titles.</li></td></tr>
							<tr><td><li>First Row: Room Number, Second Row: Wing Name</li></td></tr>
							<tr><td><li>Ex: B232, BFFW02</li></td></tr>
						</ul>
					</table><br>
					<form action="upload_room.php" method="post" enctype="multipart/form-data">
						<input type="file" name="roomlist" id="list" accept=".csv" required='required'>
						<input type="submit" value="Upload Room List" name="submitroom" class="stulist">
					</form>
				</div>	
			</div>
			<script language="javascript" type="text/javascript">
				//read a popper cookie 
				var pin = document.cookie.replace(/(?:(?:^|.*;\s*)resetdone\s*\=\s*([^;]*).*$)|^.*$/, "$1");
				if(pin =='1') {
					alert('Ready For Next Round!'); //notify user
					document.cookie="resetdone=0";
				}	
				//read a popper cookie 
				var random = document.cookie.replace(/(?:(?:^|.*;\s*)random\s*\=\s*([^;]*).*$)|^.*$/, "$1");
				if(random =='1') {
					alert('Random Allotment Done!'); //notify user
					document.cookie="random=0";
				}	
			</script>
		</div> <!--container-->
	</body>
</html>