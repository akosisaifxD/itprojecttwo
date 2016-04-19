<?php
	session_start();
	if(isset($_POST['cenro'])) {
		$_SESSION['cenro'] = $_POST['cenro'];
	}
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$cenro = $_SESSION['cenro'];
	
	include 'connect.php';
	
	$cenros = array();
	$cencount = 0;
	
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
	
	if(strlen($cenro) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'snlength=error';	
		}else{
			$errorstring = $errorstring . '&snlength=error';	
		}
	}
	
	if (ctype_digit($cenro) && strlen($cenro) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'sncontchar=error';	
		}else{
			$errorstring = $errorstring . '&sncontchar=error';	
		}
	}
	
	if (in_array($cenro, $cenros) && !ctype_digit($cenro) && strlen(TRIM($cenro)) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'sndup=error';	
		}else{
			$errorstring = $errorstring . '&sndup=error';	
		}
	}
	
	$inactivecenro = array();
	$icencount = 0;
	
	$sql = "SELECT cenroName FROM cenro WHERE active = 0";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$inactivecenro[$icencount] = $row['cenroName'];
			$icencount++;
		}
	} else {
		echo "0 results";
	}
	
	if($errorcount > 0){
		header ("location: hncenro.php?" . $errorstring . "&cenroname=" . $cenro);
	}else{
		if (in_array($cenro, $inactivecenro)) {
			$sql = "UPDATE cenro SET active = 1 WHERE cenroName ='" . $cenro . "'";

			if ($conn->query($sql) === TRUE) {
			} else {
			}
		}else{
			// prepare and bind
			$stmt = $conn->prepare("INSERT INTO cenro (cenroName) VALUES (?)");
			$stmt->bind_param("s", $cenparam);
			$cenparam = $cenro;
			$stmt->execute();
		}
		
		header ("location: hncenro.php?success=added");
	}
	
?>