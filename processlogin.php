<?php
    $pw = $_POST['pw'];
    $user = $_POST['user'];


    if (empty($pw) || empty($user)) {
        echo "Empty user or password.";
    } else {
        if (($user === 'adamondra') && (md5($pw) === '460aeae04d42d43cf8a7ca23f80ce781')) {
            echo "authenticated";
        }
    }
?>