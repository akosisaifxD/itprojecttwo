<?php
	session_start();
	
	include 'connect.php';
	
	if(isset($_POST['mobnum'])) {
		$_SESSION['mobnum'] = $_POST['mobnum'];
		$_SESSION['telnum'] = $_POST['telnum'];
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['address'] = $_POST['address'];
	}
	
	$mobnum = $_SESSION['mobnum'];
	$telnum = $_SESSION['telnum'];
	$email = $_SESSION['email'];
	$address = $_SESSION['address'];
	
	$errorcount = 0;
	
	$errorstring = "";
	
	if(strlen($mobnum) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'moblength=error';	
		}else{
			$errorstring = $errorstring . '&moblength=error';	
		}
	}
	if (!ctype_digit($mobnum) && strlen($mobnum) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'mobcontchar=error';	
		}else{
			$errorstring = $errorstring . '&mobcontchar=error';	
		}
	}
	
	if(strlen($telnum) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'tellength=error';	
		}else{
			$errorstring = $errorstring . '&tellength=error';	
		}
	}
	
	if (!ctype_digit($telnum) && strlen($telnum) > 0 ) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'telcontchar=error';	
		}else{
			$errorstring = $errorstring . '&telcontchar=error';	
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
	
	if(strlen($address) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'addl=error';	
		}else{
			$errorstring = $errorstring . '&addl=error';	
		}
	}
	
	if($errorcount > 0){
		header ("location: hecperson.php?" . $errorstring . "&mobnum=" . $mobnum . "&telnum=" . $telnum . "&email=" . $email . "&address=" . $address);
	}else{
		$sql = "UPDATE contactperson SET mobileNumber = '$mobnum', telephoneNumber = '$telnum', emailaddress = '$email', address = '$address' WHERE contactPersonID ='" . $_SESSION['searchedcp'] . "'";

		if ($conn->query($sql) === TRUE) {
		} else {
		}
		
		header ("location: hscperson.php?success=true");
	}
?>
