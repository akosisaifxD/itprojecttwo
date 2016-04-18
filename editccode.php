<!-- EXTERNAL SCRIPT CALLS -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->
<link href='css/newccode.css' rel='stylesheet' type='text/css'>

<form action = "ccodeedit.php" method = "POST">
	<div id = "neworgdiv">
		<div id = "oheader"> Edit Color Code <input type = "submit" class = "enter"></input> </div>
		<?php
			if(isset($_GET["success"])){
				echo "<div id = \"success\"> Successfully edited Color Code </div>";
			}
			
			if(isset($_POST["yearcolor"])){
				$_SESSION['coloryear'] = $_POST['yearcolor'];
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

				$color = "";
				
				$sql = "SELECT color FROM colorcodes WHERE year = " . $_SESSION['coloryear'];
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						$color = $row['color'];
					}
				} else {
					echo "0 results";
				}
				
				
				echo "<div id='coloryeardiv'> Year: <input type = 'text' id = 'coloryear' name = 'coloryear' value = '" . $_SESSION['coloryear'] . "' maxlength='4' pattern = '.{4,}' title = '4 digits' readonly></input></div>";
				echo "<div id='colorpallete'> Color: <input type='color' name='color' value = '" . $color . "' id = 'color'></div>";
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
