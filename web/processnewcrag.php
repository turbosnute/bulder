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
    if (isset($_POST['frmCragName'])) {
        $cragName = $_POST['frmCragName'];
    } else {
        $cragName = null;
    }

    if (isset($_POST['frmLon'])) {
        $lon = $_POST['frmLon'];
    } else {
        $lon = null;
    }

    if (isset($_POST['frmLat'])) {
        $lat = $_POST['frmLat'];
    } else {
        $lat = null;
    }

    if (isset($_POST['frmCity'])) {
        $city = $_POST['frmCity'];
    } else {
        $city = null;
    }

    /*
    echo "lon: $lon";
    echo "lat: $lat";
    echo "cragname: $cragName";
    echo "city: $city";
    */

    if (empty($lon) || empty($lat || empty($city))) {
        echo "go back, remember to fill inn all boxes.";
    } else {
        include('dbconfig.php');
        $sanitized_name = mysqli_real_escape_string($conn, $cragName);
        $sanitized_lon = mysqli_real_escape_string($conn, $lon);
        $sanitized_lat = mysqli_real_escape_string($conn, $lat);
        $sanitized_city = mysqli_real_escape_string($conn, $city);

        $query = "INSERT INTO `bulder`.`bulder_crag` (`name`, `lon`, `lat`, `city`) VALUES ('$sanitized_name', '$sanitized_lon', '$sanitized_lat', '$sanitized_city');";
        $result = mysqli_query($conn, $query);
        mysqli_close($conn);
        header("Location: crags.php");
    }
?>