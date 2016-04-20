<!-- EXTERNAL SCRIPT CALLS -->

<script src="js/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->
<link href='css/newspecies.css' rel='stylesheet' type='text/css'>

<form action = "speciesentry.php" method = "POST">
	<div id = "neworgdiv">
		<div id = "oheader"> New Species <input type = "submit" class = "enter bypassChanges"></input> </div>
		<?php
			if(isset($_GET["success"])){
				echo "<div id = \"success\"> Successfully added new Species </div>";
			}
			if(isset($_GET["snlength"])){
				echo "<div id = \"snerror\"> Species name field must not be empty </div>";
			}
			if(isset($_GET["sncontchar"])){
				echo "<div id = \"snerror\"> Species name must not contain digits </div>";
			}
			if(isset($_GET["sndup"])){
				echo "<div id = \"snerror\"> Species already exists </div>";
			}
			if(isset($_GET["cnlength"])){
				echo "<div id = \"cnerror\"> Common name field must not be empty </div>";
			}
			if(isset($_GET["cncontchar"])){
				echo "<div id = \"cnerror\"> Common name must not contain digits </div>";
			}
			if(isset($_GET["cndup"])){
				echo "<div id = \"cnerror\"> Species already exists </div>";
			}
		?>
		<hr id="jshr">
		<div id = "inputdiv" class = "alertChanges">
			<?php
				if(isset($_GET["speciesname"])){
					echo "<div id='speciesnamediv'> Species Name: <input type = 'text' id = 'speciesname' name = 'speciesname' value = '" . $_GET['speciesname'] . "' maxlength='50'></input></div>";
				}else{
					echo "<div id='speciesnamediv'> Species Name: <input type = 'text' id = 'speciesname' name = 'speciesname' maxlength='50'></input></div>";
				}
	
				if(isset($_GET["commonname"])){
					echo "<div id='commonnamediv'> Common Name: <input type = 'text' id = 'commonname' name = 'commonname' value = '" . $_GET['commonname'] . "' maxlength='50'></input></div>";
				}else{
					echo "<div id='commonnamediv'> Common Name: <input type = 'text' id = 'commonname' name = 'commonname' maxlength='50'></input></div>";
				}
			?>
			<hr id="jshr">
			
		</div>
	</div>
</form>

<script>
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
