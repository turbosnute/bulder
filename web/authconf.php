<?php
$clientID = '';
$clientSecret = '';
$redirectUri = '';
$useGauth = false;

require_once 'vendor/autoload.php';



// init configuration fetched from database.
require_once 'dbconfig.php';

// does setting database exist?
$query = "SHOW TABLES LIKE 'bulder_setting';";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) { // yes

  $query = "SELECT * FROM `bulder_setting`";
  $result = mysqli_query($conn, $query);
  
  if (mysqli_num_rows($result) > 0) {
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
}

if ($clientID != '') {
  // create Client Request to access Google API
  $useGauth = true;
  $client = new Google_Client();
  $client->setClientId($clientID);
  $client->setClientSecret($clientSecret);
  $client->setRedirectUri($redirectUri);
  $client->addScope("email");
  $client->addScope("profile");
}
?>