<?php
if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
} else {
    $user_name = null;
}

if (isset($_SESSION['user_class'])) {
    $user_class = $_SESSION['user_class'];
} else {
    $user_class = null;
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Bulder</title>
    <style>
        #autocomplete {
            width: 300px;
        }
    </style>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">
    <link rel="manifest" href="/icons/site.webmanifest">
    <link rel="mask-icon" href="/icons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/icons/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" />
    <!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCfRCncd6qM9hMR5em49g9BAD1s7dQXhZk&libraries=places"></script>-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="css/mdb.min.css" />
    
    <!-- Custom styles -->
    <link href="custom-style.css" rel="stylesheet">

  </head>
  <body>
    
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Bulder</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                <a class="nav-link<?php if ($site == 'logbook') { echo ' active';}?>" aria-current="page" href="index.php">Logbook</a>
                </li>
                <li class="nav-item">
                <a class="nav-link<?php if ($site == 'diary') { echo ' active';}?>" aria-current="page" href="diary.php">Diary</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?php if ($site == 'stats') { echo ' active';}?>" href="stats.php">Stats</a>
                </li>
                <?php
                if ($user_class == 'admin') {
                ?>
                <li class="nav-item">
                <a class="nav-link<?php if ($site == 'gyms') { echo ' active';}?>" href="crags.php">Gyms</a>
                </li>
                <li class="nav-item">
                <a class="nav-link<?php if ($site == 'users') { echo ' active';}?>" href="users.php">Users</a>
                </li>
                <?php
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="processlogout.php">Log Out (<?php echo $user_name ?>)</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>

    <main class="container">
