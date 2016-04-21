<head>
	<!--<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.0','packages':['corechart', 'table', 'controls']}]}"></script>-->
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
		img#weblogo {
			height: 100;
			margin-top: 1%;
			margin-bottom: -1%;
		}
		div#table_div table {
    width: 100%;
}
		#cenro{
			border: 1px black;
			height: 300px;
			width: 50%;
			float: left;
		}
		#province{
			border: 1px black;
			width: 55%;
			height: 55%;
			height: 300px;
			float: left;
		}
		#tree{
			border: 1px black;
			width: 50%;
			height: 300px;
			float: left;
		}
	</style>
</head>

<?php include 'connect.php'?>

<body>
<div class = "mainformdiv">
	<div id = "nslabel"> <center> 
						<div id="denrImage"><img src="img/denr-logo.png" id="weblogo"></div>
						<p>
							Department of Environment and Natural Resources<br>
							DENR Forestry Compound, Pacdal Street, Baguio City<br>
							Tel No: (074) 446-2881
						<p>
					</center> </div>
	<hr id = "nshr">
	<h3 id="reportTitle"></h3>
<div id="cenro">
		<div id="cenroChart"></div>
		</div>
	<div id="province">
		<div id="provinceChart"></div>
		</div>
	<div id="tree">
		<div id="treeChart"></div>
		</div>
	<div id="table_div"></div>

	
</div>
</body>

<!-- END OF JAVASCRIPT CODES -->
