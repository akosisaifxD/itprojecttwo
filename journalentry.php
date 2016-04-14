<?php
	session_start();
	if(isset($_POST['sitecode'])) {
		$_SESSION['sitecode'] = $_POST['sitecode'];
		$_SESSION['comments'] = $_POST['comments'];
		$_SESSION['senderid'] = $_POST['senderid'];
	}
	
	$sitecode = $_SESSION['sitecode'];
	$comments = $_SESSION['comments'];
	$senderid = $_SESSION['senderid'];
	
	include 'connect.php';
	
	if(strlen($comments) > 0){
		// prepare and bind
		$stmt = $conn->prepare("INSERT INTO journal (comments, sender, siteCode) VALUES (?, ?, ?)");
		$stmt->bind_param("sss", $commentsparam, $senderidparam, $sitecodeparam);
		$commentsparam = $comments;
		$senderidparam = $senderid;
		$sitecodeparam = $sitecode;
		$stmt->execute();
	}
	$directory = 'uploads/journal/' . $sitecode;

	if (file_exists($directory)) {
	
	} else {
		mkdir($directory);
	}
	
	$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
	$path = $directory . '/'; // Upload directory
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
				$jrnid = 0;
			
				$sql = "SELECT journalID FROM journal ORDER BY journalID DESC LIMIT 1";
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_assoc($result)) {
						$jrnid = $row['journalID'];
					}
				} else {
				}
				
				$temp = explode(".", $_FILES["imageupload"]["name"][$f]);
				$newfilename = $temp[0] . '_' . $jrnid . '.' . end($temp);
				
	            if(move_uploaded_file($_FILES["imageupload"]["tmp_name"][$f], $path . $newfilename))
				$stmt = $conn->prepare("INSERT INTO journal (comments, sender, siteCode) VALUES (?, ?, ?)");
				$stmt->bind_param("sss", $commentsparam, $senderidparam, $sitecodeparam);
				$commentsparam = "<a href = '" . $path . $newfilename ."' target = '_blank'><img src = '" . $path . $newfilename . "' id = 'imageup'/></a><br>";
				$senderidparam = $senderid;
				$sitecodeparam = $sitecode;
				$stmt->execute();
	            $count++; // Number of successfully uploaded file
	        }
	    }
	}
	
	header ("location: hjournalr.php");
?>
