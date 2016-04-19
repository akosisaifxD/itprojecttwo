<link href='css/removesite.css' rel='stylesheet' type='text/css'>

<form action = "siteremoval.php" method = "POST">
	<div id = "neworgdiv">
		<div id = "oheader"> Remove Site <input type = "submit" class = "enter"></input> </div>
		<?php
			if(isset($_GET["success"])){
				echo "<div id = \"success\"> Successfully Removed Site </div>";
			}
		?>
		<hr id="jshr">
		<?php
			if(isset($_GET["cnamelength"])){
				echo "<div id = \"error\"> Site code field must not be empty </div>";
			}
			if(isset($_GET["cnamedne"])){
				echo "<div id = \"error\"> Site code entered does not exist </div>";
			}
		?>
		<div id = "inputdiv">
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
