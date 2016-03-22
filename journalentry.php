<?php
	session_start();
	if(isset($_POST['sitecode'])) {
		$_SESSION['sitecode'] = $_POST['sitecode'];
		$_SESSION['comments'] = $_POST['comments'];
		$_SESSION['senderid'] = $_POST['senderid'];
	}
	
	$sitecode = $_SESSION['sitecode'];
	$comments = $_SESSION['comments'];
	$senderid = $_SESSION['senderid'];
	$sendertype = $_SESSION['sendertype'];
	
	include 'connect.php';
	
	// prepare and bind
	$stmt = $conn->prepare("INSERT INTO journal (comments, senderID, siteCode, senderType) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("ssss", $commentsparam, $senderidparam, $sitecodeparam, $typeparam);
	$commentsparam = $comments;
	$senderidparam = $senderid;
	$sitecodeparam = $sitecode;
	$typeparam = $sendertype;
	$stmt->execute();
	
	header ("location: journal.php");
?>
