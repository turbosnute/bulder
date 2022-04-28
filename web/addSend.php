<?php
    session_start();
    if ($_SESSION['access'] != 'granted') {
      header("Location: login.php");
    }
    include('top.php');
?>
  <div class="bg-light p-5 rounded">
    <h1>Register new send</h1>
    <form action="processsend.php" method="post">

        <div class="mb-3">
            <label for="frmCrag" class="form-label">Location</label>
            <select name="frmCrag" id="frmCrag" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
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
            <input type="text" class="form-control" name="frmDate" id="frmDate" value="2022-04-26">
        </div>
        <div class="mb-3">
            <label class="form-label">Grade</label><br />
            <input type="radio" class="btn-check" name="frmGrade" id="yellow" value="yellow" autocomplete="off">
            <label class="btn btn-yellow" for="yellow">&nbsp;</label>
            <input type="radio" class="btn-check" name="frmGrade" id="green" value="green" autocomplete="off">
            <label class="btn btn-green" for="green">&nbsp;</label>
            <input type="radio" class="btn-check" name="frmGrade" id="blue" value="blue" autocomplete="off" checked>
            <label class="btn btn-blue" for="blue">&nbsp;</label>
            <input type="radio" class="btn-check" name="frmGrade" id="red" value="red" autocomplete="off">
            <label class="btn btn-red" for="red">&nbsp;</label>
            <input type="radio" class="btn-check" name="frmGrade" id="black" value="black" autocomplete="off">
            <label class="btn btn-black" for="black">&nbsp;</label>
            <input type="radio" class="btn-check" name="frmGrade" id="white" value="white" autocomplete="off">
            <label class="btn btn-white" for="white">&nbsp;</label>
        </div>
        <div class="mb-3">
            <input type="radio" class="btn-check" name="frmGrade" id="yellowgreen" value="yellowgreen" autocomplete="off">
            <label class="btn btn-yellowgreen" for="yellowgreen">&nbsp;</label>
            <input type="radio" class="btn-check" name="frmGrade" id="greenblue" value="greenblue" autocomplete="off">
            <label class="btn btn-greenblue" for="greenblue">&nbsp;</label>
            <input type="radio" class="btn-check" name="frmGrade" id="bluered" value="bluered" autocomplete="off">
            <label class="btn btn-bluered" for="bluered">&nbsp;</label>
            <input type="radio" class="btn-check" name="frmGrade" id="redblack" value="redblack" autocomplete="off">
            <label class="btn btn-redblack" for="redblack">&nbsp;</label>
            <input type="radio" class="btn-check" name="frmGrade" id="blackwhite" value="blackwhite" autocomplete="off">
            <label class="btn btn-blackwhite" for="blackwhite">&nbsp;</label>
            <input type="radio" class="btn-check" name="frmGrade" id="rainbw" value="rainbw" autocomplete="off">
            <label class="btn btn-rainbw" for="rainbw">&nbsp;</label>
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
<?php
    include('bottom.php');
?>