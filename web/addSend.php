<?php
    session_start();
    if ($_SESSION['access'] != 'granted') {
      header("Location: login.php");
    }
    include('top.php');
?>
<div class="bg-light p-5 rounded">
<h1>Register new send</h1>
<form id="sendform" action="processsend.php" method="post">

    <div class="mb-3">
        <label for="frmCrag" class="form-label">Location</label>
        <select name="frmCrag" id="frmCrag" class="form-select form-select mb-3" aria-label=".form-select-lg example">
            <?php
                include "dbconfig.php";
                $query = "SELECT * FROM `bulder`.`bulder_crag`;";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='".$row["crag_id"]."'>".$row["name"]." (".$row["city"].")</option>";
                    }
                }
                mysqli_close($conn);
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="frmDate" class="form-label">Date</label>
        <input type="text" class="form-control" name="frmDate" id="frmDate" value="<?php if (isset($_SESSION['last_date'])) { echo $_SESSION['last_date']; } else { echo date("Y-m-d"); }?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Grade</label><br />
        <div class="row">
            <div class="col">
                <input type="radio" class="btn-check" name="frmGrade" id="yellow" value="yellow" autocomplete="off">
                <label class="btn btn-yellow w-100" for="yellow">&nbsp;</label>
            </div>
            <div class="col">
                <input type="radio" class="btn-check" name="frmGrade" id="green" value="green" autocomplete="off">
                <label class="btn btn-green w-100" for="green">&nbsp;</label>
            </div>
            <div class="col">
                <input type="radio" class="btn-check" name="frmGrade" id="blue" value="blue" autocomplete="off" checked>
                <label class="btn btn-blue w-100" for="blue">&nbsp;</label>
            </div>
            <div class="col">
                <input type="radio" class="btn-check" name="frmGrade" id="red" value="red" autocomplete="off">
                <label class="btn btn-red w-100" for="red">&nbsp;</label>
            </div>
            <div class="col">
                <input type="radio" class="btn-check" name="frmGrade" id="black" value="black" autocomplete="off">
                <label class="btn btn-black w-100" id="lblBlack" for="black">&nbsp;</label>
            </div>
            <div class="col">
                <input type="radio" class="btn-check" name="frmGrade" id="white" value="white" autocomplete="off">
                <label class="btn btn-white w-100" for="white">&nbsp;</label>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <div class="row">
            <div class="col">
                <input type="radio" class="btn-check" name="frmGrade" id="yellowgreen" value="yellowgreen" autocomplete="off">
                <label class="btn btn-yellowgreen w-100" for="yellowgreen">&nbsp;</label>
            </div>
            <div class="col">
                <input type="radio" class="btn-check" name="frmGrade" id="greenblue" value="greenblue" autocomplete="off">
                <label class="btn btn-greenblue w-100" for="greenblue">&nbsp;</label>
            </div>
            <div class="col">
                <input type="radio" class="btn-check" name="frmGrade" id="bluered" value="bluered" autocomplete="off">
                <label class="btn btn-bluered w-100" for="bluered">&nbsp;</label>
            </div>
            <div class="col">
                <input type="radio" class="btn-check" name="frmGrade" id="redblack" value="redblack" autocomplete="off">
                <label class="btn btn-redblack w-100" for="redblack">&nbsp;</label>
            </div>
            <div class="col">
                <input type="radio" class="btn-check" name="frmGrade" id="blackwhite" value="blackwhite" autocomplete="off">
                <label class="btn btn-blackwhite w-100" for="blackwhite">&nbsp;</label>
            </div>
            <div class="col">
                <input type="radio" class="btn-check" name="frmGrade" id="rainbw" value="rainbw" autocomplete="off">
                <label class="btn btn-rainbw w-100" for="rainbw">&nbsp;</label>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Style</label><br />
        <input type="radio" class="btn-check" name="frmStyle" id="send" value="send" autocomplete="off" checked>
        <label class="btn btn-secondary" for="send">Send</label>
        <input type="radio" class="btn-check" name="frmStyle" id="flash" value="flash" autocomplete="off">
        <label class="btn btn-secondary" for="flash">Flash!</label>
    </div>
    <div class="mb-3">
        <input class="btn btn-primary" type="submit" value="Submit">
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