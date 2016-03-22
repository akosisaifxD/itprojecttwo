<?php
	session_start();
	
	//connect to database using external PHP file
	include 'connect.php';
	
	$name;
	
	$sql = "SELECT firstName, lastName FROM denr WHERE denrID = " . $_SESSION['username'];
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			//stores captured name from query onto local variable
			$name = $row['firstName'] . " " . $row['lastName'];
		}
	} else {
		//do nothing
	}
	echo "<div id = \"welcome\"> Welcome, " . $name . "!</div>";
?>

<div id = "journallink"> <a href = "journalsearch.php">Journals</a> </div>
