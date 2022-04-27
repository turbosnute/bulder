<?php
	session_start();
	if ($_SESSION['access'] != 'granted') {
		header("Location: login.php");
	}
    $cragName = $_POST['frmCragName'];
    $lon = $_POST['frmLon'];
    $lat = $_POST['frmLat'];
    $city = $_POST['frmCity'];

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