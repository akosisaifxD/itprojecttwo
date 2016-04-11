<?php
	session_start();
	
	if(isset($_POST['year'])) {
		$_SESSION['year'] = $_POST['year'];
		$_SESSION['decarea'] = $_POST['decarea'];
		$_SESSION['cperson'] = $_POST['cperson'];
		$_SESSION['org'] = $_POST['org'];
		$_SESSION['latstring'] = $_POST['latstring'];
		$_SESSION['lngstring'] = $_POST['lngstring'];
		$_SESSION['zonec'] = $_POST['zonec'];
		$_SESSION['provc'] = $_POST['provc'];
		$_SESSION['municic'] = $_POST['municic'];
		$_SESSION['brgyc'] = $_POST['brgyc'];
	}
	
	$year = $_SESSION['year'];
	$decarea = $_SESSION['decarea'];
	$cperson = $_SESSION['cperson'];
	$org = $_SESSION['org'];
	$latstring = $_SESSION['latstring'];
	$lngstring = $_SESSION['lngstring'];
	$zonec = $_SESSION['zonec'];
	$provc = $_SESSION['provc'];
	$municic = $_SESSION['municic'];
	$brgyc = $_SESSION['brgyc'];
	
	include 'connect.php';

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
	
	$sql = "SELECT contactPersonID FROM contactperson WHERE contactPersonName = '" . $cperson . "'";
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
	$compparam = 'Agroforestry';
	$scparam = '26-2666-26-26';
	$stmt->execute();
	
	$brgys = explode(",", $brgyc);
	
	for($i = 0; $i <= sizeof($brgyc); $i++){
		$stmt = $conn->prepare("INSERT INTO sitebarangay (sitecode, barangayID) VALUES (?, ?)");
		$stmt->bind_param("si", $scparam, $bidparam);
		$scparam = '26-2666-26-26';
		$bidparam = $brgys[$i];
		$stmt->execute();
	}
	
	$orgs = explode(",", $org);
	
	for($i = 0; $i <= sizeof($org); $i++){
		$stmt = $conn->prepare("INSERT INTO siteorganization (siteCode, organizationID) VALUES (?, ?)");
		$stmt->bind_param("si", $scparam, $oidparam);
		$scparam = '26-2666-26-26';
		$oidparam = $orgs[$i];
		$stmt->execute();
	}
	
	$coordslng = explode(",", $lngstring);
	$coordslat = explode(",", $latstring);
	
	for($i = 0; $i < sizeof($coordslng); $i++){
		$stmt = $conn->prepare("INSERT INTO coordinates (longitude, latitude, siteID) VALUES (?, ?, ?)");
		$stmt->bind_param("dds", $lngparam, $latparam, $sidparam);
		$lngparam = $coordslng[$i];
		$latparam = $coordslat[$i];
		$sidparam = $siteID;
		$stmt->execute();
	}
?>