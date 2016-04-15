<head>
	<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.0','packages':['corechart', 'table', 'controls']}]}"></script>
    <link rel="stylesheet" href="jquery-ui-1.11.4.custom\jquery-ui.css">
    <script src="jquery-ui-1.11.4.custom\external\jquery\jquery.js"></script>
    <script src="jquery-ui-1.11.4.custom\jquery-ui.js"></script>
	<script src="scripts/backendreport.js"></script>
	<link href="css/advanceFilter.css" rel="stylesheet">
	<style>
		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
		}
		th, td {
			padding: 5px;
			text-align: left;    
		}
	</style>
</head>

<?php include 'connect.php'?>

<body>
<div class = "mainformdiv">
	<div id = "nslabel"> <h2>Advanced Filter</h2> </div>
	<hr id = "nshr">
	<!-- MAIN FORM -->
		
		<!-- YEAR INPUT -->
				<div id="yearContainer" class="advanceFilterForm">
				<button onclick="javascript:ShowHide('year')" id="inputButton">Input Year</button>
				<div class="mid" id="year" style="display: none;">
					<input id="yearInput" placeholder="Search Year...">
					</input> <button id='enterButton' onclick='enter("year");'>Enter</button>
					<br>Selected Year/s:<div id="yearSelected">
					</div>
				</div><br>
				<script type="text/javascript">
				function ShowHide(divId){
				if(document.getElementById(divId).style.display == 'none'){
					document.getElementById(divId).style.display='block';
				}else{
				document.getElementById(divId).style.display = 'none';
				}
				}
				</script>
				</div>
		<!-- END YEAR INPUT -->
		
		<!-- PROVINCE INPUT -->
				<div id="provinceContainer" class="advanceFilterForm">
				<button onclick="javascript:ShowHide('province')" id="inputButton">Input Province</button>
				<div class="mid" id="province" style="display: none;">
					<input id="provinceInput" placeholder="Search Province...">
					</input> <button id='enterButton' onclick='enter("province");'>Enter</button>
					<br>Selected Province/s:<div id="provinceSelected">
					</div>
				</div><br>
				<script type="text/javascript">
				function ShowHide(divId){
				if(document.getElementById(divId).style.display == 'none'){
					document.getElementById(divId).style.display='block';
				}else{
				document.getElementById(divId).style.display = 'none';
				}
				}
				</script>
				</div>
		<!-- END PROVINCE INPUT -->
		
		<!-- CENRO INPUT -->
				<div id="cenroContainer" class="advanceFilterForm">
				<button onclick="javascript:ShowHide('cenro')" id="inputButton">Input CENRO</button>
				<div class="mid" id="cenro" style="display: none;">
					<input id="cenroInput" placeholder="Search CENRO...">
					</input><button id='enterButton' onclick='enter("cenro");'>Enter</button>
					<br>Selected CENRO:<div id="cenroSelected">
					</div>
				</div><br>
				<script type="text/javascript">
				function ShowHide(divId){
				if(document.getElementById(divId).style.display == 'none'){
					document.getElementById(divId).style.display='block';
				}else{
				document.getElementById(divId).style.display = 'none';
				}
				}
				</script>
				</div>
		<!-- END CENRO INPUT -->
		
		<!-- ORGANIZATION INPUT -->
				<div id="organizationContainer" class="advanceFilterForm">
				<button onclick="javascript:ShowHide('org')" id="inputButton">Input Organization Name</button>
				<div class="mid" id="org" style="display: none;">
					<input id="orgnameInput" placeholder="Search Organization...">
					</input> <button id='enterButton' onclick='enter("orgname");'>Enter</button>
					<br>Selected Organizatoin/s:<div id="orgnameSelected">
					</div>
				</div><br>
				<script type="text/javascript">
				function ShowHide(divId){
				if(document.getElementById(divId).style.display == 'none'){
					document.getElementById(divId).style.display='block';
				}else{
				document.getElementById(divId).style.display = 'none';
				}
				}
				</script>
				</div>
		<!-- END ORGANIZATION INPUT -->
		
		<!-- SPECIES INPUT -->
				<div id="specieContainer" class="advanceFilterForm">
				<button onclick="javascript:ShowHide('specie')" id="inputButton">Input Species</button>
				<div class="mid" id="specie" style="display: none;">
					<input id="speciesInput" placeholder="Search Species...">
					</input> <button id='enterButton' onclick='enter("species");'>Enter</button>
					<br>Selected Specie/s:<div id="speciesSelected">
					</input>
				</div><br>
				<script type="text/javascript">
				function ShowHide(divId){
				if(document.getElementById(divId).style.display == 'none'){
					document.getElementById(divId).style.display='block';
				}else{
				document.getElementById(divId).style.display = 'none';
				}
				}
				</script>
				</div><br>
				<!-- END SPECIES INPUT -->
				</div>
		<hr id = "nshr">
		<button class = "inputButton" align="right" onclick="search();"> Generate Report </button>
	<!-- END OF MAIN FORM -->
	
		<div id='table_div'>
		</div>
		
		<div id="chart_survival"></div>
		<div id="chart_growth"></div>
	
</div>
</body>

<!-- END OF JAVASCRIPT CODES -->
