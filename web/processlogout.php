<?php
    session_start();
    $_SESSION['access'] = 'loggedout';
    header("Location: login.php");
?>