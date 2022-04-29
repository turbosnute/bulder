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

      <tbody>
        <?php
          $lastDate = "123";
          include "dbconfig.php";
          $query = "SELECT
          `bulder_send`.`date`,
          `bulder_send`.`style`,
          `bulder_send`.`grade`,
          `bulder_send`.`terrain`,
          `bulder_send`.`user_id`,
          `bulder_crag`.`name`
          FROM `bulder`.`bulder_send`
          INNER JOIN `bulder`.`bulder_crag` ON `bulder_send`.crag_id = `bulder_crag`.crag_id
          WHERE `user_id` = ".$_SESSION['user_id'].";";
          $result = mysqli_query($conn, $query);

          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              $sendDate = $row['date'];
              $sendGrade = $row['grade'];
              $sendStyle = $row['style'];

              if ($lastDate != $sendDate) {
                $lastDate = $sendDate;
                echo "<h4>$sendDate</h4>";
              }
              echo $row["grade"]."<br />".$row['style']."<br />".$row['name'];
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
    /*
    SELECT
COUNT(`style`), style
FROM `bulder`.`bulder_send`
WHERE `user_id` = 3
GROUP BY `style`

*/
?>