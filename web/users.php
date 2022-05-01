<?php
    session_start();
    if ($_SESSION['user_class'] != 'admin') {
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
        </tr>
      </thead>
      <tbody>
        <?php
          include "dbconfig.php";
          $query = "SELECT * FROM `bulder`.`bulder_user`;";
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              echo "<tr><td>".$row["name"]."</td><td>".$row["email"]."</td></tr>";
            }
          } else {
            echo "<tr><td colspan='3'>No users found</td></tr>";
          }
          mysqli_close($conn);
        ?>
        
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