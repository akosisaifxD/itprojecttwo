<?php
	session_destroy();
	
	header ("location: denrhome.php?logout=true");
?>