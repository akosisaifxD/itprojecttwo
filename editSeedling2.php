<?php
	session_start();

	if(isset($_POST['surveyor'])){
		$_SESSION['startDate'] = $_POST['startDate'];
		$_SESSION['endDate'] = $_POST['endDate'];
		$_SESSION['surveyor'] = $_POST['surveyor'];
		$_SESSION['inputBy'] = $_POST['inputBy'];
		$_SESSION['area'] = $_POST['area'];
		$_SESSION['siteCode'] = $_POST['siteCode'];

	}

	$validationID = $_SESSION['validationID'];


	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "ipuno";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$dateFrom = $_SESSION['startDate'];
	$dateTo = $_SESSION['endDate'];
	$surveyor = $_SESSION['surveyor'];
	$siteCode = $_SESSION['siteCode'];
	$areaValidated = (float)$_SESSION['area'];
	$inputBy = $_SESSION['inputBy'];
	$validationID;

	$sql = "UPDATE validation SET startDate = ? , endDate = ? , surveyor = ? , siteCode = ? , areaValidated = ? , inputBy = ? WHERE validationID = ?";
	$stmt = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($stmt, "ssisdsi", $dateFrom, $dateTo, $surveyor, $siteCode, $areaValidated, $inputBy, $validationID);
	mysqli_stmt_execute($stmt);
	

	$commonNames = array();
	$quantity = array();
	$editCommonNames = array();
	for($x=0;$x< count($_POST['species']);$x++){
		$editCommonNames[$x] = $_POST['editCommonNames'][$x];
		$commonNames[$x] = $_POST['species'][$x];
		$quantity[$x] = $_POST['quantity'][$x];
	}

	$commonNames1 = array();
	$quantity1 = array();
	$editCommonNames1 = array();
	for($x=0;$x< count($_POST['species1']);$x++){
		$editCommonNames1[$x] = $_POST['editCommonNames'][$x];
		$commonNames1[$x] = $_POST['species1'][$x];
		$quantity1[$x] = $_POST['quantity1'][$x];
	}
	
	$speciesID = array();
	for($y=0;$y < count($commonNames);$y++){
		$sql = "SELECT speciesID FROM species where commonName='".$commonNames[$y]."'";
		$result2 = $conn->query($sql);
		while ($row2 = $result2->fetch_assoc()) {
			array_push($speciesID, $row2["speciesID"]);
		}

	}

	if(isset($_POST['speciesID1']) && ($_POST['speciesID1'] === true)){
	$speciesID1 = array();
	for($y=0;$y < count($commonNames);$y++){
		$sql = "SELECT speciesID FROM species where commonName='".$commonNames[$y]."'";
		$result2 = $conn->query($sql);
		while ($row2 = $result2->fetch_assoc()) {
			array_push($speciesID1, $row2["speciesID"]);
		}

	}
	}
	
	for($counter = 0; $counter < count($speciesID); $counter++){
			$sql = "UPDATE seedling SET  quantity = ? WHERE validationID = ? AND speciesID = ?";
			$stmt = mysqli_prepare($conn, $sql);
			mysqli_stmt_bind_param($stmt, "iii", $quantity[$counter], $validationID, $editCommonNames[$counter]);
			mysqli_stmt_execute($stmt);
	}

	for($counter = 0; $counter < count($speciesID1); $counter++){
			$sql = "INSERT INTO seedling(validationID, speciesID, quantity) VALUES('". $validationID ."', '". $speciesID1[$counter] ."', 
				'". $quantity1[$counter] ."')";
			if($conn->query($sql)){
		echo "New validation successfully created";
	}else{
		$error= $conn->error;
		echo "Error: " .$error. "!";
	}

	}

	
	
	
?>