<?php
	session_start();
	if(isset($_POST['speciesname'])) {
		$_SESSION['speciesname'] = $_POST['speciesname'];
		$_SESSION['commonname'] = $_POST['commonname'];
	}
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$speciesname = $_SESSION['speciesname'];
	$commonname = $_SESSION['commonname'];
	
	include 'connect.php';
	
	$speciesnames = array();
	$spsncount = 0;
	
	$sql = "SELECT speciesName FROM species WHERE active = 1";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$speciesnames[$spsncount] = $row['speciesName'];
			$spsncount++;
		}
	} else {
		echo "0 results";
	}
	
	if(strlen($speciesname) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'snlength=error';	
		}else{
			$errorstring = $errorstring . '&snlength=error';	
		}
	}
	if (ctype_digit($speciesname) && strlen($speciesname) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'sncontchar=error';	
		}else{
			$errorstring = $errorstring . '&sncontchar=error';	
		}
	}
	
	if (in_array($speciesname, $speciesnames) && !ctype_digit($speciesname) && strlen(TRIM($speciesname)) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'sndup=error';	
		}else{
			$errorstring = $errorstring . '&sndup=error';	
		}
	}
	
	$commonnames = array();
	$cmnncount = 0;
	
	$sql = "SELECT commonName FROM species WHERE active = 1";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$commonnames[$cmnncount] = $row['commonName'];
			$cmnncount++;
		}
	} else {
		echo "0 results";
	}
	
	if(strlen($commonname) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'cnlength=error';	
		}else{
			$errorstring = $errorstring . '&cnlength=error';	
		}
	}
	if (ctype_digit($commonname) && strlen($commonname) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'cncontchar=error';	
		}else{
			$errorstring = $errorstring . '&cncontchar=error';	
		}
	}
	
	if (in_array($speciesname, $speciesnames) && !ctype_digit($speciesname) && strlen(TRIM($commonname)) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'cndup=error';	
		}else{
			$errorstring = $errorstring . '&cndup=error';	
		}
	}
	
	$inactivespecies = array();
	$ispscount = 0;
	
	$sql = "SELECT commonName FROM species WHERE active = 0";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$inactivespecies[$ispscount] = $row['commonName'];
			$ispscount++;
		}
	} else {
		echo "0 results";
	}
	
	if($errorcount > 0){
		header ("location: hnspecies.php?" . $errorstring . "&speciesname=" . $speciesname . "&commonname=" . $commonname);
	}else{
		if (in_array($commonname, $inactivespecies)) {
			$sql = "UPDATE species SET speciesName = '$speciesname', commonName = '$commonname', active = 1 WHERE commonName ='" . $commonname . "'";

			if ($conn->query($sql) === TRUE) {
			} else {
			}
		}else{
			// prepare and bind
			$stmt = $conn->prepare("INSERT INTO species (speciesName, commonName) VALUES (?, ?)");
			$stmt->bind_param("ss", $snparam, $cnparam);
			$snparam = $speciesname;
			$cnparam = $commonname;
			$stmt->execute();
		}
		
		header ("location: hnspecies.php?success=added");
	}
	
?>