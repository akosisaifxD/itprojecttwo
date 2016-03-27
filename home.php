<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<style>
	@font-face{
		font-family: 'ChunkFiveRegular';
		src:url('fonts/ChunkFive/Chunkfive.otf');
	}
	
	@font-face{
		font-family: 'Junction';
		src:url('fonts/junction-regular/Junction.otf');
	}
	
	#homeheader{
		background-color: #146336;
		height: 12%;
		clear: both;
	}
	
	#weblogo{
		width: 4%;
		heigth:4%;
		float: left;
		margin-top: 0.6%;
		margin-left: 11%;
	}
	
	#title{
		cursor: context-menu;
		font-family: 'ChunkFiveRegular';
		float: left;
		font-size: 320%;
		margin-top: 1%;
		margin-left: 0.5%;
		color: white;
	}
	
	#login{
		cursor: pointer;
		font-family: 'Junction';
		float: right;
		margin-top: 1.9%;
		margin-right: 11%;
		border-radius: 10px 10px 10px 10px;
		background-color: #25af62;
		color: white;
		padding-top: 0.4%;
		padding-bottom: 0.4%;
		padding-left: 1.2%;
		padding-right: 1.2%;
	}
	
	#login:hover{
		background-color: white; /* Green */
		color: #25af62;
	}
	
	#banner{
		clear: both;
	}
	
	#homeimage{
		position: relative; 
		float: left;
		width: 100.8%;
		height: 70%;
		margin-left: -0.46%;
	}
	
	#bantitle{
		cursor: context-menu;
		font-family: 'Junction';
		color: white;
		position: absolute;
		top: 25%; 
		left: 11%; 
		width: 48%;
		font-size: 200%;
		font-weight: bold;
	}
	
	#bandes{
		cursor: context-menu;
		font-family: 'Junction';
		color: white;
		position: absolute;
		top: 50%; 
		left: 11%; 
		width: 48%;
		font-size: 85%;
	}
	
	#banbut{
		cursor: pointer;
		font-family: 'Junction';
		position: absolute;
		top: 60%; 
		left: 11%; 
		width: 7%;
		height: 6%;
		font-size: 85%;
		border-radius: 10px 10px 10px 10px;
		border-color: white; 
		background-color: Transparent;
		color: white;
		font-weight: bold;
	}
	
	.modal {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 1; /* Sit on top */
		left: 0;
		top: 0;
		width: 100%; /* Full width */
		height: 100%; /* Full height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0,0,0); /* Fallback color */
		background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}
	
	.modalcontent {
		background-color: #fefefe;
		margin: 15% auto; /* 15% from the top and centered */
		padding: 20px;
		border: 1px solid #888;
		width: 30%; /* Could be more or less, depending on screen size */
	}
	
	.close {
		color: #aaa;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}

	.close:hover,
	.close:focus {
		color: black;
		text-decoration: none;
		cursor: pointer;
	}
	
	#icon{
		margin-top: 2%;
		margin-left: 20%;
		color: #146336;
	}
	
	#funconehead{
		font-family: 'Junction';
		position: absolute;
		top: 100%; 
		left: 18%; 
		width: 20%;
		height: 6%;
		font-size: 180%;
		font-weight: bold;
		color: #146336;
	}
	
	#functwohead{
		font-family: 'Junction';
		position: absolute;
		top: 100%; 
		left: 44%; 
		width: 20%;
		height: 6%;
		font-size: 180%;
		font-weight: bold;
		color: #146336;
	}
	
	#functhreehead{
		font-family: 'Junction';
		position: absolute;
		top: 100%; 
		left: 71%; 
		width: 20%;
		height: 6%;
		font-size: 180%;
		font-weight: bold;
		color: #146336;
	}
	
	#funconedesc{
		font-family: 'Junction';
		position: absolute;
		top: 105%; 
		left: 44.4%; 
		width: 11%;
		height: 6%;
		font-size: 85%;
		color: #146336;
		text-align: center;
	}
	
	#functwodesc{
		font-family: 'Junction';
		position: absolute;
		top: 105%; 
		left: 18.4%; 
		width: 11%;
		height: 6%;
		font-size: 85%;
		color: #146336;
		text-align: center;
	}
	
	#functhreedesc{
		font-family: 'Junction';
		position: absolute;
		top: 105%; 
		left: 71.4%; 
		width: 11%;
		height: 6%;
		font-size: 85%;
		color: #146336;
		text-align: center;
	}
	
	#appdesc{
		margin-top: 15%;
		background-color: #146336;
		height: 40%;
	}
	
	#applogo{
		width: 15%;
		heigth:15%;
		float: right;
		margin-top: 2%;
		margin-right: 16%;
	}
	
	#apphead{
		font-family: 'Junction';
		font-weight: bold;
		font-size: 180%;
		width: 50%;
		float: left;
		margin-top: 6%;
		margin-left: 16%;
		color: white;
	}
	
	#appdescr{
		font-family: 'Junction';
		font-weight: bold;
		font-size: 70%;
		width: 50%;
		float: left;
		margin-top: 2%;
		margin-left: 16%;
		color: white;
	}
	
	#mapimage{
		width: 100%;
	}
	
	#m{
		height: 100%;
	}
	
	#mapdescr{
		font-family: 'Junction';
		position: absolute;
		top: 185%; 
		left: 25%; 
		width: 50%;
		height: 6%;
		font-size: 160%;
		color: white;
		text-align: center;
	}
	
	#mapbut{
		font-family: 'Junction';
		position: absolute;
		top: 205%; 
		left: 44.2%; 
		width: 12%;
		height: 6%;
		font-size: 85%;
		border-radius: 10px 10px 10px 10px;
		border-color: white; 
		background-color: #36b767;
		color: white;
		font-weight: bold;
	}
	
	#footer{
		background-color: #146336;
		height: 20%;
	}
	
	#footerlogo{
		width: 6%;
		heigth:6%;
		float: left;
		margin-top: 1.2%;
		margin-left: 38%;
	}
	
	#footertitle{
		font-family: 'Junction';
		font-weight: bold;
		font-size: 400%;
		color: white;
		width: 10%;
		float: left;
		margin-left: 1%;
		margin-top: 3%;
	}
	
	#footerdis{
		font-family: 'Junction';
		font-size: 100%;
		color: white;
		width: 20%;
		float: left;
		margin-top: 8.5%;
		margin-left: -15.5%;
	}
