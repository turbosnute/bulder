<?php
    session_start();
    $site = "addUser";
    if (isset($_SESSION['user_class'])) {
      $user_class = $_SESSION['user_class'];
    } else {
          $user_class = null;
    }

    if ($user_class != 'admin') {
      header("Location: login.php");
    }
    include('top.php');  
?>

  <div class="bg-light p-5 rounded">
    <h1>Add <?php if ( (isset($_GET['firstuser'])) && ($_GET['firstuser'] == 'true') ) { echo "Admin "; }?>User</h1>
    <form method="post" action="processnewuser.php">
        <div class="mb-3">
            <label for="frmName" class="form-label">Name</label>
            <input type="text" class="form-control" name="frmName" id="frmName" value="">
        </div>
        <div class="mb-3">
            <label for="frmMail" class="form-label">Mail</label>
            <input type="email" class="form-control" id="frmMail" name="frmMail" placeholder="Enter email">
        </div>
        <div class="mb-3">
            <label for="frmPw" class="form-label">Password</label>
            <input type="password" class="form-control" name="frmPw" id="frmPw" placeholder="Password">
        </div>
        <div class="mb-3">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="frmAdminUser" name="frmAdminUser" <?php if (isset($_GET['firstuser']) && (($_GET['firstuser'] == 'true'))) { echo "checked"; }?>>
            <label class="form-check-label" for="frmAdminUser">Admin User</label>
          </div>
        </div>
        <div class="mb-3">
            <input class="btn btn-primary" type="submit" value="Submit">
        </div>
    </form>
  </div>



<?php
    include('bottom.php');
?>