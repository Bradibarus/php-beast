<?php 
	require 'connection.php';

	function get_role($username) {
		if(isset($_SESSION['role']) && ($_SESSION['role'] == 'user' || $_SESSION['role'] == 'admin')) {
			$role = $_SESSION['role'];
			return $role;
		} else {
			$query="select role from user WHERE username='$username'";
			global $link;
			$result = mysqli_query($link,$query);
			if(mysqli_num_rows($result)>0) {
				$row = mysqli_fetch_assoc($result);
				$role = $row['role'];
				$_SESSION['username'] = $username;
				$_SESSION['role'] = $role;
				return $role;
			} else {
				echo "Invalid session username: $username";
				unset($_SESSION['username']);
				return null;
			}
		}
	}

	function sign_out() {
		unset($_SESSION['role']);
		unset($_SESSION['username']);
		header('location:signin.php');
	}
?>