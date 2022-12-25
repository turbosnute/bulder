<?php
    session_start();
    $site = "Edit Session";
    if (isset($_SESSION['access'])) {
        if ($_SESSION['access'] == 'granted') {
            $access = 'granted';
        }
    } else {
        $access = $null;
    }

    if ($access != 'granted') {
      header("Location: login.php");
    }
    include('top.php');

    $title = "Edit Climbing Session Location";

    $start_send = intval($_GET['start']);
    $end_send = intval($_GET['end']);

?>
<div class="bg-light p-5 rounded">
<h1><?php echo $title;?></h1>
<form id="gym_location_form" action="processlocation.php" method="post">
    <input type="hidden" name="frmStart" value="<?php echo $start_send; ?>">
    <input type="hidden" name="frmEnd" value="<?php echo $end_send; ?>">
    <div class="mb-3">
        <label for="frmCrag" class="form-label">Location</label>
        <select name="frmCrag" id="frmCrag" class="form-select form-select mb-3" aria-label=".form-select-lg example">
            <?php

                include "dbconfig.php";
                $submitButtonText = "Submit"; //default text for submit button. 

                $send_id = -1;

                    $query = "SELECT * FROM `bulder`.`bulder_send` WHERE `user_id` = ".$_SESSION['user_id']." AND `send_id` >= 10 AND `send_id` = '$start_send' LIMIT 1";
                    $result = mysqli_query($conn, $query);

                    //echo $query;
                    if (mysqli_num_rows($result) > 0) {
                        $existing_send = mysqli_fetch_assoc($result);
                        $selected_crag = $existing_send['crag_id'];
                        //$selectedstyle = $existing_send['style'];
                        //$selectedgrade = $existing_send['grade'];
                        $send_id = $existing_send['send_id'];
                        $date = $existing_send['date'];
                        $submitButtonText = "Save";
                    } else {
                        mysqli_close($conn);
                        die("<option>Invalid send_id or a send_id that belongs to another user.</option>");
                    }

                $query = "SELECT * FROM `bulder`.`bulder_crag`;";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        if ($selected_crag == $row["crag_id"]) {
                            $selected = " selected";
                        } else {
                            $selected = "";
                        }
                        echo "<option value='".$row["crag_id"]."'$selected>".$row["name"]." (".$row["city"].")</option>";
                    }
                }
                mysqli_close($conn);
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="frmDate" class="form-label">Date</label>
        <input type="text" class="form-control" name="frmDate" id="frmDate" value="<?php echo $date;?>">
    </div>

    <hr />
    <div class="mb-3">
        <input class="btn btn-primary" type="submit" id="submit" value="<?php echo $submitButtonText; ?>"> 
    </div>
</form>
</div>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>

<script src="js/FormValidation.min.js"></script>
<script src="js/Bootstrap.min.js"></script>
<script src="js/bulder.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function (e) {
        $('[name="frmDate"]')
            .datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
            })
            .on('changeDate', function (e) {
                // Revalidate the date field
                //fv.revalidateField('frmDate');
            });
    });
</script>
<?php
    include('bottom.php');
?>
