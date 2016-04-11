<!-- EXTERNAL SCRIPT CALLS -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->
<link href='css/accsettings.css' rel='stylesheet' type='text/css'>

<?php
	$email = "";
	$userid = $_SESSION['username'];
	
	$sqltwo = "SELECT email FROM denr WHERE denrID = \"" . $userid . "\"";
	$resulttwo = mysqli_query($conn, $sqltwo);
							
	if (mysqli_num_rows($resulttwo) > 0) {
		// output data of each row
		while($rowtwo = mysqli_fetch_assoc($resulttwo)) {
			//stores captured name from query onto local variable
			$email = $rowtwo['email'];
		}
	} else {
		//do nothing
	}
?>

<div id = "accsetdiv">
	<div id = "asheader"> Account Settings </div>
	<hr id="jshr">
	<div id = "settings">
		<div id="email"> Email Address: <?php echo $email;?> <button id = "cemail" class = "button" onclick = "changeEmail()"> Change E-mail Address </button> </div>
		<div id="pw"> Password: <button id = "cpass" class = "button"> Change Password </button> </div>
	</div>
</div>

<div id="emailmodal" class="emailmodal">

  <!-- Modal content -->
  <div class="e-modal-content">
    <span class="close">x</span>
    <div id="cemailadd">
		<div id = "cemheader"> Change E-mail Address </div>
		<hr id="jshr">
		<div id = "currentemail"> E-mail Address: <?php echo $email;?> </div>
		<div id = "newemail"> New E-mail Address: <input type = "text" id = "newea"> </input> </div>
		<button class = "change"> Change </button>
	</div>
  </div>

</div>

<script>
	function changeEmail(){
		// Get the modal
		var modal = document.getElementById('emailmodal');

				// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];
				
		modal.style.display = "block";

				// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
			modal.style.display = "none";
		}
				
				
		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
	}
	
	$('.change').on('click',function(){
		var newea = document.getElementById("newea").value;
		var userid = <?php echo $userid;?>;
		$.ajax({
			url: "updateem.php",
			type: "POST",
			data: {userid:userid, newea:newea}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hacc.php?changeemail=success";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});
	});
</script>