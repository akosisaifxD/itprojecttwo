<?php
	session_start();
	include 'connect.php';
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$cperson = $_POST['cperson'];
	
	if(strlen(TRIM($cperson)) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'cpersonlength=error';	
		}else{
			$errorstring = $errorstring . '&cpersonlength=error';	
		}
	}
	
	$cpersons = array();
	$cpscount = 0;
	
	$sql = "SELECT concat(firstName, ' ', lastName, ' ', suffix) as 'contactPersonName' FROM contactperson WHERE active = 1 AND suffix != ''";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$cpersons[$cpscount] = $row['contactPersonName'];
			$cpscount++;
		}
	} else {
		echo "0 results";
	}
	
	$sql = "SELECT concat(firstName, ' ', lastName) as 'contactPersonName' FROM contactperson WHERE active = 1";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$cpersons[$cpscount] = $row['contactPersonName'];
			$cpscount++;
		}
	} else {
		echo "0 results";
	}
	
	if (!in_array($cperson, $cpersons) && strlen(TRIM($cperson)) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'cpersondne=error';	
		}else{
			$errorstring = $errorstring . '&cpersondne=error';	
		}
	}
	
	if($errorcount > 0){
		header ("location: hscperson.php?" . $errorstring);
	}else{
		$sql = "SELECT contactPersonID FROM contactPerson WHERE concat(firstName, ' ', lastName, ' ', suffix) = '" . $cperson . "' AND suffix != ''";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$_SESSION['searchedcp'] = $row['contactPersonID'];
			}
		} else {
			echo "0 results";
		}
		
		$sql = "SELECT contactPersonID FROM contactPerson WHERE concat(firstName, ' ', lastName) = '" . $cperson . "' AND suffix = ''";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$_SESSION['searchedcp'] = $row['contactPersonID'];
			}
		} else {
			echo "0 results";
		}
		
		header ("location: hecperson.php");
	}
?>