<?php
    session_start();

    require_once 'authconf.php'; 

    $googleLink = '';

    if ($useGauth) {
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
        $picture = !empty($userinfo['picture'])?$userinfo['picture']:'';

        $_SESSION['mail'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['picture'] = $picture;

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
          $_SESSION['picture'] = $row['picture'];
        } else {
          // Create user if it doesn't exist here.
          $query = "INSERT INTO `bulder`.`bulder_user` (`name`, `email`, `user_class`, `picture`) VALUES ('$name', '$email', 'user', '$picture');";
          mysqli_query($conn, $query);
          $query = "SELECT * FROM `bulder_user` WHERE `email` = '$email';";
          $result = mysqli_query($conn, $query);
          $row = mysqli_fetch_assoc($result);
          $_SESSION['access'] = 'granted';
          $_SESSION['user_name'] = $row['name'];
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['user_class'] = $row['user_class'];
          $_SESSION['picture'] = $row['picture'];
        }

        header("Location: index.php");
      } else { 
        // Get login url 
        $authUrl = $client->createAuthUrl(); 
        
        // google login button 
        $login_image = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'">
        <img src="images/google-sign-in-btn.png" alt=""/></a>';
        
        $googleLink = "<a style=\"margin-top:10px;\"class=\"w-100 btn btn-lg btn-light\" type=\"submit\" href=\"".filter_var($authUrl, FILTER_SANITIZE_URL)."\"><img src=\"https://img.icons8.com/color/16/000000/google-logo.png\"> Sign in with Google</a>";

      
      } 
  } # end if use gauth
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Bulder Login</title>


    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      html, body {
        height: 100%;
        }

        body {
        display: flex;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
        }

        .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
        }

        .form-signin .checkbox {
        font-weight: 400;
        }

        .form-signin .form-floating:focus-within {
        z-index: 2;
        }

        .form-signin input[type="text"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        }
    </style>


  </head>
  <body class="text-center">
    
    <main class="form-signin">
    <form method="post" action="processlogin.php">
        <img class="mb-4" src="bulder_logo.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        <div class="form-floating">
        <input id="mail" name="mail" type="text" class="form-control" placeholder="Mail" autocomplete="username email" />
        <label for="mail">mail</label>
        </div>
        <div class="form-floating">
        <input id="pw" name="pw" type="password" class="form-control"  placeholder="Password" autocomplete="new-password" />
        <label for="pw">password</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        <?php echo $googleLink; ?>
    </form>
    </main>

  </body>
</html>
