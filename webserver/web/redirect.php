<?php
    session_start();
    require_once 'authconf.php'; 

    if (isset($_GET['code'])) { 
      $client->authenticate($_GET['code']); 
      $_SESSION['token'] = $client->getAccessToken(); 
      header('Location: ' . filter_var($redirectUri, FILTER_SANITIZE_URL)); 
    }
    
    if (isset($_SESSION['token'])) { 
      $client->setAccessToken($_SESSION['token']); 
    } 

    if ($client->getAccessToken()) { 
      // Get user profile data from google 
      $oauth = new Google_Service_Oauth2($client);
      $userinfo = $oauth->userinfo->get();

      $name = !empty($userinfo['name'])?$userinfo['name']:''; 
      $email = !empty($userinfo['email'])?$userinfo['email']:'';
      
      $_SESSION['mail'] = $email;
      $_SESSION['user_name'] = $name;

      // Fetch user data from db here.
      $query = "SELECT * FROM `bulder_user` WHERE `email` = '$email';";
      include "dbconfig.php";

      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['access'] = 'granted';
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_class'] = $row['user_class'];
      } else {
        // Create user if it doesn't exist here.
        $query = "INSERT INTO `bulder`.`bulder_user` (`name`, `email`, `user_class`) VALUES ('$name', '$email', 'user');";
        mysqli_query($conn, $query);
      }

      header("Location: index.php");
    } else { 
      // Get login url 
      $authUrl = $client->createAuthUrl(); 
       
      // google login button 
      $login_image = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'">
      <img src="images/google-sign-in-btn.png" alt=""/></a>';
      echo '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'">Login with Google</a>'; 
      echo $login_image;
  } 
?>