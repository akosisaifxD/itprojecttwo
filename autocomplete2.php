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

$sql = "";
if($q == "province") {
	$sql = 'SElECT DISTINCT provinceName from province ORDER BY 1';
	$key = 'provinceName';
} else if($q == "muni_city") {
	$sql = 'SELECT DISTINCT municipalityName from municipality ORDER BY 1';
	$key = 'municipalityName';
} else if($q == "cenro") {
	$sql = 'SELECT DISTINCT cenroName from cenro ORDER BY 1';
	$key = 'cenroName';
} else if($q == "components") {
	$sql = 'SELECT DISTINCT component FROM site ORDER BY 1';
	$key = 'component';
} else if($q == "species") {
	$sql = 'SELECT DISTINCT commonName FROM species ORDER BY 1';
	$key = 'commonName';
} else if($q == "commodities") {
	$sql = 'SELECT DISTINCT commodityName FROM commodity ORDER BY 1';
	$key = 'commodityName';
} else if($q == "orgname") {
	$sql = 'SELECT DISTINCT organizationName FROM organization ORDER BY 1';
	$key = 'organizationName';
} else if($q == "orgtype") {
	$sql = 'SELECT DISTINCT organizationTypeName FROM organizationtype ORDER BY 1';
	$key = 'organizationTypeName';
} else if($q == "year") {
	$sql = 'SELECT DISTINCT year FROM site ORDER BY 1';
	$key = 'year';
} else if($q == "vyear") {
	$sql = 'SELECT DISTINCT year(startDate) FROM validation ORDER BY 1';
	$key = 'year(startDate)';
}

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

mysqli_select_db($conn,"ipuno");
$result = mysqli_query($conn,$sql);
$number = mysqli_num_rows($result);
$i = 1;

while($r = $result->fetch_assoc()) {
	if($i < $number) {
		echo $r[$key].',';
	} else {
		echo $r[$key];
	}
	
	$i++;
}

?>