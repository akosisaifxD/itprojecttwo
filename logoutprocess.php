<?php
	session_start();

	// Unset all of the session variables.
	$_SESSION = array();
	
	session_destroy();
	
	header ("location: denrhome.php?logout=true");
?>