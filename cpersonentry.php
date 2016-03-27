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
	
	// prepare and bind
	$stmt = $conn->prepare("INSERT INTO contactperson (contactPersonID, contactPersonName, mobileNumber, telephonenumber, emailaddress, address, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("sssssss", $idparam, $nameparam, $mobnumparam, $telnumparam, $emailparam, $addressparam, $pwparam);
	$idparam = "P" . $lastid;
	$nameparam = $name;
	$mobnumparam = $mobnum;
	$telnumparam = $telnum;
	$emailparam = $email;
	$addressparam = $address;
	$pwparam = "PASSWORD";
	$stmt->execute();
?>
