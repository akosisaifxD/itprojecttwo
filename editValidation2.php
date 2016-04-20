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

	$sql = "UPDATE validation SET startDate = ? , endDate = ? , surveyor = ? , siteCode = ? , areaValidated = ? , inputBy = ? WHERE validationID = ?";
	$stmt = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($stmt, "ssisdsi", $dateFrom, $dateTo, $surveyor, $siteCode, $areaValidated, $inputBy, $validationID);
	mysqli_stmt_execute($stmt);

	$commonNames = array();
	$quantity = array();
	$diameter = array();
	$height = array();
	$editCommonNames = array();
	
	for($x=0;$x< count($_POST['species']);$x++){
		$editCommonNames[$x] = $_POST['editCommonNames'][$x];
		$commonNames[$x] = $_POST['species'][$x];
		$quantity[$x] = $_POST['quantity'][$x];
		$diameter[$x] = $_POST['diameter'][$x];
		$height[$x] = $_POST['height'][$x];
	}
	
	$editCommonNames1 = array();
	$commonNames1 = array();
	$quantity1 = array();
	$diameter1 = array();
	$height1 = array();
	
	for($x=0;$x< count($_POST['species1']);$x++){
		$editCommonNames1[$x] = $_POST['editCommonNames'][$x];
		$commonNames1[$x] = $_POST['species1'][$x];
		$quantity1[$x] = $_POST['quantity1'][$x];
		$diameter1[$x] = $_POST['diameter1'][$x];
		$height1[$x] = $_POST['height1'][$x];
	}
	
	$speciesID = array();
	for($y=0;$y < count($commonNames);$y++){
		$sql = "SELECT speciesID FROM species where commonName='".$commonNames[$y]."'";
		$result2 = $conn->query($sql);
		while ($row2 = $result2->fetch_assoc()) {
			array_push($speciesID, $row2["speciesID"]);
		}
	}
	
	$speciesID1 = array();
	for($y=0;$y < count($commonNames1);$y++){
		$sql = "SELECT speciesID FROM species where commonName='".$commonNames1[$y]."'";
		$result2 = $conn->query($sql);
		while ($row2 = $result2->fetch_assoc()) {
			array_push($speciesID1, $row2["speciesID"]);
		}
	}

	for($counter = 0; $counter < count($speciesID); $counter++){
			$sql = "UPDATE tree SET speciesID = ? , quantity = ? , diameter = ? , height = ? WHERE validationID = ? AND speciesID = ?";
			$stmt = mysqli_prepare($conn, $sql);
			mysqli_stmt_bind_param($stmt, "iiddii",  $speciesID[$counter], $quantity[$counter], $diameter[$counter], $height[$counter], $validationID, $editCommonNames[$counter]);
			mysqli_stmt_execute($stmt);
	}

	for($counter = 0; $counter < count($speciesID1); $counter++){	
			echo $validationID;
			echo "<br>";
			echo $speciesID1[$counter];
			echo "<br>";
			echo $quantity1[$counter];
			echo "<br>";
			echo $diameter1[$counter];
			echo "<br>";
			echo $height1[$counter];
			$sql = "INSERT INTO tree(validationID, speciesID, quantity, diameter, height) VALUES('". $validationID ."', '". $speciesID1[$counter] ."', 
				'". $quantity1[$counter] ."','". $diameter1[$counter] ."','". $height1[$counter] ."')";
			$conn->query($sql);
	}

/*	$directory = 'uploads/validation/' . $siteCode . '/' . $validationID;

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
	}*/
?>