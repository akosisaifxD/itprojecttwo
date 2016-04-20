<link href='css/viewdpersonnel.css' rel='stylesheet' type='text/css'>

<div id = "theader"> View DENR Personnels</div>
<div id = "thint"> Press Ctrl+F to Search for DENR Personnel </div>
<div id = "tablediv">
	<hr id="jshr">
	<?php
		include 'connect.php';
		
		$sqlcount = 0;
		
		$denrids = array();
		$names = array();
		$emails = array();
		$cenronames = array();
		
		$sql = "SELECT denrID, concat(firstName, ' ', lastName) as 'denrName', email, cenro.cenroName FROM denr INNER JOIN cenro ON cenro.cenroID = denr.cenroID ORDER BY concat(firstName, ' ', lastName)";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$denrids[$sqlcount] = $row['denrID'];
				$names[$sqlcount] = $row['denrName'];
				$emails[$sqlcount] = $row['email'];
				$cenronames[$sqlcount] = $row['cenroName'];
				$sqlcount++;
			}
		} else {
			echo "0 results";
		}
		
		echo "<table id = 'viewtable'>";
		echo "<tr>";
		echo "<th id = 'tableheaders'> # </th>";
		echo "<th id = 'tableheaders'> DENR ID </th>";
		echo "<th id = 'tableheaders'> DENR Name </th>";
		echo "<th id = 'tableheaders'> E-mail Address </th>";
		echo "<th id = 'tableheaders'> CENRO </th>";
		echo "</tr>";
		for($i = 0; $i < sizeof($denrids); $i++){
			echo "<tr>";
			echo "<td id = 'tablecontents'>" . ($i + 1) . "</td>";
			echo "<td id = 'tablecontents'>" . $denrids[$i] . "</td>";
			echo "<td id = 'tablecontents'>" . $names[$i] . "</td>";
			echo "<td id = 'tablecontents'>" . $emails[$i] . "</td>";
			echo "<td id = 'tablecontents'>" . $cenronames[$i] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	?>
	<hr id="jshr">
</div>