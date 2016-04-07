<!-- EXTERNAL SCRIPT CALLS -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->
<link href='css/newcperson.css' rel='stylesheet' type='text/css'>

<div id = "newcontactpersondiv">
	<div id = "cpheader"> New Contact Person <button class = "enter"> Submit </button> </div>
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
		var firstname = document.getElementById("firstname").value;
		var lastname = document.getElementById("lastname").value;
		var name = firstname + " " + lastname;
		var mobnum = document.getElementById("mobnum").value;
		var telnum = document.getElementById("telnum").value;
		var email = document.getElementById("email").value;
		var address = document.getElementById("address").value;
		
		$.ajax({
			url: "cpersonentry.php",
			type: "POST",
			data: {name:name, mobnum:mobnum, telnum:telnum, email:email, address:address}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hcperson.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});
	});
</script>
