<?php
    $servername = "bulder-db";
    $username = "root";
    $password = "asijsadijodaijodsai";

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }
?>