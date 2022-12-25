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
        header("Location: login.php");
    }

    function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    # Variable initiation 
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = null;
    }

    if (isset($_POST['frmCrag'])) {
        $crag = $_POST['frmCrag'];
    } else {
        $crag = null;
    }

    if (isset($_POST['frmDate'])) {
        $date = $_POST['frmDate'];
    } else {
        $date = null;
    }

    if (isset($_POST['frmStart'])) {
        $start = $_POST['frmStart'];
    }

    if (isset($_POST['frmEnd'])) {
        $end = $_POST['frmEnd'];
    }

    if (!(validateDate($date, "Y-m-d"))) {
        die("Date should be in 'yyyy-mm-dd' format.");
    }

    if (!(is_int(intval($crag)))) {
        die("Invalid gym.");
    }

    if (!(is_int(intval($user_id)))) {
        die("Invalid user."); 
    }

    if (!(is_int(intval($start)))) {
        die("Invalid start send id.");
    }

    if (!(is_int(intval($end)))) {
        die("Invalid end send id.");
    }

    //echo "Gym: $crag  Date: $date Grade: $grade Style: $style";

    include('dbconfig.php');

    $sanitized_crag = intval(mysqli_real_escape_string($conn, $crag));
    $sanitized_date = mysqli_real_escape_string($conn, $date);
    $sanitized_start = mysqli_real_escape_string($conn, $start);
    $sanitized_end = mysqli_real_escape_string($conn, $end);

    $_SESSION['last_date'] = $sanitized_date;
    $_SESSION['last_crag_id'] = $sanitized_crag;

    $query = "UPDATE `bulder`.`bulder_send` SET `crag_id`='$sanitized_crag', `date`='$sanitized_date' WHERE `send_id`>='$sanitized_start' AND `send_id` <= '$sanitized_end' AND `user_id`='$user_id';";

    //die($query);
    $result = mysqli_query($conn, $query);

    $query = "UPDATE `bulder`.`bulder_user` SET `lastcrag_id`=$sanitized_crag WHERE `user_id`='$user_id';";
    $result = mysqli_query($conn, $query);

    mysqli_close($conn);
    header("Location: index.php");
?>
