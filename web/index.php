<?php
    session_start();
    if ($_SESSION['access'] != 'granted') {
      header("Location: login.php");
    }
    $site = "logbook";
    include('top.php');
?>

  <div class="bg-light p-5 rounded">
  <h1>Logbook</h1>
  <a class="btn btn-primary" href="addSend.php">Add new send</a>
      <?php
        $first = true;
        $lastDate = "123";
        $lastGym = '-2';
        include "dbconfig.php";
        $query = "SELECT
        `bulder_send`.`date`,
        `bulder_send`.`style`,
        `bulder_send`.`grade`,
        `bulder_send`.`terrain`,
        `bulder_send`.`user_id`,
        `bulder_send`.`send_id`,
        `bulder_crag`.`name`
        FROM `bulder`.`bulder_send`
        INNER JOIN `bulder`.`bulder_crag` ON `bulder_send`.crag_id = `bulder_crag`.crag_id
        WHERE `user_id` = '".$_SESSION['user_id']."' ORDER BY DATE DESC, send_id ASC;";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            $sendDate = $row['date'];
            $sendGrade = $row['grade'];
            $sendStyle = $row['style'];
            $send_id = $row['send_id'];
            $gymName = $row['name'];

            if (($lastDate != $sendDate) || ($gymName != $lastGym)) {
              $lastDate = $sendDate;
              $lastGym = $gymName;
              if (!$first) { echo "</div></div></div>"; }
              $day = date("l", strtotime($sendDate));
              echo "<div class=\"row\" style=\"margin-top:25px;\"><div class=\"card\"><div class=\"card-body\"><h4>$day</h4>";
              echo "<i class=\"bi bi-calendar-event\"></i> $sendDate<br />";
              echo "<i class=\"bi bi-geo-alt\"></i> $gymName<br />";
            }

            if ($sendStyle == 'flash') {
              $icon = "<i class=\"bi bi-lightning-fill\"></i>";
            } else {
              $icon = "<i class=\"bi bi-send-fill\"></i>";
            }

            echo "<a class='btn-c badge bg-$sendGrade' href='addSend.php?edit=".$send_id."' style='color:#FFF;'>$icon $sendStyle</a> ";
            //echo '<i class="bi-github" role="img" aria-label="GitHub"></i>';
            $first = $false;
          }
        } else {
          echo "<tr><td colspan='3'>No sends found</td></tr>";
        }
        mysqli_close($conn);
      ?>



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