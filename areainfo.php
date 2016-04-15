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
$sql="SELECT 
Site.siteid, 
province.provincename, 
municipality.municipalityname, 
organization.organizationname, 
site.declaredarea, 
site.computedarea, 
site.zone, 
site.component,
barangay.barangayname,
cenro.cenroName   
FROM site 
INNER JOIN siteorganization ON site.siteCode = siteorganization.siteCode
INNER JOIN organization ON siteorganization.organizationID = organization.organizationID
INNER JOIN organizationtype ON organization.organizationTypeID = organizationtype.organizationTypeID
INNER JOIN municipality ON site.municipalityID = municipality.municipalityID
INNER JOIN sitebarangay ON site.siteCode = sitebarangay.siteCode
INNER JOIN barangay ON sitebarangay.barangayID = barangay.barangayID
INNER JOIN province ON municipality.provinceID = province.provinceID
INNER JOIN cenromunicipality ON site.municipalityID = cenromunicipality.municipalityID
INNER JOIN cenro ON cenromunicipality.cenroID = cenro.cenroID
WHERE  site.siteid =".$q;
$result = mysqli_query($conn,$sql);
$rows = array();
while($r = mysqli_fetch_assoc($result)) {
    $rows[] = $r;
}
echo json_encode($rows);

?>