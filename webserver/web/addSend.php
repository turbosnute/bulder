<?php
    session_start();
    $site = "addSend";
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

    $isEdit = null;
    $edit = null;

    $existing_send = null;

    if (isset($_GET['edit'])) {
        $edit = $_GET['edit'];
    } else {
        $edit = null;
    }

    if (isset($edit) && (is_int(intval($edit)))) {
        $title = "Edit send";
    } else {
        $title = "Register new send";
    }


?>
<div class="bg-light p-5 rounded">
<h1><?php echo $title;?></h1>
<form id="sendform" action="processsend.php" method="post">

    <div class="mb-3">
        <label for="frmCrag" class="form-label">Location</label>
        <select name="frmCrag" id="frmCrag" class="form-select form-select mb-3" aria-label=".form-select-lg example">
            <?php

                include "dbconfig.php";
                $selectedstyle = "send"; //default style.
                $selectedgrade = "blue"; //default grade.
                $submitButtonText = "Submit"; //default text for submit button. 
                $isEdit = 'NO';
                $send_id = -1;
                if (isset($edit) && (is_int(intval($edit)))) {
                    $query = "SELECT * FROM `bulder`.`bulder_send` WHERE `send_id` = $edit AND `user_id` = ".$_SESSION['user_id']." LIMIT 1;";
                    $result = mysqli_query($conn, $query);

                    echo $query;
                    if (mysqli_num_rows($result) > 0) {
                        $existing_send = mysqli_fetch_assoc($result);
                        $selected_crag = $existing_send['crag_id'];
                        $selectedstyle = $existing_send['style'];
                        $selectedgrade = $existing_send['grade'];
                        $send_id = $existing_send['send_id'];
                        $date = $existing_send['date'];
                        $submitButtonText = "Save";
                        $isEdit = 'YES';
                    } else {
                        mysqli_close($conn);
                        die("<option>Invalid send_id or a send_id that belongs to another user.</option>");
                    }
                } else {
                    $selected_crag = intval($_SESSION['last_crag_id']);
                    if (isset($_SESSION['last_date'])) {
                        $date = $_SESSION['last_date'];
                    } else {
                        $date = date("Y-m-d");
                    }
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
    <div class="mb-3">
        <label class="form-label">Grade</label><br />
        <div class="row">
            <?php
foreach (array('yellow', 'green', 'blue', 'red', 'black', 'white') as &$value) {
    if ($value == $selectedgrade) {
        $checked = "checked";
    } else {
        $checked = "";
    }
    echo "            <div class=\"col\">";
    echo "                <input type=\"radio\" class=\"btn-check\" name=\"frmGrade\" id=\"$value\" value=\"$value\" autocomplete=\"off\" onclick=\"nextFocus('send')\" $checked>";
    echo "                <label class=\"btn btn-$value btn-c w-100\" for=\"$value\">&nbsp;</label>";
    echo "            </div>";
}
            ?>
        </div>
    </div>
    <div class="mb-3">
        <div class="row">
        <?php
foreach (array('yellowgreen', 'greenblue', 'bluered', 'redblack', 'blackwhite', 'rainbw') as &$value) {
    if ($value == $selectedgrade) {
        $checked = "checked";
    } else {
        $checked = "";
    }
    echo "            <div class=\"col\">";
    echo "                <input type=\"radio\" class=\"btn-check\" name=\"frmGrade\" id=\"$value\" value=\"$value\" autocomplete=\"off\" onclick=\"nextFocus('send')\" $checked>";
    echo "                <label class=\"btn btn-$value btn-c w-100\" for=\"$value\">&nbsp;</label>";
    echo "            </div>";
}
            ?> 
        </div>
    </div>

    <div class="mb-3">
        <div class="row">
            <label class="form-label">Style</label>
        </div>

        <div class="row gy-2">
            <div class="col-md-auto">
                <input type="radio" class="btn-check" name="frmStyle" id="send" value="send" onclick="nextFocus('submit')" autocomplete="off"<?php if ($selectedstyle == 'send') { echo " checked";}?>>
                <label class="btn btn-secondary" for="send">Send</label>
            </div>
            <div class="col-md-auto">
                <input type="radio" class="btn-check" name="frmStyle" id="flash" value="flash" onclick="nextFocus('submit')" autocomplete="off"<?php if ($selectedstyle == 'flash') { echo " checked";}?>>
                <label class="btn btn-secondary" for="flash">Flash!</label>
            </div>
            <div class="col-md-auto">
                <input type="radio" class="btn-check" name="frmStyle" id="repeat" value="repeat" onclick="nextFocus('submit')" autocomplete="off"<?php if ($selectedstyle == 'repeat') { echo " checked";}?>>
                <label class="btn btn-secondary" for="repeat">Repeat</label>
            </div>
        </div>

    </div>
    <input type="hidden" id="frmIsEdit" name="frmIsEdit" value="<?php echo $isEdit; ?>">
    <input type="hidden" id="frmSendId" name="frmSendId" value="<?php echo $send_id; ?>">
    <hr />
    <div class="mb-3">
        <input class="btn btn-primary" type="submit" id="submit" value="<?php echo $submitButtonText; ?>"> 
        <?php
            if (isset($edit) && (is_int(intval($edit)))) {
                // delete button
                //echo "<a href=\"deletesend.php?sendId=$edit\" class=\"btn btn-danger\">Delete Send<a/>";
                //echo "<a href=\"deletesend.php?sendId=$edit\" class=\"btn btn-danger\">Delete Send<a/>";
                ?>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#DeleteModal">Delete Send</button>  

                <!-- Modal -->
                <div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="DeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="DeleteModalLabel">Delete Send</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this send?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                        <a class="a btn btn-danger" href="<?php echo "deletesend.php?sendId=$edit";?>">Delete</a>
                    </div>
                    </div>
                </div>
                </div>

                <?php
            }
        ?>
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