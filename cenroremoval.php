<?php
	session_start();
	if(isset($_POST['cname'])) {
		$_SESSION['cname'] = $_POST['cname'];
	}
	
	
	include 'connect.php';
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$cname = $_SESSION['cname'];
	
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
		header ("location: hrcenro.php?" . $errorstring);
	}else{
		$sql = "UPDATE cenro SET active = 0 WHERE cenroName ='" . $cname . "'";

		if ($conn->query($sql) === TRUE) {
		} else {
		}
			
		header ("location: hrcenro.php?success=removed");
	}
?>