<?php
	session_start();

	include 'connect.php';

	$un = $_SESSION['username'];
	
	if(isset($_SESSION['prevll'])){
		$sql = "SELECT lastLogin FROM denr WHERE denrID = \"" . $un . "\"";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$_SESSION['prevll'] = $row['lastLogin'];
			}
		} else {
		}
		
		$sql = "UPDATE denr SET lastLogin=now() WHERE denrID = '" . $un . "'";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
		
		unset($_SESSION['ujcount']);
		
		header('Location: hjournal.php');
	}
?>