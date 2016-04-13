<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<link href='css/validation.css' rel='stylesheet' type='text/css'>

<div id = "validationdiv">
	<div id = "vdheader"> New Seedling Validation </div>
	<hr id="jshr">
	<div id = "inputdiv">
		<form class="form-horizontal" method="POST" action="submitSeedling.php">
			<div id = "startdatelabel"> Start Date: <input type="date" class="form-control" name="startDate" id="dateFrom"> </div>
			<div id = "enddatelabel"> End Date: <input type="date" class="form-control" name="endDate" id="dateTo"/> </div>
			<div id = "surveyorlabel"> Surveyor: <input type="text" class="form-control" name="surveyor" id="surveyor"> </div>
			<div id = "inputbylabel"> Input By: <input type="text" class="form-control" name="inputBy" id="inputBy"> </div>
			<div id = "areavalidatedlabel"> Area Validated: <input type="text" class="form-control" name="area" id="area"> </div>
			<div id = "sitecodelabel"> Site Code: <input type="text" class="form-control" name="siteCode" id="siteCode"> </div>
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
						<tr>
							<td><input type="text" name="species[]"></input> </td>
							<td><input type="text" name="quantity[]" ></input> </td>
				
						<tr>
						<tr>
							<td><input type="text" name="species[]"></input> </td>
							<td><input type="text" name="quantity[]" ></input> </td>
				
						<tr>
					</tbody>
				</table>
			</div>
			<input type="submit" class="btn btn-success"></input>
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
	
	$("#siteCode").blur(function (event){
		var id = document.getElementById("siteCode").value;
		
		if(id ==""){
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

			xmlhttp.open("GET","getSeedling.php?id="+id,true);
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

    speciesName.innerHTML = "<input type=text name=species[] id = 'spf'></input>";
    quantity.innerHTML = "<input type=text name=quantity[] id = 'qf'></input>";
	
	}
	
</script>