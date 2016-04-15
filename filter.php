<?php
ini_set('memory_limit', '1028M');
$servername = "localhost";
$username = "root";
$password = "";

if(empty($_GET['q'])) {
	$q = "";
} else {
	$q = $_GET['q'];
}

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

mysqli_select_db($conn,"ipuno");
$sql="SELECT site.siteID FROM site 
INNER JOIN siteorganization ON site.siteCode = siteorganization.siteCode
INNER JOIN organization ON siteorganization.organizationID = organization.organizationID
INNER JOIN organizationtype ON organization.organizationTypeID = organizationtype.organizationTypeID
INNER JOIN municipality ON site.municipalityID = municipality.municipalityID
INNER JOIN province ON municipality.provinceID = province.provinceID
INNER JOIN cenromunicipality ON site.municipalityID = cenromunicipality.municipalityID
INNER JOIN cenro ON cenromunicipality.cenroID = cenro.cenroID
LEFT JOIN validation ON validation.siteCode = site.siteCode
LEFT JOIN tree ON validation.validationid = tree.validationid
LEFT JOIN species ON tree.speciesID = species.speciesID
LEFT JOIN speciescommodity ON tree.speciesID = speciescommodity.speciesID
LEFT JOIN commodity ON commodity.commodityID = speciescommodity.commodityID".$q;
$result = mysqli_query($conn,$sql);
$number = mysqli_num_rows($result);
$i = 1;

echo "{";

while($row = $result->fetch_assoc()) {
	if($i < $number) {
		echo '"' . $row["siteID"] . '":"",';
	} else {
		echo '"' . $row["siteID"] . '":""';
	}
	
	$i ++;
	
}

echo "}";

?>