<link href='css/removecenro.css' rel='stylesheet' type='text/css'>

<form action = "hscenrocheck.php" method = "POST">
	<div id = "neworgdiv">
		<div id = "oheader"> Edit CENRO <input type = "submit" class = "enter"></input> </div>
		<hr id="jshr">
		<?php
			if(isset($_GET["cnamelength"])){
				echo "<div id = \"error\"> CENRO Name field must not be empty </div>";
			}
			if(isset($_GET["cnamedne"])){
				echo "<div id = \"error\"> CENRO entered does not exist </div>";
			}
		?>
		<div id = "inputdiv">
			CENRO Name: <input id="cname" type = "text" name = "cname"></input>
		</div>
		<hr id="jshr">
	</div>
</form>

<script>
	$(function() {
		$( "#cname" ).autocomplete({
			source: 'autocompletecenro.php'
		});
	});

	/*
	$('.enter').on('click',function(){
		var orgname = document.getElementById("orgname").value;
		var orgtype = document.getElementById("orgtype").value;
		
		$.ajax({
			url: "orgentry.php",
			type: "POST",
			data: {orgname:orgname, orgtype:orgtype}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="horg.php?success=true";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});
	});
	*/
</script>
