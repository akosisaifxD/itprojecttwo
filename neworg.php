<!-- EXTERNAL SCRIPT CALLS -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->

<div id = "neworgdiv">
	<div id = "header"> New Organization </div>
	<div id = "inputdiv">
		<div id="orgnamediv"> Organization Name <input type = "text" id = "orgname"></input></div>
		<div id="orgtypediv"> Organization Type
			<select id = "orgtype">
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
		<button class = "enter"> SUBMIT </button>
	</div>
</div>

<script>
	$('.enter').on('click',function(){
		var orgname = document.getElementById("orgname").value;
		var orgtype = document.getElementById("orgtype").value;
		
		$.ajax({
			url: "orgentry.php",
			type: "POST",
			data: {orgname:orgname, orgtype:orgtype}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="neworg.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});
	});
</script>
