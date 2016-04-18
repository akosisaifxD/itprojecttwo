<link href='css/removedpersonnel.css' rel='stylesheet' type='text/css'>

<form action = "hsdpersonnelcheck.php" method = "POST">
	<div id = "neworgdiv">
		<div id = "oheader"> Edit DENR Personnel <input type = "submit" class = "enter"></input> </div>
		<hr id="jshr">
		<?php
			if(isset($_GET["dpersonlength"])){
				echo "<div id = \"error\"> DENR Personnel Name field must not be empty </div>";
			}
			if(isset($_GET["dpersondne"])){
				echo "<div id = \"error\"> DENR Personnel entered does not exist </div>";
			}
		?>
		<div id = "inputdiv">
			DENR Personnel Name: <input id="dperson" type = "text" name = "dperson"></input>
		</div>
		<hr id="jshr">
	</div>
</form>

<script>
	$(function() {
		$( "#dperson" ).autocomplete({
			source: 'autocompletedenr.php'
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
