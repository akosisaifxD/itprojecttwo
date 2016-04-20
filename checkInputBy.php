<?php
	
 	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "ipuno";

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$surveyorId = $_GET['id'];

	$sql = "SELECT denrID FROM denr where denrID='".$surveyorId."'";

	if($result=mysqli_query($conn,$sql)){
		$rowcount =mysqli_num_rows($result);
		if($rowcount>0){
			echo "";
			
		}else{
			echo "<font color=red>Input By: Denr ID does not exist<br></font>";
			
		}
	}

	$conn->close();
?>