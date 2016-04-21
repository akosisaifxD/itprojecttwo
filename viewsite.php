<link href='css/viewdpersonnel.css' rel='stylesheet' type='text/css'>

<div id = "theader"> View Sites</div>
<div id = "thint"> Press Ctrl+F to Search for Site </div>
<div id = "tablediv">
	<hr id="jshr">
	<?php
		include 'connect.php';
		
		$sqlcount = 0;
		
		$years = array();
		$cpersons = array();
		$decarea = array();
		$comparea = array();
		$munis = array();
		$zones = array();
		$comps = array();
		$sitecodes = array();
		
		$sql = "SELECT year, IF(contactperson.lastName = '' OR contactperson.lastName IS NULL, contactperson.firstName, IF(contactperson.suffix = '', concat(contactperson.firstName, ' ', contactperson.lastName), concat(contactperson.firstName, ' ', contactperson.lastName, ' ', contactperson.suffix))) as 'contactPerson', 
		declaredArea, computedArea, municipality.municipalityName, zone, component, siteCode FROM site INNER JOIN contactperson ON contactperson.contactPersonID = site.contactPersonID INNER JOIN municipality ON municipality.municipalityID = site.municipalityID WHERE siteCode IS NOT NULL ORDER BY year";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$years[$sqlcount] = $row['year'];
				$cpersons[$sqlcount] = $row['contactPerson'];
				$decarea[$sqlcount] = $row['declaredArea'];
				$comparea[$sqlcount] = $row['computedArea'];
				$munis[$sqlcount] = $row['municipalityName'];
				$zones[$sqlcount] = $row['zone'];
				$comps[$sqlcount] = $row['component'];
				$sitecodes[$sqlcount] = $row['siteCode'];
				$sqlcount++;
			}
		} else {
			echo "0 results";
		}
		
		echo "<table id = 'viewtable'>";
		echo "<tr>";
		echo "<th id = 'tableheaders'> # </th>";
		echo "<th id = 'tableheaders'> Year </th>";
		echo "<th id = 'tableheaders'> Contact Person </th>";
		echo "<th id = 'tableheaders'> Declared Area </th>";
		echo "<th id = 'tableheaders'> Computed Area </th>";
		echo "<th id = 'tableheaders'> Municipality </th>";
		echo "<th id = 'tableheaders'> Zone </th>";
		echo "<th id = 'tableheaders'> Component </th>";
		echo "<th id = 'tableheaders'> Site Code </th>";
		echo "</tr>";
		for($i = 0; $i < sizeof($years); $i++){
			echo "<tr>";
			echo "<td id = 'tablecontents'>" . ($i + 1) . "</td>";
			echo "<td id = 'tablecontents'>" . $years[$i] . "</td>";
			echo "<td id = 'tablecontents'>" . $cpersons[$i] . "</td>";
			echo "<td id = 'tablecontents'>" . $decarea[$i] . "</td>";
			echo "<td id = 'tablecontents'>" . $comparea[$i] . "</td>";
			echo "<td id = 'tablecontents'>" . $munis[$i] . "</td>";
			echo "<td id = 'tablecontents'>" . $zones[$i] . "</td>";
			echo "<td id = 'tablecomp'>" . $comps[$i] . "</td>";
			echo "<td id = 'tablesite'>" . $sitecodes[$i] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	?>
	<hr id="jshr">
</div>