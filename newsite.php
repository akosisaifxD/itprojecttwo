<head>
	<link rel="stylesheet" type="text/css" href="/js/jquery.tokenize.css" />
</head>

<link href='css/newsite.css' rel='stylesheet' type='text/css'>

<?php include 'connect.php'?>

<!-- EXTERNAL SCRIPTS -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
<script   src="https://code.jquery.com/ui/1.12.0-rc.1/jquery-ui.min.js"   integrity="sha256-mFypf4R+nyQVTrc8dBd0DKddGB5AedThU73sLmLWdc0="   crossorigin="anonymous"></script>
	<script type="text/javascript" src="jquery.tokenize.js"></script>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<!-- END EXTERNAL SCRIPTS -->

<div class = "mainformdiv">
	<div id = "sheader"> New Site <button class = "enter" onclick = "exampsaif()"> Submit </button> </div>
	<?php
		if(isset($_GET["success"])){
			echo "<div id = \"success\"> Successfully added new Organization </div>";
		}
	?>
	<hr id="jshr">
	<!-- MAIN FORM -->
		<!-- YEAR INPUT -->
		<div class="yearlabel">Year
			<div class="inputdiv">
				<select class = "yearcontent" id = "yearval">
					<!-- PHP CODE -->
					<?php
						$currentyear = date("Y"); //Get Current Year
						
						// For-loop to input options into select from 2011 - current year
						for($i = 2011; $i <= $currentyear; $i++){
							echo "<option value =\"" . $i . "\">" . $i . "</option>";
						}
					?>
				</select>
			</div>
		</div>
		<!-- END YEAR INPUT -->
		
		<!-- DECLARED AREA INPUT -->
		<div class="decareadiv">Declared Area
			<div class="inputdiv">
				<input type="text" id = "decarea"></input> ha
			</div>
		</div>
		<!-- END DECLARED AREA INPUT -->
		
		<!-- CONTACT PERSON INPUT -->
		<div class="cplabel">Contact Person
			<div class="inputdiv">
				<input id="cperson" type = "text"></input>
			</div>
		</div>
		<!-- END CONTACT PERSON INPUT -->
		
		<!-- ORGANIZATION INPUT -->
		<div class="orglabel">Organization
			<div class="inputdiv">
				<select class = "organizationcontent" multiple="multiple" id="orgid">
				<!-- PHP CODE -->
					<?php
						$sql = "SELECT organizationID, organizationName FROM organization ORDER BY organizationName ASC";
						$result = mysqli_query($conn, $sql);

						if (mysqli_num_rows($result) > 0) {
							// output data of each row
							while($row = mysqli_fetch_assoc($result)) {
								echo "<option value =\"" . $row["organizationID"] . "\">" . $row["organizationName"] . "</option>";
							}
						} else {
							//do nothing
						}
					?>
				</select>
				<script type="text/javascript">
					$('.organizationcontent').tokenize();
				</script>
			</div>
		</div>
		<!-- END ORGANIZATION INPUT -->
		<br>

		<div class="zonelabel">Zone
			<div class="inputdiv">
				<select class = "zonecontent" id = "zonecontent">
					<option value= "Protection"> Protection </option>
					<option value= "Production"> Production </option>
					<option value= "Protection/Production"> Protection/Production </option>
				</select>
			</div>
		</div>
		
		<!-- PROVINCE INPUT -->
		<div class="provlabel">Province
			<div class="inputdiv">
				<select class = "provincecontent"  id="provid">
				<option value="0"></option>
				<!-- PHP CODE -->
					<?php
						$counter = 1;
						
						$sql = "SELECT provinceID, provinceName FROM province WHERE regionID = 2 ORDER BY provinceName ASC";
						$result = mysqli_query($conn, $sql);

						if (mysqli_num_rows($result) > 0) {
							// output data of each row
							while($row = mysqli_fetch_assoc($result)) {
								echo "<option value =\"" . $counter . "\" name = \"" . $row["provinceName"] . "\">" . $row["provinceName"] . "</option>";
								$counter++;
							}
						} else {
							//do nothing
						}
					?>
				</select>
			</div>
		</div>
		<!-- END PROVINCE INPUT -->
		
		<!-- MUNICIPALITY INPUT -->
		<div class="munilabel">Municipality
			<div class="inputdiv">
				<select class = "municipalitycontent"  id="municiid">
				<option value="0"></option>
					<!-- DYNAMIC PROVINCE MUNICIPALITY RELATIONSHIP (SEE JAVASCRIPT) -->
				</select>
			</div>
		</div>
		<!-- END MUNICIPALITY INPUT -->	
	
		<!-- BARANGAY INPUT -->
		<div class="brgylabel">Barangay
			<div class="inputdiv">
				<select class = "barangaycontent" multiple="multiple" id="brgyid">
				<option value="0"></option>
				<!-- PHP CODE -->
				</select>
				<script type="text/javascript">
					$('#brgyid').tokenize();
				</script>
			</div>
		</div>
		<!-- END BARANGAY INPUT -->		
		
		<!-- COORDINATE TABLE INPUT -->
		<div class = "tablelabel">
				<header class = "tableheader">Coordinates</header>
				<div id = "tablebuttons">
					<button type = "button" class = "addbutton" onclick="addRow()"><i class="fa fa-plus-square"></i> Add Row </button>
					<button type = "button" class = "removebutton" onclick="removeRow()"><i class="fa fa-minus-square"></i> Remove Row </button>
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
                            <tr>
                                <td>1</td>
								<td><input type = "text" id = "lng1"></input></td>
								<td><input type = "text" id = "lat1"></input></td>
                            </tr>
                            <tr>
                                <td>2</td>
								<td><input type = "text" id = "lng2"></input></td>
								<td><input type = "text" id = "lat2"></input></td>
                            </tr>
                            <tr>
                                <td>3</td>
								<td><input type = "text" id = "lng3"></input></td>
								<td><input type = "text" id = "lat3"></input></td>
                        </tbody>
                    </table>
		</div>
		<!-- END COORDINATE TABLE INPUT -->
	<hr id="endjshr">
	<!-- END OF MAIN FORM -->
