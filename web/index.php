<?php
    session_start();
    if ($_SESSION['access'] != 'granted') {
      header("Location: login.php");
    }
    include('top.php');
?>

  <div class="bg-light p-5 rounded">
    <h1>Loogbook</h1>
    <a class="btn btn-primary" href="addSend.php">Add new send</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Date</th>
          <th scope="col">Grade</th>
          <th scope="col">Style</th>
        </tr>
      </thead>
      <tbody>
        <?php
          include "dbconfig.php";
          $query = "SELECT * FROM `bulder`.`bulder_send` WHERE `user_id` = '".$_SESSION['user_id']."';";
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              echo "<tr><td>".$row["date"]."</td><td>".$row["grade"]."</td><td>".$row['style']."</td></tr>";
            }
          } else {
            echo "<tr><td colspan='3'>No sends found</td></tr>";
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