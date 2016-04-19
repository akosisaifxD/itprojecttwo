<?php
	session_start();
	
	require 'connect.php';
	
	if(isset($_POST['year'])) {
		$_SESSION['year'] = $_POST['year'];
		$_SESSION['decarea'] = $_POST['decarea'];
		$_SESSION['cperson'] = $_POST['cperson'];
		$_SESSION['org'] = $_POST['org'];
		$_SESSION['zonec'] = $_POST['zonec'];
		$_SESSION['provc'] = $_POST['provc'];
		$_SESSION['municic'] = $_POST['municic'];
		$_SESSION['brgyc'] = $_POST['brgyc'];
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
	$provc = $_SESSION['provc'];
	$municic = floatval($_SESSION['municic'] + 14);
	$brgyc = $_SESSION['brgyc'];
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
	
	if($provc === '0'){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . "provlength=error";
		}else{
			$errorstring = $errorstring . "&provlength=error";
		}
	}
	
	if($municic === '0'){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . "munilength=error";
		}else{
			$errorstring = $errorstring . "&munilength=error";
		}
	}
	
	if(!isset($brgyc)) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'brgyerr=error';	
		}else{
			$errorstring = $errorstring . '&brgyerr=error';	
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
	
	
		
	$yearpart = substr($year, -2);
	
	$psgcpart = "";
	$areapart = "";
	
	$sql = "SELECT PSGCCode, areaCode FROM municipality WHERE municipalityID = '" . $municic . "'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$psgcpart = $row['PSGCCode'];
			$areapart = $row['areaCode'];
		}
	} else {
		echo "0 results";
	}
	
	$sitecount = 0;
	
	$sql = "SELECT siteCode FROM site WHERE year = '" . $year . "' AND municipalityID = '" . $municic . "'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$sitecount++;
		}
	} else {
		echo "0 results";
	}
	
	echo $sitecount;
	
	$sitecount++;
	
	$randpart = "";
	
	if($sitecount < 10){
		$randpart = "000" . $sitecount;
	}
	
	if($sitecount > 9 && $sitecount < 100){
		$randpart = "00" . $sitecount;
	}
	
	if($sitecount > 99 && $sitecount < 1000){
		$randpart = "0" . $sitecount;
	}
	
	if($sitecount > 999){
		$randpart = $sitecount;
	}
	
	$sitecodeprep = $yearpart . "-" . $psgcpart . "-" . $randpart . "-" . $areapart;
	
	echo $sitecodeprep;
	
	if($errorcount > 0){
		header ("location: hsite.php?" . $errorstring . "&year=" . $year . "&decarea=" . $decarea . "&cperson=" . $cperson);
	}else{
		
		$siteID;
		
		$sql = "SELECT COUNT(*) AS num FROM site";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$siteID = ($row['num'] + 1);
			}
		} else {
			echo "0 results";
		}
		
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
		
		$stmt = $conn->prepare("INSERT INTO site (siteID, year, contactPersonID, declaredArea, computedArea, municipalityID, zone, component, siteCode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("sssddisss", $idparam, $yearparam, $cidparam, $decaparam, $caparam, $miparam, $zparam, $compparam, $scparam);
		$idparam = $siteID;
		$yearparam = $year;
		$cidparam = $cpID;
		$decaparam = $decarea;
		$caparam = $decarea;
		$miparam = $municic;
		$zparam = $zonec;
		$compparam = $compc;
		$scparam = $sitecodeprep;
		$stmt->execute();
		
		for($i = 0; $i <= sizeof($brgyc); $i++){
			$stmt = $conn->prepare("INSERT INTO sitebarangay (sitecode, barangayID) VALUES (?, ?)");
			$stmt->bind_param("si", $scparam, $bidparam);
			$scparam = $sitecodeprep;
			$bidparam = $brgyc[$i];
			$stmt->execute();
		}
		
		for($i = 0; $i <= sizeof($org); $i++){
			$stmt = $conn->prepare("INSERT INTO siteorganization (siteCode, organizationID) VALUES (?, ?)");
			$stmt->bind_param("si", $scparam, $oidparam);
			$scparam = $sitecodeprep;
			$oidparam = $org[$i];
			$stmt->execute();
		}
		
		for($i = 0; $i < numofrows; $i++){
			$stmt = $conn->prepare("INSERT INTO coordinates (longitude, latitude, siteID) VALUES (?, ?, ?)");
			$stmt->bind_param("dds", $lngparam, $latparam, $sidparam);
			$lngparam = $latitudecoords[$i];
			$latparam = $longitudecoords[$i];
			$sidparam = $siteID;
			$stmt->execute();
		}
		
		header ("location: hsite.php?success=true");
	}
?>