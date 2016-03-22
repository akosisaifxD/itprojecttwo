<!-- EXTERNAL SCRIPT CALLS -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->

<?php
	if(isset($_GET["error"])){
		echo "<div id = \"error\"> Invalid Username/Password</div>";
	}
?>
<div id = "loginbody">
	<div id = "header"> Login </div>
	<div id = "untextbox"> Username: <input type = "text" id = "untb"></input>
	<div id = "pwtextbox"> Password: <input type = "text" id = "pwtb"></input>
	<button onclick = "loginfunc()"> Log In </button>
</div>

<script type = "text/javascript">

	function loginfunc(){
		var usernamev = document.getElementById("untb").value;
		var passwordv = document.getElementById("pwtb").value;
		
		$.ajax({
			url: "loginprocess.php",
			type: "POST",
			data: {username:usernamev, password: passwordv}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="loginprocess.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
	
</script>
