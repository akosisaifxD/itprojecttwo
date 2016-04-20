<link href='css/viewdpersonnel.css' rel='stylesheet' type='text/css'>

<div id = "theader"> View CENRO</div>
<div id = "thint"> Press Ctrl+F to Search for CENRO </div>
<div id = "tablediv">
	<hr id="jshr">
	<?php
		include 'connect.php';
		
		$sqlcount = 0;
		
		$cenros = array();
		
		$sql = "SELECT cenroName FROM cenro ORDER BY cenroName";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$cenros[$sqlcount] = $row['cenroName'];
				$sqlcount++;
			}
		} else {
			echo "0 results";
		}
		
		echo "<table id = 'viewtable'>";
		echo "<tr>";
		echo "<th id = 'tableheaders'> # </th>";
		echo "<th id = 'tableheaders'> CENRO Name </th>";
		echo "</tr>";
		for($i = 0; $i < sizeof($cenros); $i++){
			echo "<tr>";
			echo "<td id = 'tablenum'>" . ($i + 1) . "</td>";
			echo "<td id = 'tablecontents'>" . $cenros[$i] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	?>
	<hr id="jshr">
</div>