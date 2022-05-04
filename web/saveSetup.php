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


    //$placesKey = $_POST['frmPlacesKey'];
    $placesKey = !empty($_POST['frmPlacesKey'])?$_POST['frmPlacesKey']:''; 
    $gauth_client_id = !empty($_POST['frmGoogleAuthClientId'])?$_POST['frmGoogleAuthClientId']:'';
    $gauth_client_secret = !empty($_POST['frmGoogleAuthClientSecret'])?$_POST['frmGoogleAuthClientSecret']:'';
    $gauth_client_redirect_uri = !empty($_POST['frmGoogleAuthRedirectUri'])?$_POST['frmGoogleAuthRedirectUri']:'';

    include('dbconfig.php');

    $sanitized_placesKey = mysqli_real_escape_string($conn, $placesKey);
    $sanitized_gauth_client_id = mysqli_real_escape_string($conn, $gauth_client_id);
    $sanitized_gauth_client_secret = mysqli_real_escape_string($conn, $gauth_client_secret);
    $sanitized_redirect_uri = mysqli_real_escape_string($conn, $gauth_client_redirect_uri);
    


    $query = "INSERT INTO `bulder`.`bulder_setting` (`setting`, `value`)
    VALUES ('placeskey', '$sanitized_placesKey'),
    ('gauth_client_id', '$sanitized_gauth_client_id'),
    ('gauth_client_secret', '$sanitized_gauth_client_secret'),
    ('gauth_redirect_uri', '$sanitized_redirect_uri')
    ON DUPLICATE KEY UPDATE VALUE = VALUES(value)
    ;";

    $result = mysqli_query($conn, $query);
    mysqli_close($conn);
    header("Location: addUser.php?firstuser=true");

?>