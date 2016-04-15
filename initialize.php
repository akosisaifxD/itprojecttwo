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
$sql="SELECT site.siteID, site.year, 
coordinates.longitude, 
coordinates.latitude, 
colorcodes.color
FROM 
coordinates INNER JOIN site 
ON site.siteID = coordinates.siteID 
INNER JOIN colorcodes 
ON site.year = colorcodes.year";
$result = mysqli_query($conn,$sql);
$rows = array();
while($r = mysqli_fetch_assoc($result)) {
    $rows[] = $r;
}
echo json_encode($rows);
?>