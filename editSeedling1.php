<?php
	include "connect.php";
	
	if(isset($_POST['siteCode'])){
		$_SESSION['siteCode']=$_POST['siteCode'];
	}

	$siteCode = $_SESSION['siteCode'];

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "ipuno";

	$validationID = "";
	$startDate = "";
	$endDate = "";
	$surveyor = "";
	$siteCode1 = "";
	$areaValidated = "";
	$inputBy = "";	

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$query = "SELECT * FROM validation WHERE siteCode = ? Order by startDate desc LIMIT 1 ";

	$stmt = mysqli_prepare($conn, $query);
	mysqli_stmt_bind_param($stmt, "s", $siteCode);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $a, $b, $c, $d, $e , $f, $g);
	while(mysqli_stmt_fetch($stmt)) {			

				$validationID = $a;
				$startDate = $b;
				$endDate = $c;
				$surveyor = $d;
				$siteCode1 = $e;
				$areaValidated = $f;
				$inputBy = $g;		
	}


	$boom = explode(" ", $startDate);
	$startDate1 = $boom[0];
	$startDate2 = date($startDate1);
	$_SESSION['recentStartDate'] = $startDate2;


	$boom = explode(" ", $endDate);
	$endDate1 = $boom[0];
	$endDate2 = date($endDate1);
	$_SESSION['recentEndDate'] = $endDate2;

	$_SESSION['validationID'] = $validationID;



?>

<link href='css/validation.css' rel='stylesheet' type='text/css'>
<span id="surveyorMessage"></span> 
<span id="inputByMessage"></span>
<span id="areaMessage"></span>
<span id="siteMessage"></span>

<form class="form-horizontal" method="POST" action="editSeedling2.php"> 
<div id = "validationdiv">
	<div id = "vdheader"> Edit Seedling Validation <input type="submit" class="btn btn-success enter"></input></div>
	<hr id="jshr">
	<div id = "inputdiv">
			<?php print("<div id = 'startdatelabel'> Start Date: <input type='date' class='form-control' name='startDate' id='dateFrom' value='$startDate2'> </div>")?>
			<?php print("<div id = 'enddatelabel'> End Date: <input type='date' class='form-control' name='endDate' id='dateTo' value='$endDate2'/> </div>")?>
			<?php print("<div id = 'surveyorlabel'> Surveyor: <input type='text' class='form-control' name='surveyor' maxlength='40' id='surveyor' value='$surveyor'> </div>")?>
			<?php print("<div id = 'inputbylabel'> Input By: <input type='text' class='form-control' name='inputBy'  maxlength='40' id='inputBy' value='$inputBy'> </div>")?>
			<?php print("<div id = 'areavalidatedlabel'> Area Validated: <input type='text' class='form-control' name='area' maxlength='40' id='area' value='$areaValidated'> </div>")?>
			<?php print("<div id = 'sitecodelabel'> Site Code: <input type='text' class='form-control' name='siteCode' maxlength='40' id='siteCode' value='$siteCode' readonly> </div>")?>
			<?php print("<div id = 'ptableholder'> Current Plantation");?>
				<button type="button" id="addRowButton">+ Add Row</button>
				<button type="button" id="removeRowButton">- Remove Row </button>
				<table class="table table-striped" id="plantationTable">
					<thead>
						<tr>
							<th id = "spid">Species</th>
							<th id = "qid">Quantity</th>
						
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="text" name="species[]" id = 'spf' class = 'spf'></input> </td>
							<td><input type="text" name="quantity[]" id = 'qf'></input> </td>
				
						<tr>
						<tr>
							<td><input type="text" name="species[]" id = 'spf' class = 'spf'></input> </td>
							<td><input type="text" name="quantity[]" id = 'qf'></input> </td>
				
						<tr>
					</tbody>
				</table>
			</div>
	</div>
	
	</form>
	<hr id="jshr">
	
</div>                                                                                  
  
</div>
</div>

