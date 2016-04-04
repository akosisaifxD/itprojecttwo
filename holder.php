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
		position: absolute;
		top: 0%;
		left: 10%;
	}
	
	#holdnav{
		width: 12%;
		height:85%;
		position: absolute;
		top: 15%;
		left:10%;
	}
	
	#holdcontent{
		width: 68%;
		height: 85%;
		position: absolute;
		top: 15%;
		left: 22%;
	}
</style>

<div id = "holdheader">
	<?php include 'header.php' ?>
</div>

<div id = "holdnav">
	<?php include 'navbar.php' ?>
</div>

<div id = "holdcontent">
	<?php include 'content.php' ?>
</div>
