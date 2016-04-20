<!-- EXTERNAL SCRIPT CALLS -->

<script src="js/jquery.min.js"></script>
<script src="js/formfilledcheck.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->

<?php
	session_start();

	if(isset($_SESSION["username"])){
		
	}else{
		header('Location: denrhome.php?login=fail');
	}
	
	$_SESSION['cpage'] = 'cperson';
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
		min-height: 85%;
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
	<?php include 'header.php' ?>
</div>

<div id = "holdnav">
	<?php include 'navbar.php' ?>
</div>

<div id = "holdcontent">
	<div id = "hcontent">
		<?php include 'newcperson.php' ?>
	</div>
</div>
