<head>
	<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.0','packages':['corechart', 'table', 'controls']}]}"></script>
    <link rel="stylesheet" href="jquery-ui-1.11.4.custom\jquery-ui.css">
    <script src="jquery-ui-1.11.4.custom\external\jquery\jquery.js"></script>
    <script src="jquery-ui-1.11.4.custom\jquery-ui.js"></script>
	<script src="scripts/dashboard.js"></script>
		<link href='css/ccode.css' rel='stylesheet' type='text/css'>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<style>
  
		#inputBody {
			background-color: rgb(51, 128, 81);
			color: white;
			font-family: testFont;
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
		#repBod {
		    margin-top: 4%;
		    margin-bottom: 0%;
		    margin-left: 8%;
			display: block;
		}
		#yearsites {
			float: left;
			height: 50% !important;
			width: 33% !important;
		}
		#provincesites{
			float: left;
			height: 50% !important;
			width: 60% !important;
		}
		#treechart{
			float: left;
			height: 40% !important;
			width: 93% !important;
		}

	</style>
</head>

<?php include 'connect.php'?>

<body>
<div class = "mainformdiv">
	<div id="ccheader">Dashboard</div>
	<hr id="jshr">
	
	<div id = "repBod">
			<div id = "yearsites">
			</div>
			<div id = "provincesites">
			</div><br>
			<div id = "treechart">
			</div>
	</div>
</div>
</body>

<!-- END OF JAVASCRIPT CODES -->