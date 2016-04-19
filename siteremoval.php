<?php
	session_start();
	if(isset($_POST['sitecode'])) {
		$_SESSION['sitecode'] = $_POST['sitecode'];
	}
	
	
	include 'connect.php';
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$sitecode = $_SESSION['sitecode'];
	
	$sitecodes = array();
	$scscount = 0;
	
	if(strlen(TRIM($sitecode)) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'cnamelength=error';	
		}else{
			$errorstring = $errorstring . '&cnamelength=error';	
		}
	}
	
	$sql = "SELECT siteCode FROM site WHERE active = 1 AND siteCode IS NOT NULL";
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
			$errorstring = $errorstring . 'cnamedne=error';	
		}else{
			$errorstring = $errorstring . '&cnamedne=error';	
		}
	}
	
	if($errorcount > 0){
		header ("location: hrsite.php?" . $errorstring);
	}else{
		$sql = "UPDATE site SET active = 0 WHERE siteCode ='" . $sitecode . "'";

		if ($conn->query($sql) === TRUE) {
		} else {
		}
			
		header ("location: hrsite.php?success=removed");
	}
?>