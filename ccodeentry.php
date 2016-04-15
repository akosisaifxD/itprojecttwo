<?php
	session_start();
	if(isset($_POST['coloryear'])) {
		$_SESSION['coloryear'] = $_POST['coloryear'];
		$_SESSION['color'] = $_POST['color'];
	}
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$coloryear = $_SESSION['coloryear'];
	$color = $_SESSION['color'];
	
	include 'connect.php';
	
	echo $coloryear . " " . $color;
	
	if(strlen($coloryear) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'colorlength=error';	
		}else{
			$errorstring = $errorstring . '&colorlength=error';	
		}
	}
	if (!ctype_digit($coloryear) && strlen($coloryear) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'colorcontchar=error';	
		}else{
			$errorstring = $errorstring . '&colorcontchar=error';	
		}
	}
	
	$sql = "SELECT year FROM colorcodes";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if(strtolower($row['year']) === $coloryear){
				$errorcount++;
				if($errorcount === 1){
					$errorstring = $errorstring . 'colordup=error';	
				}else{
					$errorstring = $errorstring . '&colordup=error';	
				}
			}
		}
	} else {
	}
	
	if($errorcount > 0){
		header ("location: hcolorcode.php?" . $errorstring . "&coloryear=" . $coloryear);
	}else{
		// prepare and bind
		$stmt = $conn->prepare("INSERT INTO colorcodes (year, color) VALUES (?, ?)");
		$stmt->bind_param("is", $yearparam, $colorparam);
		$yearparam = $coloryear;
		$colorparam = $color;
		$stmt->execute();
		
		header ("location: hcolorcode.php?success=added");
	}
	
?>