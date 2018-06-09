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
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=allotment_results.csv');
	$output = fopen('php://output', 'w');
	
	fputcsv($output, array("ID","NAME","ROOM"));
	$q2 = mysqli_query($con, "SELECT uid,name,room_num FROM room_list");
	while($r2 = mysqli_fetch_assoc($q2))
	{
		fputcsv($output, $r2);
	}
	fclose($output);
?>
