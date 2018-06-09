<?php
	//Security
	session_start();
	if (!isset($_SESSION["admusername"])) {
		header("location:adminlogin.php");
		exit();
	} else {
		if ($_SESSION["admusername"] != "admin")
		{
			header("location:index.php");
			exit();
		}
	}
	
	//File Upload CSV
	
	require 'global_vars.php';
	$con = connect_2_db();
	
	mysqli_query($con, "TRUNCATE TABLE student_list"); //clean student list
	mysqli_query($con, "TRUNCATE TABLE login"); //clean login data
	mysqli_query($con, "TRUNCATE TABLE wing_pref"); //clean preference data
	mysqli_query($con, "TRUNCATE TABLE updates"); //clean update data
	
	if(is_uploaded_file($_FILES['studlist']['tmp_name'])) {
		$fileloc = $_FILES["studlist"]["tmp_name"];
		$fp = fopen($fileloc, "r");
		$h=0;
		$lc=0;
		$user_table_vals = array("");
		$c0 = $c1 = false;
		while(!feof($fp)) {
			$line = fgetcsv($fp);
			if(sizeof($line) == 2) {
				$c0 = check($line[0],"uid");
				$c1 = check($line[1], "name");
				if($c0 && $c1) {
					$rvs[0] = sanitize_input($line[0]);
					$rvs[1] = sanitize_input($line[1]);
					$user_table_vals[$h] = "('".implode("','",$rvs)."')";
					$h++;
					$lc++;
				} else {
					echo "<br>Error in Line ".($lc+1)." The line was skipped.";
					$lc++;
				}
			} else {
				echo "<br>Error in Line ".($lc+1)." The line was skipped.";
				$lc++;
			}
		}
		fclose($fp);
		$values = implode(",", $user_table_vals);
		if (!empty($values)) {
			mysqli_query($con, "INSERT IGNORE INTO student_list (uid,name) VALUES " . $values);
			if(strlen(mysqli_error($con))>0) {
				echo "<br>".mysqli_error($con);
			} else {
				echo "<br>Students Added to database";
			}
		} else {
			echo "<br><br>No Students added. File was empty or all entries were corrupt";
		}
		echo "<br><br><a href='admin.php'>GO BACK</a>";
	}
	
	function check($input, $case)
	{
		$op = false;
		switch($case)
		{
			case "uid":		if(preg_match("/^[a-zA-Z0-9]*$/", $input) && $input!="")
									$op = true;
								break;
			
			case "name":	if(preg_match("/^[a-zA-Z .]*$/", $input) && !preg_match("/^[ ]*$/", $input) && $input!="")
									$op = true;
								break;
		}
		return $op;
	}
	
?>