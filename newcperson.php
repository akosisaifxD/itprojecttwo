<!-- EXTERNAL SCRIPT CALLS -->

<script src="js/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->
<link href='css/newcperson.css' rel='stylesheet' type='text/css'>

<form action = "cpersonentry.php" method = "POST">
	<div id = "newcontactpersondiv">
		<div id = "cpheader"> New Contact Person <input type="submit" class = "enter bypassChanges"></input> </div>
		<?php
			if(isset($_GET["success"])){
				echo "<div id = \"success\"> Successfully added new Contact Person </div>";
			}
			if(isset($_GET["cpersondup"])){
				echo "<div id = 'cpersondup'> Contact Person already exists </div>";
			}
			if(isset($_GET["fnamelength"])){
				echo "<div id = \"error\"> First name field must not be empty </div>";
			}
			if(isset($_GET["fnamedig"])){
				echo "<div id = \"error\"> First name must only contain characters </div>";
			}
			if(isset($_GET["lnamelength"])){
				echo "<div id = \"error\"> Last name field must not be empty </div>";
			}
			if(isset($_GET["moblength"])){
				echo "<div id = \"error\"> Mobile number field must not be empty </div>";
			}
			if(isset($_GET["mobcontchar"])){
				echo "<div id = \"error\"> Only numeric digits are allowed for mobile number </div>";
			}
			if(isset($_GET["tellength"])){
				echo "<div id = \"error\"> Telephone number field must not be empty </div>";
			}
			if(isset($_GET["telcontchar"])){
				echo "<div id = \"error\"> Only numeric digits are allowed for telephone number </div>";
			}
			if(isset($_GET["emaill"])){
				echo "<div id = \"error\"> Please enter an email address. </div>";
			}
			if(isset($_GET["emailf"])){
				echo "<div id = \"error\"> You have entered an invalid email address. Please try another one </div>";
			}
			if(isset($_GET["addl"])){
				echo "<div id = \"error\"> Address field must not be empty </div>";
			}
		?>
		<hr id="jshr">
		<div id = "inputdiv" class = "alertChanges">
			<?php
				if(isset($_GET["fname"])){
					echo "<div id = 'firstnamediv'> First Name: <input type = 'text' id = 'firstname' name = 'firstname' value = '" . $_GET['fname'] . "' maxlength='50'></input></div>";
				}else{
					echo "<div id = 'firstnamediv'> First Name: <input type = 'text' id = 'firstname' name = 'firstname' maxlength='50'></input></div>";
				}
			
				if(isset($_GET["lname"])){
					echo "<div id = 'lastnamediv'> Last Name: <input type = 'text' id = 'lastname' name = 'lastname' value = '" . $_GET['lname'] . "' maxlength='50'></input></div>";
				}else{
					echo "<div id = 'lastnamediv'> Last Name: <input type = 'text' id = 'lastname' name = 'lastname' maxlength='50'></input></div>";
				}
		
				if(isset($_GET["mobnum"])){
					echo "<div id = 'mobnumdiv'> Mobile Number: <input type = 'text' id = 'mobnum' name = 'mobnum' value = '" . $_GET['mobnum'] . "' maxlength='40'></input></div>";
				}else{
					echo "<div id = 'mobnumdiv'> Mobile Number: <input type = 'text' id = 'mobnum' name = 'mobnum' maxlength='40'></input></div>";
				}
			
				if(isset($_GET["telnum"])){
					echo "<div id = 'telnumdiv'> Telephone Number: <input type = 'text' id = 'telnum' name = 'telnum' value = '" . $_GET['telnum'] . "' maxlength='40'></input></div>";
				}else{
					echo "<div id = 'telnumdiv'> Telephone Number: <input type = 'text' id = 'telnum' name = 'telnum' maxlength='40'></input></div>";
				}
			
				if(isset($_GET["email"])){
					echo "<div id = 'emaildiv'> Email Address: <input type = 'text' id = 'email' name = 'email' value = '" . $_GET['email'] . "' maxlength='40'></input> </div>";
				}else{
					echo "<div id = 'emaildiv'> Email Address: <input type = 'text' id = 'email' name = 'email' maxlength='40'></input> </div>";
				}
				
				if(isset($_GET["address"])){
					echo "<div id = 'addressdiv'> Address: <input type = 'text' id = 'address' name = 'address' value = '" . $_GET['address'] . "' maxlength='200'></input> </div>";
				}else{
					echo "<div id = 'addressdiv'> Address: <input type = 'text' id = 'address' name = 'address' maxlength='200'></input> </div>";
				}
			?>
			
			<hr id="jshr">
		</div>
		
	</div>
</form>

