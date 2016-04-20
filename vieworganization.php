<link href='css/viewdpersonnel.css' rel='stylesheet' type='text/css'>

<div id = "theader"> View Organization</div>
<div id = "thint"> Press Ctrl+F to Search for Organization </div>
<div id = "tablediv">
	<hr id="jshr">
	<?php
		include 'connect.php';
		
		$sqlcount = 0;
		
		$orgnames = array();
		$orgtypes = array();
		
		$sql = "SELECT organizationName, organizationtype.organizationTypeName FROM organization INNER JOIN organizationtype ON organizationtype.organizationTypeID = organization.organizationTypeID ORDER BY organizationName";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				$orgnames[$sqlcount] = $row['organizationName'];
				$orgtypes[$sqlcount] = $row['organizationTypeName'];
				$sqlcount++;
			}
		} else {
			echo "0 results";
		}
		
		echo "<table id = 'viewtable'>";
		echo "<tr>";
		echo "<th id = 'tableheaders'> # </th>";
		echo "<th id = 'tableheaders'> Organization Name </th>";
		echo "<th id = 'tableheaders'> Organization Type </th>";
		echo "</tr>";
		for($i = 0; $i < sizeof($orgnames); $i++){
			echo "<tr>";
			echo "<td id = 'tablecontents'>" . ($i + 1) . "</td>";
			echo "<td id = 'tablecontents'>" . $orgnames[$i] . "</td>";
			echo "<td id = 'tablecontents'>" . $orgtypes[$i] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	?>
	<hr id="jshr">
</div>