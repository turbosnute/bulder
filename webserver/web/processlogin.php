<?php
    session_start();
    include('config.php');

    # Variable initiation
    if(isset($_POST['pw'])) {
        $pw = $_POST['pw'];
    } else {
        $pw = null;
    }

    if(isset($_POST['mail'])) {
        $mail = $_POST['mail'];
    } else {
        $mail = null;
    }

    if (empty($pw) || empty($mail)) {
        header("Location: login.php");
    } else {
        $pw = md5($pw);
        if (($mail == 'adamondra') && ($pw == $stdpw)) {
            $_SESSION['access'] = 'granted';
            $_SESSION['user_name'] = 'Adam Ondra';
            $_SESSION['user_id'] = 5000000;
            $_SESSION['user_class'] = 'admin';
            header("Location: setup.php");
        } else {
            #
            # Check user db
            #
            include('dbconfig.php');
    
            $query = "SELECT * FROM `bulder`.`bulder_user` WHERE `email` = '$mail' AND `password` = '$pw' LIMIT 1;";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['access'] = 'granted';
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_class'] = $row['user_class'];
                $last_crag_id = intval($row['lastcrag_id']);

                if ($last_crag_id == 0) {
                    $query = "SELECT `crag_id` FROM `bulder`.`bulder_crag` LIMIT 1;";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_assoc($result);
                        $last_crag_id = intval($row['crag_id']);
                    }
                }

                $_SESSION['last_crag_id'] = intval($last_crag_id);
                mysqli_close($conn);
                header("Location: index.php");
            } else {
                header("Location: login.php");
            }
        }
    }
?>
