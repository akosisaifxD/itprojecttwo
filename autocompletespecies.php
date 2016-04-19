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
    $query = $db->query("SELECT commonName FROM species WHERE commonName LIKE '%".$searchTerm."%' AND active = 1 ORDER BY commonName ASC");
    while ($row = $query->fetch_assoc()) {
        $data[] = $row['commonName'];
    }
    
    //return json data
    echo json_encode($data);
?>