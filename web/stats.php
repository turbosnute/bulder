<?php
    session_start();
    if (isset($_SESSION['access'])) {
      if ($_SESSION['access'] == 'granted') {
          $access = 'granted';
      }
    } else {
        $access = null;
    }

    if ($access != 'granted') {
      header("Location: login.php");
    }
    $site = "stats";
    include('top.php');
    $user_id = $_SESSION['user_id'];
?>

  <div class="bg-light p-5 rounded">
    <h1>Your Stats</h1>
        <?php
          include "dbconfig.php";

          # Number of sends
          $query = "SELECT COUNT(send_id) AS 'count' FROM `bulder_send` WHERE `user_id` = '$user_id' LIMIT 1";
          $result = mysqli_query($conn, $query);

          if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $climb_count = $row['count'];
          } else {
            $climb_count = 0;
          }

          if ($climb_count == 0) {
            echo "Register more sends to see statistics.";
          } else {
            $query = "SELECT COUNT(send_id) AS 'count' FROM `bulder_send` WHERE `user_id` = '$user_id' AND `style` != 'repeat' LIMIT 1";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_assoc($result);
              $send_count = $row['count'];
            } else {
              $send_count = 0;
            }

            # Most number of climbs in a day 
            $query = "SELECT `bulder_send`.`date`,COUNT(`date`) AS 'count'
                      FROM `bulder_send`
                      WHERE `user_id` = '$user_id'
                      GROUP BY `date`
                      ORDER BY `count` DESC
                      LIMIT 1";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $climbs_in_a_day_record = $row['count'];
            $climbs_in_a_day_date = $row['date'];

            # Most number of sends in a day 
            $query = "SELECT `bulder_send`.`date`,COUNT(`date`) AS 'count'
                      FROM `bulder_send`
                      WHERE `user_id` = '$user_id' AND `style` != 'repeat'
                      GROUP BY `date`
                      ORDER BY `count` DESC
                      LIMIT 1";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $sends_in_a_day_record = $row['count'];
            $sends_in_a_day_date = $row['date'];

            # grade stats and favorite grade.
            $query = "SELECT COUNT(*) AS 'count', `bulder_send`.`grade`, `bulder_grade`.`hardness`,  `bulder_grade`.`cssclass`, `bulder_grade`.`friendlyname`
                      FROM `bulder_send`
                      INNER JOIN `bulder`.`bulder_grade` ON `bulder_send`.grade = `bulder_grade`.grade
                      WHERE `user_id` = '$user_id'
                      GROUP BY `grade`
                      ORDER BY `count` DESC";

            $result = mysqli_query($conn, $query);
            $arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $usersendcount = array_sum(array_column($arr,'count'));

            ?>
            <div class="card mb-3">
            <div class="card-body">
            <p class="text-muted">Number of climbs logged<br /><span class="metatext">Flashes, sends and repeats.</span></p>
            <p class="h1"><?php echo "$climb_count"; ?></p>

            <?php
            foreach ($arr as &$value) {
              $grade = $value['grade'];
              $count = $value['count'];
              $cssclass = $value['cssclass'];
              echo "<a class='badge $cssclass'>$count</a> ";
            }

            $query = "SELECT COUNT(*) AS 'count', `bulder_send`.`grade`, `bulder_send`.`style`, `bulder_grade`.`hardness`,  `bulder_grade`.`cssclass`, `bulder_grade`.`friendlyname`
            FROM `bulder_send`
            INNER JOIN `bulder`.`bulder_grade` ON `bulder_send`.grade = `bulder_grade`.grade
            WHERE `user_id` = '$user_id' AND `style` != 'repeat'
            GROUP BY `grade`
            ORDER BY `count` DESC";

            $result = mysqli_query($conn, $query);
            $sendarr = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $sendusersendcount = array_sum(array_column($sendarr,'count'));
            ?>
            <p class="text-muted"><br />Number of sends logged<br /><span class="metatext">Only flashes and sends</span></p>
            <p class="h1"><?php echo "$send_count"; ?></p>
            <?php
            foreach ($sendarr as &$value) {
              $grade = $value['grade'];
              $count = $value['count'];
              $cssclass = $value['cssclass'];
              echo "<a class='badge $cssclass'>$count</a> ";
            }
            
            $query = "SELECT COUNT(*) AS 'count', `bulder_send`.`grade`, `bulder_send`.`style`, `bulder_grade`.`hardness`,  `bulder_grade`.`cssclass`, `bulder_grade`.`friendlyname`
            FROM `bulder_send`
            INNER JOIN `bulder`.`bulder_grade` ON `bulder_send`.grade = `bulder_grade`.grade
            WHERE `user_id` = '$user_id' AND `style` = 'flash'
            GROUP BY `grade`
            ORDER BY `count` DESC";

            $result = mysqli_query($conn, $query);
            $flasharr = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $userflashcount = array_sum(array_column($flasharr,'count'));

            if ($userflashcount > 0) {
            ?>
              <p class="text-muted"><br />Number of flashes logged<br /><span class="metatext">Only first tries</span></p>
              <p class="h1"><?php echo "$userflashcount"; ?></p>
              <?php
              foreach ($flasharr as &$value) {
                $grade = $value['grade'];
                $count = $value['count'];
                $cssclass = $value['cssclass'];
                echo "<a class='badge $cssclass'>$count</a> ";
              }
            }
            ?>
            
