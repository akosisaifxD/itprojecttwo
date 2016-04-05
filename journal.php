<!-- EXTERNAL SCRIPT CALLS -->

	<!-- JQUERY -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->

<!-- EXTERNAL CSS -->

	<!-- CUSTOM FONT - PT Sans -->
	<link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">


<!-- END OF EXTERNAL CSS -->

<!-- INTERNAL CSS -->

	<link rel="stylesheet" type="text/css" href="journal.css">

<!-- END OF INTERNAL CSS -->

<!-- PHP Script which captures contact person ID and contact person name -->
<?php
	session_start();
	
	//connect to database using external PHP file
	include 'connect.php';
	
	//Check if 'siteid' is present in POST data
	if(isset($_POST['sitecode'])) {
		$_SESSION['sitecode'] = $_POST['sitecode'];
	}
	
	//use POST data and set to local PHP Variables
	$sitecode = $_SESSION['sitecode'];
	$sendertype = $_SESSION['sendertype'];
	
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
	<div id = "jrnhead"> Journal </div> 
	<hr id = "hrule">
	<div id = "jnum1">
		<div id = "header">
			<!-- Header which uses PHP code to display siteID and contact person -->
			<div id = "subhead">
				<div id = "addm"><span id = "sh2"><i class="fa fa-book fa-2x"></i> <?php echo $sitecode; ?></span></div>
				<span id = "sh1"><i class="fa fa-user fa-2x"></i> <?php echo $contactperson; ?></span>
			</div>
		</div>
		<div id = "body">
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
						
						if (strpos($row['sender'], 'P') === false) {
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
						}else{
							$sqltwo = "SELECT contactPersonName FROM contactperson WHERE contactPersonID = \"" . $row['sender'] . "\"";
							$resulttwo = mysqli_query($conn, $sqltwo);
							
							if (mysqli_num_rows($resulttwo) > 0) {
								// output data of each row
								while($rowtwo = mysqli_fetch_assoc($resulttwo)) {
									//stores captured name from query onto local variable
									$sendername = $rowtwo['contactPersonName'];
								}
							} else {
								//do nothing
							}
						}
						

						
						//display formatted date together with contact person
						echo "<div id = \"repwhole\"><div id = \"repnum\"> <a>" . $finaldate . " - " . $sendername . "</a></div>";
						//display journal content
						echo "<div id = \"repcont\"> <a>" . $row["comments"] . "</a></div></div>";
					}
				} else {
				}
			?>
			</div>
			<div id = "commentbox"><textarea rows = "4" cols = "90" name = "jrnreport" id = "jrnreport"></textarea><button id = "jrnsubmit" class = "jrnsubmit">Send</button></div>
		</div>
	</div>
</div>

<!-- END OF HTML Content -->

<!-- INTERNAL JAVASCRIPT CODES -->

<?php
	$senderid = $_SESSION['username'];
?>

<script type="text/javascript">
	var elem = document.getElementById('bodyrep');
	elem.scrollTop = elem.scrollHeight;
	
	//submit journal entry and update database through external php file
	$('.jrnsubmit').on('click',function(){
		
		var textarea = document.getElementById("jrnreport").value;
			
		$.ajax({
			url: "journalentry.php",
			type: "POST",
			data: {sitecode: "<?php echo $sitecode;?>" , senderid: "<?php echo $senderid;?>",comments: textarea}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="journal.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});
	});
	
	//function used by previous button
	function previous(){
		window.location="journalsearch.php";
	}
	
</script>

<!-- INTERNAL JAVASCRIPT CODES -->
