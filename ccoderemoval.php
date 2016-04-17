<?php
	session_start();
	if(isset($_POST['coloryear'])) {
		$_SESSION['coloryear'] = $_POST['coloryear'];
	}
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$coloryear = $_SESSION['coloryear'];
	
	include 'connect.php';
	
	$sql = "UPDATE colorcodes SET active = 0 WHERE year =" . $coloryear;

	if ($conn->query($sql) === TRUE) {
	} else {
	}
		
	header ("location: hrccode.php?success=removed");
	
?>