<script type="text/javascript">
	var error1=0;
	var error2=0;
	var error3=0;
	var error4=0;
	var error5=0;
	var error6=0;
	$(document).ready(function() {
		$(window).keydown(function(event){
			if(event.keyCode == 13) {
				event.preventDefault();
				return false;
			}
		});
	});
	$("#surveyor").blur(function(event){
		
		var surveyorId = $("#surveyor").val().trim();
		var numReg = /^[0-9]*$/;
		if(!numReg.test(surveyorId)){
			$("#surveyorMessage").html('<font color="red">Surveyor ID: You entered an invalid id.</font>');
			error1=1;
		}else if(surveyorId==""){
			$("#surveyorMessage").html('<font color="red">Surveyor ID: Required!<br></font>');
			error1=1;
			return;
		}else{
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			}
			
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					$("#surveyorMessage").html(xmlhttp.responseText);
				}
			};

			xmlhttp.open("GET","checkSurveyorID.php?id="+surveyorId,true);
			xmlhttp.send();
			error1=0;
		}
		
		if($("#surveyorMessage").html().indexOf("exist")>=0){
			error1=1;
		}
		



	});

	$("#inputBy").blur(function(event){
		
		var inputBy = $("#inputBy").val().trim();
		var numReg = /^[0-9]*$/;
		if(!numReg.test(inputBy)){
			$("#inputByMessage").html('<font color="red">Input by: You entered an invalid id.</font>');
			error2=1;
		}else if(inputBy==""){
			$("#inputByMessage").html('<font color="red">Input by: Required!<br></font>');
			error2=1;
			return;
		}else{
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			}
			
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					$("#inputByMessage").html(xmlhttp.responseText);
				}
			};

			xmlhttp.open("GET","checkInputBy.php?id="+inputBy,true);
			xmlhttp.send();
			if($("#inputByMessage").html().indexOf("exist")>=0){
				error2=1;
			}else{
				error2=0;
			}
		}
		
		


	});

	$("#area").blur(function(event){
		
		var area = $("#area").val().trim();
		var floatReg = /^[0-9\.]*$/;
		if(!floatReg.test(area)){
			$("#areaMessage").html('<font color="red">Area validated must be a valid number.<br></font>');
			error3=1;
			
		}else if(area==""){
			$("#areaMessage").html('<font color="red">Area Validated: Required!<br></font>');
			error3=1;
		}else{
			$("#areaMessage").empty();
			error3=0;
		}
		

	});




	
	$("#siteCode").blur(function (event){
		var id = document.getElementById("siteCode").value;
		
		var siteCodeFormat = /^\d{2}-?\d{6}-?\d{4}-?\d{4}$/;
		
		if(id ==""){
			$("#siteMessage").html('<font color="red">Site Code: Required!</font>')
			error4=1;
			return;
		}else if(!siteCodeFormat.test(id)){
			$("#siteMessage").html('<font color="red">Site code invalid format! Follow e.g 12-123456-1234-1234</font>');
			error4=1;
		}else{
			if (window.XMLHttpRequest) {
				xmlhttp2 = new XMLHttpRequest();
			}
			
			xmlhttp2.onreadystatechange = function() {
				if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
					document.getElementById("siteMessage").innerHTML=xmlhttp2.responseText;
				}
			};

			xmlhttp2.open("GET","checkSiteCode.php?id="+id,true);
			xmlhttp2.send();
			
			if($("#siteMessage").html().indexOf("exist")>=0){
				error4=1;
			}else{
				error4=0;
			}
			
		} 
		if(error4==0){
		if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			}
			
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("plantationTable").innerHTML=xmlhttp.responseText;
				}
			};

			xmlhttp.open("GET","getSeedling.php?id="+id,true);
			xmlhttp.send();
		}
		else{
			return;
		}
		
	});  
	$("#spf").blur(function(event){
		
		var spf = $("#spf").val().trim();
		var spfReg = /^[A-Za-z\s]*$/;
		if(!spfReg.test(spf)){
			$("#spfMessage").html('<font color="red"><br>Species: Only letters of the alphabet are allowed.</font>');
			error5=1;
			
		}else{
			$("#spfMessage").html('');
			error5=0;
		}
		

	});	
	$("#qf").blur(function(event){
		
		var qf = $("#qf").val().trim();
		var qfReg = /^[0-9\.]*$/;
		if(!qfReg.test(qf)){
			$("#qfMessage").html('<font color="red"><br>Quantity: Only numbers are allowed.</font>');
			error6=1;
			
		}else{
			$("#qfMessage").html('');
			error6=0;
		}
		

	});


	$("#submitButton").click(function(event){
			if(error1 || error2 || error3 || error4 || error5 || error6 >0){
			$("#submitMessage").html('<font color="red">Please fill up the form properly before submitting</font>');
			event.preventDefault();
			
			}else{
				$("#submitMessage").html("");
				$("#validationForm").submit();
			}
		});
	$("#validationForm").on("click","#removeRow", function(){
			$(this).closest('tr').remove();
	});
	
	$("#validationForm").on("focus","#spf", function(){
		autocompletetest();
	});
</script>

<script type="text/javascript">
  document.getElementById("addRowButton").addEventListener("click", addrow);
  var counter = 1;
  function addrow(){
    var tableRef = document.getElementById('plantationTable').getElementsByTagName('tbody')[0];
    var newRow   = tableRef.insertRow(tableRef.rows.length);
    var speciesName = newRow.insertCell(0);
    var quantity = newRow.insertCell(1);
    var button = newRow.insertCell(2);

    speciesName.innerHTML = "<input type=text name=species[] id = 'spf' maxlength=40 required class = 'spf'></input>";
    quantity.innerHTML = "<input type=text name=quantity[] id = 'qf'></input>";
    button.innerHTML = "<button type=button id=removeRow>Remove</button>";
	
	}
	
	function autocompletetest(){
		$(function() {
			$( ".spf" ).autocomplete({
				source: 'autocompletespecies.php'
			});
		});
	}
	
		$(function() {
			$( ".spf" ).autocomplete({
				source: 'autocompletespecies.php'
			});
		});
</script>