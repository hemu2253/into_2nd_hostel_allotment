<?php
require 'global_vars.php';
$con = connect_2_db();

if(isset($_GET)) {
	if(isset($_GET['request'])) {
		$request = sanitize_input($_GET['request']);
		switch($request) {
			case "uid":
				if(isset($_POST['uid']))
				{
					$uid = sanitize_input($_POST['uid']);
					$query0 = mysqli_query($con,"SELECT * FROM student_list WHERE uid='$uid'");
					$row0 = mysqli_fetch_assoc($query0);
					$query1 = mysqli_query($con,"SELECT COUNT(uid) AS num FROM login WHERE uid='$uid'");
					$row1 = mysqli_fetch_assoc($query1);
					if($row1['num'] == 0) {
						if(mysqli_num_rows($query0) == 1) {
							if($row0['gid']=="0") {
								echo "PASS+".$row0['name'];
							} else {
								echo "PART+";
							}
						} else {
							echo "INVALID+";
						}
					} else {
						echo "EXIST+";
					}
				}
			break;
		}
	}
}
function validateID()
{
	
}

?>