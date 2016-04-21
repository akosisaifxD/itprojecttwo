<link href='css/ccode.css' rel='stylesheet' type='text/css'>

<div id = "ccheader"> Site </div>
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
	<div id = "viewcolorcode" onclick = "viewdb()">
		<div id = "logo"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></div>
		<div id = "title">View</div>
	</div>
</div>
<hr id="jshr">

<script>
	function add(){
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
	
	function edit(){
		$.ajax({
			url: "hssite.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hssite.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
	
	function removex(){
		$.ajax({
			url: "hrsite.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hrsite.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
	
	function viewdb(){
		$.ajax({
			url: "hvsite.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hvsite.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
</script>