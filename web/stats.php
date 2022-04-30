<?php
    session_start();
    if ($_SESSION['access'] != 'granted') {
      header("Location: login.php");
    }
    include('top.php');
?>

  <div class="bg-light p-5 rounded">
    <h1>Stats</h1>
        <?php
          include "dbconfig.php";

          # Number of sends
          $query = "SELECT COUNT(send_id) AS 'count' FROM `bulder_send` WHERE `user_id` = '1' LIMIT 1";
          $result = mysqli_query($conn, $query);
          
          if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $send_count = $row['count'];
          } else {
            $send_count = 0;
          }

          if ($send_count == 0) {
            echo "Register more sends to see statistics.";
          } else {
            echo "Send Count: $send_count";
            # Most number of sends in a day 
            $query = "SELECT COUNT(DATE) AS 'count', `date` FROM `bulder_send` WHERE `user_id` = '1' GROUP BY DATE ORDER BY COUNT LIMIT 1";

            # grade stats and favorite grade.
            $query = "SELECT COUNT(grade) AS 'count' , grade FROM `bulder_send` WHERE `user_id` = '1' GROUP BY grade ORDER BY 'count' LIMIT 1;";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            //$favorite_grade = $row['grade'];
            //echo "Favorite Grade: $favorite_grade";

            # favorite gym.
            $query = "SELECT `bulder_send`.`crag_id`, `bulder_crag`.`name`, COUNT(`bulder_send`.`crag_id`) AS 'count' FROM `bulder_send` INNER JOIN `bulder`.`bulder_crag` ON `bulder_send`.crag_id = `bulder_crag`.crag_id WHERE `user_id` = '1' GROUP BY crag_id ORDER BY 'count' ASC LIMIT 1";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $favorite_crag_name = $row['name'];
            $favorite_crag_count = $row['count'];
            echo "Favorite Gym: $favorite_crag_name ($favorite_crag_count sends).";

            # hardest send.
            $query = "SELECT `bulder_send`.`crag_id`, `bulder_send`.`date`, `bulder_crag`.crag_id, `bulder_crag`.name,`bulder_send`.style, `bulder_grade`.`hardness`, `bulder_send`.grade
                      FROM `bulder_send`
                      INNER JOIN `bulder`.`bulder_grade` ON `bulder_send`.grade = `bulder_grade`.grade
                      INNER JOIN `bulder`.`bulder_crag` ON `bulder_send`.crag_id = `bulder_crag`.crag_id
                      WHERE `user_id` = '1' AND `bulder_send`.style = 'send'
                      ORDER BY hardness DESC, DATE ASC
                      LIMIT 1";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $hardest_send_crag = $row['name'];
            $hardest_send_date = $row['date'];
            $hardest_send_grade = $row['grade'];
            echo "Hardest Send: $hardest_send_grade ($hardest_send_date at $hardest_send_crag)";
          }

          mysqli_close($conn);
        ?>
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