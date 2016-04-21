<link href='css/ccode.css' rel='stylesheet' type='text/css'>

<div id = "ccheader"> Tree Validation </div>
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
	</div>
</div>
<hr id="jshr">

<script>
	function add(){
		$.ajax({
			url: "hnvalidation.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hnvalidation.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
	
	function edit(){
		$.ajax({
			url: "hsvalidation.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hsvalidation.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
</script>