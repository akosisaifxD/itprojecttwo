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
    $query = $db->query("SELECT IF(suffix = '', concat(firstName, ' ', lastName), concat(firstName, ' ', lastName, ' ', suffix)) as 'contactPersonName' FROM contactperson WHERE concat(firstName, ' ', lastName, ' ', suffix) LIKE '%".$searchTerm."%' AND active = 1 ORDER BY firstName ASC");
    while ($row = $query->fetch_assoc()) {
        $data[] = $row['contactPersonName'];
    }
    
    //return json data
    echo json_encode($data);
?>