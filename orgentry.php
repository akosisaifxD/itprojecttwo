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
	
	if($orgcount > 0){
		header ("location: horg.php?fail=exists&orgname=" . $orgname);
	}else{
		// prepare and bind
		$stmt = $conn->prepare("INSERT INTO organization (organizationName, organizationTypeID) VALUES (?, ?)");
		$stmt->bind_param("ss", $orgnameparam, $orgtypeparam);
		$orgnameparam = $orgname;
		$orgtypeparam = $orgtype;
		$stmt->execute();
		
		header ("location: horg.php?success=added");
	}

?>
