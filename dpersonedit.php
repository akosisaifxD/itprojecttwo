<?php
	session_start();
	
	include 'connect.php';
	
	if(isset($_POST['firstname'])) {
		$_SESSION['firstname'] = $_POST['firstname'];
		$_SESSION['lastname'] = $_POST['lastname'];
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['acctype'] = $_POST['acctype'];
		$_SESSION['cenro'] = $_POST['cenro'];
	}
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$firstname = trim($_SESSION['firstname']);
	$lastname = trim($_SESSION['lastname']);
	$firstnameuntr = $_SESSION['firstname'];
	$lastnameuntr = $_SESSION['lastname'];
	
	$name = $_SESSION['firstname'] . " " . $lastnameuntr;
	$email = $_SESSION['email'];
	$acctype = $_SESSION['acctype'];
	$cenro = $_SESSION['cenro'];
	
	$lastid = 0;
	
	if(strlen($firstname) === 0 ){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'fnamelength=error';	
		}else{
			$errorstring = $errorstring . '&fnamelength=error';	
		}
	}
	
	if (ctype_digit($firstname) && strlen($firstname) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'fnamedig=error';	
		}else{
			$errorstring = $errorstring . '&fnamedig=error';	
		}
	}
	
	if(strlen($lastname) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'lnamelength=error';	
		}else{
			$errorstring = $errorstring . '&lnamelength=error';	
		}
	}
	
	if (ctype_digit($lastname) && strlen($lastname) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'lnamedig=error';	
		}else{
			$errorstring = $errorstring . '&lnamedig=error';	
		}
	}
	
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	
	if(strlen($email) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'emaill=error';	
		}else{
			$errorstring = $errorstring . '&emaill=error';	
		}
	}else{
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			$errorcount++;
			if($errorcount === 1){
				$errorstring = $errorstring . 'emailf=error';	
			}else{
				$errorstring = $errorstring . '&emailf=error';	
			}
		}	
	}
	
	if($errorcount > 0){
		header ("location: hedpersonnel.php?" . $errorstring . "&fname=" . $firstname . "&lname=" . $lastname . "&email=" . $email . "&acctype=" . $acctype);
	}else{
		$sql = "UPDATE denr SET firstName = '$firstnameuntr', lastName = '$lastnameuntr', email = '$email', accountType = '$acctype', cenroID = '$cenro' WHERE denrID ='" . $_SESSION['searcheddp'] . "'";

		if ($conn->query($sql) === TRUE) {
		} else {
		}
		
		header ("location: hedpersonnel.php?success=true");
	}
?>
