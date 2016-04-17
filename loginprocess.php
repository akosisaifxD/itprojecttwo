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
	
	if(strpos($un, 'P') !== false){
		$sql = "SELECT password FROM contactperson WHERE contactPersonID = \"" . $un . "\"";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				if($row["password"] == $pw){
					$checker = 1;
					$_SESSION['accounttype'] = "CPerson";
				}
			}
		} else {
			header('Location: denrhome.php?error=true');
		}
	}else{
		$sql = "SELECT password, accountType, lastLogin FROM denr WHERE denrID = \"" . $un . "\"";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				if($row["password"] === $pw){
					$_SESSION['prevll'] = $row['lastLogin'];
					$checker = 1;
					if($row["accountType"] === "Basic"){
						$_SESSION['accounttype'] = "Basic";
					}else{
						$_SESSION['accounttype'] = "Advanced";
					}
				}
			}
		} else {
			header('Location: denrhome.php?error=true');
		}
	}
	
	if($checker == 1){
		$_SESSION['sendertype'] = 0;
		
		$sql = "UPDATE denr SET lastLogin=now() WHERE denrID = '" . $un . "'";

		if ($conn->query($sql) === TRUE) {
		} else {
		}
		
		header('Location: holder.php');
	}else{
		header('Location: denrhome.php?error=true');
	}
?>
