<!-- EXTERNAL SCRIPT CALLS -->

<script src="js/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->
<link href='css/newcenro.css' rel='stylesheet' type='text/css'>

<form action = "cenroentry.php" method = "POST">
	<div id = "neworgdiv">
		<div id = "oheader"> New CENRO <input type = "submit" class = "enter bypassChanges"></input> </div>
		<?php
			if(isset($_GET["success"])){
				echo "<div id = \"success\"> Successfully added new CENRO </div>";
			}
			if(isset($_GET["snlength"])){
				echo "<div id = \"error\"> CENRO name field must not be empty </div>";
			}
			if(isset($_GET["sncontchar"])){
				echo "<div id = \"error\"> CENRO name must not contain digits </div>";
			}
			if(isset($_GET["sndup"])){
				echo "<div id = \"error\"> CENRO already exists </div>";
			}
		?>
		<hr id="jshr">
		<div id = "inputdiv" class = "alertChanges">
			<?php
				/*
				if(isset($_GET["snlength"])){
					echo "<div id = \"snerror\"> CENRO name field must not be empty </div>";
				}
				if(isset($_GET["sncontchar"])){
					echo "<div id = \"snerror\"> CENRO name must not contain digits </div>";
				}
				if(isset($_GET["sndup"])){
					echo "<div id = \"snerror\"> CENRO already exists </div>";
				}
				*/
				if(isset($_GET["cenroname"])){
					echo "<div id='speciesnamediv'> CENRO Name: <input type = 'text' id = 'speciesname' name = 'cenro' value = '" . $_GET['cenroname'] . "' maxlength='50'></input></div>";
				}else{
					echo "<div id='speciesnamediv'> CENRO Name: <input type = 'text' id = 'speciesname' name = 'cenro' maxlength='50'></input></div>";
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
