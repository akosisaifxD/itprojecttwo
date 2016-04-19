<?php
	session_start();
	include 'connect.php';
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$cname = $_POST['cname'];
	
	$cenros = array();
	$cencount = 0;
	
	if(strlen(TRIM($cname)) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'cnamelength=error';	
		}else{
			$errorstring = $errorstring . '&cnamelength=error';	
		}
	}
	
	$sql = "SELECT cenroName FROM cenro WHERE active = 1";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$cenros[$cencount] = $row['cenroName'];
			$cencount++;
		}
	} else {
		echo "0 results";
	}
	
	if (!in_array($cname, $cenros) && strlen(TRIM($cname)) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'cnamedne=error';	
		}else{
			$errorstring = $errorstring . '&cnamedne=error';	
		}
	}
	
	if($errorcount > 0){
		header ("location: hscenro.php?" . $errorstring);
	}else{
		$sql = "SELECT cenroID FROM cenro WHERE cenroName = '" . $cname . "'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$_SESSION['searchedcen'] = $row['cenroID'];
			}
		} else {
			echo "0 results";
		}
		header ("location: hecenro.php");
	}
?>