<!-- EXTERNAL SCRIPT CALLS -->

<script src="js/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->
<link href='css/rccode.css' rel='stylesheet' type='text/css'>

<form action = "ccoderemoval.php" method = "POST">
	<div id = "neworgdiv">
		<div id = "oheader"> Remove Color Code <input type = "submit" class = "enter bypassChanges"></input> </div>
		<?php
			if(isset($_GET["success"])){
				echo "<div id = \"success\"> Successfully Removed Color Code </div>";
			}
		?>
		<hr id="jshr">
		<div id = "inputdiv" class = "alertChanges">
			Year: <select id = "coloryear" name="coloryear">
			<?php
				$sql = "SELECT year FROM colorcodes WHERE active = 1";
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value = \"" . $row["year"] ."\">" . $row["year"] . "</option>";
					}
				} else {
					echo "0 results";
				}
			?>
			</select>
		</div>
		<hr id="jshr">
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