</style>

<div id = "homeheader">
	<img src = "img/logo.png" id = "weblogo"/>
	<span id = "title">iPuno</span>
	<button id = "login"> Log in</button>
</div>

<div id = "banner">
	<img src = "img/homeimage.jpg" id = "homeimage"/>
	<span id = "bantitle">Utilizing Data Visualization for Monitoring the Status and Trends
	of Philippine Forests under the National Greening Program</span>
	<span id = "bandes"> Last February 24, 2011, President Benigno S. Aquino initiated the National Greening Program (NGP) in ]
	order to intensify reforestation efforts. Led by the Department of Environment and Natural Resources (DENR), the NGP seeks 
	to plant 1.5 billion trees nationwide.</span>
	<button id = "banbut"> Learn more </button>
</div>

<div id = "funcpart">
	<i class="fa fa-area-chart fa-5x" id="icon"></i>
	<i class="fa fa-map fa-5x" id = "icon"></i>
	<i class="fa fa-arrows fa-5x" id = "icon"></i>
	<span id = "funconehead">Function #1</span>
	<span id = "functwohead">Function #2</span>
	<span id = "functhreehead">Function #3</span>
	<span id = "funconedesc"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
	dolore magna aliqua.</span>
	<span id = "functwodesc"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
	dolore magna aliqua.</span>
	<span id = "functhreedesc"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
	dolore magna aliqua.</span>
</div>

<div id = "appdesc">
	<img src = "img/logo.png" id = "applogo"/>
	<span id = "apphead">iPuno: Web Based Forest Management System</span>
	<span id = "appdescr"> In order to aid the DENR-CAR in the monitoring of the plantations under the NGP, the researchers aim to develop 
	iPuno, a web-based forest management system that utilizes data visualization. Data visualization manipulates pools of data and presents 
	them in non-textual form, which compared to traditional reports, can make patterns, trends and correlations among data easier to understand,
	interpret and analyze. iPuno aims to provide the DENR-CAR with the capability to visually represent data through interactive tables, maps, 
	graphs, and charts with search, filtration and comparison capabilities, along with a standard means of recording and storing data through 
	online forms, and a centralized database for relevant data.</span>
</div>

<div id = "mapdesc">
	<img src = "img/samplemap.png" id = "mapimage" />
	<span id = "mapdescr"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
	dolore magna aliqua.</span>
	<button id = "mapbut"><i class="fa fa-map-o"></i> View Map</button>
</div>

<div id = "footer">
	<img src = "img/logo.png" id = "footerlogo"/>
	<span id = "footertitle"> iPuno </span>
	<span id = "footerdis"> ©2016 iPuno. All rights reserved.
</div>

<div id = "myModal" class = "modal">
	<div class = "modalcontent">
		<span class="close">x</span>
		<?php include 'login.php'?>
	</div>
</div>

<script>
// Get the modal
	var modal = document.getElementById('myModal');

	// Get the button that opens the modal
	var btn = document.getElementById("login");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on the button, open the modal 
	btn.onclick = function() {
		modal.style.display = "block";
	}

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
</script>