</div>
</div>
<div class="card mb-3">
      <div class="card-body">
        <p class="text-muted">Most climbs in a day</p>
        <p class="h1"><?php echo $climbs_in_a_day_record; ?></p>
        <p class="card-text"><small class="text-muted"><i class="bi bi-calendar-event"></i> <?php echo "$climbs_in_a_day_date";?></small></p>
        <p class="text-muted">Most sends in a day</p>
        <p class="h1"><?php echo $sends_in_a_day_record; ?></p>
        <p class="card-text"><small class="text-muted"><i class="bi bi-calendar-event"></i> <?php echo "$sends_in_a_day_date";?></small></p>
      </div>
</div>


            <?php
            $favorite_grade = $arr[0]['friendlyname'];
            $favorite_grade_count = $arr[0]['count'];
/*
            while($row = mysqli_fetch_assoc($result)) {
              echo "<tr><td>".$row["name"]."</td><td>".$row["email"]."</td></tr>";
            }
*/
            # favorite gym.
            $query = "SELECT `derp`.`name`, `derp`.`crag_id`, `derp`.`city`, COUNT(`derp`.`crag_id`) AS 'times_visited' FROM (
              SELECT `bulder_send`.`crag_id`, `bulder_send`.`date`,`bulder_crag`.`name`,`bulder_crag`.`city`
              FROM `bulder_send`
              INNER JOIN `bulder`.`bulder_crag` ON `bulder_send`.crag_id = `bulder_crag`.crag_id
              WHERE `user_id` = '$user_id'
              GROUP BY `crag_id`, `date`
            ) AS derp
            GROUP BY `crag_id`
            ORDER BY `times_visited` DESC
            LIMIT 1";

            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $favorite_crag_name = $row['name'];
            $favorite_crag_id = $row['crag_id'];
            $favorite_crag_city = $row['city'];
            $favorite_crag_visit_count = $row['times_visited'];
            
            $query = "SELECT COUNT(`crag_id`) AS 'count'
                      FROM `bulder_send`
                      WHERE `user_id` = '$user_id' AND `crag_id` = '$favorite_crag_id'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $favorite_crag_logs = $row['count'];

            # hardest flash.
            $query = "SELECT `bulder_send`.`crag_id`, `bulder_send`.`date`, `bulder_crag`.crag_id, `bulder_crag`.`name`,`bulder_send`.`style`, `bulder_grade`.`hardness`, `bulder_grade`.`friendlyname`, `bulder_grade`.`cssclass`, `bulder_send`.grade
                      FROM `bulder_send`
                      INNER JOIN `bulder`.`bulder_grade` ON `bulder_send`.grade = `bulder_grade`.grade
                      INNER JOIN `bulder`.`bulder_crag` ON `bulder_send`.crag_id = `bulder_crag`.crag_id
                      WHERE `user_id` = '$user_id' AND `bulder_send`.style = 'flash'
                      ORDER BY hardness DESC, DATE ASC
                      LIMIT 1";

            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_assoc($result);
              $hardest_flash_crag = $row['name'];
              $hardest_flash_date = $row['date'];
              $hardest_flash_grade = $row['grade'];
              $hardest_flash_css = $row['cssclass'];
              $hardest_flash_friendly = $row['friendlyname'];

              ?>
