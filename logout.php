<?php 
	$value=99;
	if(isset($_COOKIE['error'])) {
		$value = $_COOKIE['error'];
	}
	if(isset($_SERVER['HTTP_COOKIE'])) {
		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		foreach($cookies as $cookie)
		{
			$parts = explode('=', $cookie);
			$name = trim($parts[0]);
			setcookie($name, '', time()-120);
			setcookie($name, '', time()-120, '/');
		}
	}
	//session_destroy();
	if($value!=99) {
		setcookie("error","$value");
	}
	header("location:index.php");
?>