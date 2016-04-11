<!-- EXTERNAL SCRIPT CALLS -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->
<link href='css/newcperson.css' rel='stylesheet' type='text/css'>

<div id = "newcontactpersondiv">
	<div id = "cpheader"> New Contact Person <button class = "enter"> Submit </button> </div>
	<?php
		if(isset($_GET["success"])){
			echo "<div id = \"success\"> Successfully added new Contact Person </div>";
		}
	?>
	<hr id="jshr">
	<div id = "inputdiv"> 
		<div id = "firstnamediv"> First Name: <input type = "text" id = "firstname"></input> </div>
		<div id = "lastnamediv"> Last Name: <input type = "text" id = "lastname"></input> </div>
		<div id = "mobnumdiv"> Mobile Number: <input type = "text" id = "mobnum"></input> </div>
		<div id = "telnumdiv"> Telephone Number: <input type = "text" id = "telnum"></input> </div>
		<div id = "emaildiv"> Email Address: <input type = "text" id = "email"></input> </div>
		<div id = "addressdiv"> Address: <input type = "text" id = "address"></input> </div>
	</div>
	<hr id="jshr">
</div>

<script>
	$('.enter').on('click',function(){
		var checker = 0;
		var firstname = document.getElementById("firstname").value;
		if(firstname.replace(/ /g,'').length == 0){
			checker = 1;
		}
		var lastname = document.getElementById("lastname").value;
		if(lastname.replace(/ /g,'').length == 0){
			checker = 1;
		}
		var name = firstname + " " + lastname;
		var mobnum = document.getElementById("mobnum").value;
		if(mobnum.replace(/ /g,'').length == 0){
			checker = 1;
		}
		var telnum = document.getElementById("telnum").value;
		if(telnum.replace(/ /g,'').length == 0){
			checker = 1;
		}
		var email = document.getElementById("email").value;
		if(email.replace(/ /g,'').length == 0){
			checker = 1;
		}
		var address = document.getElementById("address").value;
		if(address.replace(/ /g,'').length == 0){
			checker = 1;
		}
		
		if(checker == 1){
			alert("There are empty fields. please fill out the form completely.");
		}else{
			$.ajax({
				url: "cpersonentry.php",
				type: "POST",
				data: {name:name, mobnum:mobnum, telnum:telnum, email:email, address:address}, // add a flag
				success: function(data, textStatus, jqXHR){
					window.location="hcperson.php?success=true";
				},
				error: function (jqXHR, textStatus, errorThrown){
					alert('Error!')
				}
			});
		}
	});
</script>
