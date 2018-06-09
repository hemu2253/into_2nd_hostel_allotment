<?php
	require 'global_vars.php';
	$con = connect_2_db();
	
?>
<html>
	<head>
		<title>Group Registration</title>
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
			<div class='menu'><a href='index.php'><span class='icon-switch'> Login</span></a></div>
		</header>
		<div class='container'>
			<div class='commons'>
				<h1>Hostel Allotments</h1>
				<h2 style='padding-top: 10px;'>Group Registration</h2>
				<div class='contents'>
					<?php
						if(file_exists("files/status.txt")) {
							$fp = fopen("files/status.txt","r");
							$state = fgets($fp);
							if($state == "OFF") {
								echo "Registration is currently disabled. Please come back later.";
							} else {
								$groupSizeQuery = mysqli_query($con, "SELECT DISTINCT(quantity) FROM wing_list WHERE gid = '0' ORDER BY quantity");
								echo "<table class='pref-table' align='center'>";
									echo "<form name='form1' action='register_actions.php' method='POST'>";
										echo "<tr><td>ID:</td><td><input type='text' name='userid' id='userid' required='required' placeholder='Ex: f2014001'></td><td><div class='nope' id='uiddiv'></div></td></tr>";
										echo "<tr><td>Name:</td><td><input type='text' name='username' id='username' disabled></td><td><div class='nope' id='namediv'></div></td></tr>";
										echo "<tr><td>Phone:</td><td><input type='text' name='phone' id='phone' required='required' pattern='[7-9][0-9]{9}' placeholder='10 digits'></td><td><div class='nope' id='phonediv'></div></td></tr>";
										echo "<tr><td>Password:</td><td><input type='password' name='password' id='password' required='required'></td><td><div class='yup' id='pwddiv'></div></td></tr>";
										echo "<tr><td>Confirm Password:</td><td><input type='password' name='cnfpwd' id='cnfpwd' required='required'></td><td><div class='nope' id='cnfdiv'></div></td></tr>";
										echo "<tr><td>Group Size:</td><td>";
										echo "<select name='gsize' id='gsize' required='required'>";
											echo "<option value=''>Please Select</option>";
											while ($groupRow = mysqli_fetch_assoc($groupSizeQuery)) {
												$text = "Members";
												if ($groupRow['quantity'] == 1) {
													$text = "Member";
												}
												echo "<option value = ".$groupRow['quantity'].">".$groupRow['quantity']." ".$text."</option>";
											}
										echo "</select></td></tr>";
										echo "<tr><td colspan='3'><input type='submit' class='button' value='Register' id='sub-btn' hidden></td></tr>";
									echo "</form>";
								echo "</table>";
							}
							fclose($fp);
						} else {
							echo "Hostel Allotment is currently in an unknown state.";
						}
					?>
				</div>
			</div>
		</div>
		<script>
			$("#sub-btn").hide();
			var values = ["INVALID"];
			$("#userid").blur(function(){
				if($("#userid").val().length > 0)
				{
					$.post("regvalidate.php?request=uid",{uid: $("#userid").val()},function(data,status) {
						if(status=="success")
						{
							values = data.split("+");
							if(values[0]=="PASS") {
								$("#uiddiv").css("display","block");
								$("#uiddiv").removeClass("nope").addClass("yup");
								$("#sub-btn").show();
								$("#username").val(values[1]);
							} else if(values[0]=="EXIST") {
								alert("The account of ID already exists.");
								$("#uiddiv").css("display","block");
								$("#uiddiv").removeClass("yup").addClass("nope");
								$("#sub-btn").hide();
							} else if(values[0]=="PART") {
								alert("The ID entered is already a part of another group.");
								$("#uiddiv").css("display","block");
								$("#uiddiv").removeClass("yup").addClass("nope");
								$("#sub-btn").hide();
							} else if(values[0]=="INVALID") {
								alert("The ID entered is invalid.");
								$("#uiddiv").css("display","block");
								$("#uiddiv").removeClass("yup").addClass("nope");
								$("#sub-btn").hide();
							}
						} else {
							alert("Oops... Something went wrong!");
						}
					});
				}
			});
			
			$("#cnfpwd").blur(function(){
				if($("#cnfpwd").val() != '' && $("#password").val() == $("#cnfpwd").val()) {
					$("#cnfdiv").css("display","block");
					$("#cnfdiv").removeClass("nope").addClass("yup");
					$("#pwddiv").css("display","block");
					$("#pwddiv").removeClass("nope").addClass("yup");
					if (values[0] == "PASS") {
						$("#sub-btn").show();
					}
				} else {
					$("#cnfdiv").css("display","block");
					$("#cnfdiv").removeClass("yup").addClass("nope");
					$("#pwddiv").css("display","block");
					$("#pwddiv").removeClass("yup").addClass("nope");
					$("#sub-btn").hide();
				}
			});
			
			$("#password").blur(function(){
				if($("#password").val() != '' && $("#password").val() == $("#cnfpwd").val()) {
					$("#cnfdiv").css("display","block");
					$("#cnfdiv").removeClass("nope").addClass("yup");
					$("#pwddiv").css("display","block");
					$("#pwddiv").removeClass("nope").addClass("yup");
					$("#sub-btn").show();
				} else {
					$("#cnfdiv").css("display","block");
					$("#cnfdiv").removeClass("yup").addClass("nope");
					$("#pwddiv").css("display","block");
					$("#pwddiv").removeClass("yup").addClass("nope");
					$("#sub-btn").hide();
				}
			});
		</script>
	</body>
</html>