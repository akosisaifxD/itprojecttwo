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
		header ("location: horg.php?" . $errorstring);
	}
	
	if($orgcount > 0){
		header ("location: horg.php?fail=exists&orgname=" . $orgname);
	}
	
	if($errorcount === 0 && $orgcount === 0){
		// prepare and bind
		$stmt = $conn->prepare("INSERT INTO organization (organizationName, organizationTypeID) VALUES (?, ?)");
		$stmt->bind_param("ss", $orgnameparam, $orgtypeparam);
		$orgnameparam = $orgname;
		$orgtypeparam = $orgtype;
		$stmt->execute();
		
		header ("location: horg.php?success=added");
	}

?>
