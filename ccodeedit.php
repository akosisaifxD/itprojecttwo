<?php
	session_start();
	if(isset($_POST['yearcolor'])) {
		$_SESSION['yearcolor'] = $_POST['yearcolor'];
		$_SESSION['color'] = $_POST['color'];
	}
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$coloryear = $_SESSION['yearcolor'];
	$color = $_SESSION['color'];
	
	include 'connect.php';
	
	$sql = "UPDATE colorcodes SET color = '$color' WHERE year =" . $coloryear;

	if ($conn->query($sql) === TRUE) {
	} else {
	}
			
	header ("location: hsccode.php?success=edited");
?>