<?php
	require 'global_vars.php';
	$con = connect_2_db();
	session_start();
	if(!isset($_SESSION['myusername'])) {
		header("location: index.php");
		exit();
	}
	$uid = $_SESSION["myusername"];
	$gsize = $_SESSION["gsize"];
	$query0 = mysqli_query($con, "SELECT progress FROM login WHERE uid='$uid'");
	$row0 = mysqli_fetch_assoc($query0);
	$pstr = $row0['progress'];
	
	//check ha state
	$state = "OFF";
	if(file_exists("files/status.txt")) {
		$fp = fopen("files/status.txt","r");
		$state = fgets($fp);
		fclose($fp);
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
			<a href='main.php'><div class='bits-logo'>
				<img src='img/bitslogo.png' class='bits-logo' style = "width:60px;" />
				<span>BITS Pilani<br><p>Hyderabad Campus</p></span>
			</div></a>
			<div class='menu'><a href='logout.php'><span class='icon-switch'> Logout</span></a></div>
			<div class='menu'><a href='#account'><span class='icon-user'> Account</span></a></div>
			<div class='menu'><a href='#rooms'><span class='icon-home'> Pick Rooms</span></a></div>
			<div class='menu'><a href='#winglist'><span class='icon-profile'> Wing List</span></a></div>
			<div class='menu'><a href='#wingpref'><span class='icon-tree'> Wing Preference</span></a></div>
			<div class='menu'><a href='#group'><span class='icon-users'> Make Group</span></a></div>
			<div class='menu'><a href='#instructions'><span class='icon-quill'> Instructions</span></a></div>
			<div class='menu'><a href='#'><span class='icon-spinner'> Updates</span></a></div>
		</header>
		<div class='container'>
			<div class='commons' style='height: 700px;'>
				<h1>Hostel Allotments</h1>
				<h2 style='padding-top: 10px;'>UPDATES</h2>
				<div class='contents'>
					<table>
						<?php
							$query1 = mysqli_query($con, "SELECT * FROM updates ORDER BY time DESC");
							while($row1 = mysqli_fetch_assoc($query1)) {
								echo "<tr style='height: 45px;'><td style='width: 200px;'><b>".$row1['time'].": </b></td><td> ".$row1['msg']."</td></tr>";
							}
						?>
					</table>
				</div>
			</div>
			
			<div class='commons'  id='instructions' name='instructions'>
				<h2>INSTRUCTIONS</h2>
				<div class='contents'>
					<table>
					<ul>
					<tr><td><li>If you want a hassle free experience, use Google Chrome only. The website won't work properly on Firefox. (Or, if you like to live dangerously, use Internet Explorer.)</li></td></tr>
					<tr style='height: 20px;'></tr>
					<tr><th>General Information</th></tr>
					<tr><td><li>All the notices regarding this process will only be posted in the "Updates" section on this portal.</li></td></tr>
					<tr><td><li>The process is highly automated, and hence it cannot be stressed enough that you strictly adhere to the deadlines posted in the updates section.</li></td></tr>
					<tr><td><li>If you fail to submit your data before the deadline, you will not be considered for that round and you will have to apply again in the next round (if there is any).</li></td></tr>
					<tr><td><li>If you make a mistake, be it in selecting group members or filling wing preferences, you have to delete your account and start the process again. You can delete your account from the "Account" section.</li></td></tr>
					<tr><td><li>You will not be allowed to delete your account after you are allotted a wing.</li></td></tr>
					<tr><td><li>For the purpose of transparency in the process, a complete list of ID's is shown in the "Make Group" section. The colour coding enables you to see students in various stages of allotment. The "Wing List" section gives you the list of all the wings available along with their capacity and the ID of the group leader to whom the wing is allotted.</li></td></tr>
					<tr><td><li>Please go through the Allotment Process given below. If you have any doubt regarding the process, please contact the hostel office. Ensure that the answer to your query is not already mentioned below.</li></td></tr>
					<tr style='height: 20px;'></tr>
					<tr><th>Process of Allotment</th></tr>
					<tr><td><li>Make your group according to the number of rooms available in different wings.</li></td></tr>
					<tr><td><li>Log into the hostel allotment portal and select the group members from "Make Group" section.</li></td></tr>
					<tr><td><li>Fill in the 3 wing preferences in the "Wing Preference" section, 1st being the most preferred.</li></td></tr>
					<tr><td><li>After the deadline, which will be announced in the "Updates" section, the allotment will be done.</li></td></tr>
					<tr><td><li>Allotment will follow a lucky draw kind of a process where if multiple groups have applied for same wing, one of the groups will be randomly selected.</li></td></tr>
					<tr><td><li>Those who do not get their first preference will then be tried for their second preference in the very same way and then for the third if they still are left out.</li></td></tr>
					<tr><td><li>Once that is done, all the allotted wings will be displayed here on this website in the "Wing List" section.</li></td></tr>
					<tr><td><li>You can check whether your group was allotted a wing or not in the "Account" section.</li></td></tr>
					<tr><td><li>For those groups who do not get any of their 3 preferences, a new round will be conducted and you are expected to form new groups based on the rooms in the remaining wings. Remaining wings can be seen in the "Wing List" section.</li></td></tr>
					<tr><td><li>For the new round, you have to delete your account from the the "Account" section and register again from the the login page. </li></td></tr>
					<tr><td><li>Once you are allotted a wing, the "Pick Room" section will be available for you to fill in the room choices for the group.</li></td></tr>
					<tr><td><li>Make sure to be extra careful while filling the rooms against the names of your group members because once you submit the room choices, they are final. No reason, whatsoever, will be accepted to change the rooms.</li></td></tr>
					<tr><td><li>The process of starting new rounds will continue until there are very few students left. After that, a random allotment will be done.</li></td></tr>
					<tr><td><li>The allotment once done is final and will not be changed except for those who were allotted randomly. Please keep checking the hostel notice board for more details on "Room Swapping for Randomly Allotted Students".</li></td></tr>
					</ul>
					</table>
				</div>
			</div>
			
			<div class='commons' name='group' id='group'>
				<h2>PICK YOUR WING MATES</h2>
				<div class='contents'>
					<div class='side-display' id='sidedisp'></div>
					<b>Tip: Use Ctrl+F (Find) in your browser to find the ID's faster!</b>
					<table align='center'><tr>
						<td><div style='position: relative; float: left; width:25px; height:25px; background:green; border-radius:50%;'></div></td><td style='width: 200px;'>Wing Allotted</td>
						<td><div style='position: relative; float: left; width:25px; height:25px; background:yellow; border-radius:50%;'></div></td><td style='width: 200px;'>Already Picked</td>
						<td><div style='position: relative; float: left; width:25px; height:25px; background:#3232ee; border-radius:50%;'></div></td style='width: 200px;'><td>Your Selection</td></tr>
					</table>
					<br>
					<?php
						//$team = array(); //to be used later in "Pick Room" section
						if($state == "OFF") {
							echo "This feature has been disabled by the Admin.";
						} else {
							echo "<table id='group-table'>";
							$query2 = mysqli_query($con,"SELECT * FROM student_list");
							$i=1;
							echo "<tr>";
							while($row2 = mysqli_fetch_assoc($query2)) {
								if($row2['allotted'] == 1)
									echo "<td class='green'><input type='checkbox' name='peopleList' id='s".$i."' value='".$row2['uid']."' disabled><label for='s".$i."'>".$row2['uid']."</label></td>";
								elseif($row2['gid'] == $uid)
									echo "<td class='yellow' style='background-color:#6262ee'><input type='checkbox' name='peopleList' id='s".$i."' value='".$row2['uid']."' disabled><label for='s".$i."'>".$row2['uid']."</label></td>";
								elseif($row2['gid'] != "0" && $row2['allotted'] == 0)
									echo "<td class='yellow'><input type='checkbox' name='peopleList' id='s".$i."' value='".$row2['uid']."' disabled><label for='s".$i."'>".$row2['uid']."</label></td>";
								else
									echo "<td><b><input type='checkbox' name='peopleList' id='s".$i."' value='".$row2['uid']."'><label for='s".$i."'>".$row2['uid']."</label></b></td>";
								
								if($i % 10 == 0)
									echo "<tr>";
								
								/*if($row2['gid'] == $uid)
								{
									array_push($team,$row2);
								}*/
								$i++;
							}
							echo "</b></table>";
						}
						if($pstr[0] == "1")
							$groupsize = 0;
						else
							$groupsize = $gsize - 1;
					?>
					<script>
						var gsize = <?php echo $groupsize; ?>;
					</script>
					<script src='js/ha.min.js'></script>
				</div>
			</div>
			<div class='commons' name='wingpref' id='wingpref'>
				<h2>WING PREFERENCE</h2>
				<div class='contents'>
					<?php
						if($state == "ON") {
							if($pstr[1] == "0") {
								$q3 = mysqli_query($con, "SELECT * FROM wing_list WHERE quantity=$gsize AND gid = '0'");
								echo "Available wings with ".$gsize." rooms:<br><br><br>";
								echo "<form name=form1 action='pref_actions.php' method='POST'>";
									echo "<table border='0' class='pref-table'>";
										echo "<tr><td>Wing Preference 1:<br><select name='pref1' id='pref1' required='required'>";
										echo "<option value=''>Please Select</option>";
										while($row=mysqli_fetch_assoc($q3)) {
											echo "<option value = '".$row['wing']."'>".$row['wing']."</option>";
										}
										echo "</select></td>";
										
										mysqli_data_seek($q3,0);
										echo "<td>Wing Preference 2:<br><select name='pref2' id='pref2' required='required'>";
										echo "<option value=''>Please Select</option>";
										while($row=mysqli_fetch_assoc($q3))
										{
											echo "<option value = '".$row['wing']."'>".$row['wing']."</option>";
										}
										echo "</select></td>";
										
										mysqli_data_seek($q3,0);
										echo "<td>Wing Preference 3:<br><select name='pref3' id='pref3' required='required' onchange='validate()'>";
										echo "<option value=''>Please Select</option>";
										while($row=mysqli_fetch_assoc($q3))
										{
											echo "<option value = '".$row['wing']."'>".$row['wing']."</option>";
										}
										echo "</select></td>";
									echo "</table><br>";
									echo "<input type='submit' value='Submit' id='submit-button' class='button'>";
								echo "</form>";
							}
							else
							{
								$q4 = mysqli_query($con, "SELECT * FROM wing_pref WHERE gid='$uid'");
								$r4 = mysqli_fetch_assoc($q4);
								echo "Entered Wing Preference:<br><br>";
								echo "<table border='0' class='pref-table' align='center'><tr>";
									echo "<td>Preference 1<br><b>".$r4['pref1']."</b></td>";
									echo "<td>Preference 2<br><b>".$r4['pref2']."</b></td>";
									echo "<td>Preference 3<br><b>".$r4['pref3']."</b></td>";
								echo "</tr></table>";
							}
						} else {
							echo "This feature has been disabled by the Admin.";
						}
					?>
					</div>
			</div>
			
			<div class='commons' name='winglist' id='winglist'>
				<h2>WING LIST</h2>
				<div class='contents'>
					<?php
						if($state=="ON") {
							$query3 = mysqli_query($con,"SELECT * FROM wing_list");
							echo "<table class='wing-list-table' align='center'>";
							echo "<tr><th style='text-align:left;'>Wing Name</th><th style='text-align:center;'>Wing Capacity</th><th style='text-align:right;'>Allotted to</th></tr>";
								while($row3 = mysqli_fetch_assoc($query3)) {
									echo "<tr><td style='text-align:left;'>".$row3['wing']."</td><td style='text-align:center;'>".$row3['quantity']."</td>";
									
									if($row3['gid'] == "0")
										$temp = "Not Allotted";
									else
										$temp = $row3['gid'];
									
									echo "<td style='text-align:right;'>".$temp."</td></tr>";
								}
							echo "</table>";
						} else {
							echo "This feature has been disabled by the Admin.";
						}
					?>
				</div>
			</div>
			
			<div class='commons' name='rooms' id='rooms'>
				<h2>PICK YOUR ROOMS</h2>
				<div class='contents'>
					<?php
						if($state == "ON") {
							if($pstr[2] == "1" && $pstr[3] == "1") {
								$awing = $r4['allotted_wing'];
								echo "<h3>Allotted Rooms</h3><ul style='text-align:left;'>";
								echo "<li>The allotment of rooms shown below is final.</li><li>In case of any major problem, please contact hostel office after all the allotment process is over.</li><li>Swapping will not be permitted.</li><li>Do NOT come to the office claiming that you made a mistake while filling up the rooms and now you want to change.</li><li>Any such request will not be entertained.</ul>";
								echo "<table align='center' class='wing-list-table' id='room-disp-table'>";
									echo "<tr><th style='text-align:left;'>Names</th><th style='text-align:right;'>Rooms</th></tr>";
									$query7 = mysqli_query($con,"SELECT * FROM room_list WHERE wing='$awing'");
									while($row7 = mysqli_fetch_assoc($query7))
									{
										echo "<tr><td style='text-align:left;'>".$row7['name']."</td><td style='text-align:right;'>".$row7['room_num']."</td></tr>"
										;
									}
								echo "</table>";
							}
							else if($pstr[2] == "1"  && $pstr[3] == "0") {
								echo "Select the room numbers against the names. Once submitted, the rooms will <b>not</b> be changed.";
								$awing = $r4['allotted_wing'];
								$query6 = mysqli_query($con, "SELECT room_num FROM room_list WHERE wing='$awing'");
								$query7 = mysqli_query($con, "SELECT * FROM student_list WHERE gid='$uid'");
								echo "<br><br>";
								echo "<form name='room-form' action='rooms_actions.php' method='POST'>";
								echo "<input type='hidden' name='room-post' value='yup'>";
									echo "<table align='center' class='pref-table' id='room-table'>";
										echo "<tr><th>Names</th><th>Rooms</th></tr>";
										$j = 1;
										while($member = mysqli_fetch_assoc($query7)) {
											echo "<tr><td style='text-align:left;'>".$member['name']."</td>";
											echo "<td style='text-align:right;'><select name='".$member['uid']."' id= 'select".$j."' required='required' onchange='validate(".$gsize.",".$j.")'>";
											echo "<option value=''>Please Select</option>";
											while($row6 = mysqli_fetch_assoc($query6)) {
												echo "<option value='".$row6['room_num']."'>".$row6['room_num']."</option>";
											}
											echo "</select></td>";
											echo "<td><div class='nope' id='check".$j."'></div></td></tr>";
											mysqli_data_seek($query6,0);
											$j++;
										}
										echo "<tr><td colspan='3'><input type='submit' class='button' id='roomsubbtn' value='Submit'></td></tr>";
									echo "</table>";
								echo "</form>";	
							} else {
								echo "This feature is currently unavailable";
							}
						} else {
							echo "This feature has been disabled by the Admin.";
						}
					?>
				</div>
			</div>
			
			<div class='commons' name='account' id='account'>
				<h2>YOUR ACCOUNT</h2>
				<div class='contents'>
					<?php
						echo "<b>ID: ".$uid."</b><br>";
						if(isset($r4)) {
							if($r4['allotted_wing'] == "0") {
								echo "Allotment Status: NOT ALLOTTED";
							} else {
								echo "Allotment Status: WING ALLOTTED - ".$r4['allotted_wing'];
							}
						} else {
							if ($state == "ON") {
								echo "Allotment Status: NOT ALLOTTED";
							} else {
								echo "Allotment Status: This feature has been disabled by the Admin.";
							}
						}
						echo "<br><br>";
						if($pstr[2]=="1") {
							echo "You cannot delete your account now...";
						} else {
							echo "<table>";
							echo "<ul>";
								echo "<tr><td><li>If you click the link below, your account will be permanently deleted.</li></td></tr>";
								echo "<tr><td><li>Do this if you wish to begin the process again or if you have made any mistake while selecting your wing mates or while filling up your preferences.</li></td></tr>";
								echo "<tr><td><li>You can register again from the link provided on the login page.</li></td></tr>";
								echo "<tr><td><li>You cannot delete your account once you are allotted a wing.</li></td></tr>";
							echo "</ul>";
							echo "<tr><th><br><br><u style='cursor:pointer; color:red;'><p id='delete_account_link'>DELETE ACCOUNT</p></u></th></tr>";
							echo "</table>";
						}
					?>
				</div>
				<script>
					$('#delete_account_link').click(function() {
						var reply = confirm('Do you want to delete your account?');
						if (reply == true) {
							window.location.href = 'delete_account.php';
						}
					});
				</script>
			</div>
		</div> <!--container-->
	</body>
</html>