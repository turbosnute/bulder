<?php
    session_start();
    $pw = $_POST['pw'];
    $user = $_POST['user'];

    if (empty($pw) || empty($user)) {
        header("Location: login.php");
    } else {
        if (($user === 'adamondra') && (md5($pw) === '460aeae04d42d43cf8a7ca23f80ce781')) {
            $_SESSION['access'] = 'granted';
            header("Location: index.php");
        }
    }
?>