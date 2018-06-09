<?php
	date_default_timezone_set("Asia/Kolkata");
	function connect_2_db()
	{
		$host="localhost";  
		$username="user3";  
		$password="Fr*x+chAsT5SpUY2*Ac6ep#A";
		$db_name="hostel_allotment";
		$con = mysqli_connect("$host", "$username", "$password","$db_name")or die("cannot connect"); 
		return $con;
	}

	function sanitize_input($raw_input) //included in all files where user input is expected. Makes input SQL query safe.
	{
		global $con;
		$raw_input = trim($raw_input);
		$raw_input = stripslashes($raw_input);
		$raw_input = htmlspecialchars($raw_input);
		$raw_input = mysqli_real_escape_string($con, $raw_input);
		return $raw_input;
	}