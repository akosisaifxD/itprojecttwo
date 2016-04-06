<!-- EXTERNAL SCRIPT CALLS -->

	<!-- JQUERY -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->

<!-- EXTERNAL CSS -->

	<!-- CUSTOM FONT - PT Sans -->
	<link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>

<!-- END OF EXTERNAL CSS -->

<!-- INTERNAL CSS -->

<style>

	body{
		font-family: 'PT Sans', sans-serif;
	}

	#jnum1{
		border-radius: 25px 25px 0px 0px;
		background-color: #efefef;
		width: 55%;
		padding-bottom: 3%;
	}

	#jsheader{
		border-radius: 25px 0px 0px 0px;
		background-color: #487d65;
		color: white;
		font-size: 170%;
		padding: 1%;
	}
	
	#jsheader header{
		margin-left: 1.2%;
	}
	
	#jsheader #subhead{
		margin-left: 1.2%;
		font-size: 60%;
	}
	
	#rephead{
		background-color: #49b382;
		padding: 0.5%;
		text-align: center;
	}
	
	#rephead a {
		margin-left: 1.2%;
		color: white;
	}
	
	#repnum{
		border-radius: 25px 25px 0px 0px;
		background-color: #d5d7de;
		padding: 2%;
		margin-top: 2%;
		margin-left: 2%;
		width: 90%;
	}
	
	#repcont{
		border-radius: 0px 0px 25px 25px;
		padding: 2%;
		background-color: white;
		margin-left: 2%;
		width: 90%;
	}
	
	#commentbox{
		background-color: #d5d7de;
		width: 53.8%;
		padding: 0.6%;
		text-align: center;
	}
	
	#submitbox{
		background-color: #d5d7de;
		width: 54.95%;
		padding-bottom: 1%;
		text-align: center;
	}
	
	#previousbox{
		background-color: #d5d7de;
		width: 52.95%;
		padding-bottom: 1%;
		text-align: right;
		padding-right: 2%;
	}
	
	#report{
		resize: none;
	}
	
	#submit{
		width: 20%;
		height: 5%;
	}

	#bodyrep{
		width: 100%;
		height: 70%;
		overflow: scroll;
	}
	
	</style>

<!-- END OF INTERNAL CSS -->

<!-- PHP Script which captures contact person ID and contact person name -->
<?php
if(!isset($_SESSION)){
    session_start();
}
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
	<div id = "jnum1">
		<div id = "jsheader">
			<!-- Header which uses PHP code to display siteID and contact person -->
			<header> Journal - Site <?php echo $sitecode; ?></header><a id = "subhead"><?php echo "Handled by " . $contactperson; ?></a>
		</div>
		<div id = "body">
			<div id = "rephead"> <a>REPORTS</a> </div>
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
						

						
						//display formatted date together with contact person
						echo "<div id = \"repnum\"> <a>" . $finaldate . " by " . $sendername . "</a></div>";
						//display journal content
						echo "<div id = \"repcont\"> <a>" . $row["comments"] . "</a></div>";
					}
				} else {
				}
			?>
			</div>
		</div>
	</div>
	<div id = "commentbox"><textarea rows = "8" cols = "80" name = "report" id = "report"></textarea></div>
	<div id = "submitbox"><button id = "submit" class = "submit">Submit</button></div>
	<div id = "previousbox"> <button id="previousbutton" onclick="previous()">Search Again</button></div>
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
	$('.submit').on('click',function(){
		
		var textarea = document.getElementById("report").value;
			
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
		window.location="hjournal.php";
	}
	
</script>

<!-- INTERNAL JAVASCRIPT CODES -->
