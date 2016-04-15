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
$sql="select 
    site.siteID, startDate, commonname, quantity
from
    site
        inner join
    validation ON site.sitecode = validation.sitecode
        inner join
    tree ON tree.validationID = validation.validationID
        inner join
    species ON species.speciesID = tree.speciesID
order by 1	";
$result = mysqli_query($conn,$sql);
$rows = array();
while($r = mysqli_fetch_assoc($result)) {
    $rows[] = $r;
}
echo json_encode($rows);

?>