</div>

<div id="prevmodal" class="prevmodal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">x</span>
    <div id="map"></div>
  </div>

</div>


<!-- JAVASCRIPT CODES -->
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
			table.deleteRow(x - 1);
		}else{
			alert("A polygon must have at least 3 coordinate points");
		}
	}
	
	//ADD ROW FUNCTION FOR COORDINATE TABLE IN MAIN FORM
	function addRow(){
		var table = document.getElementById("formactualtableid"); //Call Coordinate Table
		var x = table.rows.length; //Take number of rows of Coordinate Table
		var row = table.insertRow(x); //Insert new row in the Coordinate Table
		var cell1 = row.insertCell(0); //Create 1st cell for new row
		var cell2 = row.insertCell(1); //Create 2nd cell for new row
		var cell3 = row.insertCell(2); //Create 3rd cell for new row
		cell1.innerHTML = x;
		cell2.innerHTML = "<input type = \"text\" id = \"lng" + x + "\"></input>";
		cell3.innerHTML = "<input type = \"text\" id = \"lat" + x + "\"></input>";
	}

	// DYNAMIC PROVINCE - MUNICIPALITY RELATIONSHIP
	$(document).ready(function() {

		$("#provid").change(function() {
			var val = $(this).val();
			$("#municiid").html(options[val]);
			$("#brgyid").html(adjoptions[val]);
		});
		
		$("#municiid").change(function() {
			var mval = $(this).val();
			$("#brgyid").html(moptions[mval]);
		});
		
		var adjoptions = ["<option value='0'></option>","<option value='0'></option>","<option value='0'></option>","<option value='0'></option>","<option value='0'></option>","<option value='0'></option>","<option value='0'></option>","<option value='0'></option>"];
		
		var moptions = [
			"<option value='0'></option>",
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 15 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 16 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 17 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 18 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 19 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 20 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 21 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 22 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 23 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 24 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 25 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 26 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 27 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 28 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 29 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 30 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 31 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 32 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 33 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 34 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 35 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 36 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 37 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 38 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 39 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 40 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 41 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 42 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 43 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 44 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 45 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 46 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 47 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 48 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 49 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 50 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 51 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 52 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 53 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 54 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 55 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 56 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 57 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 58 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 59 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 60 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 61 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 62 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 63 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 64 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 65 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 66 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 67 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 68 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 69 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 70 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 71 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 72 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 73 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 74 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 75 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 76 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 77 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 78 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 79 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 80 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 81 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 82 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 83 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 84 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 85 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 86 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 87 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 88 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 89 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 90 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$sql = "SELECT barangayID, barangayName, municipalityID FROM barangay WHERE municipalityID = 91 ORDER BY barangayName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $row["barangayID"] . "'>" . $row["barangayName"] . "</option>";
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>
		];
		
		var options = [
			"<option value='0'></option>",
			<?php
				$munictr = 1;
				
				$sql = "SELECT municipalityID, municipalityName, provinceID FROM municipality WHERE provinceID = 2 ORDER BY municipalityName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $munictr . "'>" . $row["municipalityName"] . "</option>";
						$munictr++;
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$munictr = 28;
				
				$sql = "SELECT municipalityID, municipalityName, provinceID FROM municipality WHERE provinceID = 3 ORDER BY municipalityName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $munictr . "'>" . $row["municipalityName"] . "</option>";
						$munictr++;
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$munictr = 35;
				
				$sql = "SELECT municipalityID, municipalityName, provinceID FROM municipality WHERE provinceID = 4 ORDER BY municipalityName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $munictr . "'>" . $row["municipalityName"] . "</option>";
						$munictr++;
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$munictr = 49;
				
				$sql = "SELECT municipalityID, municipalityName, provinceID FROM municipality WHERE provinceID = 5 ORDER BY municipalityName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $munictr . "'>" . $row["municipalityName"] . "</option>";
						$munictr++;
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$munictr = 60;
				
				$sql = "SELECT municipalityID, municipalityName, provinceID FROM municipality WHERE provinceID = 6 ORDER BY municipalityName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $munictr . "'>" . $row["municipalityName"] . "</option>";
						$munictr++;
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>,
			<?php
				$munictr = 68;
				
				$sql = "SELECT municipalityID, municipalityName, provinceID FROM municipality WHERE provinceID = 7 ORDER BY municipalityName ASC";
				$result = mysqli_query($conn, $sql);
				echo "\"<option value='0'></option>";
				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						echo "<option value ='" . $munictr . "'>" . $row["municipalityName"] . "</option>";
						$munictr++;
					}
				} else {
					//do nothing
				}
				echo "\"";
			?>
		];

	});
