<?php
	session_start();
	if(isset($_POST['dperson'])) {
		$_SESSION['dperson'] = $_POST['dperson'];
	}
	
	
	include 'connect.php';
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$dperson = $_SESSION['dperson'];
	
	$dpersons = array();
	$dpscount = 0;
	
	if(strlen(TRIM($dperson)) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'dpersonlength=error';	
		}else{
			$errorstring = $errorstring . '&dpersonlength=error';	
		}
	}
	
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
		header ("location: hrdpersonnel.php?" . $errorstring);
	}else{
		$sql = "UPDATE denr SET active = 0 WHERE concat(firstName, ' ', lastName) ='" . $dperson . "'";

		if ($conn->query($sql) === TRUE) {
		} else {
		}
			
		header ("location: hrdpersonnel.php?success=removed");
	}
?>