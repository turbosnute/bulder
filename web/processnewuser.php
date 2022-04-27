<?php
	session_start();
	if ($_SESSION['access'] != 'granted') {
		header("Location: login.php");
	}
    $name = $_POST['frmName'];
    $mail = $_POST['frmMail'];
    $pw = $_POST['frmPw'];



    if (empty($name) || empty($mail) || empty($pw)) {
        echo "go back, remember to fill inn all boxes.";
    } else {
        include('dbconfig.php');
        $sanitized_name = mysqli_real_escape_string($conn, $cragName);
        $sanitized_mail = mysqli_real_escape_string($conn, $mail);
        $sanitized_pw = mysqli_real_escape_string($conn, $lat);

        //convert pw to md5

        $query = "INSERT INTO `bulder`.`bulder_user` (`name`, `email`, `password`) VALUES ('$sanitized_name', '$$sanitized_mail', '$sanitized_pw');";
        $result = mysqli_query($conn, $query);
        mysqli_close($conn);
        header("Location: crags.php");
    }
?>