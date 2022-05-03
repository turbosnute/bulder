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

    if (isset($_POST['frmGrade'])) {
        $grade = $_POST['frmGrade'];
    } else {
        $grade = null;
    }

    if (isset($_POST['frmStyle'])) {
        $style = $_POST['frmStyle'];
    } else {
        $style = null;
    }

    if (isset($_POST['frmSendId'])) {
        $send_id = $_POST['frmSendId'];
    } else {
        $send_id = null;
    }

    if (isset(($_POST['frmIsEdit']))) {
        if($_POST['frmIsEdit'] == "YES") {
            $isedit = true;
        } else {
            $isedit = false;
        }
    } else {
        $isedit = false;
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

    #echo "Gym: $crag  Date: $date Grade: $grade Style: $style";

    include('dbconfig.php');

    $sanitized_crag = intval(mysqli_real_escape_string($conn, $crag));
    $sanitized_date = mysqli_real_escape_string($conn, $date);
    $sanitized_style = mysqli_real_escape_string($conn, $style);
    $sanitized_grade = mysqli_real_escape_string($conn, $grade);
    $sanitized_send_id = mysqli_real_escape_string($conn, $send_id);

    $_SESSION['last_date'] = $sanitized_date;
    $_SESSION['last_crag_id'] = $sanitized_crag;

    if ($isedit) {
        $query = "UPDATE `bulder`.`bulder_send` SET `crag_id`='$sanitized_crag', `style`='$sanitized_style', `grade`='$sanitized_grade', `date`='$sanitized_date' WHERE `send_id`='$sanitized_send_id' AND `user_id`='$user_id';";

    } else {
        $query = "INSERT INTO `bulder`.`bulder_send` (`user_id`, `crag_id`, `style`, `grade`, `date`) VALUES ($user_id, $sanitized_crag, '$sanitized_style', '$sanitized_grade', '$sanitized_date');";
    }
    $result = mysqli_query($conn, $query);

    $query = "UPDATE `bulder`.`bulder_user` SET `lastcrag_id`=$sanitized_crag WHERE `user_id`='$user_id';";
    $result = mysqli_query($conn, $query);

    mysqli_close($conn);
    header("Location: index.php");
/*
    if (empty($name) || empty($mail) || empty($pw)) {
        echo "go back, remember to fill inn all boxes.";
    } else {
        include('dbconfig.php');
        $sanitized_name = mysqli_real_escape_string($conn, $name);
        $sanitized_mail = mysqli_real_escape_string($conn, $mail);
        $hashedpw = md5($pw);

        //convert pw to md5

        $query = "INSERT INTO `bulder`.`bulder_user` (`name`, `email`, `password`) VALUES ('$sanitized_name', '$sanitized_mail', '$hashedpw');";
        $result = mysqli_query($conn, $query);
        mysqli_close($conn);
        header("Location: users.php");
   }
   */
?>