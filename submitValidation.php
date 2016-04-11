<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "etanim3";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$dateFrom = $_POST['dateFrom'];
	$dateTo = $_POST['dateTo'];
	$surveyor = $_POST['surveyor'];
	$siteCode = $_POST['siteCode'];
	$areaValidated = (float)$_POST['area'];
	$inputBy = $_POST['inputBy'];
	$validationID;

	$sql = "SELECT validationID FROM `validation` order by 1 desc limit 1";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {

       $validationID = $row["validationID"];
       $validationID++;
       
    }

	$sql = "INSERT INTO validation(validationID, startDate, endDate, surveyor, siteCode, areaValidated, inputBy) VALUES('". $validationID . "', '". $dateFrom ."'
		,'". $dateTo ."','". $surveyor ."','". $siteCode ."','". $areaValidated ."','". $inputBy ."')";
	
	if($conn->query($sql)){
		echo "New validation successfully created";
	}else{
		$error= $conn->error;
		echo "Error: " .$error. "!";
	}
	$commonNames = array();
	$quantity = array();
	$diameter = array();
	$height = array();
	for($x=0;$x< count($_POST['species']);$x++){
		$commonNames[$x] = $_POST['species'][$x];
		$quantity[$x] = $_POST['quantity'][$x];
		$diameter[$x] = $_POST['diameter'][$x];
		$height[$x] = $_POST['height'][$x];
	}
	echo "$commonNames[0]";
	$speciesID = array();
	for($y=0;$y < count($commonNames);$y++){
		$sql = "SELECT speciesID FROM species where commonName='".$commonNames[$y]."'";
		$result2 = $conn->query($sql);
		while ($row2 = $result2->fetch_assoc()) {
			array_push($speciesID, $row2["speciesID"]);
		}

	}
	

	for($counter = 0; $counter < count($speciesID); $counter++){
			$sql = "INSERT INTO tree(validationID, speciesID, quantity, diameter, height) VALUES('". $validationID ."', '". $speciesID[$counter] ."', 
				'". $quantity[$counter] ."','". $diameter[$counter] ."','". $height[$counter] ."')";
			if($conn->query($sql)){
		echo "New validation successfully created";
	}else{
		$error= $conn->error;
		echo "Error: " .$error. "!";
	}

	}

	
	
	
?>