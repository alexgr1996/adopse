<?php 
session_start();

	include("connection.php");
	include("functions.php");
    $Error = "";

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
		$user_mail = $_POST['user_mail'];
		$con_pass = $_POST['confirm_password'];

		$sname = mysqli_query($con, "SELECT * FROM users WHERE user_name = '". $_POST['user_name']."'");
		$smail = mysqli_query($con, "SELECT * FROM users WHERE user_mail = '". $_POST['user_mail']."'");
	
		if(!preg_match("/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/",$user_mail)) {
			$Error = "Please enter a valid email";
		}
		
		elseif(mysqli_num_rows($sname)) {
			echo "This username already exists";
		}
		
		elseif(mysqli_num_rows($smail)) {
			echo "This email already exists";
		}
		
		
		elseif($con_pass !== $password) {
			echo "Password and confirm Password are not the same!";
		}

		elseif(!empty($user_name) && !empty($password) && !empty($user_mail) && !is_numeric($user_name))
		{


			//save to database
			$user_id = random_num(20);
			$query = "insert into users(user_id,user_name,password,user_mail) values('$user_id','$user_name','$password','$user_mail')";

			mysqli_query($con,$query);

			header("Location: login.php");
			die;
		}else
		{
			echo "Please enter some valid information!";
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>
</head>
<body>

	<style type="text/css">
	
	#text{

		height: 25px;
		border-radius: 5px;
		padding: 4px;
		border: solid thin #aaa;
		width: 100%;
	}

	#button{

		padding: 10px;
		width: 100px;
		color: white;
		background-color: lightblue;
		border: none;
	}

	#box{

		background-color: grey;
		margin: auto;
		width: 300px;
		padding: 20px;
	}

	</style>

	<div id="box">
		
	<form method="post">
			<div><?php 
				if(isset($Error) && $Error != "")
				{
					echo $Error;
				}
			?>
			</div>
			<div style="font-size: 20px;margin: 10px;color: white;">Signup</div>
			<input id="text" type="email" name="user_mail" placeholder="Email"><br><br>
            <input id="text" type="text" name="user_name" placeholder="Username"><br><br>
			<input id="text" type="password" name="password" placeholder="Password"><br><br>
			<input id="text" type="password" name="confirm_password" placeholder="Confirm Password"><br><br>

			<input id="button" type="submit" value="Signup"><br><br>

			<a href="login.php">Click to Login</a><br><br>
		</form>
	</div>
</body>
</html>