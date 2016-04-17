<!-- EXTERNAL SCRIPT CALLS -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->
<link href='css/editorg.css' rel='stylesheet' type='text/css'>

<?php
	include 'connect.php';
			
	$orgname = "";
	$orgtype = "";
	
	$sql = "SELECT organizationName, organizationTypeID FROM organization WHERE organizationID =" . floatval($_SESSION['searchedorg']);
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$orgname = $row['organizationName'];
			$orgtype = $row['organizationTypeID'];
		}
	} else {
		echo floatval($_SESSION['searchedorg']);
		echo "0 results";
	}
?>

<form action = "orgedit.php" method = "POST">
	<div id = "newcontactpersondiv">
		<div id = "oheader"> Edit Organization - <?php echo $orgname;?> <input type="submit" class = "enter"></input> </div>
		<?php
			if(isset($_GET["success"])){
				echo "<div id = \"success\"> Successfully edited Organization </div>";
			}
			if(isset($_GET["cpersondup"])){
				echo "<div id = 'cpersondup'> Organization already exists </div>";
			}
		?>
		<hr id="jshr">
		<div id = "inputdiv">
			<?php
				if(isset($_GET["fail"])){
					echo "<div id = \"error\"> Organization with the same name already exists. </div>";
				}
				if(isset($_GET["orglength"])){
					echo "<div id = \"error\"> Organization Name field must not be empty </div>";
				}
				if(isset($_GET["orgname"])){
					echo "<div id='orgnamediv'> Organization Name: <input type = 'text' id = 'orgname' name = 'orgname' value = '" . $_GET['orgname'] . "'></input></div>";
				}else{
					echo "<div id='orgnamediv'> Organization Name: <input type = 'text' id = 'orgname' name = 'orgname' value = '" . $orgname . "'></input></div>";
				}
			?>
			
			<div id="orgtypediv"> Organization Type:
				<select id = "orgtype" name = "orgtype">
					<?php
						include 'connect.php';
						
						$sql = "SELECT organizationTypeID, organizationTypeName from organizationtype";
						$result = mysqli_query($conn, $sql);
						if (mysqli_num_rows($result) > 0) {
							// output data of each row
							while($row = mysqli_fetch_assoc($result)) {
								if($row['organizationTypeID'] === $orgtype){
									echo "<option value = \"" . $row['organizationTypeID'] . "\" selected>" . $row['organizationTypeName'] . "</option>";
								}else{
									echo "<option value = \"" . $row['organizationTypeID'] . "\">" . $row['organizationTypeName'] . "</option>";
								}
							}
						} else {
							echo "0 results";
						}
					?>
				</select>
			</div>
		</div>
		<hr id="jshr">
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
