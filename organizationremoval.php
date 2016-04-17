<?php
	session_start();
	if(isset($_POST['orgname'])) {
		$_SESSION['orgname'] = $_POST['orgname'];
	}
	
	
	include 'connect.php';
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$orgname = $_SESSION['orgname'];
	
	$organizations = array();
	$orgcount = 0;
	
	if(strlen(TRIM($orgname)) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'orglength=error';	
		}else{
			$errorstring = $errorstring . '&orglength=error';	
		}
	}
	
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
		header ("location: hrorg.php?" . $errorstring);
	}else{
		$sql = "UPDATE organization SET active = 0 WHERE organizationName ='" . $orgname . "'";

		if ($conn->query($sql) === TRUE) {
		} else {
		}
			
		header ("location: hrorg.php?success=removed");
	}
?>