<head>
	<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.0','packages':['corechart', 'table', 'controls']}]}"></script>
    <link rel="stylesheet" href="jquery-ui-1.11.4.custom\jquery-ui.css">
    <script src="jquery-ui-1.11.4.custom\external\jquery\jquery.js"></script>
    <script src="jquery-ui-1.11.4.custom\jquery-ui.js"></script>
	<link href='css/ccode.css' rel='stylesheet' type='text/css'>
	<style>
		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
		}
		th, td {
			padding: 5px;
			text-align: left;    
		}
		
		#yearEndDiv {
			display: none;
		}
	select {
	    width: 24%;
	    height: 4%;
	    font-size: smaller;
	    /* font-weight: 800; */
	    color: black;
	    border-color: forestgreen;
	    border-width: medium;
	    border-radius: 10px;
	}		
	#repBod {
		    margin-top: 0%;
		    margin-bottom: 0%;
		    margin-left: 8%;
	}
	table{
		width: 88%;
	}
	table, tr, td {
    	border-color: white;
	}
	#inputBody {
	    background-color: rgb(51, 128, 81);
	    color: white;
		font-family: raleway;
	    font-weight: 500;
	    font-size: 25px;
	    padding-left: 27px;
	    width: 85%;
	}
	#enterButton {
	    height: 28px;
	    width: 65px;
	    font-weight: 700;
	    color: #ffffff;
	    background: rgb(72, 125, 101);
	    border: 1px solid transparent;
	    border-radius: 4px;
	}
	

	</style>
</head>

<?php include 'connect.php'?>

<body>
<div class = "mainformdiv">
	<!-- MAIN FORM -->
			<div id= "centerType">
			<div id="ccheader">Type of Report:
			<label>	
				<select onchange ="updateFilter(this.value);" id="reportType">
					<!--<option selected disabled>Choose Type of Report...</option>-->
					<option selected value = "validation">Validation Report</option>
					<option value = "yearend">NGP Year end Report</option>
				</select>
				
				<div id="yearEndDiv">
				<p>Year End: <select id="yearEndValue" onchange="updatevYear(this.value);">
				
				</select>
				</div>
			</label>
			</div>
			<hr id="jshr">
			
			</div><br>
		<div id = "repBod">
		<table class="advanceFilterForm">
		<tr>
			<td>
		<!-- SITE YEAR INPUT -->
				<div id="yearContainer" class="advanceFilterForm">
				<p id="inputBody"> Year</p>
				<div class="mid" id="year" style="display: visible;">
					<input id="sYearInput" placeholder="Search Site Year...">
					</input> <button id='enterButton' onclick='enter("sYear");'>Enter</button>
					<br>Selected Site Year/s:<div id="sYearSelected">
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
			</td>
		<!-- END YEAR INPUT -->
		
		<!-- VALIDATION YEAR INPUT -->
			<td>
				<div id="validationYearContainer" class="advanceFilterForm">
				<p id="inputBody"> Validation Year</p>
				<div class="mid" id="validationYear" style="display: visible;">
					<input id="vYearInput" placeholder="Search Validation Year...">
					</input><button id='enterButton' onclick='enter("vYear");'>Enter</button>
					<br>Selected Validation Year/s:<div id="vYearSelected">
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
			</td>
		</tr>
		<!-- END CENRO INPUT -->
		
		<!-- PROVINCE INPUT -->
		<tr>
			<td>
				<div id="provinceContainer" class="advanceFilterForm">
				<p id="inputBody">Province</p>
				<div class="mid" id="province" style="display: visible;">
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
			</td>
		<!-- END PROVINCE INPUT -->
		
		<!-- CENRO INPUT -->
			<td>
				<div id="cenroContainer" class="advanceFilterForm">
				<p id="inputBody">CENRO</p>
				<div class="mid" id="cenro" style="display: visible;">
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
			</td>
		</tr>
		<!-- END CENRO INPUT -->
		
		<!-- ORGANIZATION INPUT -->
		<tr>
			<td>
				<div id="organizationContainer" class="advanceFilterForm">
				<p id="inputBody">Organization Name</p>
				<div class="mid" id="org" style="display: visible;">
					<input id="orgnameInput" placeholder="Search Organization...">
					</input> <button id='enterButton' onclick='enter("orgname");'>Enter</button>
					<br>Selected Organization/s:<div id="orgnameSelected">
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
			</td>
		<!-- END ORGANIZATION INPUT -->
		
		<!-- SPECIES INPUT -->
			<td>
				<div id="specieContainer" class="advanceFilterForm">
				<p id="inputBody">Species</p>
				<div class="mid" id="specie" style="display: visible;">
					<input id="speciesInput" placeholder="Search Species...">
					</input> <button id='enterButton' onclick='enter("species");'>Enter</button>
						<br>Selected Species:<div id="speciesSelected">
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
			</td>
		</tr>
		</table>
		<button id="generateButton"class = "inputButton" onclick="search();"> Generate Report </button>
	<!-- END OF MAIN FORM -->
	</div>
	<hr id = "jshr">
	

</div>
</body>
<script src="scripts/backendreport.js"></script>
<!-- END OF JAVASCRIPT CODES -->