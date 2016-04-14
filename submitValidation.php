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
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "newschema";

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

	$directory = 'uploads/validation/' . $siteCode . '/' . $validationID;

	if (file_exists($directory)) {
	
	} else {
		mkdir($directory);
	}
	
	$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
	$path = $directory . '/' . $validationID . '/'; // Upload directory
	$count = 0;
	
	foreach ($_FILES['imageupload']['name'] as $f => $name) {     
	    if ($_FILES['imageupload']['error'][$f] == 4) {
	        continue; // Skip file if any error found
	    }	       
	    if ($_FILES['imageupload']['error'][$f] == 0) {	           
			if( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
				$message[] = "$name is not a valid format";
				continue; // Skip invalid file formats
			}
	        else{ // No error found! Move uploaded files 
				
				$temp = explode(".", $_FILES["imageupload"]["name"][$f]);
				$newfilename = $temp[0] . '_' . $validationID . '.' . end($temp);
				
	            if(move_uploaded_file($_FILES["imageupload"]["tmp_name"][$f], $path . $newfilename))
	            $count++; // Number of successfully uploaded file
	        }
	    }
	}
?>