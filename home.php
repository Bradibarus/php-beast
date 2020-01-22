<?php
  	session_start();
	require 'connection.php';
	require 'access.php';

  	if(!isset($_SESSION['username'])) {
  		header('location:signin.php');
  	} else {
  		$username = $_SESSION['username'];
  		$role = get_role($username) or die("Unknown user role error");
		if ($role == 'admin') {
			header('location:admin.php');
		} elseif($role != 'user') {
			echo "Unknown role recieved: $role";
		}
  	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Home Page</title>
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
			<h2>Welcome home</h2>	
			<a href="add.php">Add request</a>
			<?php
				$username = $_SESSION['username'] or die("Ошибка сессии");;
				$query = "select id, address, message, status from request where username = '$username'";
				$result = mysqli_query($link,$query) or die("Ошибка " . mysqli_error($link));
				if(isset($_GET['id'])){
					$id = $_GET['id'];
				}
				if(mysqli_num_rows($result)>0) {
					echo 
					"<table>
						<thead>
							<tr>
						    	<td>id</td>
								<td>address</td>
								<td>message</td>
								<td>status</td>
								<td></td>
						    </tr>
					    </thead>";
					while($row = mysqli_fetch_assoc($result)) {
						if (isset($id) && $id == $row["id"]) {
							$imagefile = 'files/'.$username."/".$id.".jpg";
							if(!file_exists($imagefile)) {
								$imagefile = 'files/'.$username."/".$id.".jpeg";
							} 
							echo 
						    "<tr style = 'background-color: yellow;'>
						    	<td>$row[id]</td>
								<td>$row[address]</td>
								<td>$row[message]</td>
								<td>$row[status]</td>
								<td><a href='home.php?id=$row[id]'>info</a></td>
						    </tr>";						    
							if(file_exists($imagefile)) {
								echo "
								</table>
								<img style='max-width: 500px; max-height: 400px;'' src=$imagefile>
								<table>
									<thead>
										<tr>
									    	<td>id</td>
											<td>address</td>
											<td>message</td>
											<td>status</td>
											<td></td>
									    </tr>
					    			</thead>
								";
							}
						} else {
							echo 
						    "<tr>
						    	<td>$row[id]</td>
								<td>$row[address]</td>
								<td>$row[message]</td>
								<td>$row[status]</td>
								<td><a href='home.php?id=$row[id]'>info</a></td>
						    </tr>";
						}
					}
					echo "</table>";			
				} else {
					echo "Requests not found for user $username";
				}
			?>
		</center>	
	</body>
</html>