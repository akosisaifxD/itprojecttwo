<link href='css/removespecies.css' rel='stylesheet' type='text/css'>

<form action = "speciesremoval.php" method = "POST">
	<div id = "neworgdiv">
		<div id = "oheader"> Remove Species <input type = "submit" class = "enter bypassChanges"></input> </div>
		<?php
			if(isset($_GET["success"])){
				echo "<div id = \"success\"> Successfully Removed Species </div>";
			}
			if(isset($_GET["cnamelength"])){
				echo "<div id = \"error\"> Species Common Name field must not be empty </div>";
			}
			if(isset($_GET["cnamedne"])){
				echo "<div id = \"error\"> Species entered does not exist </div>";
			}
		?>
		<hr id="jshr">
		<div id = "inputdiv" class = 'alertChanges'>
			Species Common Name: <input id="cname" type = "text" name = "cname"></input>
		</div>
		<hr id="jshr">
	</div>
</form>

<script>
	$(function() {
		$( "#cname" ).autocomplete({
			source: 'autocompletespecies.php'
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
