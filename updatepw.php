<?php
	session_start();
	
	if(isset($_POST['userid'])) {
		$_SESSION['userid'] = $_POST['userid'];
		$_SESSION['oldpw'] = $_POST['oldpw'];
		$_SESSION['newpw'] = $_POST['newpw'];
	}
	
	$userid = $_SESSION['userid'];
	$oldpw = $_SESSION['oldpw'];
	$newpw = $_SESSION['newpw'];
	
	$check = 0;
	
	include 'connect.php';
	
	$sqltwo = "SELECT password FROM denr WHERE denrID = \"" . $userid . "\"";
	$resulttwo = mysqli_query($conn, $sqltwo);
							
	if (mysqli_num_rows($resulttwo) > 0) {
		// output data of each row
		while($rowtwo = mysqli_fetch_assoc($resulttwo)) {
			if($oldpw === $rowtwo['password']){
				$check = 1;
			}
		}
	} else {
		//do nothing
	}
	
	if($check === 1){
		$sql = "UPDATE denr SET password='" . $newpw . "' WHERE denrID='" . $userid . "'";

		if ($conn->query($sql) === TRUE) {
			echo "Record updated successfully";
		} else {
		}
	}
	
	header('Location: hacc.php?changepw=success');
?>