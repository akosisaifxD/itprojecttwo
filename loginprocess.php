<?php
	//connect to database using external PHP file
	include 'connect.php';
	
	session_start();
	
	//GLOBAL VARIABLES
	$un = "";
	$pw = "";
	$checker = 0;
	
	//FUNCTIONS
	function checkData(){
		if(isset($_POST['username'])) {
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['password'] = $_POST['password'];
		}
	}
	
	function setUsername(){
		return $_SESSION['username'];
	}
	
	function setPassword(){
		return $_SESSION['password'];
	}
	
	function setChecker(){
		if(isset($_SESSION['checker'])) {
			return 1;
		}else{
			return 0;
		}
	}
	
	function checkIfContactPerson($un){
		return strpos($un, 'P');
	}
	
	function verifyPasswordForContactPerson(){
		$sql = "SELECT password FROM contactperson WHERE contactPersonID = \"" . $un . "\"";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				if($row["password"] == $pw){
					$checker = 1;
					$_SESSION['accounttype'] = "CPerson";
				}
			}
		} else {
			header('Location: denrhome.php?error=true');
		}
	}
	
	function verifyPasswordForDENR($un, $pw, $checker, $conn){
		$sql = "SELECT password, accountType, lastLogin FROM denr WHERE denrID = \"" . $un . "\"";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				if($row["password"] === $pw){
					$_SESSION['prevll'] = $row['lastLogin'];
					$_SESSION['checker'] = 1;
					if($row["accountType"] === "Basic"){
						$_SESSION['accounttype'] = "Basic";
					}else{
						$_SESSION['accounttype'] = "Advanced";
					}
				}
			}
		} else {
			header('Location: denrhome.php?error=true');
		}
	}

	function verifyIfValid($un, $conn, $checker){
		if($checker === 1){
			$_SESSION['sendertype'] = 0;
			
			$sql = "UPDATE denr SET lastLogin=now() WHERE denrID = '" . $un . "'";

			if ($conn->query($sql) === TRUE) {
			} else {
			}
			
			header('Location: holder.php');
		}else{
			header('Location: denrhome.php?error=true');
		}
	}
	//END OF FUNCTIONS
	
	//PHP RUNNING CODE
	checkData();
	
	$un = setUsername();
	$pw = setPassword();
	
	if(checkIfContactPerson($un) !== false){
		verifyPasswordForContactPerson();
	}else{
		verifyPasswordForDENR($un, $pw, $checker, $conn);
		$checker = setChecker();
	}
	
	verifyIfValid($un, $conn, $checker);
	//END OF PHP RUNNING CODE
?>
