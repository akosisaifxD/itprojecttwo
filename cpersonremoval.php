<?php
	session_start();
	if(isset($_POST['cperson'])) {
		$_SESSION['cperson'] = $_POST['cperson'];
	}
	
	
	include 'connect.php';
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$cperson = $_SESSION['cperson'];
	
	$cpersons = array();
	$cpscount = 0;
	
	if(strlen(TRIM($cperson)) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'cpersonlength=error';	
		}else{
			$errorstring = $errorstring . '&cpersonlength=error';	
		}
	}
	
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
		header ("location: hrcperson.php?" . $errorstring);
	}else{
		$sql = "UPDATE contactperson SET active = 0 WHERE concat(firstName, ' ', lastName, ' ', suffix) ='" . $cperson . "' AND suffix != ''";

		if ($conn->query($sql) === TRUE) {
		} else {
		}
		
		$sql = "UPDATE contactperson SET active = 0 WHERE concat(firstName, ' ', lastName) ='" . $cperson . "' AND suffix = ''";

		if ($conn->query($sql) === TRUE) {
		} else {
		}
			
		header ("location: hrcperson.php?success=removed");
	}
?>