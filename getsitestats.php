<?php
ini_set('memory_limit', '1028M');
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

mysqli_select_db($conn,"ipuno");
$sql="SELECT site.year, province.provinceName, colorcodes.color
FROM 
site
INNER JOIN municipality ON site.municipalityID = municipality.municipalityID
INNER JOIN province ON municipality.provinceID = province.provinceID
INNER JOIN colorcodes ON site.year = colorcodes.year
WHERE site.siteID NOT LIKE '%ring%'";
$result = mysqli_query($conn,$sql);
$rows = array();
while($r = mysqli_fetch_assoc($result)) {
    $rows[] = $r;
}
echo json_encode($rows);
?>