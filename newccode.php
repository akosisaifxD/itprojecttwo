<!-- EXTERNAL SCRIPT CALLS -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->
<link href='css/newccode.css' rel='stylesheet' type='text/css'>

<form action = "ccodeentry.php" method = "POST">
	<div id = "neworgdiv">
		<div id = "oheader"> New Color Code <input type = "submit" class = "enter"></input> </div>
		<?php
			if(isset($_GET["success"])){
				echo "<div id = \"success\"> Successfully added new Color Code </div>";
			}
		?>
		<hr id="jshr">
		<div id = "inputdiv">
			<?php
				if(isset($_GET["colorlength"])){
					echo "<div id = \"colorerror\"> Year field must not be empty </div>";
				}
				if(isset($_GET["colorcontchar"])){
					echo "<div id = \"colorerror\"> Year field must only contain digits </div>";
				}
				if(isset($_GET["colordup"])){
					echo "<div id = \"colorerror\"> A color has already been assigned to this year </div>";
				}
				if(isset($_GET["coloryear"])){
					echo "<div id='coloryeardiv'> Year: <input type = 'text' id = 'coloryear' name = 'coloryear' value = '" . $_GET['coloryear'] . "' maxlength='4' pattern = '.{4,}' title = '4 digits'></input></div>";
				}else{
					echo "<div id='coloryeardiv'> Year: <input type = 'text' id = 'coloryear' name = 'coloryear' maxlength='4' pattern = '.{4,}' title = '4 digits'></input></div>";
				}
				
				if(isset($_GET["color"])){
					echo "<div id='colorpallete'> Color: <input type='color' name='color' value = '" . $_GET['color'] . "' id = 'color'></div>";
				}else{
					echo "<div id='colorpallete'> Color: <input type='color' name='color' value='#ff0000' id = 'color'></div>";;
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
