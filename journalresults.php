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
	
	#resheader{
		border-radius: 0px 0px 0px 0px;
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
	
	#resresults{
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
	
	$sendertypefs = $_SESSION['sendertype'];
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
	
	$sql = "SELECT siteCode FROM siteorganization WHERE organizationID = " . $orgid;
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$siteids[$numofrows] = $row["siteCode"];
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
	<div id="resheader">Search results for <?php echo $orgname;?></div>
	<div id="resresults"></div>
	<div id="pages"></div>
</div>

<script>
	var numofrows = <?php echo $numofrows; ?>;
	
	var tableholder = document.getElementById("resresults");
	var table = document.createElement("TABLE");
	table.id = "tableid";
	var header = table.createTHead();
	var row = header.insertRow(0);
	var cellOne = row.insertCell(0);
	cellOne.id = "head1";
	var cellTwo = row.insertCell(1);
	cellTwo.id = "head2";
	
	cellOne.innerHTML = "Site Code";
	cellTwo.innerHTML = "Link";
	
	var rows = [];
	var cells = [];
	var cellsvalue = [<?php echo $stringvalue; ?>];
	var cellstwo = [];
	
	if(numofrows < 10){
		for(var i = 0; i < numofrows; i++){
			rows[i] = document.createElement("TR");
			cells[i] = rows[i].insertCell(0);
			cells[i].id = "cell" + (i+1);
			cellstwo[i] = rows[i].insertCell(0);
			cellstwo[i].id = "celltwo" + (i+1);
			
			cellstwo[i].innerHTML = "" + cellsvalue[i] + "";
			cells[i].innerHTML = "<button onclick=\"followlink(this)\" id = \"" + cellsvalue[i] +"\">GO</button>";
			
			table.appendChild(rows[i]);
		}
	}else{
		for(var i = 0; i < 10; i++){
			rows[i] = document.createElement("TR");
			cells[i] = rows[i].insertCell(0);
			cells[i].id = "cell" + (i+1);
			cellstwo[i] = rows[i].insertCell(0);
			cellstwo[i].id = "celltwo" + (i+1);
			
			cellstwo[i].innerHTML = "" + cellsvalue[i] + "";
			cells[i].innerHTML = "<button onclick=\"followlink(this)\" id = \"" + cellsvalue[i] +"\">GO</button>";
			
			table.appendChild(rows[i]);
		}
	}
	
	if(numofrows > 10){
		var pagecounter = 0;
		var pages = [];
		var pagestab = document.getElementById("pages");
		
		for(var j = numofrows; j > 0; j = j - 10){
			pages[pagecounter] = document.createElement("span");
			pages[pagecounter].innerHTML = "<button onclick = \"changepage(" + (pagecounter) +")\">" + (pagecounter + 1) + "</button>";
			pagestab.appendChild(pages[pagecounter]);
			
			pagecounter++;
		}
	}
	
	
	tableholder.appendChild(table);
	
	function followlink(siteidnum){
		$.ajax({
			url: "journal.php",
			type: "POST",
			data: {siteid:siteidnum.id, sendertype: <?php echo $sendertypefs;?>}, // add a flag
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
	
	function changepage(pagenum){
		var nor = <?php echo $numofrows; ?>;
		
		var limsub = 10 * pagenum;
		var limholder = 0;
		
		if(numofrows - limsub >= 10){
			limholder = 10;
		}else{
			limholder = numofrows - limsub;
		}
		
		var table = document.getElementById("tableid");
		var cellsvalue = [<?php echo $stringvalue; ?>];
		
		var rowscnum = document.getElementById("tableid").rows.length;
		
		if(rowscnum < 11){
			for(var num = rowscnum; num < 11; num++){
				var row = document.getElementById("tableid").insertRow(num);
				var cell = row.insertCell(0);
				cell.id = "cell" + num;
				var celltwo = row.insertCell(0);
				celltwo.id = "celltwo" + num;
			}
		}
		
		if(limholder < 10){
			var limitcheck = limholder;
			for(var i = 10; i > limitcheck; i--){
				document.getElementById("tableid").deleteRow(i);
			}
		}
		
		for(var i = 0; i < limholder; i++){
			var dummycelltwo = document.getElementById("celltwo" + (i+1));
			var dummycell = document.getElementById("cell" + (i+1));
			
			dummycelltwo.innerHTML = "" + cellsvalue[i + limsub] + "";
			dummycell.innerHTML = "<button onclick=\"followlink(this)\" id = \"" + cellsvalue[i + limsub] +"\">GO</button>";
		}
	}
	
	function alertsample(){
		alert("HELLO");
	}
</script>