</script>

<script>
$(function() {
    $( "#cperson" ).autocomplete({
        source: 'autocomplete.php'
    });
});

	function exampsaif(){
		var sitevalidate = 0;
		
		var year = document.getElementById("yearval").value;
		var decarea = document.getElementById("decarea").value;
		if(decarea.replace(/ /g,'').length == 0){
			sitevalidate = 1;
		}
		
		var cperson = document.getElementById("cperson").value;
		if(cperson.replace(/ /g,'').length == 0){
			sitevalidate = 1;
		}
		
		
		var organization = $('#orgid').val();
		
		if(organization == undefined){
			sitevalidate = 1;
		}else{
			var org = "";
			
			for(var j = 0; j < organization.length; j++){
				org = org + organization[j];
				if(j != organization.length - 1){
					org = org + ",";
				}
			}
		}
		
		
		var table = document.getElementById("formactualtableid");
		var offnum = table.rows.length - 1;
		
		var latitudestring = "";
		var longitudestring = "";
		
		for(var i = 0; i < offnum; i++){
			var latelem = document.getElementById("lat" + (i + 1)).value;
			var lngelem = document.getElementById("lng" + (i + 1)).value;
			
			var latelemc = latelem.replace(/ /g,'');
			var lngelemc = lngelem.replace(/ /g,'');
			
			if(latelemc.length == 0){
				sitevalidate = 1;
			}
			if(lngelemc.length == 0){
				sitevalidate = 1;
			}
			
			latitudestring = latitudestring + latelem;
			longitudestring = longitudestring + lngelem;
			if(i !== (offnum - 1)){
				latitudestring = latitudestring + ",";
				longitudestring = longitudestring + ",";
			}
		}
		
		var zonec = document.getElementById("zonecontent").value;
		
		var provc = document.getElementById("provid").value;
		if(provc.replace(/ /g,'').length == 0){
			sitevalidate = 1;
		}
		
		var municic = document.getElementById("municiid").value;
		if(municic.replace(/ /g,'').length == 0){
			sitevalidate = 1;
		}
		
		var brgy = $('#brgyid').val();
		
		if(brgy == undefined){
			sitevalidate = 1;
		}else{
			var brgyc = "";
			
			for(var k = 0; k < brgy.length; k++){
				brgyc = brgyc + brgy[k];
				if(k != brgy.length - 1){
					brgyc = brgyc + ",";
				}
			}
		}
		

		if(sitevalidate == 1){
			alert("Some fields are empty. Please fill up the form completely.");
		}else{
			$.ajax({
				url: "siteprocess.php",
				type: "POST",
				data: {year:year, decarea:decarea, cperson:cperson, org:org, latstring:latitudestring, lngstring:longitudestring, zonec:zonec, provc:provc, municic: municic, brgyc: brgyc}, // add a flag
				success: function(data, textStatus, jqXHR){
					window.location="hsite.php?success=true";
				},
				error: function (jqXHR, textStatus, errorThrown){
					alert('Error!')
				}
			});
		}
	}
</script>
<!-- END OF JAVASCRIPT CODES -->

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyGBTdSmKQ2wq_L0QhV6fZcOLWIO2IbXs&callback=initMap"></script>