<?php
    $servername = "bulder-db";
    $username = "root";
    $password = "asijsadijodaijodsai";
    $dbname = "bulder";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    //echo "db connection ok<br />";

    
?>