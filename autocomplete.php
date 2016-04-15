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
	$sql = 'SElECT DISTINCT provinceName from province';
	$key = 'provinceName';
} else if($q == "muni_city") {
	$sql = 'SELECT DISTINCT municipalityName from municipality';
	$key = 'municipalityName';
} else if($q == "cenro") {
	$sql = 'SELECT DISTINCT cenroName from cenro';
	$key = 'cenroName';
} else if($q == "components") {
	$sql = 'SELECT DISTINCT component FROM site';
	$key = 'component';
} else if($q == "species") {
	$sql = 'SELECT DISTINCT commonName FROM species';
	$key = 'commonName';
} else if($q == "commodities") {
	$sql = 'SELECT DISTINCT commodityName FROM commodity';
	$key = 'commodityName';
} else if($q == "orgname") {
	$sql = 'SELECT DISTINCT organizationName FROM organization';
	$key = 'organizationName';
} else if($q == "orgtype") {
	$sql = 'SELECT DISTINCT organizationTypeName FROM organizationtype';
	$key = 'organizationTypeName';
} else if($q == "year") {
	$sql = 'SELECT DISTINCT year FROM site';
	$key = 'year';
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