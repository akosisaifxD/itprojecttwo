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
	
	include 'connect.php';
	
	// prepare and bind
	$stmt = $conn->prepare("INSERT INTO journal (comments, sender, siteCode) VALUES (?, ?, ?)");
	$stmt->bind_param("sss", $commentsparam, $senderidparam, $sitecodeparam);
	$commentsparam = $comments;
	$senderidparam = $senderid;
	$sitecodeparam = $sitecode;
	$stmt->execute();
	
	header ("location: hjournalr.php");
?>
