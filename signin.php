<?php
  	session_start();
	require 'connection.php';
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
		<title>Sign In Page</title>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
	
		<center>
			<h2>Sign In Form</h2>	
			<form action="signin.php" method="post">
				<label><b>Username:</b></label><br>
				<input name="username" type="text" placeholder="Type your username" required/><br>
				<label><b>Password:</b></label><br>
				<input name="password" type="password" placeholder="Type your password" required/><br>
				<input name="signin" type="submit" value="Sign In"/><br>
				<a href="signup.php"><input type="button" value="Sign Up"/></a>
			</form>
			<?php
				if(isset($_POST['username']) && isset($_POST['password'])) {
					$username=$_POST['username'];
					$password=$_POST['password'];
					$md5_password = md5($password);					
					$query="select role from user WHERE username='$username' AND password='$md5_password'";
					$query_run = mysqli_query($link,$query);
					if(mysqli_num_rows($query_run)>0) {
						$_SESSION['username'] = $username;
						$row = mysqli_fetch_assoc($result);
						$role = $row['role'];
						$_SESSION['role'] = $role;
						header('location:home.php');
					} else {
						echo "Invalid credentials";
					}					
				}
			?>
		</center>	
	</body>
</html>