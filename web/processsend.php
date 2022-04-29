<?php
	session_start();
	if ($_SESSION['access'] != 'granted') {
		header("Location: login.php");
	}

    function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    $user_id = $_SESSION['user_id'];
    $crag = $_POST['frmCrag'];
    $date = $_POST['frmDate'];
    $grade = $_POST['frmGrade'];
    $style = $_POST['frmStyle'];

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


    $sanitized_crag = mysqli_real_escape_string($conn, $crag);
    $sanitized_date = mysqli_real_escape_string($conn, $date);
    $sanitized_style = mysqli_real_escape_string($conn, $style);
    $sanitized_grade = mysqli_real_escape_string($conn, $grade);

    $query = "INSERT INTO `bulder`.`bulder_send` (`user_id`, `crag_id`, `style`, `grade`, `date`) VALUES ($user_id, '$sanitized_crag', '$sanitized_style', '$sanitized_grade', '$sanitized_date');";
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