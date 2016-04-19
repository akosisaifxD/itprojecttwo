<?php
	session_start();

	include 'connect.php';
	
	if(isset($_SESSION["username"])){
		
	}else{
		header('Location: denrhome.php?login=fail');
	}
?>

<!-- EXTERNAL SCRIPT CALLS -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->

<?php
	$_SESSION['cpage'] = 'journals';

	$senderid = $_SESSION['username'];
	
	if(isset($_POST['sitecode'])) {
		$_SESSION['sitecode'] = $_POST['sitecode'];
	}
	
	//use POST data and set to local PHP Variables
	$sitecode = $_SESSION['sitecode'];
	$sendertype = $_SESSION['sendertype'];
	
	$errorcount = 0;
	
	$errorstring = "";
	
	if(strlen(TRIM($sitecode)) === 0){
		$errorcount++;
		if($errorcount === 1){
			$errorstring = $errorstring . 'sitecode=error';	
		}else{
			$errorstring = $errorstring . '&sitecode=error';	
		}
	}
	
	if($errorcount > 0){
		header ("location: hjournal.php?" . $errorstring);
	}
	
	$sites = array();
	$arrcount = 0;
	
	if($_SESSION['accounttype'] === 'Advanced'){
		$sql = "SELECT siteCode FROM site";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$sites[$arrcount] = $row['siteCode'];
				$arrcount++;
			}
		}
	}else{
		$cenroid = "";
		
		$sql = "SELECT cenroID FROM denr WHERE denrID = '" . $senderid . "'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$cenroid = $row['cenroID'];
			}
		}
		
		$municipalities = array();
		$municount = 0;
		
		$sql = "SELECT municipalityID FROM cenromunicipality WHERE cenroID = '" . $cenroid . "'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$municipalities[$municount] = $row['municipalityID'];
				$municount++;
			}
		}
		
		for($i = 0; $i < sizeof($municipalities); $i++){
			$sql = "SELECT siteCode FROM site WHERE municipalityID = '" . $municipalities[$i] . "'";
			$result = mysqli_query($conn, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
					$sites[$arrcount] = $row['siteCode'];
					$arrcount++;
				}
			}	
		}
	}
	
	if (!in_array($sitecode, $sites)) {
		header ("location: hjournal.php?dne=true");
	}
?>

<style>
	html, body {
		height: 100%;
    	margin: 0;
		background-color: #d5d4d0;
		width: 100%;
	}
	
	#holdheader{
		width: 80%;
		height: 15%;
		position: fixed;
		top: 0%;
		left: 10%;
		z-index:1;
	}
	
	#holdnav{
		width: 12%;
		height:85%;
		position: fixed;
		top: 15%;
		left:10%;
		z-index: 2;
	}
	
	#holdcontent{
		width: 68%;
		min-height: 100%;
		position: relative;
		top: 15%;
		left: 22%;
		background-color: white;
	}
	
	#hcontent{
		position: relative;
	}
</style>

<div id = "holdheader">
	<?php
		include 'header.php';
	?>
</div>

<div id = "holdnav">
	<?php
		include 'navbar.php';
	?>
</div>

<div id = "holdcontent">
	<div id = "hcontent">
		<?php
			include 'journal.php';
		?>
	</div>
</div>
