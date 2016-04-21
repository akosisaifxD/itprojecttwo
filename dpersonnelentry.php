<?php
	session_start();
	
	include 'connect.php';
	
	if(isset($_POST['firstname'])) {
		$_SESSION['firstname'] = $_POST['firstname'];
		$_SESSION['lastname'] = $_POST['lastname'];
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['acctype'] = $_POST['acctype'];
		$_SESSION['cenro'] = $_POST['cenro'];
		$_SESSION['denrid'] = $_POST['denrid'];
	}
	
	$errorcount = 0;
	
	$errorstring = "";
	
	$denrpersons = array();
	$dpscount = 0;
		
	$sql = "SELECT firstName, lastName FROM denr WHERE active = 1";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$denrpersons[$dpscount] = $row['firstName'] . " " . $row['lastName'];
			$dpscount++;
		}
	} else {
		echo "0 results";
	}
	
	$illegal = array(';',':','!','$','%','^','*','(',')','{','}','[',']','"','\\','-','_','=',',','/','?');
	$illegalem = array(';',':','!','$','%','^','*','(',')','{','}','[',']','"','\\','=',',','/','?');
	
	$firstname = TRIM(strip_tags(str_replace($illegal, '', $_SESSION['firstname'])));
	$lastname = TRIM(strip_tags(str_replace($illegal, '', $_SESSION['lastname'])));
	$firstnameuntr = TRIM(strip_tags(str_replace($illegal, '', $_SESSION['firstname'])));
	$lastnameuntr = TRIM(strip_tags(str_replace($illegal, '', $_SESSION['lastname'])));
	
	$name = $firstnameuntr . " " . $lastnameuntr;
	$email = TRIM(strip_tags(str_replace($illegal, '', $_SESSION['email'])));
	$denrid = TRIM(strip_tags(str_replace($illegal, '', $_SESSION['denrid'])));
	$acctype = $_SESSION['acctype'];
	$cenro = $_SESSION['cenro'];
	
	$lastid = 0;
	
	if (strlen($denrid) === 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'denrempt=error';	
		}else{
			$errorstring = $errorstring . '&denrempt=error';	
		}
	}
	
	if (!ctype_digit(str_replace(' ', '', $denrid)) && strlen($denrid) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'denras=error';	
		}else{
			$errorstring = $errorstring . '&denras=error';	
		}
	}
	
	if (strlen($denrid) < 7 && strlen($denrid) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'denrlen=error';	
		}else{
			$errorstring = $errorstring . '&denrlen=error';	
		}
	}
	
	if (in_array($name, $denrpersons)) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'cpersondup=error';	
		}else{
			$errorstring = $errorstring . '&cpersondup=error';	
		}
	}
	
	if(strlen($firstname) === 0 ){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'fnamelength=error';	
		}else{
			$errorstring = $errorstring . '&fnamelength=error';	
		}
	}
	
	if (!ctype_alpha(str_replace(' ', '', $firstname)) && strlen($firstname) > 0) {
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
	
	if (!ctype_alpha(str_replace(' ', '', $lastname)) && strlen($lastname) > 0) {
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'lnamedig=error';	
		}else{
			$errorstring = $errorstring . '&lnamedig=error';	
		}
	}
	
	/*
	if(strlen($lastname) > 50 ){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'lnameexceed=error';	
		}else{
			$errorstring = $errorstring . '&lnameexceed=error';	
		}
	}
	*/
	
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
	
	$denrids = array();
	$didscount = 0;
	
	$sql = "SELECT denrID FROM denr";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$denrids[$didscount] = $row['denrID'];
			$didscount++;
		}
	} else {
		echo "0 results";
	}
	
	if(in_array($denrid, $denrids)){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'denrdiup=error';	
		}else{
			$errorstring = $errorstring . '&denrdiup=error';	
		}
	}
	
	if($errorcount > 0){
		header ("location: hdpersonnel.php?" . $errorstring . "&fname=" . $firstname . "&lname=" . $lastname . "&email=" . $email . "&acctype=" . $acctype . "&denrid=" . $denrid);
	}else{
		$inactdpersons = array();
		$idpscount = 0;
		
		$lastid = 0;
		
		$sql = "SELECT firstName, lastName FROM denr WHERE active = 0";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$inactdpersons[$idpscount] = $row['firstName'] . " " . $row['lastName'];
				$idpscount++;
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
		
		if (in_array($name, $inactdpersons)) {
			$sql = "UPDATE denr SET denrID = '$denrid', email = '$email', accountType = '$acctype', password = '$password', active = 1 WHERE concat(firstName, ' ', lastName) ='" . $name . "'";

			if ($conn->query($sql) === TRUE) {
			} else {
			}
			
		}else{
			
			// prepare and bind
			$stmt = $conn->prepare("INSERT INTO denr (denrID, firstName, lastName, email, password, accountType, cenroID) VALUES (?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssss", $idparam, $fnameparam, $lnameparam, $emailparam, $pwparam, $acctypeparam, $cidparam);
			$idparam = $denrid;
			$fnameparam = $firstnameuntr;
			$lnameparam = $lastnameuntr;
			$emailparam = $email;
			$pwparam = $password;
			$acctypeparam = $acctype;
			$cidparam = $cenro;
			$stmt->execute();
			
		}
		
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
		$mail->Body    = 'Dear ' . $name . ',<br>Good Day!<br><br>Your username is ' . $denrid .' and your password is ' . $password . ". You may use iPuno's journals to report any activity by accessing this link.<br><br>Thank You!";

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Message has been sent';
		}
		
		header ("location: hdpersonnel.php?success=true");
	}
?>
