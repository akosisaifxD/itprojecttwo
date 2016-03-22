<?php
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
	$mail->addAddress('akosisaif@rocketmail.com');               // Name is optional

	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'iPuno Account';
	$mail->Body    = 'Your password is ********';
	$mail->AltBody = 'Your password is ********';

	if(!$mail->send()) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		echo 'Message has been sent';
	}
?>
