<?php
	session_start();
	include 'connect.php';
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$dperson = $_POST['dperson'];
	
	if(strlen(TRIM($dperson)) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'dpersonlength=error';	
		}else{
			$errorstring = $errorstring . '&dpersonlength=error';	
		}
	}
	
	$dpersons = array();
	$dpscount = 0;
	
	$sql = "SELECT firstName, lastName FROM denr WHERE active = 1";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$dpersons[$dpscount] = $row['firstName'] . " " . $row['lastName'];
			$dpscount++;
		}
	} else {
		echo "0 results";
	}
	
	if (!in_array($dperson, $dpersons) && strlen(TRIM($dperson)) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'dpersondne=error';	
		}else{
			$errorstring = $errorstring . '&dpersondne=error';	
		}
	}
	
	if($errorcount > 0){
		header ("location: hsdpersonnel.php?" . $errorstring);
	}else{
		$sql = "SELECT denrID FROM denr WHERE concat(firstName, ' ', lastName) = '" . $dperson . "'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$_SESSION['searcheddp'] = $row['denrID'];
			}
		} else {
			echo "0 results";
		}
		header ("location: hedpersonnel.php");
	}
?>