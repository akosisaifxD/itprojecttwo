<link href='css/esite.css' rel='stylesheet' type='text/css'>

<?php
	include 'connect.php';
	
	
	$sitecode = "";
	$year = "";
	$declaredarea = "";
	$contactpersonid = "";
	$zone = "";
	$component = "";
	
	$sql = "SELECT year, siteCode, declaredArea, contactPersonID, zone, component FROM site WHERE siteID ='" . $_SESSION['searchedsite'] . "'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$year = $row['year'];
			$sitecode = $row['siteCode'];
			$declaredarea = $row['declaredArea'];
			$contactpersonid = $row['contactPersonID'];
			$zone = $row['zone'];
			$component = $row['component'];
		}
	} else {
		echo "0 results";
	}
	
	$cpersonname = '';
	
	$sql = "SELECT IF(suffix != '', concat(firstName, ' ', lastName, ' ', suffix), concat(firstName, ' ', lastName)) as 'contactPersonName' FROM contactperson WHERE contactPersonID ='" . $contactpersonid . "'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$cpersonname = $row['contactPersonName'];
		}
	} else {
		echo "0 results";
	}
	
	$orgs = array();
	$ocount = 0;
	
	$sql = "SELECT organizationID FROM siteorganization WHERE siteCode ='" . $sitecode . "' AND active = 1";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$orgs[$ocount] = $row['organizationID'];
			$ocount++;
		}
	} else {
		echo "0 results";
	}
	
	$coordinateslng = array();
	$coordinateslat = array();
	$coocount = 0;
	
	$sql = "SELECT longitude, latitude FROM coordinates WHERE siteID ='" . $_SESSION['searchedsite'] . "'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$coordinateslng[$coocount] = $row['longitude'];
			$coordinateslat[$coocount] = $row['latitude'];
			$coocount++;
		}
	} else {
		echo "0 results";
	}
?>

