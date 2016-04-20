<link href='css/viewdpersonnel.css' rel='stylesheet' type='text/css'>

<div id = "theader"> View Color Codes</div>
<div id = "thint"> Press Ctrl+F to Search for Color Code </div>
<div id = "tablediv">
	<hr id="jshr">
	<?php
		include 'connect.php';
		
		$sqlcount = 0;
		
		$years = array();
		$colors = array();
		
		$sql = "SELECT year, color FROM colorcodes ORDER BY year";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$years[$sqlcount] = $row['year'];
				$colors[$sqlcount] = $row['color'];
				$sqlcount++;
			}
		} else {
			echo "0 results";
		}
		
		echo "<table id = 'viewtable'>";
		echo "<tr>";
		echo "<th id = 'tableheaders'> # </th>";
		echo "<th id = 'tableheaders'> Year </th>";
		echo "<th id = 'tableheaders'> Color Hex Code </th>";
		echo "<th id = 'tableheaders'> Color </th>";
		echo "</tr>";
		for($i = 0; $i < sizeof($years); $i++){
			echo "<tr>";
			echo "<td id = 'tablecontents'>" . ($i + 1) . "</td>";
			echo "<td id = 'tablecontents'>" . $years[$i] . "</td>";
			echo "<td id = 'tablecontents'>" . $colors[$i] . "</td>";
			echo "<td id = 'tablecontents' style='background-color:" . $colors[$i] ."'></td>";
			echo "</tr>";
		}
		echo "</table>";
	?>
	<hr id="jshr">
</div>