<?php

require_once 'vendor/autoload.php';

$clientID = '';
$clientSecret = '';
$redirectUri = '';


// init configuration fetched from database.
require_once 'dbconfig.php';

$query = "SELECT * FROM `bulder_setting`";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result)) {
  while($row = mysqli_fetch_assoc($result)) {
    $setting = $row['setting'];
    $value = $row['value'];

    if ($setting == 'gauth_client_id') {
        $clientID = $value;
    } elseif ($setting == 'gauth_client_secret') {
        $clientSecret = $value;
    } elseif ($setting == 'gauth_redirect_uri') {
        $redirectUri = $value;
    }
  }
}

//die("$query $clientID $clientSecret $redirectUri");
// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Include Google API client library


?>