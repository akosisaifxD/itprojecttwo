<link href='css/removecperson.css' rel='stylesheet' type='text/css'>

<form action = "hscpersoncheck.php" method = "POST">
	<div id = "neworgdiv">
		<div id = "oheader"> Search Contact Person <input type = "submit" class = "enter bypassChanges" value = 'Edit'></input> </div>
		<?php
			if(isset($_GET["success"])){
				echo "<div id = \"success\"> Successfully edited Contact Person </div>";
			}
			if(isset($_GET["cpersonlength"])){
				echo "<div id = \"error\"> Contact Person Name field must not be empty </div>";
			}
			if(isset($_GET["cpersondne"])){
				echo "<div id = \"error\"> Contact Person entered does not exist </div>";
			}
		?>
		<hr id="jshr">
		<div id = "inputdiv" class = "alertChanges">
			Contact Person Name: <input id="cperson" type = "text" name = "cperson"></input>
		</div>
		<hr id="jshr">
	</div>
</form>

<script>
	$(function() {
		$( "#cperson" ).autocomplete({
			source: 'autocomplete.php'
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
