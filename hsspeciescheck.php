<?php
	session_start();
	include 'connect.php';
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$cname = $_POST['cname'];
	
	$species = array();
	$spscount = 0;
	
	if(strlen(TRIM($cname)) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'cnamelength=error';	
		}else{
			$errorstring = $errorstring . '&cnamelength=error';	
		}
	}
	
	$sql = "SELECT commonName FROM species WHERE active = 1";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$species[$spscount] = $row['commonName'];
			$spscount++;
		}
	} else {
		echo "0 results";
	}
	
	if (!in_array($cname, $species) && strlen(TRIM($cname)) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'cnamedne=error';	
		}else{
			$errorstring = $errorstring . '&cnamedne=error';	
		}
	}
	
	if($errorcount > 0){
		header ("location: hsspecies.php?" . $errorstring);
	}else{
		$sql = "SELECT speciesID FROM species WHERE commonName = '" . $cname . "'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$_SESSION['searcheds'] = $row['speciesID'];
			}
		} else {
			echo "0 results";
		}
		header ("location: hespecies.php");
	}
?>