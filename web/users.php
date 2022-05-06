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
    $site = "users";
    include('top.php');
?>

  <div class="bg-light p-5 rounded">
    <h1>Users</h1>
    <a class="btn btn-primary" href="addUser.php">Add new user</a>
    <hr />
        <?php
          include "dbconfig.php";
          $query = "SELECT * FROM `bulder`.`bulder_user`;";
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              $userpic = !empty($row['picture'])?$row['picture']:'user.png';

              //echo "<tr><td>".$row["name"]."</td><td>".$row["email"]."</td><td>".$row['user_class']."</tr>";
              ?>
              <div class="card mb-3" style="max-width: 540px;">
              <div class="row no-gutters">
                <div class="col-md-3">
                  <img src="<?php echo $userpic; ?>" class="card-img" alt="...">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $row["name"]; ?></h5>
                    <p class="card-text"><strong>Mail: </strong><?php echo $row['email']; ?><br /><strong>User Class: </strong><?php echo $row['user_class'] ?></p>                  </div>
                </div>
              </div>
            </div>
            <?php
            }
          } else {
            echo "<tr><td colspan='3'>No users found</td></tr>";
          }
          mysqli_close($conn);
        ?>
        



</div>

<?php
    include('bottom.php');
?>