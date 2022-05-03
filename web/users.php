<?php
    session_start();
    if (isset($_SESSION['user_class'])) {
      if ($_SESSION['user_class'] == 'admin') {
          $user_class = 'admin';
      }
    } else {
        $user_class = null;
    }

    if ($user_class != 'admin') {
      header("Location: login.php");
    }
    $site = "users";
    include('top.php');
?>

  <div class="bg-light p-5 rounded">
    <h1>Users</h1>
    <a class="btn btn-primary" href="addUser.php">Add new user</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col">E-mail</th>
          <th scope="col">User Class</th>
        </tr>
      </thead>
      <tbody>
        <?php
          include "dbconfig.php";
          $query = "SELECT * FROM `bulder`.`bulder_user`;";
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              echo "<tr><td>".$row["name"]."</td><td>".$row["email"]."</td><td>".$row['user_class']."</tr>";
            }
          } else {
            echo "<tr><td colspan='3'>No users found</td></tr>";
          }
          mysqli_close($conn);
        ?>
        
      </tbody>
   </table>
  </div>

<?php
    include('bottom.php');
?>