<link href='css/removespecies.css' rel='stylesheet' type='text/css'>

<form action = "hsspeciescheck.php" method = "POST">
	<div id = "neworgdiv">
		<div id = "oheader"> Edit Species <input type = "submit" class = "enter"></input> </div>
		<hr id="jshr">
		<?php
			if(isset($_GET["cnamelength"])){
				echo "<div id = \"error\"> Species Common Name field must not be empty </div>";
			}
			if(isset($_GET["cnamedne"])){
				echo "<div id = \"error\"> Species entered does not exist </div>";
			}
		?>
		<div id = "inputdiv">
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
