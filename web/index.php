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

    if( isset($_SESSION['user_id']) ) {
      $user_id = $_SESSION['user_id'];
    } else {
      $user_id = null;
    }

    $site = "logbook";
    include('top.php');

    $climbing_session_id = '';

?>

  <div class="bg-light p-5 rounded">
  <h1>Logbook</h1>
  <a class="btn btn-primary" href="addSend.php">Add send</a>
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
        `bulder_crag`.`name`,
        `bulder_grade`.`cssclass`
        FROM `bulder`.`bulder_send`
        INNER JOIN `bulder`.`bulder_crag` ON `bulder_send`.crag_id = `bulder_crag`.crag_id
        INNER JOIN `bulder`.`bulder_grade` ON `bulder_send`.grade = `bulder_grade`.grade
        WHERE `user_id` = '$user_id' ORDER BY DATE DESC, send_id ASC;";

        $result = mysqli_query($conn, $query);
        $sendcount = mysqli_num_rows($result);
        if ($sendcount > 0) {
          ?>
              &nbsp;<a type="button" class="btn btn-secondary" href="exportLog.php">Download CSV</a>
          <?php
          $climbing_session_id_array = array();
          $count = 0;
          $i = 0;
          
          while($row = mysqli_fetch_assoc($result)) {
            $sendDate = $row['date'];
            $sendGrade = $row['grade'];
            $sendStyle = $row['style'];
            $send_id = $row['send_id'];
            $gymName = $row['name'];
            $climbing_session_card = "";

            if (($lastDate != $sendDate) || ($gymName != $lastGym)) {
              
              $lastDate = $sendDate;
              $lastGym = $gymName;
              $last_climbing_session_id = $climbing_session_id;
              $climbing_session_id = uniqid();

              if (!$first) {
                array_push($climbing_session_id_array, "$last_climbing_session_id,$count");
                $count = 0;
                echo "</div></div></div>";
              }


              $day = date("l", strtotime($sendDate));
              echo "<div class=\"row\" style=\"margin-top:25px;\"><div class=\"card\"><div class=\"card-body\"><h4>$day</h4>";
              echo "<div class='metatext'><i class=\"bi bi-calendar-event\"></i> $sendDate<br />";
              echo "<i class=\"bi bi-geo-alt\"></i> $gymName<br />";
              echo "<i class=\"bi bi-card-checklist\"></i> <span id='$climbing_session_id'></span></div>";
            }

            if ($sendStyle == 'flash') {
              $icon = "<i class=\"bi bi-lightning-fill\"></i>";
            } elseif ($sendStyle == 'send') {
              $icon = "<i class=\"bi bi-send-fill\"></i>";
            } else {
              $icon = "<i class=\"bi bi-arrow-repeat\"></i>";
            }

            echo "<a class='btn-c badge bg-$sendGrade' href='addSend.php?edit=".$send_id."' style='color:#FFF;'>$icon $sendStyle</a> ";
            //echo '<i class="bi-github" role="img" aria-label="GitHub"></i>';
            $count++;
            
            $first = false;
            $i++;
          }
          array_push($climbing_session_id_array, "$climbing_session_id,$count");
          //$climbing_session_id = uniqid();
          //array_push($climbing_session_id_array, "$last_climbing_session_id,$count");

          $jsArray = 'var sess_ids = ["' . implode('", "', $climbing_session_id_array) . '"];';
        } else {
          echo "<p>No sends found</p>";
        }
        mysqli_close($conn);

        if ($sendcount > 0) {
          echo "<script>";
          echo $jsArray;
          ?>
          sess_ids.forEach(function(e, i) {
              console.log('[' + i + '] : ' + e);
              var split = e.split(',');
              var id = split[0];
              var num = split[1];
              document.getElementById(id).innerText = num + " sends logged";
          });
          <?php
          echo "</script>";
        }
      ?>

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