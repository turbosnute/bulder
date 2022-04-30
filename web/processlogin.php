<?php
    session_start();
    $pw = $_POST['pw'];
    $mail = $_POST['mail'];

    if (empty($pw) || empty($mail)) {
        header("Location: login.php");
    } else {
        $pw = md5($pw);
        if (($mail == 'adamondra') && ($pw == '460aeae04d42d43cf8a7ca23f80ce781')) {
            $_SESSION['access'] = 'granted';
            $_SESSION['user_name'] = 'Adam Ondra';
            $_SESSION['user_id'] = 5000000;
            header("Location: index.php");
        } else {
            #
            # Check user db
            #
            include('dbconfig.php');
    
            $query = "SELECT * FROM `bulder`.`bulder_user` WHERE `email` = '$mail' AND `password` = '$pw' LIMIT 1;";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                mysqli_close($conn);
                $_SESSION['access'] = 'granted';
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_id'] = $row['user_id'];
                $last_crag_id = intval($row['last_crag_id']);

                if ($last_crag_id) == 0 {
                    $query = "SELECT crag_id FROM `bulder`.`bulder_crag` LIMIT 1;";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_assoc($result);
                        $last_crag_id = intval($row['lasct_crag_id']);
                    }
                }

                $_SESSION['last_crag_id'] = intval($last_crag_id);

                header("Location: index.php");
            } else {
                header("Location: login.php");
            }
        }
    }
?>