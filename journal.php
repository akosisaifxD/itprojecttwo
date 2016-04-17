<!-- EXTERNAL SCRIPT CALLS -->

	<!-- JQUERY -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->

<!-- EXTERNAL CSS -->

	<!-- CUSTOM FONT - PT Sans -->
	<link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
	<link href='css/journal.css' rel='stylesheet' type='text/css'>
<!-- END OF EXTERNAL CSS -->

<!-- PHP Script which captures contact person ID and contact person name -->
<?php
	//connect to database using external PHP file
	include 'connect.php';
	
	//local variable to store contact person ID
	$contactpersonid = "";
	
	//SQL Query which captures ID of contact person using 'siteCode' from POST data
	$sql = "SELECT contactPersonID FROM site WHERE siteCode = \"" . $sitecode . "\"";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			//stores captured ID from query onto local variable
			$contactpersonid = $row["contactPersonID"];
		}
	} else {
		//do nothing
	}
	
	//local variable to store contact person name
	$contactperson;
	
	//SQL Query which captures name of contact person using local variable which has the value of the ID of contact person
	$sql = "SELECT contactPersonName FROM contactperson WHERE contactPersonID = \"" . $contactpersonid . "\"";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			//stores captured name from query onto local variable
			$contactperson = $row["contactPersonName"];
		}
	} else {
		//do nothing
	}
?>

<!-- HTML Content -->

<div class = "journals">
	<div id = "jnum1">
		<div id = "jsheader">
			<!-- Header which uses PHP code to display siteID and contact person -->
			<header> Journal - Site <?php echo $sitecode; ?></header><a id = "subhead"><?php echo "Handled by " . $contactperson; ?></a>
			<button id = "searchagn"> Return </button>
		</div>
		<hr id="jshr">
			<div id ="bodyrep">
			<?php
				//SQL query which retrieves journal information using 'siteid'
				$sql = "SELECT journalDate, comments, sender FROM journal WHERE siteCode = \"" . $sitecode . "\"";
				$result = mysqli_query($conn, $sql);
				
				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_assoc($result)) {
						$thirdcounter = 0;
						
						//parse journalDate to a specific format
						$date = explode(" ", $row["journalDate"]);
						$datepartition = explode("-", $date[0]);
						$month;
						
						//convert number formatted months into words
						if($datepartition[1] == 1){
							$month = "January";
						}
						if($datepartition[1] == 2){
							$month = "February";
						}
						if($datepartition[1] == 3){
							$month = "March";
						}
						if($datepartition[1] == 4){
							$month = "April";
						}
						if($datepartition[1] == 5){
							$month = "May";
						}
						if($datepartition[1] == 6){
							$month = "June";
						}
						if($datepartition[1] == 7){
							$month = "July";
						}
						if($datepartition[1] == 8){
							$month = "August";
						}
						if($datepartition[1] == 9){
							$month = "September";
						}
						if($datepartition[1] == 10){
							$month = "October";
						}
						if($datepartition[1] == 11){
							$month = "November";
						}
						if($datepartition[1] == 12){
							$month = "December";
						}
						
						//Complete date format (mm, dd, yyyy)
						$finaldate = $month . " " . $datepartition[2] . ", " . $datepartition[0];
						
						$sendername = "";
						
						if (strpos($row['sender'], 'P') !== false) {
							$sqltwo = "SELECT contactPersonName FROM contactperson WHERE contactPersonID = \"" . $row['sender'] . "\"";
							$resulttwo = mysqli_query($conn, $sqltwo);
							
							if (mysqli_num_rows($resulttwo) > 0) {
								// output data of each row
								while($rowtwo = mysqli_fetch_assoc($resulttwo)) {
									$sendername = $rowtwo['contactPersonName'];
								}
							} else {
								//do nothing
							}
						}else{
							$sqltwo = "SELECT firstName, lastName FROM denr WHERE denrID = \"" . $row['sender'] . "\"";
							$resulttwo = mysqli_query($conn, $sqltwo);
							
							if (mysqli_num_rows($resulttwo) > 0) {
								// output data of each row
								while($rowtwo = mysqli_fetch_assoc($resulttwo)) {
									//stores captured name from query onto local variable
									$sendername = $rowtwo['firstName'] . " " . $rowtwo['lastName'];
								}
							} else {
								//do nothing
							}
						}
						
						if($row['sender'] === $senderid){
							echo "<div id = \"repnumself\"> <a>" . $finaldate . " by " . $sendername . "</a></div>";
							echo "<div id = \"repcontself\"> <a>" . $row["comments"] . "</a></div>";
						}else{
							echo "<div id = \"repnum\"> <a>" . $finaldate . " by " . $sendername . "</a></div>";
							echo "<div id = \"repcont\"> <a>" . $row["comments"] . "</a></div>";
						}
					}
				} else {
				}
			?>
			</div>
			<hr id="jshr">
		</div>
	</div>
	<form action = "journalentry.php" method = "POST" enctype="multipart/form-data">
		<input type = "hidden" id = "sitecode" name = "sitecode" value = "<?php echo $sitecode;?>"/>
		<input type = "hidden" id = "senderid" name = "senderid" value = "<?php echo $senderid;?>"/>
		<div id = "commentbox"><textarea rows = "8" cols = "80" name = "comments" id = "report"></textarea></div>
		<div id = "submitbox"><input type="file" name="imageupload[]" id="imageupload" multiple><input type = "submit" id = "submit" class = "submit" value = "Submit" /></div>
	</form>
</div>
<hr id="jshr">

<!-- END OF HTML Content -->

<!-- INTERNAL JAVASCRIPT CODES -->

<script type="text/javascript">
	var elem = document.getElementById('bodyrep');
	elem.scrollTop = elem.scrollHeight;
	
	//submit journal entry and update database through external php file
	/*
	$('.submit').on('click',function(){
		
		var textarea = document.getElementById("report").value;
			
		$.ajax({
			url: "journalentry.php",
			type: "POST",
			data: {sitecode: "<?php echo $sitecode;?>" , senderid: "<?php echo $senderid;?>",comments: textarea}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="hjournalr.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});
	});
	*/
	
	$('#searchagn').on('click',function(){
		window.location="hjournal.php";
	});
	
</script>

<!-- INTERNAL JAVASCRIPT CODES -->
