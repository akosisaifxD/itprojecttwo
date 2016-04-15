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
$sql="select 
    site.sitecode, site.year, cenro.cenroName, startDate, commonname, quantity, areaValidated
from
    site
		inner join
	municipality ON site.municipalityID = municipality.municipalityID
		inner join
	province ON municipality.provinceID = province.provinceID
		inner join
	cenromunicipality ON municipality.municipalityID = cenromunicipality.municipalityID
		inner join
	cenro ON cenromunicipality.cenroID = cenro.cenroID
        inner join
    siteorganization ON site.sitecode = siteorganization.sitecode
        inner join
    organization ON siteorganization.organizationID = organization.organizationID
    	inner join
    validation ON site.sitecode = validation.sitecode
        inner join
    tree ON tree.validationID = validation.validationID
        inner join
    species ON species.speciesID = tree.speciesID ".$q."order by 1, 4";
$result = mysqli_query($conn,$sql);
$rows = array();
while($r = mysqli_fetch_assoc($result)) {
    $rows[] = $r;
}
echo json_encode($rows);

?>