<form action = "siteedit.php" method = "POST">
	<div id = "mainformdiv">
		<div id = "sheader"> Edit Site - <?php echo $sitecode;?> <input type="submit" class = "entert bypassChanges"></input> </div>
		<?php
			if(isset($_GET["success"])){
				echo "<div id = \"success\"> Successfully added new Organization </div>";
			}
			if(isset($_GET["decalength"])){
				echo "<div id = \"error\"> Declared area field must not be left empty </div>";
			}
			if(isset($_GET["deccont"])){
				echo "<div id = \"error\"> Declared area field must only contain digits </div>";
			}
			if(isset($_GET["cpersondne"])){
				echo "<div id = \"error\"> Contact person field must not be left empty </div>";
			}
			if(isset($_GET["cplength"])){
				echo "<div id = \"error\"> Contact person entered does not exist </div>";
			}
			if(isset($_GET["orgerr"])){
				echo "<div id = \"error\"> At least one organization must be chosen </div>";
			}
			if(isset($_GET["provlength"])){
				echo "<div id = \"error\"> A province must be chosen </div>";
			}
			if(isset($_GET["munilength"])){
				echo "<div id = \"error\"> A municipality must be chosen </div>";
			}
			if(isset($_GET["brgyerr"])){
				echo "<div id = \"error\"> At least one barangay must be chosen </div>";
			}
			if(isset($_GET["tableerr"])){
				echo "<div id = \"error\"> All rows in table must be filled up </div>";
			}
		?>
		<hr id="jshr">
		<div id = "inputdiv" class = "alertChanges">
		<!-- MAIN FORM -->
			<!-- YEAR INPUT -->
			<div class="yearlabel">Year
				<div class="inputdiv">
					<select class = "yearcontent" id = "yearval" name="year">
						<!-- PHP CODE -->
						<?php
							$currentyear = date("Y"); //Get Current Year
							
							// For-loop to input options into select from 2011 - current year
							for($i = 2011; $i <= $currentyear; $i++){
								if($year == $i){
									echo "<option value =\"" . $i . "\" selected>" . $i . "</option>";
								}else{
									echo "<option value =\"" . $i . "\">" . $i . "</option>";
								}
								
							}
						?>
					</select>
				</div>
			</div>
			<!-- END YEAR INPUT -->
			
			<!-- DECLARED AREA INPUT -->
			<div class="decareadiv">Declared Area
				<div class="inputdiv">
					<?php
						echo "<input type='text' id = 'decarea' name = 'decarea' value = '$declaredarea'></input> ha";
					?>
					
				</div>
			</div>
			<!-- END DECLARED AREA INPUT -->
			
			<!-- CONTACT PERSON INPUT -->
			<div class="cplabel">Contact Person
				<div class="inputdiv">
					<?php
						echo "<input id='cperson' type = 'text' name = 'cperson' value = '$cpersonname'></input>";
					?>
					
				</div>
			</div>
			<!-- END CONTACT PERSON INPUT -->
			
			<!-- ORGANIZATION INPUT -->
			<div class="orglabel">Organization
				<div class="inputdiv">
					<select class = "organizationcontent" multiple="multiple" id="orgid" name = "org[]">
					<!-- PHP CODE -->
						<?php
							$sql = "SELECT organizationID, organizationName FROM organization ORDER BY organizationName ASC";
							$result = mysqli_query($conn, $sql);

							if (mysqli_num_rows($result) > 0) {
								// output data of each row
								while($row = mysqli_fetch_assoc($result)) {
									if(in_array($row['organizationID'], $orgs)){
										echo "<option value =\"" . $row["organizationID"] . "\" selected>" . $row["organizationName"] . "</option>";
									}else{
										echo "<option value =\"" . $row["organizationID"] . "\">" . $row["organizationName"] . "</option>";
									}
								}
							} else {
								//do nothing
							}
						?>
					</select>
					<script type="text/javascript">
						$(document).ready(function() {
							$('#orgid').multiselect();
						});
					</script>
				</div>
			</div>
			<!-- END ORGANIZATION INPUT -->
			<br>

			<div class="zonelabel">Zone
				<div class="inputdiv">
					<select class = "zonecontent" id = "zonecontent" name = "zonec">
						<?php
							if($zone === "Protection"){
								echo "<option value= 'Protection' selected> Protection </option>";
							}else{
								echo "<option value= 'Protection'> Protection </option>";
							}
							
							if($zone === "Production"){
								echo "<option value= 'Production' selected> Production </option>";
							}else{
								echo "<option value= 'Production'> Production </option>";
							}
							
							if($zone === "Protection/Production"){
								echo "<option value= 'Protection/Production' selected> Protection/Production </option>";
							}else{
								echo "<option value= 'Protection/Production'> Protection/Production </option>";
							}
						?>

					</select>
				</div>
			</div>
			
			<!-- COORDINATE TABLE INPUT -->
			<div class = "tablelabel">
					<header class = "tableheader">Coordinates</header>
					<div id = "tablebuttons">
						<!--
						<button type = "button" class = "addbutton" onclick="addRow()"><i class="fa fa-plus-square"></i> Add Row </button>
						<button type = "button" class = "removebutton" onclick="removeRow()"><i class="fa fa-minus-square"></i> Remove Row </button>
						-->
						<button type = "button" class = "previewbutton" id="previewbutton" onclick="prevcoords()"> <i class="fa fa-eye"></i> Preview </button>
					</div>
						<table class="formactualtable" id="formactualtableid">
							<thead>
								<tr>
									<th>No.</th>
									<th>Longitude</th>
									<th>Latitude</th>
								</tr>
							</thead>
							<tbody>
								<?php
									
										for($i = 0; $i < (sizeof($coordinateslng) - 1); $i++){
											echo "<tr>";
											echo "<td>" . ($i + 1) . "</td>";
											echo "<td><input type = 'text' id = 'lng" . ($i + 1) . "' name = 'lng" . ($i + 1) . "' value = '" . $coordinateslng[$i] . "'></input></td>";
											echo "<td><input type = 'text' id = 'lat" . ($i + 1) . "' name = 'lat" . ($i + 1) . "' value = '" . $coordinateslat[$i] ."'></input></td>";
											echo "</tr>";
										}
									
								?>
							</tbody>
						</table>
			</div>
			<?php
				echo "<input type='hidden' id='numofrows' name='numofrows' value= '" . (sizeof($coordinateslng) - 1) . "'  />";
			?>
			
			<!-- END COORDINATE TABLE INPUT -->
			
			<div class="complabel">Component
				<div class="inputdiv">
					<select class = "compcontent" id = "compcontent" name = "compc">
						<?php
							if($component === "Agroforestry"){
								echo "<option value= 'Agroforestry' selected> Agroforestry </option>";
							}else{
								echo "<option value= 'Agroforestry'> Agroforestry </option>";
							}
							
							if($component === "Reforestation"){
								echo "<option value= 'Reforestation' selected> Reforestation </option>";
							}else{
								echo "<option value= 'Reforestation'> Reforestation </option>";
							}
							
							if($component === "Urban Greening"){
								echo "<option value= 'Urban Greening' selected> Urban Greening </option>";
							}else{
								echo "<option value= 'Urban Greening'> Urban Greening </option>";
							}
							
							if($component === "Agroforestry/Reforestation"){
								echo "<option value= 'Agroforestry/Reforestation' selected> Agroforestry/Reforestation </option>";
							}else{
								echo "<option value= 'Agroforestry/Reforestation'> Agroforestry/Reforestation </option>";
							}
							
							if($component === "Ornamental"){
								echo "<option value= 'Ornamental' selected> Ornamental </option>";
							}else{
								echo "<option value= 'Ornamental'> Ornamental </option>";
							}
							
							if($component === "Fuel Wood"){
								echo "<option value= 'Fuel Wood' selected> Fuel Wood </option>";
							}else{
								echo "<option value= 'Fuel Wood'> Fuel Wood </option>";
							}
							
							if($component === "Rattan"){
								echo "<option value= 'Rattan' selected> Rattan </option>";
							}else{
								echo "<option value= 'Rattan'> Rattan </option>";
							}
						?>
					</select>
				</div>
			</div>
		</div>
	<hr id="endjshr">
	</div>
