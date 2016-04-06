<!-- EXTERNAL SCRIPT CALLS -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->

<link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
<link href='css/journalsearch.css' rel='stylesheet' type='text/css'>

<?php
	$sendertypefs = $_SESSION['sendertype'];
?>

<!-- HTML CONTENT -->

<div id="searchbody">
	<div id="jsheader"> Journal Search </div>
	<hr id="jshr">
	<div id = "search">
		<select id = "searchbytype" name="searchselect">
			<option value = "SiteCode"> Site Code </option>
			<option value = "Organization"> Organization </option>
			<option value = "Municipality"> Municipality </option>
		</select>
		<div id="sitecodeshow" class="desc">
			<input type = "text" id = "searchbox" name="searchbox"></input>
			<button class = "enter">Search</button>
		</div>
		<div id="orgcodeshow" class="desc">
			<select id = "searchboxtwo" name="searchboxtwo">
				<?php
					$servername = "localhost";
					$username = "root";
					$password = "";
					$dbname = "newschema";
					$conn = mysqli_connect($servername, $username, $password, $dbname);
					if (!$conn) {
						die("Connection failed: " . mysqli_connect_error());
					}
					
					$checkid = $_SESSION['username'];
					
					if($_SESSION['accounttype'] === 'Advanced'){
						$sql = "SELECT organizationName FROM organization";
						$result = mysqli_query($conn, $sql);
						if (mysqli_num_rows($result) > 0) {
							// output data of each row
							while($row = mysqli_fetch_assoc($result)) {
								echo "<option value = \"" . $row["organizationName"] ."\">" . $row["organizationName"] . "</option>";
							}
						} else {
							echo "0 results";
						}
					}
					
					if($_SESSION['accounttype'] === 'Basic'){
						$sql = "SELECT DISTINCT organizationName from organization 
								INNER JOIN siteorganization ON siteorganization.organizationID = organization.organizationID 
								INNER JOIN site ON site.siteCode = siteorganization.siteCode 
								INNER JOIN cenromunicipality ON cenromunicipality.municipalityID = site.municipalityID 
								INNER JOIN denr ON denr.cenroID = cenromunicipality.cenroID
								WHERE denr.denrID = '" . $checkid . "'";
						$result = mysqli_query($conn, $sql);
						if (mysqli_num_rows($result) > 0) {
							// output data of each row
							while($row = mysqli_fetch_assoc($result)) {
								echo "<option value = \"" . $row["organizationName"] ."\">" . $row["organizationName"] . "</option>";
							}
						} else {
							echo "0 results";
						}
					}
				?>
			</select>
			<button class = "enter">Search</button>
		</div>
		<div id="municodeshow" class="desc">
			<select id = "searchboxthree" name="searchboxthree">
				<?php
					$servername = "localhost";
					$username = "root";
					$password = "";
					$dbname = "newschema";
					$conn = mysqli_connect($servername, $username, $password, $dbname);
					if (!$conn) {
						die("Connection failed: " . mysqli_connect_error());
					}
					
					$sql = "SELECT municipality.municipalityName, province.provinceName FROM municipality INNER JOIN province ON municipality.provinceID = province.provinceID WHERE municipality.provinceID BETWEEN 2 AND 7 ORDER BY provinceName, municipalityName";
					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result) > 0) {
						// output data of each row
						while($row = mysqli_fetch_assoc($result)) {
							echo "<option value = \"" . $row["municipalityName"] ."\">" . $row["municipalityName"] . " (" . $row["provinceName"] . ")" . "</option>";
						}
					} else {
						echo "0 results";
					}
				?>
			</select>
			<button class = "enter">Search</button>
		</div>
	</div>
	<hr id="jshrf">
	<div id = "results"></div>
</div>

<div id = "resultcontainer"></div>

<!-- END OF HTML CONTENT -->

<!-- JAVASCRIPT CODES -->

<script type="text/javascript">
	$("#orgcodeshow").hide();
	$("#municodeshow").hide();

	$('#searchbytype').change(function(){
		var test = $(this).val();
		$("div.desc").hide();
		if(test == "SiteCode"){
			$("#sitecodeshow").show();
		}
		if(test == "Organization"){
			$("#orgcodeshow").show();
		}
		if(test == "Municipality"){
			$("#municodeshow").show();
		}
	});
	
	$('.enter').on('click',function(){
		
		var searchoption = document.getElementById("searchbytype").value;
		
		if(searchoption === "SiteCode"){
			
			var value = document.getElementById("searchbox").value;
			
			$.ajax({
				url: "journal.php",
				type: "POST",
				contentType: "application/x-www-form-urlencoded",
				data: {sitecode:value, sendertype: <?php echo $sendertypefs;?>}, // add a flag
				success: function(data, textStatus, jqXHR){
					window.location="hjournalr.php";
				},
				error: function (jqXHR, textStatus, errorThrown){
					alert('Error!')
				}
			});
		}
		
		if(searchoption === "Organization"){
		
			var value = document.getElementById("searchboxtwo").value;
			
			$.ajax({
				url: "journalresults.php",
				type: "POST",
				contentType: "application/x-www-form-urlencoded",
				data: {orgname:value}, // add a flag
				success: function(data, textStatus, jqXHR){
				},
				error: function (jqXHR, textStatus, errorThrown){
					alert('Error!')
				}
			});	
			
			$("#resultcontainer").html("");
			
			$.ajax({
				type:'GET',
				contentType: "application/x-www-form-urlencoded",
				url:'journalresults.php',
				data:'',
				success: function(data){
						$('#resultcontainer').html(data);
				}
			});
		}
		
		if(searchoption === "Municipality"){
		
			var value = document.getElementById("searchboxthree").value;
			
			$.ajax({
				url: "journalmresults.php",
				type: "POST",
				contentType: "application/x-www-form-urlencoded",
				data: {muniname:value}, // add a flag
				success: function(data, textStatus, jqXHR){
				},
				error: function (jqXHR, textStatus, errorThrown){
					alert('Error!')
				}
			});
			
			$("#resultcontainer").html("");
			
			$.ajax({
				type:'GET',
				contentType: "application/x-www-form-urlencoded",
				url:'journalmresults.php',
				data:'',
				success: function(data){
						$('#resultcontainer').html(data);
				}
			});
		}
	});
</script>

<!-- END OF JAVASCRIPT CODES -->
