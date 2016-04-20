<link href='css/validation.css' rel='stylesheet' type='text/css'>

<div id = "validationdiv">
	<form id="validationForm"class="form-horizontal" method="POST" action="submitSeedling.php">
	<div id = "vdheader"> New Seedling Validation <input type="submit" class="btn btn-success enter" id="submitValidation"><span id="submitMessage"></span></input></div>
	<?php
	if(isset($_GET['message'])){
		if($_GET['message']=="submitDone"){
			echo "<div id='success'>Successfully created new Seedling Validation</div>";
		}
	}
	?>

	<span id="surveyorMessage"></span> 
	<span id="inputByMessage"></span>
	<span id="areaMessage"></span>
	<span id="siteMessage"></span> 
	<span id="spfMessage"></span>
	<span id="qfMessage"></span>
	<hr id="jshr">
	<div id = "inputdiv">
		
			<div id = "startdatelabel"> Start Date: <input type="date" class="form-control" min="1979-12-31" max="2099-12-31" name="startDate" id="dateFrom" required> </div>
			<div id = "enddatelabel"> End Date: <input type="date" class="form-control" min="1979-12-31" max="2099-12-31" name="endDate" id="dateTo"/> </div>
			<div id = "surveyorlabel"> Surveyor ID: <input type="text" class="form-control" name="surveyor" id="surveyor" maxlength="40" required> </div>
			<div id = "inputbylabel"> Input By: <input type="text" class="form-control" name="inputBy" id="inputBy" maxlength="40" required> </div>
			<div id = "areavalidatedlabel"> Area Validated: <input type="text" class="form-control" name="area" id="area" maxlength="40" required> </div>
			<div id = "sitecodelabel"> Site Code: <input type="text" class="form-control" name="siteCode" id="siteCode" maxlength="40" required> </div>
			<div id = "ptableholder"> Current Plantation
				<button type="button" id="addRowButton">+ Add Row</button>
				<table class="table table-striped" id="plantationTable">
					<thead>
						<tr>
							<th id = "spid">Species</th>
							<th id = "qid">Quantity</th>
						
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
	</div>
	
	
	<hr id="jshr">
	</form>
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
	
	$(function() {
		$( "#siteCode" ).autocomplete({
			source: 'autocompletesite.php'
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
			
		}else if(spf==""){
			$("#spfMessage").html('<font color="red"><br>Species: Required!</font>');
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
			$('#removeRow').closest('tr').remove();
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

    speciesName.innerHTML = "<input type=text name=species[] id = 'spf'></input>";
    quantity.innerHTML = "<input type=text name=quantity[] id = 'qf'></input>";
    button.innerHTML = "<button type=button id=removeRow>Remove</button>";
	
	}
	
</script>