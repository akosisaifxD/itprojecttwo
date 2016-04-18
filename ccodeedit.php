<?php
	session_start();
	if(isset($_POST['coloryear'])) {
		$_SESSION['coloryear'] = $_POST['coloryear'];
		$_SESSION['color'] = $_POST['color'];
	}
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$coloryear = $_SESSION['coloryear'];
	$color = $_SESSION['color'];
	
	include 'connect.php';
	
	$sql = "UPDATE colorcodes SET color = '$color' WHERE year =" . $coloryear;

	if ($conn->query($sql) === TRUE) {
	} else {
	}
			
	header ("location: heccode.php?success=edited");
?>