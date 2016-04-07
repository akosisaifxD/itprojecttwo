<?php
    //database configuration
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'newschema';
    
    //connect with the database
    $db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
    
    //get search term
    $searchTerm = $_GET['term'];
    
    //get matched data from skills table
    $query = $db->query("SELECT contactPersonName FROM contactperson WHERE contactPersonName LIKE '%".$searchTerm."%' ORDER BY contactPersonName ASC");
    while ($row = $query->fetch_assoc()) {
        $data[] = $row['contactPersonName'];
    }
    
    //return json data
    echo json_encode($data);
?>