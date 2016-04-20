<?php
session_start();
	
	require 'connect.php';
	
	if(isset($_POST['year'])) {
		$_SESSION['year'] = $_POST['year'];
		$_SESSION['decarea'] = $_POST['decarea'];
		$_SESSION['cperson'] = $_POST['cperson'];
		$_SESSION['org'] = $_POST['org'];
		$_SESSION['zonec'] = $_POST['zonec'];
		$_SESSION['compc'] = $_POST['compc'];
		$_SESSION['numofrows'] = $_POST['numofrows'];
	}
	
	$errorcount = 0;
	$errorstring = "";
	$numofrows = $_SESSION['numofrows'];
	
	$latitudecoords = array();
	$longitudecoords = array();
	
	for($i = 1; $i <= $numofrows; $i++){
		$latitudecoords[$i-1] = $_POST['lat' . $i];
		$longitudecoords[$i-1] = $_POST['lng' . $i];
	}
	
	$tablecontcheck = false;
	
	for($i = 1; $i <= $numofrows; $i++){
		if($latitudecoords[$i-1] === ""){
			$tablecontcheck = true;
		}
		if($longitudecoords[$i-1] === ""){
			$tablecontcheck = true;
		}
	}
	
	$year = $_SESSION['year'];
	$decarea = $_SESSION['decarea'];
	$cperson = $_SESSION['cperson'];
	$org = $_SESSION['org'];
	$zonec = $_SESSION['zonec'];
	$compc = $_SESSION['compc'];
	$numofrows = $_SESSION['numofrows'];
	
	if(strlen(TRIM($decarea)) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . "decalength=error";
		}else{
			$errorstring = $errorstring . "&decalength=error";
		}
	}
	
	if(!is_numeric($decarea) && strlen(TRIM($decarea)) > 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . "deccont=error";
		}else{
			$errorstring = $errorstring . "&deccont=error";
		}
	}
	
	if(strlen(TRIM($cperson)) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . "cplength=error";
		}else{
			$errorstring = $errorstring . "&cplength=error";
		}
	}
	
	$cpersons = array();
	$cpscount = 0;
	
	$sql = "SELECT IF(suffix = '', concat(firstName, ' ', lastName), concat(firstName, ' ', lastName, ' ', suffix)) as 'contactPersonName' FROM contactperson WHERE active = 1";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$cpersons[$cpscount] = $row['contactPersonName'];
			$cpscount++;
		}
	} else {
		echo "0 results";
	}
	
	if (!in_array($cperson, $cpersons) && strlen(TRIM($cperson)) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'cpersondne=error';	
		}else{
			$errorstring = $errorstring . '&cpersondne=error';	
		}
	}

	if(!isset($org)) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'orgerr=error';	
		}else{
			$errorstring = $errorstring . '&orgerr=error';	
		}
	}
	
	if($tablecontcheck === true) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'tableerr=error';	
		}else{
			$errorstring = $errorstring . '&tableerr=error';	
		}
	}
	
	if($errorcount > 0){
		header ("location: hesite.php?" . $errorstring . "&mobnum=" . $mobnum . "&telnum=" . $telnum . "&email=" . $email . "&address=" . $address);
	}else{
		$cpID;
		
		$sql = "SELECT contactPersonID FROM contactperson WHERE concat(firstName, ' ', lastName) = '" . $cperson . "' OR concat(firstName, ' ', lastName, ' ', suffix) = '" . $cperson . "'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$cpID = ($row['contactPersonID']);
			}
		} else {
			echo "0 results";
		}
	
		$sql = "UPDATE site SET year = '$year', contactPersonID = '$cpID', declaredArea = '$decarea', zone = '$zonec', component = '$compc' WHERE siteID ='" . $_SESSION['searchedsite'] . "'";

		if ($conn->query($sql) === TRUE) {
		} else {
		}
		
		$sitecode = "";
		
		$sql = "SELECT siteCode FROM site WHERE siteID ='" . $_SESSION['searchedsite'] . "'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$sitecode = $row['siteCode'];
			}
		} else {
			echo "0 results";
		}
		
		$prevorgsites = array();
		$poscount = 0;
		
		$sql = "SELECT organizationID FROM siteorganization WHERE siteCode ='" . $sitecode . "' AND active = 1";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$prevorgsites[$poscount] = $row['organizationID'];
				$poscount++;
			}
		} else {
			echo "0 results";
		}
		
		for($i = 0; $i < sizeof($org); $i++){
			if(!in_array($org[$i], $prevorgsites)){
				$stmt = $conn->prepare("INSERT INTO siteorganization (siteCode, organizationID) VALUES (?, ?)");
				$stmt->bind_param("si", $scparam, $oidparam);
				$scparam = $sitecode;
				$oidparam = $org[$i];
				$stmt->execute();
			}
		}
		
		for($i = 0; $i < sizeof($prevorgsites); $i++){
			if(!in_array($prevorgsites[$i], $org)){
				$sql = "UPDATE siteorganization SET active = 0 WHERE siteCode ='" . $sitecode . "' AND organizationID = '" . $prevorgsites[$i] . "'";

				if ($conn->query($sql) === TRUE) {
				} else {
				}
			}
		}
		
		$inactprevos = array();
		$iposcount = 0;
		
		$sql = "SELECT organizationID FROM siteorganization WHERE siteCode ='" . $sitecode . "' AND active = 0";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$inactprevos[$iposcount] = $row['organizationID'];
				$iposcount++;
			}
		} else {
			echo "0 results";
		}
		
		for($i = 0; $i < sizeof($inactprevos); $i++){
			if(in_array($inactprevos[$i], $org)){
				$sql = "UPDATE siteorganization SET active = 1 WHERE siteCode ='" . $sitecode . "' AND organizationID = '" . $inactprevos[$i] . "'";

				if ($conn->query($sql) === TRUE) {
				} else {
				}
			}
		}
		
		$coordid = 0;
		
		$sql = "SELECT coordinatesID FROM coordinates WHERE siteID ='" . $_SESSION['searchedsite'] . "'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				// output data of each row
				if($coordid === 0){
					$coordid = $row['coordinatesID'];
				}else{
				}
			}
		} else {
			echo "0 results";
		}
		
		for($i = 0; $i < $numofrows; $i++){
				
			$sql = "UPDATE coordinates SET longitude = '$longitudecoords[$i]', latitude = '$latitudecoords[$i]' WHERE coordinatesID ='" . ($coordid + $i) . "'";
			
			if ($conn->query($sql) === TRUE) {
			} else {
			}
			
		}
		
		$sql = "UPDATE coordinates SET longitude = '$longitudecoords[0]', latitude = '$latitudecoords[0]' WHERE coordinatesID ='" . ($coordid + $numofrows) . "'";
			
		if ($conn->query($sql) === TRUE) {
		} else {
		}
		
		header ("location: hssite.php?success=true");
	}
?>
