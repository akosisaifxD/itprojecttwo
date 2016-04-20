<?php
	session_start();
	include 'connect.php';
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$sitecode = $_POST['sitecode'];
	
	if(strlen(TRIM($sitecode)) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'cpersonlength=error';	
		}else{
			$errorstring = $errorstring . '&cpersonlength=error';	
		}
	}
	
	$sitecodes = array();
	$scscount = 0;
	
	$sql = "SELECT siteCode FROM site WHERE active = 1";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$sitecodes[$scscount] = $row['siteCode'];
			$scscount++;
		}
	} else {
		echo "0 results";
	}
	
	if (!in_array($sitecode, $sitecodes) && strlen(TRIM($sitecode)) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'cpersondne=error';	
		}else{
			$errorstring = $errorstring . '&cpersondne=error';	
		}
	}
	
	if($errorcount > 0){
		header ("location: hssite.php?" . $errorstring);
	}else{
		
		$sql = "SELECT siteID FROM site WHERE siteCode = '" . $sitecode . "' AND siteCode IS NOT NULL";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$_SESSION['searchedsite'] = $row['siteID'];
			}
		} else {
			echo "0 results";
		}
		
		header ("location: hesite.php");
	}
?>