<?php
	
 	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "ipuno";

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$siteCode = $_GET['id'];

	$sql = "SELECT siteCode FROM site where siteCode='".$siteCode."'";

	if($result=mysqli_query($conn,$sql)){
		$rowcount =mysqli_num_rows($result);
		if($rowcount>0){
			echo "";
		}else{
			echo "<font color=red>Site Code does not exist</font>";
			
		}
	}

	$conn->close();
?>