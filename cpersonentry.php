<?php
	session_start();
	
	if(isset($_POST['firstname'])) {
		$_SESSION['firstname'] = $_POST['firstname'];
		$_SESSION['lastname'] = $_POST['lastname'];
		$_SESSION['mobnum'] = $_POST['mobnum'];
		$_SESSION['telnum'] = $_POST['telnum'];
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['address'] = $_POST['address'];
	}
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$firstname = trim($_SESSION['firstname']);
	$lastname = trim($_SESSION['lastname']);
	
	$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
	$mobnum = $_SESSION['mobnum'];
	$telnum = $_SESSION['telnum'];
	$email = $_SESSION['email'];
	$address = $_SESSION['address'];
	
	$lastid = 0;
	
	if(strlen($firstname) === 0 ){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'fnamelength=error';	
		}else{
			$errorstring = $errorstring . '&fnamelength=error';	
		}
	}
	
	if(strlen($lastname) > 50 ){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'lnameexceed=error';	
		}else{
			$errorstring = $errorstring . '&lnameexceed=error';	
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
	
	if(strlen($lastname) > 50 ){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'lnameexceed=error';	
		}else{
			$errorstring = $errorstring . '&lnameexceed=error';	
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
	
	if (!ctype_digit($telnum) && strlen($telnum) > 0 ) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'telcontchar=error';	
		}else{
			$errorstring = $errorstring . '&telcontchar=error';	
		}
	}
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
echo("$email is a valid email address");
} else {
  echo("$email is not a valid email address");
}
	
	if($errorcount > 0){
		header ("location: hcperson.php?" . $errorstring . "&fname=" . $firstname . "&lname=" . $lastname . "&mobnum=" . $mobnum . "&telnum=" . $telnum);
	}
	
	include 'connect.php';

	$sql = "SELECT COUNT(*) AS num FROM contactperson";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$lastid = ($row['num'] + 1);
		}
	} else {
		echo "0 results";
	}
	
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	$password = generateRandomString();
	
	// prepare and bind
	$stmt = $conn->prepare("INSERT INTO contactperson (contactPersonID, contactPersonName, mobileNumber, telephonenumber, emailaddress, address, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("sssssss", $idparam, $nameparam, $mobnumparam, $telnumparam, $emailparam, $addressparam, $pwparam);
	$idparam = "P" . $lastid;
	$nameparam = $name;
	$mobnumparam = $mobnum;
	$telnumparam = $telnum;
	$emailparam = $email;
	$addressparam = $address;
	$pwparam = $password;
	$stmt->execute();
	
	require 'PHPMailerAutoload.php';

	$mail = new PHPMailer;

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';  						  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'denrtestmailer@gmail.com';                 // SMTP username
	$mail->Password = 'denr2016';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->setFrom('denrtestmailer@gmail.com', 'DENRTestMailer');
	$mail->addAddress($email);               // Name is optional

	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'iPuno Account';
	$mail->Body    = 'Dear ' . $name . ',<br>Good Day!<br><br>Your username is P' . $lastid .' and your password is ' . $password . ". You may use iPuno's journals to report any activity by accessing this link.<br><br>Thank You!";

	if(!$mail->send()) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		echo 'Message has been sent';
	}
?>
