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
    $query = $db->query("SELECT contactPersonName FROM contactperson WHERE contactPersonName LIKE '%".$searchTerm."%' AND active = 1 ORDER BY contactPersonName ASC");
    while ($row = $query->fetch_assoc()) {
        $data[] = $row['contactPersonName'];
    }
    
    //return json data
    echo json_encode($data);
?>