</form>

<script>
	var map;
	var polygon;
	var polycheck = 0;
	
    function initMap() {
		var mapOptions = {
				zoom: 10,
				center: {
					lat: 16.52023885,
					lng: 120.8456877
                },
                mapTypeId: google.maps.MapTypeId.SATELLITE
		};
		map = new google.maps.Map(document.getElementById("map"),mapOptions);  
    }
	
	function prevcoords(){
		var checker = 0;
		var table = document.getElementById("formactualtableid"); //Call Coordinate Table
		var offnum = table.rows.length - 1;
		
		for(var i = 0; i < offnum; i++){
			var latelem = document.getElementById("lat" + (i + 1)).value.replace(/ /g,'');
			var lngelem = document.getElementById("lng" + (i + 1)).value.replace(/ /g,'');
			
			if(latelem.length == 0){
				checker = 1;
			}
			if(lngelem.length == 0){
				checker = 1;
			}
		}
		
		if(checker == 1){
			alert("All coordinates must be specified and must not have empty values");
		}else{
			// Get the modal
			var modal = document.getElementById('prevmodal');

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];
			
			modal.style.display = "block";

			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
				modal.style.display = "none";
			}
			
			
			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
				if (event.target == modal) {
					modal.style.display = "none";
				}
			}
			var polygonc = new google.maps.MVCArray();
			
			var flat;
			var flng;
			
			for(var i = 0; i < offnum; i++){
				var latelem = document.getElementById("lat" + (i + 1)).value;
				var lngelem = document.getElementById("lng" + (i + 1)).value;
				
				if(i === 0){
					flat = latelem;
					flng = lngelem;
				}
				
				var point = new google.maps.LatLng(parseFloat(latelem), parseFloat(lngelem));
				polygonc.insertAt(polygonc.length, point);
			}
			
			if(polycheck == 0){
				polycheck = 1;
			}else{
				polygon.setMap(null);
			}
			
			polygon = new google.maps.Polygon({
							paths: polygonc,
							strokeColor: 'yellow',
							strokeOpacity: 0.8,
							strokeWeight: 1,
							fillColor: 'yellow',
							fillOpacity: 0.7
			});
			
			polygon.setMap(map);
			
			google.maps.event.trigger(map, 'resize');
			map.setZoom(16);
			
			map.setCenter({lat:parseFloat(flat), lng:parseFloat(flng)});
		}
	}
	
	function removeRow(){
		var table = document.getElementById("formactualtableid"); //Call Coordinate Table
		var x = table.rows.length; //Take number of rows of Coordinate Table
		if(x > 4){
			var tnor = document.getElementById("numofrows");
			table.deleteRow(x - 1);
			tnor.value = parseFloat(tnor.value) - 1;
		}else{
			alert("A polygon must have at least 3 coordinate points");
		}
	}
	
	//ADD ROW FUNCTION FOR COORDINATE TABLE IN MAIN FORM
	function addRow(){
		var table = document.getElementById("formactualtableid"); //Call Coordinate Table
		var tnor = document.getElementById("numofrows");
		tnor.value = parseFloat(tnor.value) + 1;
		var x = table.rows.length; //Take number of rows of Coordinate Table
		var row = table.insertRow(x); //Insert new row in the Coordinate Table
		var cell1 = row.insertCell(0); //Create 1st cell for new row
		var cell2 = row.insertCell(1); //Create 2nd cell for new row
		var cell3 = row.insertCell(2); //Create 3rd cell for new row
		cell1.innerHTML = x;
		cell2.innerHTML = "<input type = \"text\" id = \"lng" + x + "\" name = 'lng" + x + "'></input>";
		cell3.innerHTML = "<input type = \"text\" id = \"lat" + x + "\" name = 'lat" + x +"'></input>";
	}

	$(function() {
		$( "#cperson" ).autocomplete({
			source: 'autocomplete.php'
		});
	});
</script>