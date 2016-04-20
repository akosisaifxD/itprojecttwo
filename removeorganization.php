<link href='css/removeorganization.css' rel='stylesheet' type='text/css'>

<form action = "organizationremoval.php" method = "POST">
	<div id = "neworgdiv">
		<div id = "oheader"> Remove Organization <input type = "submit" class = "enter bypassChanges"></input> </div>
		<?php
			if(isset($_GET["success"])){
				echo "<div id = \"success\"> Successfully Removed Organization </div>";
			}
			if(isset($_GET["orglength"])){
				echo "<div id = \"error\"> Organization Name field must not be empty </div>";
			}
			if(isset($_GET["orgdne"])){
				echo "<div id = \"error\"> Organization entered does not exist </div>";
			}
		?>
		<hr id="jshr">
		<?php
			/*
			if(isset($_GET["orglength"])){
				echo "<div id = \"error\"> Organization Name field must not be empty </div>";
			}
			if(isset($_GET["orgdne"])){
				echo "<div id = \"error\"> Organization entered does not exist </div>";
			}
			*/
		?>
		<div id = "inputdiv" class = "alertChanges">
			Organization Name: <input id="orgname" type = "text" name = "orgname"></input>
		</div>
		<hr id="jshr">
	</div>
</form>

<script>
	$(function() {
		$( "#orgname" ).autocomplete({
			source: 'autocompleteorg.php'
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
