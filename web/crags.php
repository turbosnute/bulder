<?php
    session_start();
    if ($_SESSION['access'] != 'granted') {
      header("Location: login.php");
    }
    include('top.php');

    // check if places api key exists.
    include "dbconfig.php";
    $query = "SELECT * FROM `bulder`.`bulder_setting` WHERE setting = 'placeskey' LIMIT 1;";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) != 0) {
      $row = mysqli_fetch_assoc($result);
      $placeskey = $row['value'];
      $places = True;
    } else {
      $placeskey = "";
      $places = False;
    }
    mysqli_close($conn);
?>

  <div class="bg-light p-5 rounded">
    <h1>Crags</h1>
    <a class="btn btn-primary" href="addCrag.php">Add new crag</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col">City</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Grip Klatring Sluppen</td>
          <td>Trondheim</td>
          <td><span class="glyphicon glyphicon-remove"></span></td>
        </tr>
      </tbody>
   </table>
  </div>

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
    </style>

<?php
    include('bottom.php');
?>