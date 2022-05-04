<?php
    session_start();
    session_destroy();

    require_once 'authconf.php';

    // Reset OAuth access token
    $client->revokeToken();
    
    header("Location: login.php");
?>