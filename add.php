<?php
  	session_start();
  	if(!isset($_SESSION['username'])) {
  		header('location:signin.php');
  	};
	require 'connection.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Add Request Page</title>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<?php
	        if(isset($_POST['sign_out'])) { 
	            sign_out(); 
	        }
	    ?> 	      
	    <form method="post"> 
	        <input type="submit" name="sign_out"
	                value="Sign out"/> 
	    </form> 
		<center>
			<h2>Add Request</h2>	
			<a href="home.php">home</a>
			<form action="add.php" method="post" enctype="multipart/form-data">
				<label><b>Address:</b></label><br>
				<input name="address" type="text" placeholder="Type address of the request" required/><br>
				<label><b>Message:</b></label><br>
				<input name="message" type="text" placeholder="Type additional info about the request" required/><br>
				<label><b>Image:</b></label><br>
			    <input type="file" name="userfile" id="userfile" accept="image/jpeg">
				<input name="add" type="submit" value="Add"/><br>
				<a href="home.php"><input type="button" value="Home"/></a>
			</form>
			<?php
				if(isset($_POST['address']) && isset($_POST['message']))
				{
					$username = $_SESSION['username'] or die("Ошибка сессии");;
					$address=$_POST['address'];
					$message=$_POST['message'];
					$query="insert into request (address, message, status, username) values ('$address', '$message', 0, '$username');";
					mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
					$id = mysqli_insert_id($link);
					if (isset($_FILES['userfile']['tmp_name']) && is_uploaded_file($_FILES['userfile']['tmp_name'])) {
						$uploaddir = 'files/'.$username."/";
						$filetype = $_FILES['userfile']['type'];
						if ($filetype != 'image/jpeg' && $filetype != 'image/jpg') die("Wrong file type");
						if (!is_dir($uploaddir)) {
							mkdir($uploaddir);
						};
						$filename = $_FILES['userfile']['name'];
						$explode = explode(".", $filename);
						$ext = end($explode);
						$uploadfile = $uploaddir.$id.".".$ext;
						move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
					}
					echo "Yout request was successfully added. You will be redirected soon.";
					$role = $_SESSION['role'];
					if ($role == 'user') {
						header('Refresh: 1; url=home.php?id='.$id);					
					} elseif($role == 'admin') {
						header('Refresh: 1; url=admin.php?id='.$id);					
					} else {
						echo "Unknown role recieved: $role";
					}
				} else {
					echo "Some of the parameters of the form not set";
				}
			?>
		</center>	
	</body>
</html>