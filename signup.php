<?php
  	session_start();
  	require 'access.php';

  	if(isset($_SESSION['username'])) {
  		$username = $_SESSION['username'];
  		$role = get_role($username) or die("Unknown user role error");
		if ($role == 'user') {
			header('location:home.php');
		} elseif($role == 'admin') {
			header('location:admin.php');
		} else {
			echo "Unknown role recieved: $role";
		}
  	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sign up Page</title>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
	
		<center>
			<h2>Sign Up Form</h2>	
			<form action="signup.php" method="post">
				<label><b>Username:</b></label><br>
				<input name="username" type="text" placeholder="Type your username" required/><br>
				<label><b>Password:</b></label><br>
				<input name="password" type="password" placeholder="Type your password" required/><br>
				<input name="password2" type="password" placeholder="Repeat your password" required/><br>	
				<input name="signup" type="submit" value="Sign Up"/><br>
				<a href="signin.php"><input type="button" value="Sign In"/></a>
			</form>
			<?php
				if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2']))
				{
					$username=$_POST['username'];
					$password=$_POST['password'];
					$password2=$_POST['password2'];
					if ($password2 == $password) {
						$md5_password = md5($password);
						$query="select username from user where username = '$username'";
						$query_run = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
						if(mysqli_num_rows($query_run)>0)
						{
							echo "Username already signed up. Choose another one or sign in.";
						} else {
							$query="insert into user (username, password, role) values ('$username', '$md5_password', 'user');";
							mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
							echo "Thanks for the sign up! U can no sign in.";
						}
					} else {
						echo "Passwords do not match";
					}					
				}
			?>
		</center>	
	</body>
</html>