<?php
	session_start();
	if(isset($_POST['name'])) {
		$_SESSION['name'] = $_POST['name'];
		$_SESSION['mobnum'] = $_POST['mobnum'];
		$_SESSION['telnum'] = $_POST['telnum'];
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['address'] = $_POST['address'];
	}
	
	$name = $_SESSION['name'];
	$mobnum = $_SESSION['mobnum'];
	$telnum = $_SESSION['telnum'];
	$email = $_SESSION['email'];
	$address = $_SESSION['address'];
	
	$lastid = 0;
	
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
