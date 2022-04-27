<?php
	session_start();
	if ($_SESSION['access'] != 'granted') {
		header("Location: login.php");
	}
    $placesKey = $_POST['frmPlacesKey'];
    $googleAuthKey = $_POST['frmGoogleAuthKey'];

    include('dbconfig.php');

    $sanitized_placesKey = mysqli_real_escape_string($conn, $placesKey);
    $sanitized_googleAuthKey = mysqli_real_escape_string($conn, $googleAuthKey);

    #$query = "INSERT INTO `bulder`.`bulder_crag` (`name`, `lon`, `lat`, `city`) VALUES ('$sanitized_name', '$sanitized_lon', '$sanitized_lat', '$sanitized_city');";
    $query = "INSERT INTO `bulder`.`bulder_setting` (`setting`, `value`) VALUES ('placeskey', '$sanitized_placesKey') ON DUPLICATE KEY UPDATE VALUE = '$sanitized_placesKey';";
    $result = mysqli_query($conn, $query);
    mysqli_close($conn);
    header("Location: index.php");

?>