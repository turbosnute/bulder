<?php
	session_start();
	if ($_SESSION['access'] != 'granted') {
		header("Location: login.php");
	}

    $crag = $_POST['frmCrag'];
    $date = $_POST['frmDate'];
    $grade = $_POST['frmGrade'];
    $style = $_POST['frmStyle'];

    echo "Gym: $crag  Date: $date Grade: $grade Style: $style";


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