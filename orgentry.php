<?php
	session_start();
	if(isset($_POST['orgname'])) {
		$_SESSION['orgname'] = $_POST['orgname'];
		$_SESSION['orgtype'] = $_POST['orgtype'];
	}
	
	$orgname = $_SESSION['orgname'];
	$orgtype = $_SESSION['orgtype'];
	
	include 'connect.php';
	
	// prepare and bind
	$stmt = $conn->prepare("INSERT INTO organization (organizationName, organizationTypeID) VALUES (?, ?)");
	$stmt->bind_param("ss", $orgnameparam, $orgtypeparam);
	$orgnameparam = $orgname;
	$orgtypeparam = $orgtype;
	$stmt->execute();
?>
