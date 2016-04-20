<link href='css/editvalidation.css' rel='stylesheet' type='text/css'>

<form action="heseedling.php" method="POST">
	<div id = 'vheader'> Search Site Code <input type="submit" value="Submit" class = 'enter'> </div>
	
	<hr id="jshr">
	<div id = 'inputdiv'>
			<div id = 'entersitecode'> Site Code: <input type="text" name="siteCode" id = 'sitecode' /> </div>	
	</div>
	<hr id="jshr">
</form>

<script>
	$(function() {
		$( "#sitecode" ).autocomplete({
			source: 'autocompletesite.php'
		});
	});
</script>