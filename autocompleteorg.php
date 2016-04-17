<?php
    //database configuration
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'ipuno';
    
    //connect with the database
    $db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
    
    //get search term
    $searchTerm = $_GET['term'];
    
    //get matched data from skills table
    $query = $db->query("SELECT organizationName FROM organization WHERE organizationName LIKE '%".$searchTerm."%' AND active = 1 ORDER BY organizationName ASC");
    while ($row = $query->fetch_assoc()) {
        $data[] = $row['organizationName'];
    }
    
    //return json data
    echo json_encode($data);
?>