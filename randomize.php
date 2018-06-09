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
	
	require 'global_vars.php';
	
	$con = connect_2_db();
	
	$query1 = mysqli_query($con,"SELECT uid,name from student_list where allotted = '0'"); //get unallocated students
	echo mysqli_error($con);
	$query2 = mysqli_query($con, "SELECT room_num from room_list where uid ='0'"); //get unallocated rooms
	echo mysqli_error($con);
	$count1 = mysqli_num_rows($query1);
	$count2 = mysqli_num_rows($query2);
	/*de-comment the commented code below to achieve true randomness*/
	
	//$bag = array();
	if($count1 <= $count2) {
		//for($z=0;$z<$count1;$z++)
			//array_push($bag, $z);
		
		while($row1 = mysqli_fetch_array($query1)) {
			//$rnum = mt_rand(0,(sizeof($bag)-1));
			//mysqli_data_seek($query2,$bag[$rnum]);
			$row2 = mysqli_fetch_array($query2);
			mysqli_query($con, "UPDATE room_list SET uid = '".$row1['uid']."', name = '".$row1['name']."' WHERE room_num = '".$row2['room_num']."'");
			mysqli_query($con,"UPDATE student_list SET allotted = 1 WHERE uid = '".$row1['uid']."'");
			echo mysqli_error($con);
			//unset($bag[$rnum]);
			//$bag = array_values($bag);
		}
	} else {
		//for($z=0;$z<$count2;$z++)
			//array_push($bag, $z);
		
		while($row2 = mysqli_fetch_array($query2))
		{
			//$rnum = mt_rand(0,(sizeof($bag)-1));
			//mysqli_data_seek($query1,$bag[$rnum]);
			$row1 = mysqli_fetch_array($query1);
			mysqli_query($con, "UPDATE room_list SET uid = '".$row1['uid']."', name = '".$row1['name']."' WHERE room_num = '".$row2['room_num']."'");
			mysqli_query($con,"UPDATE student_list SET allotted = 1 WHERE uid = '".$row1['uid']."'");
			echo mysqli_error($con);
			//unset($bag[$rnum]);
			//$bag = array_values($bag);
		}
	}
	setcookie("random","1");
	header("location:admin.php");
?>
	