<link href='css/removeccode.css' rel='stylesheet' type='text/css'>

<?php
	include 'connect.php';
?>

<form action = "heccode.php" method = "POST">
	<div id = "neworgdiv">
		<div id = "oheader"> Edit Color Code <input type = "submit" class = "enter"></input> </div>
		<hr id="jshr">
		<div id = "inputdiv">
			Year: <select id = "yearcolor" name = "yearcolor">
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
