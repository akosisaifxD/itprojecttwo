<link href='css/ccode.css' rel='stylesheet' type='text/css'>

<div id = "ccheader"> DENR Personnel </div>
<hr id="jshr">
<div id = "options">
	<div id = "addcolorcode" onclick = "add()">
		<div id = "logo"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></div>
		<div id = "title">Add</div>
	</div>
	<div id = "editcolorcode" onclick = "edit()">
		<div id = "logo"><i class = 'fa fa-pencil fa-2x' aria-hidden="true"></i></div>
		<div id = "title">Edit</div>
	</div>
	<div id = "removecolorcode" onclick = "removex()">
		<div id = "logo"><i class="fa fa-times fa-2x" aria-hidden="true"></i></div>
		<div id = "title">Remove</div>
	</div>
</div>
<hr id="jshr">

<script>
	function add(){
		$.ajax({
			url: "hdpersonnel.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hdpersonnel.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
	
	function edit(){
		$.ajax({
			url: "hsdpersonnel.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hsdpersonnel.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
	
	function removex(){
		$.ajax({
			url: "hrdpersonnel.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hrdpersonnel.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
</script>