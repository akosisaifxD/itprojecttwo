<link href='css/ccode.css' rel='stylesheet' type='text/css'>

<div id = "ccheader"> Color Code </div>
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
			url: "hnccode.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hnccode.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
	
	function edit(){
		$.ajax({
			url: "hsccode.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hsccode.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
	
	function removex(){
		$.ajax({
			url: "hrccode.php",
			type: "POST",
			data: {}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hrccode.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});	
	}
</script>