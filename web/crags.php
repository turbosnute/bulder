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
    $site = "gyms";
    include('top.php');
?>

  <div class="bg-light p-5 rounded">
    <h1>Gyms</h1>
    <a class="btn btn-primary" href="addCrag.php">Add new gym</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col">City</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php
          include "dbconfig.php";
          $query = "SELECT * FROM `bulder`.`bulder_crag`;";
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              echo "<tr><td>".$row["name"]."</td><td>".$row["city"]."</td><td></td></tr>";
            }
          } else {
            echo "<tr><td colspan='3'>No Gyms found</td></tr>";
          }
          mysqli_close($conn);
        ?>
        
      </tbody>
   </table>
  </div>

<?php
    include('bottom.php');
?>