<link href='css/ccode.css' rel='stylesheet' type='text/css'>

<div id = "addcolorcode" onclick = "add()">
	<div id = "logo"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></div>
	<div id = "title">Add Color Code</div>
</div>
<div id = "editcolorcode">
	<div id = "logo"><i class = 'fa fa-pencil fa-2x' aria-hidden="true"></i></div>
	<div id = "title">Edit Color Code</div>
</div>

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
</script>