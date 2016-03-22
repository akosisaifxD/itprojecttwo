<?php

	session_start();
	
	//connect to database using external PHP file
	include 'connect.php';
	
	//Check if 'siteid' is present in POST data
	if(isset($_POST['username'])) {
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['password'] = $_POST['password'];
	}
	
	$un = $_SESSION['username'];
	$pw = $_SESSION['password'];
	
	$checker = 0;
	
	$sql = "SELECT password FROM denr WHERE denrID = " . $un;
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if($row["password"] == $pw){
				$checker = 1;
			}
		}
	} else {
		header('Location: login.php?error=true');
	}
	
	if($checker == 1){
		$_SESSION['sendertype'] = 0;
		header('Location: denrhome.php');
	}else{
		header('Location: login.php?error=true');
	}
?>
