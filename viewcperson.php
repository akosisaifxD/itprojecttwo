<link href='css/viewdpersonnel.css' rel='stylesheet' type='text/css'>

<div id = "theader"> View Contact Persons</div>
<div id = "thint"> Press Ctrl+F to Search for Contact Person </div>
<div id = "tablediv">
	<hr id="jshr">
	<?php
		include 'connect.php';
		
		$sqlcount = 0;
		
		$cpids = array();
		$names = array();
		$mobnums = array();
		$telnums = array();
		$emails = array();
		$addresses = array();
		
		$sql = "SELECT contactPersonID, IF(suffix = '', concat(firstName, ' ', lastName), concat(firstName, ' ', lastName, ' ', suffix)) AS 'cPersonName', mobileNumber, telephoneNumber, emailAddress, address FROM contactPerson ORDER BY firstName";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$cpids[$sqlcount] = $row['contactPersonID'];
				$names[$sqlcount] = $row['cPersonName'];
				$mobnums[$sqlcount] = $row['mobileNumber'];
				$telnums[$sqlcount] = $row['telephoneNumber'];
				$emails[$sqlcount] = $row['emailAddress'];
				$addresses[$sqlcount] = $row['address'];
				$sqlcount++;
			}
		} else {
			echo "0 results";
		}
		
		echo "<table id = 'viewtable'>";
		echo "<tr>";
		echo "<th id = 'tableheaders'> # </th>";
		echo "<th id = 'tableheaders'> Contact Person ID </th>";
		echo "<th id = 'tableheaders'> Contact Person Name </th>";
		echo "<th id = 'tableheaders'> Mobile Number </th>";
		echo "<th id = 'tableheaders'> Telephone Number </th>";
		echo "<th id = 'tableheaders'> E-mail Address </th>";
		echo "<th id = 'tableheaders'> Address </th>";
		echo "</tr>";
		for($i = 0; $i < sizeof($cpids); $i++){
			echo "<tr>";
			echo "<td id = 'tablecontents'>" . ($i + 1) . "</td>";
			echo "<td id = 'tablecontents'>" . $cpids[$i] . "</td>";
			echo "<td id = 'tablecontents'>" . $names[$i] . "</td>";
			echo "<td id = 'tablecontents'>" . $mobnums[$i] . "</td>";
			echo "<td id = 'tablecontents'>" . $telnums[$i] . "</td>";
			echo "<td id = 'tablecontents'>" . $emails[$i] . "</td>";
			echo "<td id = 'tablecontents'>" . $addresses[$i] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	?>
	<hr id="jshr">
</div>