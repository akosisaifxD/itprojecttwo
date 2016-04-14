<!-- EXTERNAL SCRIPT CALLS -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->
<link href='css/neworg.css' rel='stylesheet' type='text/css'>

<form action = "orgentry.php" method = "POST">
	<div id = "neworgdiv">
		<div id = "oheader"> New Organization <input type = "submit" class = "enter"></input> </div>
		<?php
			if(isset($_GET["success"])){
				echo "<div id = \"success\"> Successfully added new Organization </div>";
			}
			if(isset($_GET["fail"])){
				echo "<div id = \"error\"> Organization with the same name already exists. </div>";
			}
		?>
		<hr id="jshr">
		<div id = "inputdiv">
			<div id="orgnamediv"> Organization Name: <input type = "text" id = "orgname" name = "orgname"></input></div>
			<div id="orgtypediv"> Organization Type:
				<select id = "orgtype" name = "orgtype">
					<?php
						include 'connect.php';
						
						$sql = "SELECT organizationTypeID, organizationTypeName from organizationtype";
						$result = mysqli_query($conn, $sql);
						if (mysqli_num_rows($result) > 0) {
							// output data of each row
							while($row = mysqli_fetch_assoc($result)) {
								echo "<option value = \"" . $row['organizationTypeID'] . "\">" . $row['organizationTypeName'] . "</option>";
							}
						} else {
							echo "0 results";
						}
					?>
				</select>
			</div>
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
