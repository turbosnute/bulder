<?php
    session_start();
    if ($_SESSION['access'] != 'granted') {
      header("Location: login.php");
    }
    include('top.php');
?>
  <div class="bg-light p-5 rounded">
    <h1>Register new send</h1>
    <form>

        <div class="mb-3">
            <label for="frmCrag" class="form-label">Location</label>
            <select id="frmCrag" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                <option selected>Select Location</option>
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
            <input type="text" class="form-control" id="frmDate" value="2022-04-26">
        </div>
        <div class="mb-3">
            <label class="form-label">Grade</label><br />
            <button type="button" class="btn btn-yellow" data-bs-toggle="button" autocomplete="off">&nbsp;</button>
            <button type="button" class="btn btn-green" data-bs-toggle="button" autocomplete="off">&nbsp;</button>
            <button type="button" class="btn btn-blue" data-bs-toggle="button" autocomplete="off">&nbsp;</button>
            <button type="button" class="btn btn-red" data-bs-toggle="button" autocomplete="off">&nbsp;</button>
            <button type="button" class="btn btn-black" data-bs-toggle="button" autocomplete="off">&nbsp;</button>
            <button type="button" class="btn btn-white" data-bs-toggle="button" autocomplete="off">&nbsp;</button>
        </div>
        <div class="mb-3">
            <button type="button" class="btn btn-yellowgreen" data-bs-toggle="button" autocomplete="off">&nbsp;</button>
            <button type="button" class="btn btn-greenblue" data-bs-toggle="button" autocomplete="off">&nbsp;</button>
            <button type="button" class="btn btn-bluered" data-bs-toggle="button" autocomplete="off">&nbsp;</button>
            <button type="button" class="btn btn-redblack" data-bs-toggle="button" autocomplete="off">&nbsp;</button>
            <button type="button" class="btn btn-blackwhite" data-bs-toggle="button" autocomplete="off">&nbsp;</button>
            <button type="button" class="btn btn-rainbw" data-bs-toggle="button" autocomplete="off">&nbsp;</button>
        </div>
        <div class="mb-3">
            <label class="form-label">Style</label><br />
            <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" checked>
            <label class="btn btn-secondary" for="option1">Send</label>
            <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off">
            <label class="btn btn-secondary" for="option2">Flash!</label>
        </div>
        <div class="mb-3">
            <input class="btn btn-primary" type="submit" value="Submit">
        </div>
    </form>
  </div>
<?php
    include('bottom.php');
?>