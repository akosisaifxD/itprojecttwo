<!-- EXTERNAL SCRIPT CALLS -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->

<!-- HTML CONTENT -->

<div id = "search">
	<select id = "searchbytype">
		<option value = "SiteCode"> Site Code </option>
		<option value = "Organization"> Organization </option>
		<option value = "Municipality"> Municipality </option>
	</select>
	<input type = "text" id = "searchbox"></input>
	<button class = "enter">Search</button>
</div>
<div id = "results">
</div>

<!-- END OF HTML CONTENT -->

<!-- JAVASCRIPT CODES -->
<script type="text/javascript">

	$('.enter').on('click',function(){
		
		var searchoption = document.getElementById("searchbytype").value;
		
		if(searchoption === "SiteCode"){
			
			var value = document.getElementById("searchbox").value;
			
			$.ajax({
				url: "journal.php",
				type: "POST",
				data: {siteid:value, sendertype: 0}, // add a flag
				success: function(data, textStatus, jqXHR){
					window.location="journal.php";
				},
				error: function (jqXHR, textStatus, errorThrown){
					alert('Error!')
				}
			});	
		}
});

</script>
<!-- END OF JAVASCRIPT CODES -->
