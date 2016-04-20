<?php
	session_start();
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

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<link href='css/validation.css' rel='stylesheet' type='text/css'>

<div id = "validationdiv">
	<div id = "vdheader"> New Site Validation </div>
	<hr id="jshr">
	<div id = "inputdiv">
		<form class="form-horizontal" method="POST" action="editValidation2.php">
			<?php print ("<div id = 'startdatelabel'> Start Date: <input type='date' class='form-control' name='startDate' id='dateFrom' value= '$startDate2' required> </div>") ?>
			<?php print ("<div id = 'enddatelabel'> End Date: <input type='date' class='form-control' name='endDate' id='dateTo' value= '$endDate2' /> </div>") ?>
			<?php print ("<div id = 'surveyorlabel'> Surveyor ID: <input type='text' class='form-control' name='surveyor' id='surveyor' value= '$surveyor' required><span id='surveyorMessage'></span> </div>") ?>
			<?php print ("<div id = 'inputbylabel'> Input By: <input type='text' class='form-control' name='inputBy' id='inputBy' value='$inputBy' required><span id='inputByMessage'></span> </div>") ?>
			<?php print ("<div id = 'areavalidatedlabel'> Area Validated: <input type='text' class='form-control' name='area' id='area' value= '$areaValidated' required>ha <span id='areaMessage'></span></div>") ?>
			<?php print ("<div id = 'sitecodelabel'> Site Code: <input type='text' class='form-control' name='siteCode' id='siteCode' value='$siteCode'  readonly><span id='siteMessage'></span> </div>") ?>
			<div id = "ptableholder"> Current Plantation
				<button type="button" id="addRowButton">+ Add Row</button>
				<table class="table table-striped" id="plantationTable">
					<thead>
						<tr>
							<th id = "spid">Species</th>
							<th id = "qid">Quantity</th>
							<th id = "hid">Height </th>
							<th id = "did">Diameter</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="text" name="species[]" id = "spf" required></input> </td>
							<td><input type="text" name="quantity[]" id = "qf"></input> </td>
							<td><input type="text" name="height[]" id = "hf"></input> </td>
							<td><input type="text" name="diameter[]" id = "df"></input> </td>
						<tr>
					</tbody>
				</table>
			</div>
			<div id = "uploadframe"> Upload Images <input type="file" name="imageupload[]" id="imageupload" multiple> </div>
			<input type="submit" class="enter"></input>
	</div>
	
	</form>
	<hr id="jshr">
	
</div>                                                                                  
  
</div>
</div>

<script type="text/javascript">
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
			$("#surveyorMessage").html('<font color="red">Please enter a valid id</font>');
		}else if(surveyorId==""){
			$("#surveyorMessage").html('<font color="red">REQUIRED*');
			return;
		}else{
			$("#surveyorMessage").html('<font color="green">&#10004');
		}
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



	});
	

	$("#inputBy").blur(function(event){
		
		var inputBy = $("#inputBy").val().trim();
		var numReg = /^[0-9]*$/;
		if(!numReg.test(inputBy)){
			$("#inputByMessage").html('<font color="red">Please enter a valid id</font>');
		}else if(inputBy==""){
			$("#inputByMessage").html('<font color="red">REQUIRED*</font>');
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

			xmlhttp.open("GET","checkSurveyorID.php?id="+inputBy,true);
			xmlhttp.send();
		}
		


	});

	$("#area").blur(function(event){
		
		var area = $("#area").val().trim();
		var floatReg = /^[0-9\.]*$/;
		if(!floatReg.test(area)){
			$("#areaMessage").html('<font color="red">Please enter a valid id</font>');
		}else if(area==""){
			$("#areaMessage").html('<font color="red">REQUIRED*</font>');
		}else{
			$("#areaMessage").html('<font color="green">&#10004</font>');
		}
		

	});




	
	$("#siteCode").blur(function (event){
		var id = document.getElementById("siteCode").value;
		
		if(id ==""){
			$("#siteMessage").html('<font color="red">REQUIRED*</font>')
			return;
		}else{
			
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			}
			
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("plantationTable").innerHTML=xmlhttp.responseText;
				}
			};

			xmlhttp.open("GET","editValidation3.php?id="+id,true);
			xmlhttp.send();
			
		} 
		
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
    var height  = newRow.insertCell(2);
    var diameter  = newRow.insertCell(3);

    speciesName.innerHTML = "<input type=text name=species1[] id = 'spf' required></input>";
    quantity.innerHTML = "<input type=text name=quantity1[] id = 'qf'></input>";
    height.innerHTML = "<input type=text name=height1[] id = 'hf'></input>";
    diameter.innerHTML = "<input type=text name=diameter1[] id = 'df'></input>";
	
	}
	
</script>