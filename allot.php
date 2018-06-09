<html>
	<head>
		<link rel='shortcut icon' href='favicon.ico' type='image/x-icon'/ >
		<style>
			.allot-table {
				position: absolute;
				witdh: 70%;
				text-align: center;
				border-collapse: collapse;
				left: 50%;
				margin-left: -25%;
			}
			.allot-table td {
				width: 33%;
				padding: 5px;
				padding-left: 10px;
				padding-right: 10px;
			}
			.allot-table th {
				font-size: 25px;
				border-bottom: 1px solid #000000;
				border-top: 1px solid #000000;
				padding-top: 25px;
				padding-bottom: 10px;
			}
		</style>
	</head>
	<body>
		<?php
			session_start();
			if(!isset($_SESSION["admusername"])) {
				header("location:adminlogin.php");
				exit();
			} else {
				if($_SESSION["admusername"] != "admin") {
					header("location:adminlogin.php");
					exit();
				}
			}
			require 'global_vars.php';
			$con = connect_2_db();
			echo "<table class='allot-table'>";
			for($i = 0; $i < 3; $i++) {
				$round = $i + 1;
				$prefcol = 'pref' . $round;
				echo "<tr><th colspan=3>Preference ".$round." Allotment</th></tr>";
				$query = mysqli_query($con, "SELECT * FROM `wing_list` WHERE `gid`='0'");
				while($row = mysqli_fetch_array($query)) {
					$wing = $row['wing'];
					$qtext = "SELECT `wing_pref`.`gid` FROM `wing_pref` INNER JOIN `login` WHERE `wing_pref`.`".$prefcol."` = '$wing' AND `wing_pref`.`allotted_wing`='0' AND `login`.`uid`=`wing_pref`.`gid` AND `login`.`progress` = '11000000'";
					$q = mysqli_query($con, $qtext);
					$num = mysqli_num_rows($q);
					if($num > 1) {
						$num--;
						$_r = mt_rand(0,$num);
						mysqli_data_seek($q, $_r);
						$row2 = mysqli_fetch_array($q);
						$gid = $row2['gid'];
						
						mysqli_query($con, "UPDATE `wing_pref` SET `allotted_wing`='$wing' WHERE `gid` = '$gid'");
						mysqli_query($con, "UPDATE `wing_list` SET `gid`='$gid' WHERE `wing` = '$wing'");
						mysqli_query($con, "UPDATE `student_list` SET `allotted`=1 WHERE `gid`='$gid'");
						$queryx = mysqli_query($con, "SELECT `progress` FROM `login` WHERE `uid` = '$gid'");
						$rowx = mysqli_fetch_assoc($queryx);
						$pstr = $rowx['progress'];
						$pstr[2] = "1";
						mysqli_query($con, "UPDATE `login` SET `progress` = '$pstr' WHERE `uid` = '$gid'");
						echo "<tr><td>Wing</td><td> <b>".$wing."</b></td><td> allotted to ID: <b>".$gid."</b></td></tr>";
					} else if($num == 1) {
						$row2 = mysqli_fetch_array($q);
						$gid = $row2['gid'];
						
						mysqli_query($con, "UPDATE `wing_pref` SET `allotted_wing`='$wing' WHERE `gid` = '$gid'");
						mysqli_query($con, "UPDATE `wing_list` SET `gid`='$gid' WHERE `wing` = '$wing'");
						mysqli_query($con, "UPDATE `student_list` SET `allotted`=1 WHERE `gid`='$gid'");
						$queryx = mysqli_query($con, "SELECT `progress` FROM `login` WHERE `uid` = '$gid'");
						$rowx = mysqli_fetch_assoc($queryx);
						$pstr = $rowx['progress'];
						$pstr[2] = "1";
						mysqli_query($con, "UPDATE `login` SET `progress` = '$pstr' WHERE `uid` = '$gid'");
						echo "<tr><td>Wing</td><td> <b>".$wing."</b></td><td> allotted to ID: <b>".$gid."</b></td></tr>";
					} else {
						echo "<tr><td>Wing</td><td> <b>".$wing."</b></td><td> was not allotted to any ID.</td></tr>";
					}
				}
			}
			echo "</table>";
		?>
	</body>
</html>