<div class="card mb-3">
      <div class="card-body">
        <p class="text-muted">Hardest Flash</p>
        <p class="h1"><?php echo $hardest_flash_friendly; ?></p>

        <p class="card-text"><small class="text-muted"><i class="bi bi-calendar-event"></i> <?php echo $hardest_flash_date;?><br /><i class="bi bi-geo-alt"></i> <?php echo $hardest_flash_crag;?></small></p>
      </div>
</div>
              <?php
            }

            # hardest send.
            $query = "SELECT `bulder_send`.`crag_id`, `bulder_send`.`date`, `bulder_crag`.crag_id, `bulder_crag`.`name`,`bulder_send`.style, `bulder_grade`.`hardness`, `bulder_grade`.`friendlyname`, `bulder_send`.grade
                      FROM `bulder_send`
                      INNER JOIN `bulder`.`bulder_grade` ON `bulder_send`.grade = `bulder_grade`.grade
                      INNER JOIN `bulder`.`bulder_crag` ON `bulder_send`.crag_id = `bulder_crag`.crag_id
                      WHERE `user_id` = '$user_id'
                      ORDER BY hardness DESC, DATE ASC
                      LIMIT 1";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $hardest_send_crag = $row['name'];
            $hardest_send_date = $row['date'];
            $hardest_send_grade = $row['grade'];
            $hardest_send_friendly = $row['friendlyname'];
          }

          mysqli_close($conn);

          if ($climb_count > 0) {
?>


<div class="card mb-3">
      <div class="card-body">
        <p class="text-muted">Hardest Send</p>
        <p class="h1"><?php echo $hardest_send_friendly; ?></p>

        <p class="card-text"><small class="text-muted"><i class="bi bi-calendar-event"></i> <?php echo $hardest_send_date;?><br /><i class="bi bi-geo-alt"></i> <?php echo $hardest_send_crag;?></small></p>
      </div>
</div>

<div class="card mb-3">
      <div class="card-body">
        <p class="text-muted">Favorite Grade</p>
        <p class="h1"><?php echo ucfirst($favorite_grade); ?></p>
        <p class="card-text"><small class="text-muted"><i class="bi bi-card-checklist"></i><?php echo " $favorite_grade_count climbs logged"; ?></small></p>
      </div>
</div>
<div class="card mb-3">
      <div class="card-body">
        <p class="text-muted">Favorite Gym</p>
        <p class="h1"><?php echo $favorite_crag_name; ?></p>
        
        <p class="card-text">
          <small class="text-muted">
          <i class="bi bi-geo-alt"></i> <?php echo $favorite_crag_city;?>
            <br /><i class="bi bi-bicycle"></i> <?php echo "Visited $favorite_crag_visit_count times";?>
            <br /><i class="bi bi-card-checklist"></i> <?php echo "$favorite_crag_logs climbs logged";?>
          </small>
        </p>
      </div>
</div>
<?php
          } # end if send_count > 0
?>

<?php
    include('bottom.php');
?>