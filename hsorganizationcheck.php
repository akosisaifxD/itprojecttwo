<?php
	session_start();
	include 'connect.php';
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$orgname = $_POST['orgname'];
	
	if(strlen(TRIM($orgname)) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'orglength=error';	
		}else{
			$errorstring = $errorstring . '&orglength=error';	
		}
	}
	
	$organizations = array();
	$orgcount = 0;
	
	$sql = "SELECT organizationName FROM organization WHERE active = 1";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$organizations[$orgcount] = $row['organizationName'];
			$orgcount++;
		}
	} else {
		echo "0 results";
	}
	
	if (!in_array($orgname, $organizations) && strlen(TRIM($orgname)) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'orgdne=error';	
		}else{
			$errorstring = $errorstring . '&orgdne=error';	
		}
	}
	
	if($errorcount > 0){
		header ("location: hsorg.php?" . $errorstring);
	}else{
		$sql = "SELECT organizationID FROM organization WHERE organizationName = '" . $orgname . "'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$_SESSION['searchedorg'] = $row['organizationID'];
			}
		} else {
			echo "0 results";
		}
		header ("location: heorganization.php");
	}
?>