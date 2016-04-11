<?php
	session_start();
	
	if(isset($_POST['userid'])) {
		$_SESSION['userid'] = $_POST['userid'];
		$_SESSION['newea'] = $_POST['newea'];
	}
	
	$userid = $_SESSION['userid'];
	$newea = $_SESSION['newea'];
	
	include 'connect.php';
	
	$sql = "UPDATE denr SET email='" . $newea . "' WHERE denrID='" . $userid . "'";

	if ($conn->query($sql) === TRUE) {
		echo "Record updated successfully";
	} else {
	}
?>