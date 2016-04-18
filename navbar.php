<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<link href='css/navbar.css' rel='stylesheet' type='text/css'>

<div id = "navbar">
	<div id = "navstat">
		<?php	
			if(isset($_SESSION['cpage'])){
				if($_SESSION['cpage'] === 'trends'){
					echo "<div id = 'stattitle' class = 'current' onclick = 'trend()'> <i class = 'fa fa-bar-chart fa-2x'> </i> Trends </div>";
				}else{
					echo "<div id = 'stattitle' onclick = 'trend()'> <i class = 'fa fa-bar-chart fa-2x'> </i> Trends </div>";
				}
				
				if($_SESSION['cpage'] === 'reporting'){
					echo "<div id = 'stattitle-rg' class = 'current' onclick = 'reporting()'> <i class='fa fa-table fa-2x' aria-hidden='true'> </i> Reporting </div>";
				}else{
					echo "<div id = 'stattitle-rg' onclick = 'reporting()'> <i class='fa fa-table fa-2x' aria-hidden='true'> </i> Reporting </div>";
				}
				
				if($_SESSION['cpage'] === 'journals'){
					if(isset($_SESSION['ujcount'])){
						echo "<div id = 'stattitle-js' class = 'current' onclick = 'journal()'> <i class = 'fa fa-book fa-2x'> </i> Journals <div id = 'notifnum'>" . $_SESSION['ujcount'] . "</div></div>";
					}else{
						echo "<div id = 'stattitle-js' class = 'current' onclick = 'journal()'> <i class = 'fa fa-book fa-2x'> </i> Journals </div>";
					}
				}else{
					if(isset($_SESSION['ujcount'])){
						echo "<div id = 'stattitle-js' onclick = 'journal()'> <i class = 'fa fa-book fa-2x'> </i> Journals <div id = 'notifnum'>" . $_SESSION['ujcount'] . "</div></div>";
					}else{
						echo "<div id = 'stattitle-js' onclick = 'journal()'> <i class = 'fa fa-book fa-2x'> </i> Journals </div>";
					}
				}
				
				if($_SESSION['accounttype'] !== 'CPerson'){
					echo "<div id = 'stattitle-b' onclick = 'adminoptions()'> ADMIN TOOLS <i class='fa fa-caret-right fa-2x' aria-hidden='true' id = 'atarrow'></i></div>";
					
					echo "<div id = 'adminsettings'>";
					if($_SESSION['cpage'] === 'colorcode'){
						echo "<div id = 'stattitle-cc' class = 'current' onclick = 'colorcode()'> <i class = 'fa fa-pencil fa-2x' id = 'decicon'></i> Color Code </div>";
					}else{
						echo "<div id = 'stattitle-cc' onclick = 'colorcode()'> <i class = 'fa fa-pencil fa-2x' id = 'decicon'></i> Color Code </div>";
					}
					
					if($_SESSION['cpage'] === 'cperson'){
						echo "<div id = 'stattitle-cp' class = 'current' onclick = 'cperson()'> <i class = 'fa fa-user-plus fa-2x' id = 'decicon'></i> Contact Person </div>";
					}else{
						echo "<div id = 'stattitle-cp' onclick = 'cperson()'> <i class = 'fa fa-user-plus fa-2x' id = 'decicon'></i> Contact Person </div>";
					}
					
					if($_SESSION['cpage'] === 'denrpersonnel'){
						echo "<div id = 'stattitle-dp' class = 'current' onclick = 'denrpersonnel()'> <i class = 'fa fa-user-secret fa-2x' id = 'decicon'></i> DENR Personnel </div>";
					}else{
						echo "<div id = 'stattitle-dp' onclick = 'denrpersonnel()'> <i class = 'fa fa-user-secret fa-2x' id = 'decicon'></i> DENR Personnel </div>";
					}
					
					if($_SESSION['cpage'] === 'organization'){
						echo "<div id = 'stattitle-o' class = 'current' onclick = 'org()'> <i class = 'fa fa-users fa-2x' id = 'decicon'></i> Organization </div>";
					}else{
						echo "<div id = 'stattitle-o' onclick = 'org()'> <i class = 'fa fa-users fa-2x' id = 'decicon'></i> Organization </div>";
					}
					
					if($_SESSION['cpage'] === 'seedling'){
						echo "<div id = 'stattitle-g' class = 'current' onclick = 'seedling()'> <i class='fa fa-tree fa-2x' aria-hidden='true' id = 'decicon'></i> Seedling </div>";
					}else{
						echo "<div id = 'stattitle-g' onclick = 'seedling()'> <i class='fa fa-tree fa-2x' aria-hidden='true' id = 'decicon'></i> Seedling </div>";
					}
					
					if($_SESSION['cpage'] === 'site'){
						echo "<div id = 'stattitle-s' class = 'current' onclick = 'site()'> <i class = 'fa fa-map-marker fa-2x' id = 'decicon'></i> Site </div>";
					}else{
						echo "<div id = 'stattitle-s' onclick = 'site()'> <i class = 'fa fa-map-marker fa-2x' id = 'decicon'></i> Site </div>";
					}
					
					if($_SESSION['cpage'] === 'species'){
						echo "<div id = 'stattitle-sps' class = 'current' onclick = 'site()'> <i class = 'fa fa-leaf fa-2x' id = 'decicon'></i> Species </div>";
					}else{
						echo "<div id = 'stattitle-sps' onclick = 'site()'> <i class = 'fa fa-leaf fa-2x' id = 'decicon'></i> Species </div>";
					}
					
					if($_SESSION['cpage'] === 'validation'){
						echo "<div id = 'stattitle-v' class = 'current' onclick = 'validation()'> <i class = 'fa fa-check-circle-o fa-2x' id = 'decicon'></i> Validation </div>";
					}else{
						echo "<div id = 'stattitle-v' onclick = 'validation()'> <i class = 'fa fa-check-circle-o fa-2x' id = 'decicon'></i> Validation </div>";
					}
					echo "</div>";
				}
			}
		?>
	</div>
</div>

<script type = "text/javascript">
	function adminoptions() {
		document.getElementById("adminsettings").classList.toggle("show");
	}

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
			url: "hcontactperson.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hcontactperson.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}

	function org(){
		$.ajax({
			url: "horganization.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="horganization.php";
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
	
	function seedling(){
		$.ajax({
			url: "hseed.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hseed.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
	
	function reporting(){
		$.ajax({
			url: "hreporting.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hreporting.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
	
	function colorcode(){
		$.ajax({
			url: "hcolorcode.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hcolorcode.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
	
	function denrpersonnel(){
		$.ajax({
			url: "hdenrpersonnel.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hdenrpersonnel.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
</script>