<script>
	/*
	var error = 0;

	$('.enter').on('click',function(){
		error = 0;
		var checker = 0;
		
		var re = /^[A-Za-z]+$/;
		var rem = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		
		var fnamelength = false;
		var fnamehasdigit = false;
		
		var lnamelength = false;
		var lnamehasdigit = false;
		
		var mobnumcont = false;
		var mobnumlength = false;
		
		var telnumcont = false;
		var telnumlength = false;
		
		var emailcont = false;
		var emaillength = false;
		
		var addresslength = false;
		
		var firstname = document.getElementById("firstname").value;
		if(firstname.replace(/ /g,'').length == 0){
			checker = 1;
		}
		if(firstname.replace(/ /g,'').length > 50){
			fnamelength = true;
		}else{
			fnamelength = false;
		}
		if(firstname.replace(/ /g,'').length !== 0){
			if(re.test(document.getElementById("firstname").value)){
				fnamehasdigit = false;
			} else{
				fnamehasdigit = true;
			}

		}
		
		var lastname = document.getElementById("lastname").value;
		if(lastname.replace(/ /g,'').length == 0){
			checker = 1;
		}
		if(lastname.replace(/ /g,'').length > 50){
			lnamelength = true;
		}else{
			lnamelength = false;
		}
		if(lastname.replace(/ /g,'').length !== 0){
			if(re.test(document.getElementById("lastname").value)){
				lnamehasdigit = false;
			} else{
				lnamehasdigit = true;
			}

		}
		
		var name = firstname + " " + lastname;
		
		var mobnum = document.getElementById("mobnum").value;
		if(mobnum.replace(/ /g,'').length == 0){
			checker = 1;
		}
		if(mobnum.replace(/ /g,'').length > 0){
			var mobnumisnum = /^\d+$/.test(mobnum);
			if(mobnumisnum === false){
				mobnumcont = true;
			}else{
				mobnumcont = false;
			}
		}
		if(mobnum.replace(/ /g,'').length !== 11){
			mobnumlength = true;
		}else{
			mobnumlength = false;
		}
		
		
		var telnum = document.getElementById("telnum").value;
		if(telnum.replace(/ /g,'').length == 0){
			checker = 1;
		}
		if(telnum.replace(/ /g,'').length > 0){
			var telnumisnum = /^\d+$/.test(telnum);
			if(telnumisnum === false){
				telnumcont = true;
			}else{
				telnumcont = false;
			}
		}
		if(telnum.replace(/ /g,'').length !== 7){
			telnumlength = true;
		}else{
			telnumlength = false;
		}
		
		var email = document.getElementById("email").value;
		if(email.replace(/ /g,'').length == 0){
			checker = 1;
		}
		if(email.replace(/ /g,'').length > 0){
			var emailisvalid = rem.test(email);
			if(emailisvalid === false){
				emailcont = true;
			}else{
				emailcont = false;
			}
		}
		if(email.replace(/ /g,'').length > 100){
			emaillength = true;
		}else{
			emaillength = false;
		}
		
		var address = document.getElementById("address").value;
		if(address.replace(/ /g,'').length == 0){
			checker = 1;
		}
		if(address.replace(/ /g,'').length > 200){
			addresslength = true;
		}else{
			addresslength = false;
		}
		
		if(fnamehasdigit === true){
			alert("Numeric values are not allowed in first names.");
		}
		if(fnamelength === true){
			alert("Only 50 characters are allowed in first names.");
		}
		if(fnamelength === true || fnamehasdigit === true){
			error = 1;
			var firstnamefix = document.getElementById('firstname');
			firstnamefix.className = "errorfield";
		}else{
			var firstnamefix = document.getElementById('firstname');
			firstnamefix.className = "";
		}
		
		if(lnamehasdigit === true){
			alert("Numeric values are not allowed in last names.");
		}
		if(lnamelength === true){
			alert("Only 50 characters are allowed in last names.");
		}
		if(lnamelength === true || lnamehasdigit === true){
			error = 1;
			var lastnamefix = document.getElementById('lastname');
			lastnamefix.className = "errorfield";
		}else{
			var lastnamefix = document.getElementById('lastname');
			lastnamefix.className = "";
		}
		
		if(mobnumcont === true){
			alert("Mobile number must only contain numeric digits.");
		}
		if(mobnumlength === true){
			alert("Mobile number must contain 11 digits.");
		}
		if(mobnumcont === true || mobnumlength === true){
			error = 1;
			var mobnumfix = document.getElementById('mobnum');
			mobnumfix.className = "errorfield";
		}else{
			var mobnumfix = document.getElementById('mobnum');
			mobnumfix.className = "";
		}
		
		if(telnumcont === true){
			alert("Telephone number must only contain numeric digits.");
		}
		if(telnumlength === true){
			alert("Telephone number must contain 7 digits.");
		}
		if(telnumcont === true || telnumlength === true){
			error = 1;
			var telnumfix = document.getElementById('telnum');
			telnumfix.className = "errorfield";
		}else{
			var telnumfix = document.getElementById('telnum');
			telnumfix.className = "";
		}
		
		if(emailcont === true){
			alert("Not a valid e-mail address format.");
		}
		if(emaillength === true){
			alert("E-mail must not be more than 100 characters.");
		}
		if(emailcont === true || emaillength === true){
			error = 1;
			var emailfix = document.getElementById('email');
			emailfix.className = "errorfield";
		}else{
			var emailfix = document.getElementById('email');
			emailfix.className = "";
		}
		
		if(addresslength === true){
			alert("E-mail must not be more than 200 characters.");
		}
		if(addresslength === true){
			error = 1;
			var addfix = document.getElementById('address');
			addfix.className = "errorfield";
		}else{
			var addfix = document.getElementById('address');
			addfix.className = "";
		}
		
		
		if(checker == 1){
			error = 1;
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
	
	function validateMyForm(){
		if(error === 0){
			alert("HOOZAH");
			return true;
		}else{
			return false;
		}
	}
	*/
</script>
