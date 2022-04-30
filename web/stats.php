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
            # Most number of sends in a day 
            $query = "SELECT COUNT(DATE) AS 'count', `date` FROM `bulder_send` WHERE `user_id` = '1' GROUP BY DATE ORDER BY COUNT LIMIT 1";

            # grade stats and favorite grade.
            $query = "SELECT COUNT(*) AS 'count', `bulder_send`.`grade`, `bulder_grade`.hardness
                      FROM `bulder_send`
                      INNER JOIN `bulder`.`bulder_grade` ON `bulder_send`.grade = `bulder_grade`.grade
                      WHERE `user_id` = 1
                      GROUP BY `grade`
                      ORDER BY `count` DESC";

            $result = mysqli_query($conn, $query);
            $arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $usersendcount = array_sum(array_column($arr,'count'));

            ?>
<div class="card mb-3">
      <div class="card-body">
        <p class="text-muted">Number of sends logged</p>
        <p class="h1"><?php echo "$send_count"; ?></p>

            <?php
            foreach ($arr as &$value) {
              $grade = $value['grade'];
              $count = $value['count'];
              echo "<a class='badge bg-$grade'>$count</a> ";
            }
            ?>
            </div></div>

            <?php
            $favorite_grade = $arr[0]['grade'];
            $favorite_grade_count = $arr[0]['count'];
/*
            while($row = mysqli_fetch_assoc($result)) {
              echo "<tr><td>".$row["name"]."</td><td>".$row["email"]."</td></tr>";
            }
*/
            # favorite gym.
            $query = "SELECT DISTINCT COUNT(`date`) AS times_visited, `bulder_crag`.`name`, `bulder_crag`.`city`, `bulder_send`.crag_id
                      FROM `bulder_send`
                      INNER JOIN `bulder`.`bulder_crag` ON `bulder_send`.crag_id = `bulder_crag`.crag_id
                      WHERE `user_id` = '1'
                      GROUP BY `crag_id`
                      ORDER BY `times_visited` DESC
                      LIMIT 1";

            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $favorite_crag_name = $row['name'];
            $favorite_crag_city = $row['city'];
            $favorite_crag_visit_count = $row['times_visited'];

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
          }

          mysqli_close($conn);
        ?>
<div class="card mb-3">
      <div class="card-body">
        <p class="text-muted">Hardest Send</p>
        <p class="h1"><?php echo "$hardest_send_grade"; ?></p>

        <p class="card-text"><small class="text-muted"><i class="bi bi-calendar-event"></i> <?php echo $hardest_send_date;?><br /><i class="bi bi-geo-alt"></i> <?php echo $hardest_send_crag;?></small></p>
      </div>
</div>

<div class="card mb-3">
      <div class="card-body">
        <p class="text-muted">Favorite Grade</p>
        <p class="h1"><?php echo "$favorite_grade"; ?></p>
        <p class="card-text"><small class="text-muted"><i class="bi bi-123"></i><?php echo " $favorite_grade_count sends logged"; ?></small></p>
      </div>
</div>
<div class="card mb-3">
      <div class="card-body">
        <p class="text-muted">Favorite Gym</p>
        <p class="h1"><?php echo "$favorite_crag_name"; ?></p>
        
        <p class="card-text"><small class="text-muted"><i class="bi bi-bicycle"></i> <?php echo "Visited $favorite_crag_visit_count times";?><br /><i class="bi bi-geo-alt"></i> <?php echo $favorite_crag_city;?></small></p>
      </div>
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