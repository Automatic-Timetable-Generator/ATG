<?php  
	session_start();

	$username = "";
	$email = "";
	$errors = array();

	$db = mysqli_connect('localhost', 'root', '', 'registration');

	
	if (isset($_POST['register'])) {
	/*	$username = mysql_real_escape_string($link,$_POST['username']);
		$email = mysql_real_escape_string($link,$_POST['email']);
		$password_1 = mysql_real_escape_string($link,$_POST['password_1']);
		$password_2 = mysql_real_escape_string($link,$_POST['password_2']);
	*/
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password_1 = $_POST['password_1'];
		$password_2 = $_POST['password_2'];

		if(empty($username)) {
			array_push($errors, "Username is required");
		}
		if(empty($email)) {
			array_push($errors, "Email is required");
		}
		if(empty($password_1)) {
			array_push($errors, "Password is required");
		}
		if ($password_1 != $password_2) {
			array_push($errors, "password not match");
		}

		if (count($errors) == 0) {
			$password = md5($password_1);
			$sql = "INSERT INTO users1 (username, email, password) 
						VALUES ('$username', '$email', '$password')";
			mysqli_query($db, $sql);
			$SESSION['username'] = $username;
			$SESSION['success'] = "login successfully";
			header('location: submenu.html');
		}
	}

	//login page
	if (isset($_POST['login'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];

		if(empty($username)) {
			array_push($errors, "Username is required");
		}
		if(empty($password)) {
			array_push($errors, "Password is required");
		}
		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM users1 WHERE username='$username' AND password = '$password'";
			$result = mysqli_query($db, $query);
			if (mysqli_num_rows($result)==1) {
				$SESSION['username'] = $username;
			$SESSION['success'] = "login successfully";
			header('location: submenu.html');
			}else{
				array_push($errors, "wrong creditional");
				//header('location: login.php');
			}
		}
	}

	//logout
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header('location: login.php');
		# code...
	}
?>