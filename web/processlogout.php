<?php
    session_start();
    $_SESSION['access'] = 'loggedout';
    $_SESSION['user_name'] = '';
    $_SESSION['user_id'] = '';
    header("Location: login.php");
?>