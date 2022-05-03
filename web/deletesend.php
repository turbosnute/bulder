<?php
	session_start();
    if (isset($_SESSION['access'])) {
        if ($_SESSION['access'] == 'granted') {
            $access = 'granted';
        }
    } else {
        $access = $null;
    }

    if ($access != 'granted') {
	  header("Location: login.php?msg=notgranted");
	}



    $send_id = $_GET['sendId'];
    $user_id = $_SESSION['user_id'];

    if (isset($send_id) && (is_int(intval($send_id)))) {

        include('dbconfig.php');
        $query = "SELECT * FROM `bulder`.bulder_send WHERE `send_id` = '$send_id' AND `user_id` = '$user_id' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 1) {
            // send is owned by user.
            $query = "DELETE FROM `bulder`.bulder_send WHERE `send_id` = '$send_id' AND `user_id` = '$user_id' LIMIT 1";
            $result = mysqli_query($conn, $query);
        } else {
            die("something went wrong");
        }
        mysqli_close($conn);
    } else {
        //header("Location: index.php?msg=invalid");
        //die("derp");
    }
    header("Location: index.php");
?>