<!-- EXTERNAL SCRIPT CALLS -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->

<link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>

<style>
	body{
		font-family: 'PT Sans', sans-serif;
	}
	
	#resultsbody{
		border-radius: 25px 25px 0px 0px;
		background-color: #efefef;
		width: 55%;
		padding-bottom: 2%;
		text-align: center;
	}	
	
	#header{
		border-radius: 25px 0px 0px 0px;
		background-color: #487d65;
		color: white;
		font-size: 170%;
		padding: 1%;
		text-align: center;
	}
	
	th, td {
		border: 1px solid black;
	}
	
	table{
		width: 50%;
		margin: 0 auto;
	}
	
	#head1, #head2{
		padding: 2%;
		font-weight: bold;
		background-color: #49b382;
	}
	
	td{
		padding: 1%;
	}
	tr:nth-child(even) {
		background-color: white;
	}
	
	tr:nth-child(odd) {
		background-color: #d5d7de;
	}
	
	#results{
		padding-top: 2%;
	}
	
	#previousbutton{
		margin-top: 2%;
	}
</style>

<?php
	session_start();
	
	if(isset($_POST['orgname'])) {
		$_SESSION['orgname'] = $_POST['orgname'];
	}
	
	$orgname = $_SESSION['orgname'];
	
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "newschema";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$orgid = "";
	
	$sql = "SELECT organizationID FROM organization WHERE organizationName = \"" . $orgname . "\"";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$orgid = $row["organizationID"];
		}
	} else {
	}
	
	$numofrows = 0;
	
	$siteids = array();
	
	$sql = "SELECT siteID FROM siteorganization WHERE organizationID = " . $orgid;
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$siteids[$numofrows] = $row["siteID"];
			$numofrows++;
		}
	} else {
	}
	
	$sitecounter = 0;
?>
<?php 
	$stringvalue = "";
	$values = array();

	for($k = 0; $k < $numofrows; $k++){
		$values[$k] = "\"" . $siteids[$k] . "\"";
		$stringvalue = $stringvalue . $values[$k];
		if($k !== $numofrows - 1){
			$stringvalue = $stringvalue . ",";
		}
	}
?>

<div id="resultsbody">
	<div id="header">Search results for <?php echo $orgname;?></div>
	<div id="results"></div>
	<button id="previousbutton" onclick="previous()">Search Again</button>
</div>

<script>
	var numofrows = <?php echo $numofrows; ?>;
	
	var tableholder = document.getElementById("results");
	var table = document.createElement("TABLE");
	table.id = "tableid";
	var header = table.createTHead();
	var row = header.insertRow(0);
	var cellOne = row.insertCell(0);
	cellOne.id = "head1";
	var cellTwo = row.insertCell(1);
	cellTwo.id = "head2";
	
	cellOne.innerHTML = "Site ID";
	cellTwo.innerHTML = "Link";
	
	var rows = [];
	var cells = [];
	var cellsvalue = [<?php echo $stringvalue; ?>];
	var cellstwo = [];


	for(var i = 0; i < numofrows; i++){
		rows[i] = document.createElement("TR");
		cells[i] = rows[i].insertCell(0);
		cellstwo[i] = rows[i].insertCell(0);
		
		cellstwo[i].innerHTML = "" + cellsvalue[i] + "";
		cells[i].innerHTML = "<button onclick=\"followlink(this)\" id = \"" + cellsvalue[i] +"\">GO</button>";
		
		table.appendChild(rows[i]);
	}

	
	tableholder.appendChild(table);
	
	function followlink(siteidnum){
		$.ajax({
			url: "journal.php",
			type: "POST",
			data: {siteid:siteidnum.id, sendertype: 0}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="journal.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
	
	function previous(){
		window.location="journalsearch.php";
	}
</script>
