<?php
	if(!isset($_SESSION)){
		session_start();
	}
	
	include 'connect.php';
	
	$username = "";
	$userid = $_SESSION['username'];
	
	$sqltwo = "SELECT firstName, lastName FROM denr WHERE denrID = \"" . $userid . "\"";
	$resulttwo = mysqli_query($conn, $sqltwo);
							
	if (mysqli_num_rows($resulttwo) > 0) {
		// output data of each row
		while($rowtwo = mysqli_fetch_assoc($resulttwo)) {
			//stores captured name from query onto local variable
			$username = $rowtwo['firstName'] . " " . $rowtwo['lastName'];
		}
	} else {
		//do nothing
	}
	
	
?>

<style>
	@font-face {
		font-family: raleway;
		src: url(fonts/raleway/Raleway-SemiBold.ttf);
	}
	
	@font-face {
		font-family: berlin;
		src: url(fonts/Berlin Sans FB/Berlin Sans FB.ttf);
	}

	body #header{
		background-color: #156234;
		height: 100%;
		width: 100%;
	}
	
	#headerlogo{
		position: absolute;
		left: 5%;
		height: 95%;
	}
	
	#headertitle{
		position: absolute;
		top: 18%;
		left: 15%;
		font-size: 380%;
		color: white;
	}
	
	#headersettings{
		position: absolute;
		cursor: pointer;
		top: 51%;
		left: 95%;
		color: white;
		display: inline-block;
	}
	
	#headersettings:hover, #headersettings:focus {
		color: #25b15e!important;
	}
	
	#settingscontent {
		font-family: raleway;
		font-size: 120%;
		display: none;
		position: absolute;
		top: 78%;
		left: 85%;
		z-index: 3;
		background-color: #f9f9f9;
		text-align: center;
		box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
		width: 15%;
		height: 23%;
	}
	
	.accoption{
		cursor: pointer;
	}
	
	.show {display:block!important;}
	
	.accoption{
		padding: 2.5%;
	}
	
	.accoption:hover, .accoption:focus{
		background-color: #25b15e!important;
	}
	
	#currentuser{
		position: absolute;
		top: 54%;
		left: 86%;
		display: inline-block;
		font-family: raleway;
		font-size: 130%;
		color: white;
	}
</style>

<div id = "header">
	<img src = "img/logo.png" id = "headerlogo" />
	<div id = "headertitle"> iPUNO </div>
	<div id = "headersettings" class = "headersettings" onclick = "accoptions()"> <i class="fa fa-cog fa-2x"></i> </div>
	<div id = "currentuser"> <?php echo $username;?> </div>
	<div id="settingscontent" class="settingscontent">
		
		<div id = "signout" class = "accoption"> Sign out </div>
	</div>
</div>

<script>
	function accoptions() {
		document.getElementById("settingscontent").classList.toggle("show");
	}

	$('#signout').on('click',function(){
		window.location="logoutprocess.php";
	});
</script>
