<html lang="en">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>BITS HAM</title>
        <meta name="description" content="Custom Login Form Styling with CSS3" />
        <meta name="keywords" content="css3, login, form, custom, input, submit, button, html5, placeholder" />
        <meta name="author" content="Pranjal Kumar, Mayank Dharwa" />
        <link rel='shortcut icon' href='favicon.ico' type='image/x-icon'/ >
        <link rel="stylesheet" type="text/css" href="css/login.css" />
		<script src="js/modernizr.custom.63321.js"></script>
		<!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
		<style>
		#logo {
			height: 220px;
			width: 220px;
			position: relative;
			left: -300px;
			top: 80px;
		}
		#pos1 {
			position: relative;
			left: -300px;
			top: 80px;
		}
		#pos2 {
			position: relative;
			left: -300px;
			top: 80px;
		}
		#pos3 {
			position: relative;
			left: -300px;
			top: 80px;
		}
		</style>
    </head>
    <body>
	    <div class="container">
			<header>
				<br><br>
				<img id='logo' src="./img/bitslogo.png">
				<h1 id='pos1'>BITS Pilani</h1>
				<h2 id='pos2'>Hostel Allotment</h2>
				<h3 id='pos3'>Admin Panel</h3>
				<div class="support-note">
					<span class="note-ie">Sorry, only modern browsers.</span>
				</div>		
			</header>
			<section class="main">
				<form class="form-3" method="POST" action="checkadmin.php" name="form1">
					<p class="clearfix">
						<input type="text" name="login" id="login" placeholder="Username">
					</p>
					<p class="clearfix">
						<input type="password" name="password" id="password" placeholder="Password"> 
					</p>
					<p class="clearfix">
						<input type="submit" name="submit" value="Sign in">
					</p>
					<?php
					if (isset($_COOKIE["error"]))
					{
						if ($_COOKIE["error"] == "1") {
							echo "<h3>Invalid username or password!</h3>";
						}
						else {
							echo "Something went wrong contact admin!";
						}
						setcookie("error", "", time()-120);
					}
					?>	
				</form>
				<!--This puts the focus on the text-box, so you don't have to click it to type-->
				<script>
					document.forms["form1"].elements["login"].focus();
				</script>
			</section>
		</div>
	</body>
</html>