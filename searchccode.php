<link href='css/removeccode.css' rel='stylesheet' type='text/css'>

<?php
	include 'connect.php';
?>

<form action = "ccodeedit.php" method = "POST">
	<div id = "neworgdiv">
		<div id = "oheader"> Edit Color Code <input type = "submit" class = "enter bypassChanges"></input> </div>
		<?php
			if(isset($_GET["success"])){
				echo "<div id = \"success\"> Successfully edited Color Code </div>";
			}
		?>
		<hr id="jshr">
		<div id = "inputdiv" class = 'alertChanges'>
			<div id='coloryeardiv'>
				Year: <select id = "yearcolor" name = "yearcolor">
					<?php
						$firstcolor = "";
					
						$yearcounter = 0;
						$colorarray = array();
					
						$sql = "SELECT year, color FROM colorcodes WHERE active = 1";
						$result = mysqli_query($conn, $sql);
						if (mysqli_num_rows($result) > 0) {
							// output data of each row
							while($row = mysqli_fetch_assoc($result)) {
								if($yearcounter === 0){
									$firstcolor = $row['color'];
								}
								echo "<option value = \"" . $row["year"] ."\" class = '" . $yearcounter . "' id = '" . $row['year'] . "'>" . $row["year"] . "</option>";
								$colorarray[$yearcounter] = $row['color'];
								$yearcounter++;
							}
						} else {
							echo "0 results";
						}
						
						$colorstring = "";
						
						for($i = 0; $i < sizeof($colorarray); $i++){
							if($i === sizeof($colorarray) - 1){
								$colorstring = $colorstring . "'" . $colorarray[$i] . "'";
							}else{
								$colorstring = $colorstring . "'" . $colorarray[$i] . "',";
							}
						}
					?>
				</select>
			</div>
			<?php
				echo "<div id='colorpallete'> Color: <input type='color' name='color' value='$firstcolor' id = 'color'></div>";
			?>
		</div>
		<hr id="jshr">
	</div>
</form>

<script>
	var colorarray = [<?php echo $colorstring;?>];

	$( "#yearcolor" ).change(function() {
		var current = document.getElementById("yearcolor").value;
		var currentvalue = document.getElementById(current).className;
		var pallete = document.getElementById("color");
		pallete.value = colorarray[currentvalue];
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
