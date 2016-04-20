<head>
	<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.0','packages':['corechart', 'table', 'controls']}]}"></script>
    <link rel="stylesheet" href="jquery-ui-1.11.4.custom\jquery-ui.css">
    <script src="jquery-ui-1.11.4.custom\external\jquery\jquery.js"></script>
    <script src="jquery-ui-1.11.4.custom\jquery-ui.js"></script>
	<script src="scripts/dashboard.js"></script>
		<link href='css/ccode.css' rel='stylesheet' type='text/css'>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<style>
  
  .item{
	  height: 100%;
	  width: 90%;
  }
  .carousel {
    position: relative;
    height: 65%;
    width: 90%;
}
.carousel-caption {
    right: 20%;
    left: 20%;
    padding-bottom: 30px;
    color: darkslategray;
    font-size: large;
}
.glyphicon {
    position: relative;
    top: 1px;
    display: inline-block;
    font-family: 'Glyphicons Halflings';
    font-style: normal;
    font-weight: 400;
    line-height: 1;
    color: black;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.carousel-indicators li {
    display: inline-block;
    width: 10px;
    height: 10px;
    margin: 1px;
    text-indent: -999px;
    cursor: pointer;
    background-color: #000\9;
    background-color: rgb(2, 2, 2);
    border: 1px solid #131313;
    border-radius: 10px;
}
.carousel-inner {
    position: relative;
    width: 115%;
    height: 100%;
    overflow: hidden;
}
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
		    margin-top: 0%;
		    margin-bottom: 0%;
		    margin-left: 8%;
			display: block;
		}
		#yearsites {
			height: 95% !important;
			width: 95% !important;
			margin-left: 14%;
		}
		#provincesites{
			height: 90% !important;
			width: 90% !important;
		}
		#treechart{
			height: 100% !important;
			width: 90% !important;
		}

	</style>
</head>

<?php include 'connect.php'?>

<div class = "mainformdiv">
	<div id="ccheader">Dashboard</div>
	<hr id="jshr">
	
	<div id = "repBod">
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

      <div class="item active">
			<div id = "yearsites">
			</div>
        <div class="carousel-caption">
          <h3>Number of NGP Sites by Year</h3>
        </div>
      </div>

      <div class="item">
		<center>
			<div id = "provincesites">
			</div>
		</center>
        <div class="carousel-caption">
          <h3>Total Number Of NGP Sites by Province</h3>
        </div>
      </div>
    
      <div class="item">
		<center>
			<div id = "treechart">
			</div>
		</center>
        <div class="carousel-caption">
          <h3>NGP Site Tree Count</h3>
        </div>
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
	</div>
</div>

<!-- END OF JAVASCRIPT CODES -->