<?php
	session_start();
	if(isset($_POST['orgname'])) {
		$_SESSION['orgname'] = $_POST['orgname'];
		$_SESSION['orgtype'] = $_POST['orgtype'];
	}
	
	$orgname = $_SESSION['orgname'];
	$orgtype = $_SESSION['orgtype'];
	
	include 'connect.php';
	
	$onconverted = strtolower($orgname);
	$orgcount = 0;
	
	$errorcount = 0;
	
	$errorstring = "";
	
	if(strlen(TRIM($orgname)) === 0){
		$errorcount++;
		$errorstring = $errorstring . '&orglength=error';	
	}
	
	$sql = "SELECT organizationName FROM organization";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if(strtolower($row['organizationName']) === $onconverted){
				$orgcount++;
			}
		}
	} else {
	}
	
	if($errorcount > 0){
		header ("location: heorganization.php?" . $errorstring);
	}
	
	if($orgcount > 0){
		header ("location: heorganization.php?fail=exists&orgname=" . $orgname);
	}
	
	if($errorcount === 0 && $orgcount === 0){
		$sql = "UPDATE organization SET organizationName = '$orgname', organizationTypeID = '$orgtype' WHERE organizationID ='" . $_SESSION['searchedorg'] . "'";

		if ($conn->query($sql) === TRUE) {
		} else {
		}
		
		header ("location: heorganization.php?success=true");
	}

?>
