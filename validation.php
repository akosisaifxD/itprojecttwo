<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<link href='css/validation.css' rel='stylesheet' type='text/css'>

<div id = "validationdiv">
	<div id = "vdheader"> New Site Validation </div>
	<hr id="jshr">
	<div id = "inputdiv">
		<form class="form-horizontal" method="POST" action="submitValidation.php">
			<div id = "startdatelabel"> Start Date: <input type="date" class="form-control" name="startDate" id="dateFrom" value=<?php echo date('2015-12-01')?> required> </div>
			<div id = "enddatelabel"> End Date: <input type="date" class="form-control" name="endDate" id="dateTo"/> </div>
			<div id = "surveyorlabel"> Surveyor ID: <input type="text" class="form-control" name="surveyor" id="surveyor" required><span id="surveyorMessage"></span> </div>
			<div id = "inputbylabel"> Input By: <input type="text" class="form-control" name="inputBy" id="inputBy" required><span id="inputByMessage"></span> </div>
			<div id = "areavalidatedlabel"> Area Validated: <input type="text" class="form-control" name="area" id="area" required>ha <span id="areaMessage"></span></div>
			<div id = "sitecodelabel"> Site Code: <input type="text" class="form-control" name="siteCode" id="siteCode" required><span id="siteMessage"></span> </div>
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

			xmlhttp.open("GET","getSiteSpecies.php?id="+id,true);
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

    speciesName.innerHTML = "<input type=text name=species[] id = 'spf' required></input>";
    quantity.innerHTML = "<input type=text name=quantity[] id = 'qf'></input>";
    height.innerHTML = "<input type=text name=height[] id = 'hf'></input>";
    diameter.innerHTML = "<input type=text name=diameter[] id = 'df'></input>";
	
	}
	
</script>