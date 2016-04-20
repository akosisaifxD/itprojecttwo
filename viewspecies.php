<link href='css/viewdpersonnel.css' rel='stylesheet' type='text/css'>

<div id = "theader"> View Species</div>
<div id = "thint"> Press Ctrl+F to Search for Species </div>
<div id = "tablediv">
	<hr id="jshr">
	<?php
		include 'connect.php';
		
		$sqlcount = 0;
		
		$snames = array();
		$cnames = array();
		
		$sql = "SELECT speciesName, commonName FROM species ORDER BY commonName";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$snames[$sqlcount] = $row['speciesName'];
				$cnames[$sqlcount] = $row['commonName'];
				$sqlcount++;
			}
		} else {
			echo "0 results";
		}
		
		echo "<table id = 'viewtable'>";
		echo "<tr>";
		echo "<th id = 'tableheaders'> # </th>";
		echo "<th id = 'tableheaders'> Species Name </th>";
		echo "<th id = 'tableheaders'> Common Name </th>";
		echo "</tr>";
		for($i = 0; $i < sizeof($snames); $i++){
			echo "<tr>";
			echo "<td id = 'tablecontents'>" . ($i + 1) . "</td>";
			echo "<td id = 'tablecontents'>" . $snames[$i] . "</td>";
			echo "<td id = 'tablecontents'>" . $cnames[$i] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	?>
	<hr id="jshr">
</div>