<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">

    <title>Index</title>

    <!-- Bootstrap CSS -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />    
    <!-- full calendar css-->
    <link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
  <link href="assets/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" />
    <!-- easy pie chart-->
    <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <!-- owl carousel -->
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">
  <link href="css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <!-- Custom styles -->
  <link rel="stylesheet" href="css/fullcalendar.css">
  <link href="css/widgets.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
  <link href="css/xcharts.min.css" rel=" stylesheet"> 
  <link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <script src="js/lte-ie7.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="css/map.css" type="text/css">
    
	<script type="text/javascript" src="https://www.google.com/jsapi?autoload= 
	{'modules':[{'name':'visualization','version':'1.0','packages':
	['corechart', 'table', 'controls']}]}"></script>
    <link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.css">
    <script type="text/javascript" src="jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
    <script type="text/javascript" src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
    <title>iPuno</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" media="screen and (min-width:320px) and (max-width:480px)" href="css/map-responsive.css" />
</head>

<body>

      <header class="header dark-bg">

           <!--logo start-->
            <a href="home.php" class="logo"><img src = "img/logos/whiteinlogo.png" id="weblogo"> i<span class="lite">PUNO</span></a>
            <!--logo end-->
			
			<div class="top-nav notification-row">                
                <span class="lite"><a class="btn btn-success" title="Bootstrap 3 themes generator" id="loginButton" href="">
                					<span class="icon_lock_alt"></span> 
                					Login
                				   </a>
                </span>
            </div>

      </header>      
      <!--header end-->

    <!--main content start-->
	
	<div id="mapnavigation">
		<button type="submit" class="btn btn-success" id="SearchDivButton">Search and Filter</button>
		<button type="submit" class="btn btn-success" id="legendButton">Legend</button>
		<button type="submit" class="btn btn-success" id="sliderDivButton">Year Filter</button>
		<button type="submit" class="btn btn-success" id="resetButton">Reset</button>
	</div>
	
    <div id="map"></div>
    <div id="buttons"></div>
    <div id="lots"></div>
    <div id="info_div"></div>
	
	<div id="hide1">
	<div id="legend_div">
		<p>Map Legend</p>
	</div>
	</div>
	
	<div id="hide2">
    <div id="slider_div">
        <button type="button" id="animatebtn"><img src='flatfiles/play.png'/></button>
        <!--<button type="button" id="pausebtn"><img src='flatfiles/pause.png'/></button>-->
        <div id="slider-range" style="width: 50%;"></div>
    </div>
	</div>
	
	<div id="hide3" class="searchFilter">
	<div id="dragTab">
    <div id="search_div">
        <img src='flatfiles/search.png' id='searchheader'/>
        <select id="search_choices" onchange='getAutoComplete(this.value);'>
		  <option value = "province">Province</option>
		  <option value = "muni_city">Municipality or City</option>
		  <option value = "cenro">CENRO</option>
		  <option value = "components">Components</option>
		  <option value = "zone">Zone</option>
		  <option value = "species">Species</option>
		  <option value = "commodities">Commodity</option>
		  <option value = "orgname">Organization Name</option>
		  <option value = "orgtype">Type of Organization</option>
		</select>

        <input type="text" id="search_val" placeholder="Enter Search Item..."></input>
		
        <button id="searchbtn" class="searchButtonMain" onclick="search();">Search</button>
		
				<!-- Trigger/Open The Modal -->
		<button id="advbtn" class="searchButtonMain">Advanced Filter</button>
    </div>
	</div>
	
    <ul class="tabs" id="tabs_div">
        <li class="tab-link" data-tab="tab-1"><img src='flatfiles/trends.png' /></li>
        <li class="tab-link" data-tab="tab-2"><img src='flatfiles/trees.png' /></li>
        <li class="tab-link" data-tab="tab-3"><img src='flatfiles/compare.png' /></li>
    </ul>
	
    <div id="tab-1" class="tab-content">
        <div id="radio_div">
            <form onchange="changeCategory();">
                <input type="radio" name="chart" value="survivalRate" checked>Survival Rate</input>
                <input type="radio" name="chart" value="growthRate">Growth Rate</input>
				<input type="radio" name="chart" value="maturityRate">Maturity Rate<br/>
            </form>

            <div id='heatmapbtn'><input type='checkbox' id='isHeat' onchange='heatmapChart(this.checked)'>Apply HeatMap</div>
        </div>
        <div id="chart_div"></div>
    </div>
	
    <div id="tab-2" class="tab-content">
        <!--<input type="checkbox" id='isHeat2' onchange='checkRadio(this.checked);'>Heat Map-->
        <div id="filter_div"></div>
        <div id="table_div"></div>
    </div>
	
    <div id="tab-3" class="tab-content">
        <form onchange='changeCompare();'>
            <input type="radio" name="comparecat" value="survivalRate" checked>Survival Rate<br>
			 <input type="radio" name="comparecat" value="growthRate">Growth Rate<br>
            <input type="radio" name="comparecat" value="maturityRate">Maturity Rate
           
        </form>

        <select id="search_area" onchange="getAutoComplete(this.value,'autocomplete');">
			<option value = "province">Province</option>
			<option value = "muni_city">Municipality or City</option>
			<option value = "cenro">CENRO</option>
			<option value = "components">Components</option>
			<option value = "zone">Zone</option>
			<option value = "species">Species</option>
			<option value = "commodities">Commodity</option>
			<option value = "orgname">Organization Name</option>
			<option value = "orgtype">Type of Organization</option>
		</select>
	
        <div id="area1">
            <input type="text" id="val_area1"></input>
            <button id="searchbtn1" class="searchButtonMain" onclick="search1();">Search</button>
            <div id="chart1"></div>
        </div>

        <button id="mergecompare" class="searchButtonMain" onclick="merge();"><img id = 'mergebtn' src='flatfiles/merge.png'/></button>

        <div id="area2">
            <input type="text" id="val_area2"></input>
            <button id="searchbtn2" class="searchButtonMain" onclick="search2();">Search</button>
            <div id="chart2"></div>
        </div>
    </div>
	</div>
	
	<!-- The Modal -->
		<div id="myModal" class="modal" >

		  <!-- Modal content -->
		<div class="modal-content">
		  <div class="modal-header">
			<span class="close">×</span>
			<h2>Advanced Filter</h2>
		  </div>
		  <div class="modal-body" style="overflow:scroll;">
	<!-- MAIN FORM -->
		<!-- YEAR INPUT -->
		<table class="advanceFilterForm" style="width:100%">
		<tr>
			<td>
				<div id="yearContainer">
				<p> Year</p>
				<div class="mid" id="year" style="display: visible;">
					<br><input id="yearInput" placeholder="Search Year...">
			</input> <button id='enterButton' onclick='enter("year");'>Enter</button><br>
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
			</td>
			<!-- END YEAR INPUT -->
			
			<!-- PROVINCE INPUT -->
			<td>
				<div id="provinceContainer">
				<p>Province</p>
				<div class="mid" id="province" style="display: visible;">
					<br><input id="provinceInput" placeholder="Search Province...">
					</input> <button id='enterButton' onclick='enter("province");'>Enter</button><br>
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
			</td>
		</tr>
		<!-- END PROVINCE INPUT -->
		
		<!-- CENRO INPUT -->
		<tr>
			<td>
				<div id="cenroContainer">
				<p>CENRO</p>
				<div class="mid" id="cenro" style="display: visible;">
					<br><input id="cenroInput" placeholder="Search CENRO...">
			</input><button id='enterButton' onclick='enter("cenro");'>Enter</button><br>
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
			</td>
				<!-- END CENRO INPUT -->
				
				<!-- ORGANIZATION INPUT -->
			<td>
				<div id="organizationContainer">
				<p>Organization</p>
				<div class="mid" id="org" style="display: visible;">
					<br><input id="orgnameInput" placeholder="Search Organization...">
			</input> <button id='enterButton' onclick='enter("orgname");'>Enter</button><br>
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
			</td>
		</tr>
		<!-- END ORGANIZATION INPUT -->
		
		<!-- SPECIES INPUT -->
		<tr>
			<td>
				<div id="specieContainer">
				<p>Species</p>
				<div class="mid" id="specie" style="display: visible;">
					<br><input id="speciesInput" placeholder="Search Species...">
					</input> <button id='enterButton' onclick='enter("species");'>Enter</button><br>
			Selected Species:<div id="speciesSelected">
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
			<td>
			<td>
				
			</td>
		</tr>
		</table>
	<!-- END OF MAIN FORM -->  
		  
		</div>
				<div class="modal-footer">
					<h3><button class = "inputButton" onclick="advancedSearch();"> Search </button></h3>
				</div>
		</div>
		</div>
	
    <script src="scripts/script.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyGBTdSmKQ2wq_L0QhV6fZcOLWIO2IbXs&callback=init"></script>



  <!-- container section start -->

    <!-- javascripts -->
    <script src="js/jquery.js"></script>
  <script src="js/jquery-ui-1.10.4.min.js"></script>

    <!-- bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- nice scroll -->
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <!-- charts scripts -->
    <script src="assets/jquery-knob/js/jquery.knob.js"></script>
    <script src="js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="js/owl.carousel.js" ></script>
    <!-- jQuery full calendar -->
    <script src="js/fullcalendar.min.js"></script> <!-- Full Google Calendar - Calendar -->
  <script src="assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
    <!--script for this page only-->
    <script src="js/calendar-custom.js"></script>
  <script src="js/jquery.rateit.min.js"></script>
    <!-- custom select -->
    <script src="js/jquery.customSelect.min.js" ></script>
  <script src="assets/chart-master/Chart.js"></script>
   
    <!--custome script for all page-->
    <script src="js/scripts.js"></script>
    <!-- custom script for this page-->
    <script src="js/sparkline-chart.js"></script>
    <script src="js/easy-pie-chart.js"></script>
  <script src="js/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="js/jquery-jvectormap-world-mill-en.js"></script>
  <script src="js/xcharts.min.js"></script>
  <script src="js/jquery.autosize.min.js"></script>
  <script src="js/jquery.placeholder.min.js"></script>
  <script src="js/gdp-data.js"></script>  
  <script src="js/morris.min.js"></script>
  <script src="js/sparklines.js"></script>  
  <script src="js/charts.js"></script>
  <script src="js/jquery.slimscroll.min.js"></script>
  <script>

      //knob
      $(function() {
        $(".knob").knob({
          'draw' : function () { 
            $(this.i).val(this.cv + '%')
          }
        })
      });

      //carousel
      $(document).ready(function() {
          $("#owl-slider").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });
    
    /* ---------- Map ---------- */
  $(function(){
    $('#map').vectorMap({
      map: 'world_mill_en',
      series: {
        regions: [{
          values: gdpData,
          scale: ['#000', '#000'],
          normalizeFunction: 'polynomial'
        }]
      },
    backgroundColor: '#eef3f7',
      onLabelShow: function(e, el, code){
        el.html(el.html()+' (GDP - '+gdpData[code]+')');
      }
    });
  });



  </script>

  <script>
  //modal script
  // Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("advbtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
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
</body>
