<?php
	
 	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "ipuno";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
    echo "<thead>";
	echo " <tr>";
    echo "<th>Species</th>";
    echo "<th>Quantity</th>";
    echo "<th>Height</th>";
    echo "<th>Diameter</th>";
	echo "</tr>";
    echo "</thead>";
    
    
	$speciesID = array();
	$validationID = array();
	$commonName = array();
	$quantity = array();
	$height = array();
	$diameter = array();
 	$siteCode = $_GET['id'];
 	$sql = "SELECT * FROM validation WHERE siteCode='".$siteCode."' order by startDate desc limit 1" ;
	
	
 	$result = $conn->query($sql);
 	while($row = $result->fetch_assoc()) {

       array_push($validationID, $row["validationID"]);
       
    }
	
  for ($x=0; $x < count($validationID); $x++) { 
 	
  
    $sql = "Select * from tree join Species using(speciesID) where validationID = ".$validationID[$x];
    $result = $conn->query($sql);
    while($row2 = $result->fetch_assoc()){
		array_push($speciesID, $row2["speciesID"]);
    	array_push($commonName, $row2["commonName"]);
    	array_push($quantity, $row2["quantity"]);
    	array_push($height, $row2["height"]);
    	array_push($diameter, $row2["diameter"]);
    }
 

    for ($i=0; $i < count($commonName); $i++) { 
		echo "<tr>";
        echo "<td><input type=text name=species[] id='spf' class = 'spf' value='".$commonName[$i]."' required></input> </td> ";
        echo "<td><input type=text name=quantity[] id='qf' value=$quantity[$i] maxlength=40></input> </td>";
        echo "<td><input type=text name=height[] id='hf' value=$height[$i] maxlength=40></input> </td> ";
        echo "<td><input type=text name=diameter[] id='df' value=$diameter[$i] maxlength=40></input> </td>";
        echo "<td><button type=button id=removeRow>Remove</button></td>";
        echo "</tr>";
        
	}
	
    echo "<tbody>";
    echo "</tbody>";
  }
$conn->close();
?>

<script>

</script>
