<!-- EXTERNAL SCRIPT CALLS -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->

<div id = "newcontactpersondiv">
	<div id = "header"> Add New Contact Person </div>
	<div id = "inputdiv"> 
		<div id = "fullnamediv"> Full Name: <input type = "text" id = "fullname"></input> </div>
		<div id = "mobnumdiv"> Mobile Number: <input type = "text" id = "mobnum"></input> </div>
		<div id = "telnumdiv"> Telephone Number: <input type = "text" id = "telnum"></input> </div>
		<div id = "emaildiv"> Email Address: <input type = "text" id = "email"></input> </div>
		<div id = "addressdiv"> Address: <input type = "text" id = "address"></input> </div>
		<div id = "submit"> <button class = "enter"> Submit </button> </div>
	</div>
</div>

<script>
	$('.enter').on('click',function(){
		var name = document.getElementById("fullname").value;
		var mobnum = document.getElementById("mobnum").value;
		var telnum = document.getElementById("telnum").value;
		var email = document.getElementById("email").value;
		var address = document.getElementById("address").value;
		
		$.ajax({
			url: "cpersonentry.php",
			type: "POST",
			data: {name:name, mobnum:mobnum, telnum:telnum, email:email, address:address}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="newcperson.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});
	});
</script>
