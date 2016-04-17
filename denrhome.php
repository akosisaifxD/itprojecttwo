<!-- EXTERNAL SCRIPT CALLS -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->

<style>
	@font-face {
		font-family: raleway;
		src: url(fonts/raleway/Raleway-SemiBold.ttf);
	}

	html, body {
		height: 100%;
    	margin: 0;
		background-color: #d5d4d0;
		width: 100%;
	}

	#logincontainer{
		position: absolute;
		top: 20%;
		left: 30%;
		height: 60%;
		width: 40%;
		background-color: white;
		border-radius: 15px 15px 15px 15px;
	}
	
	#loginheader{
		height: 30%;
		border-radius: 15px 15px 0px 0px;
		background-color: #156234;
		text-align: center;
	}
	
	#logo{
		height: 80%;
		position: relative;
		top: 10%;
	}
	
	#loginform{
		font-family: raleway;
		position: relative;
		top: 5%;
		text-align: center;
	}
	
	#unenter{
		margin-bottom: 1%;
	}
	
	#pwenter{
		margin-top: 3%;
		margin-bottom: 1%;
	}
	
	#loginbutton{
		margin-top: 4%;	
	}
	
	#login{
		font-family: raleway;
		background-color: white;
		padding: 2%;
		border-radius: 10px 10px 10px 10px;
		border-color: #156234;
		border-style: solid;
		border-width: medium;
	}
	
	#lfooter{
		font-family: raleway;
		background-color: #156234;
		position: absolute;
		top: 85%;
		width: 100%;
		height: 15%;
		border-radius: 0px 0px 15px 15px;
		color: white;
		text-align: center;
		font-size: 80%;
	}
	
	#footertext{
	  position: absolute;
	  top: 50%;
	  left: 50%;
	  transform: translate(-50%, -50%);
	}
	
	#username, #password{
		font-family: raleway;

	}
	
	#error{
		font-size: 90%;
		color: red;
		margin-bottom: 2%;
	}
</style>

<div id = "logincontainer">
	<div id = "loginheader">
		<img src = "img/logo.png" id = "logo"/>
	</div>
	
	<div id = "loginform">
		<?php
			if(isset($_GET["error"])){
				echo "<div id = \"error\"> Invalid username/password </div>";
			}
			
			if(isset($_GET["logout"])){
				echo "<div id = \"error\"> Logout success </div>";
			}
			
			if(isset($_GET["login"])){
				echo "<div id = \"error\"> You must first login to visit the sites pages. </div>";
			}
		?>
		<form action = "loginprocess.php" method = "POST">
			<div id = "unenter"> DENR ID: </div> <input type = "text" id = "username" name = "username"></input>
			<div id = "pwenter"> Password: </div> <input type = "password" id = "password" name = "password" ></input>
			<div id = "loginbutton" onclick = "loginfunc()"> <input type = "submit" id = "login" value = "Sign In" /></div>
		</form>
	</div>
	
	<div id = "lfooter">
		<div id = "footertext"> Only DENR Employees will be able to sign in using this form. </div>
	</div>
</div>

<script type = "text/javascript">
	
</script>
