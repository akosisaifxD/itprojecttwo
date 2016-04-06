<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<style>
	@font-face {
		font-family: raleway;
		src: url(fonts/raleway/Raleway-SemiBold.ttf);
	}

	body #navbar{
		background-color: #208f4d;
		height: 100%;
		width: 100%;
		color: white;
	}
	
	#navstat{
		text-align: center;
		
	}
	
	#stattitle, #stattitle-js{
		cursor: pointer;
		padding: 10%;
		font-family: raleway;
		font-size: 130%;
	}
	
	#stattitle-b{
		cursor: context-menu;
		padding: 10%;
		font-family: raleway;
		font-size: 100%;
		background-color: #267747;
		color: #e0ded8;
	}
	
	#stattitle-cp, #stattitle-o, #stattitle-s, #stattitle-v{
		cursor: pointer;
		padding: 10%;
		font-family: raleway;
		font-size: 90%;
		background-color: #267747;
	}
	
	#decicon{
		float: left;
	}
	
	.current{
		background-color: #25b15e;
	}
	
	.current{
		background-color: #25b15e!important;
	}
</style>

<div id = "navbar">
	<div id = "navstat">
		<?php	
			if(isset($_SESSION['cpage'])){
				if($_SESSION['cpage'] === 'trends'){
					echo "<div id = 'stattitle' class = 'current' onclick = 'trend()'> <i class = 'fa fa-bar-chart fa-2x'> </i> Trends </div>";
				}else{
					echo "<div id = 'stattitle' onclick = 'trend()'> <i class = 'fa fa-bar-chart fa-2x'> </i> Trends </div>";
				}
				
				if($_SESSION['cpage'] === 'journals'){
					echo "<div id = 'stattitle-js' class = 'current' onclick = 'journal()'> <i class = 'fa fa-book fa-2x'> </i> Journals </div>";
				}else{
					echo "<div id = 'stattitle-js' onclick = 'journal()'> <i class = 'fa fa-book fa-2x'> </i> Journals </div>";
				}
				
				echo "<div id = 'stattitle-b'> ADD </div>";
				
				if($_SESSION['cpage'] === 'cperson'){
					echo "<div id = 'stattitle-cp' class = 'current' onclick = 'cperson()'> <i class = 'fa fa-user-plus fa-2x' id = 'decicon'></i> Contact Person </div>";
				}else{
					echo "<div id = 'stattitle-cp' onclick = 'cperson()'> <i class = 'fa fa-user-plus fa-2x' id = 'decicon'></i> Contact Person </div>";
				}
				
				if($_SESSION['cpage'] === 'organization'){
					echo "<div id = 'stattitle-o' class = 'current' onclick = 'org()'> <i class = 'fa fa-users fa-2x' id = 'decicon'></i> Organization </div>";
				}else{
					echo "<div id = 'stattitle-o' onclick = 'org()'> <i class = 'fa fa-users fa-2x' id = 'decicon'></i> Organization </div>";
				}
				
				if($_SESSION['cpage'] === 'site'){
					echo "<div id = 'stattitle-s' class = 'current' onclick = 'site()'> <i class = 'fa fa-map-marker fa-2x' id = 'decicon'></i> Site </div>";
				}else{
					echo "<div id = 'stattitle-s' onclick = 'site()'> <i class = 'fa fa-map-marker fa-2x' id = 'decicon'></i> Site </div>";
				}
				
				if($_SESSION['cpage'] === 'validation'){
					echo "<div id = 'stattitle-v' class = 'current' onclick = 'validation()'> <i class = 'fa fa-check-circle-o fa-2x' id = 'decicon'></i> Validation </div>";
				}else{
					echo "<div id = 'stattitle-v' onclick = 'validation()'> <i class = 'fa fa-check-circle-o fa-2x' id = 'decicon'></i> Validation </div>";
				}
			}
		?>
		
	</div>
</div>

<script type = "text/javascript">

	function trend(){
		$.ajax({
			url: "holder.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="holder.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}

	function journal(){
		$.ajax({
			url: "hjournal.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hjournal.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
	
	function cperson(){
		$.ajax({
			url: "hcperson.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hcperson.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}

	function org(){
		$.ajax({
			url: "horg.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="horg.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
	
	function site(){
		$.ajax({
			url: "hsite.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hsite.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
	
	function validation(){
		$.ajax({
			url: "hvalidation.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hvalidation.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
</script>
