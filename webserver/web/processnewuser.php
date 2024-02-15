<?php
	session_start();
    if (isset($_SESSION['user_class'])) {
        $user_class = $_SESSION['user_class'];
    } else {
        $user_class = null;
    }

	if ($user_class != 'admin') {
		header("Location: login.php");
	}

    #variable initiation
    if (isset($_POST['frmName'])) {
        $name = $_POST['frmName'];
    } else {
        $name = null;
    }

    if (isset($_POST['frmMail'])) {
        $mail = $_POST['frmMail'];
    } else {
        $mail = null;
    }

    if (isset($_POST['frmPw'])) {
        $pw = $_POST['frmPw'];
    } else {
        $pw = null;
    }

    if (isset($_POST['frmAdminUser'])) {
        $adm = $_POST['frmAdminUser'];
    } else {
        $adm = null;
    }

    if ($adm == 'on') {
        $user_class = 'admin';
    } else {
        $user_class = 'user';
    }

    if (empty($name) || empty($mail) || empty($pw)) {
        echo "go back, remember to fill inn all boxes.";
    } else {
        include('dbconfig.php');
        $sanitized_name = mysqli_real_escape_string($conn, $name);
        $sanitized_mail = mysqli_real_escape_string($conn, $mail);
        $hashedpw = md5($pw);

        //convert pw to md5

        $query = "INSERT INTO `bulder`.`bulder_user` (`name`, `email`, `password`, `user_class`) VALUES ('$sanitized_name', '$sanitized_mail', '$hashedpw', '$user_class');";
        $result = mysqli_query($conn, $query);
        mysqli_close($conn);
        header("Location: users.php");
    }
?>