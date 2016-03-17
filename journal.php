<!-- EXTERNAL SCRIPT CALLS -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- END OF EXTERNAL SCRIPT CALLS -->

<link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>

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

	#header{
		border-radius: 25px 0px 0px 0px;
		background-color: #487d65;
		color: white;
		font-size: 170%;
		padding: 1%;
	}
	
	#header header{
		margin-left: 1.2%;
	}
	
	#header #subhead{
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
		width: 55%;
		padding-bottom: 1%;
		text-align: center;
	}
	
	#report{
		resize: none;
	}
	
	#submit{
		width: 20%;
		height: 5%;
	}
</style>

<?php
	session_start();

	if(isset($_POST['siteid'])) {
		$_SESSION['siteid'] = $_POST['siteid'];
		$_SESSION['senderType'] = $_POST['sendertype'];
	}

	$siteid = $_SESSION['siteid'];
	$sendertype = $_SESSION['senderType'];
	
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "newschema";

	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	$contactpersonid;
	
	$sql = "SELECT contactPersonID FROM site WHERE siteID = " . $siteid;
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$contactpersonid = $row["contactPersonID"];
		}
	} else {
		echo "0 results";
	}
	
	$contactperson;
	
	$sql = "SELECT contactPersonName FROM contactperson WHERE contactPersonID = " . $contactpersonid;
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$contactperson = $row["contactPersonName"];
		}
	} else {
		echo "0 results";
	}
?>

<div class = "journals">
	<div id = "jnum1">
		<div id = "header">
			<header> Journal - Site <?php echo $siteid; ?></header><a id = "subhead"><?php echo "Handled by " . $contactperson; ?></a>
		</div>
		<div id = "body">
			<div id = "rephead"> <a>REPORTS</a> </div>
			<?php
				$sendertypes = array();
				$senderids = array();
				$firstcounter = 0;
				
				$sql = "SELECT senderId, senderType FROM journal WHERE siteID = " . $siteid;
				$result = mysqli_query($conn, $sql);

				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						$sendertypes[$firstcounter] = $row["senderType"];
						$senderids[$firstcounter] = $row["senderId"];
						$firstcounter++;
					}
				} else {
					echo "0 results";
				}				
				
				$sendernames = array();
				$secondcounter = 0;
				
				for($i = 0; $i < sizeof($sendertypes); $i++){
					if($sendertypes[$secondcounter] == 0){
							$sql = "SELECT firstName, lastName FROM denr WHERE denrID = " . $senderids[$secondcounter];
							$result = mysqli_query($conn, $sql);
							
							if (mysqli_num_rows($result) > 0) {
								// output data of each row
								while($row = mysqli_fetch_assoc($result)) {
									$sendernames[$secondcounter] = $row['firstName'] . " " . $row['lastName'];
									$secondcounter++;
								}
							} else {
								echo "0 results";
							}
					}
				}
				
				
				
				$sql = "SELECT journalDate, comments, senderID, senderType FROM journal WHERE siteID = " . $siteid;
				$result = mysqli_query($conn, $sql);

				if (mysqli_num_rows($result) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($result)) {
						$thirdcounter = 0;
						
						$date = explode(" ", $row["journalDate"]);
						$datepartition = explode("-", $date[0]);
						$month;
						
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
						
						$finaldate = $month . " " . $datepartition[2] . ", " . $datepartition[0];
						
						echo "<div id = \"repnum\"> <a>" . $finaldate . " by " . $sendernames[$thirdcounter] . "</a></div>";
						echo "<div id = \"repcont\"> <a>" . $row["comments"] . "</a></div>";

					}
				} else {
					echo "0 results";
				}
			?>
		</div>
	</div>
	<div id = "commentbox"><textarea rows = "8" cols = "80" name = "report" id = "report"></textarea></div>
	<div id = "submitbox"><button id = "submit" class = "submit">Submit</button></div>
</div>

<script type="text/javascript">

	$('.submit').on('click',function(){
		
		var textarea = document.getElementById("report").value;
			
		$.ajax({
			url: "journalentry.php",
			type: "POST",
			data: {siteid: "<?php echo $siteid; ?>" , comments: textarea}, // add a flag
			success: function(data, textStatus, jqXHR){
				window.location="journal.php";
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert('Error!')
			}
		});
});

</script>
