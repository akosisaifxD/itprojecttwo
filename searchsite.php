<link href='css/editsite.css' rel='stylesheet' type='text/css'>

<form action = "hssitecheck.php" method = "POST">
	<div id = "neworgdiv">
		<div id = "oheader"> Search Site <input type = "submit" class = "enter bypassChanges" value = 'Edit'></input> </div>
		<?php
			if(isset($_GET["success"])){
				echo "<div id = \"success\"> Successfully edited Site </div>";
			}
			if(isset($_GET["cpersonlength"])){
				echo "<div id = \"error\"> Site Code field must not be empty </div>";
			}
			if(isset($_GET["cpersondne"])){
				echo "<div id = \"error\"> Site entered does not exist </div>";
			}
		?>
		<hr id="jshr">
		<div id = "inputdiv" class = "alertChanges">
			Site Code: <input id="sitecode" type = "text" name = "sitecode"></input>
		</div>
		<hr id="jshr">
	</div>
</form>

<script>
	$(function() {
		$( "#sitecode" ).autocomplete({
			source: 'autocompletesite.php'
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
