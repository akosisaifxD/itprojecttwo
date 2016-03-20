<?php
	session_start();
	if(isset($_POST['siteid'])) {
		$_SESSION['siteid'] = $_POST['siteid'];
		$_SESSION['comments'] = $_POST['comments'];
	}
	$siteid = $_SESSION['siteid'];
	$comments = $_SESSION['comments'];
	
	include 'connect.php';
	
	// prepare and bind
	$stmt = $conn->prepare("INSERT INTO journal (comments, senderId, siteID, senderType) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("ssss", $commentsparam, $senderidparam, $siteidparam, $typeparam);
	$commentsparam = $comments;
	$senderidparam = 1237890;
	$siteidparam = $siteid;
	$typeparam = 0;
	$stmt->execute();
	
	header ("location: journal.php");
	
	exit();
?>
