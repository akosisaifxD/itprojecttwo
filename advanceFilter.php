<head>
	<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.0','packages':['corechart', 'table', 'controls']}]}"></script>
    <link rel="stylesheet" href="jquery-ui-1.11.4.custom\jquery-ui.css">
    <script src="jquery-ui-1.11.4.custom\external\jquery\jquery.js"></script>
    <script src="jquery-ui-1.11.4.custom\jquery-ui.js"></script>
	<script src="scripts/backendreport.js"></script>
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
	<div id = "nslabel"> Advanced Filter </div>
	<hr id = "nshr">
	<!-- MAIN FORM -->
		
		<!-- YEAR INPUT -->
		<div id="yearContainer">
		<button onclick="javascript:ShowHide('year')" id="inputButton">Input Year</button>
		<div class="mid" id="year" style="display: none;">
			Search Year:<br><input id="yearInput">
			</input> <button id='' onclick='enter("year");'>Enter</button>
			Selected Year/s:<div id="yearSelected">
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
		<div id="provinceContainer">
		<button onclick="javascript:ShowHide('province')" id="inputButton">Input Province</button>
		<div class="mid" id="province" style="display: none;">
			Search Province:<br><input id="provinceInput">
			</input> <button id='' onclick='enter("province");'>Enter</button>
			Selected Province/s:<div id="provinceSelected">
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
		<div id="cenroContainer">
		<button onclick="javascript:ShowHide('cenro')" id="inputButton">Input CENRO</button>
		<div class="mid" id="cenro" style="display: none;">
			Search CENRO:<br><input id="cenroInput">
			</input><button id='' onclick='enter("cenro");'>Enter</button>
			Selected CENRO:<div id="cenroSelected">
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
		<div id="organizationContainer">
		<button onclick="javascript:ShowHide('org')" id="inputButton">Input Organization Name</button>
		<div class="mid" id="org" style="display: none;">
			Search Organization:<br><input id="orgnameInput">
			</input> <button id='' onclick='enter("orgname");'>Enter</button>
			Selected Organizatoin/s:<div id="orgnameSelected">
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
		<div id="specieContainer">
		<button onclick="javascript:ShowHide('specie')" id="inputButton">Input Specie/s</button>
		<div class="mid" id="specie" style="display: none;">
			Search Specie/s:<br><input id="speciesInput">
			</input> <button id='' onclick='enter("species");'>Enter</button>
			Selected Specie/s:<div id="speciesSelected">
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
		<hr id = "nshr">
		<button class = "inputButton" align="right" onclick="search();"> Generate </button>
	<!-- END OF MAIN FORM -->
	
		<div id='table_div'>
		</div>
		
		<div id="chart_survival"></div>
		<div id="chart_growth"></div>
	</div>
</div>
</body>

<!-- END OF JAVASCRIPT CODES -->
