<?php
	session_start();
    if (isset($_SESSION['user_class'])) {
		$user_class = $_SESSION['user_class'];
	} else {
		$user_class = null;
	}

	if ($user_class != 'admin') {
		header("Location: login.php");
	}
	include('top.php');
	include "dbconfig.php";
?>
  <div class="bg-light p-5 rounded">
    <h1>Setup</h1>
<?php

// var init
$gauth_client_id = '';
$gauth_client_secret = '';
$gauth_redirect_uri = '';

// check if db connection is ok.
// check if table exsists.
$query = "SHOW TABLES LIKE 'bulder_user';";
$result = mysqli_query($conn, $query);
$placeskey = null;
$gauthkey = null;

if (mysqli_num_rows($result) === 0) {
	echo "Creating user table...<br />";
	$query = "CREATE TABLE `bulder_user` (
		`user_id` INT NOT NULL AUTO_INCREMENT,
		`name` VARCHAR(50) NOT NULL DEFAULT '',
		`email` VARCHAR(50) NOT NULL DEFAULT '',
		`lastcrag_id` INT NOT NULL DEFAULT 0,
		`password` VARCHAR(128) NOT NULL DEFAULT '',
		`user_class` VARCHAR(10) NOT NULL DEFAULT 'user',
		`picture` VARCHAR(200) NOT NULL DEFAULT '',
		PRIMARY KEY (`user_id`)
	)
	COLLATE='utf8mb4_unicode_520_ci'
	;";
	mysqli_query($conn, $query);
} 


// Create tables
$query = "SHOW TABLES LIKE 'bulder_crag';";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
	echo "Creating crag table...<br />";
	$query = "CREATE TABLE `bulder_crag` (
		`crag_id` INT NOT NULL AUTO_INCREMENT,
		`name` VARCHAR(40) NOT NULL,
		`lon` DOUBLE NOT NULL DEFAULT 0,
		`lat` DOUBLE NOT NULL DEFAULT 0,
		`city` VARCHAR(30) NOT NULL DEFAULT '',
		PRIMARY KEY (`crag_id`)
	)
	COLLATE='utf8mb4_unicode_520_ci'
	;
	";

	mysqli_query($conn, $query);

	$query = "INSERT INTO `bulder_crag` (`crag_id`, `name`, `lon`, `lat`, `city`) VALUES
	(1, 'Grip Klatring Sluppen', 10.3953684, 63.39757919999999, 'Trondheim')";
	mysqli_query($conn, $query);

}

// Create tables

$query = "SHOW TABLES LIKE 'bulder_send';";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
	echo "Creating send table...<br />";
	$query = "CREATE TABLE `bulder_send` (
		`send_id` INT NOT NULL AUTO_INCREMENT,
		`user_id` INT NOT NULL DEFAULT '0',
		`crag_id` INT NOT NULL DEFAULT '0',
		`style` VARCHAR(10) NOT NULL DEFAULT 'send',
		`grade` VARCHAR(25) NOT NULL DEFAULT '0',
		`terrain` VARCHAR(10) NOT NULL DEFAULT 'indoor',
		`date` DATE NULL DEFAULT CURDATE(),
		PRIMARY KEY (`send_id`)
	)
	COLLATE='utf8mb4_unicode_520_ci'
	;";

	mysqli_query($conn, $query);
}

$query = "SHOW TABLES LIKE 'bulder_grade';";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
	echo "Creating grade table...<br />";
	$query = "CREATE TABLE `bulder_grade` (
		`grade` VARCHAR(25) NULL DEFAULT NULL,
		`hardness` TINYINT UNSIGNED NULL DEFAULT '0',
		`friendlyname` VARCHAR(25) NOT NULL,
		`cssclass` VARCHAR(50) NOT NULL DEFAULT 'bg-defgrade'
	)
	COLLATE='utf8mb4_unicode_520_ci'
	;";

	mysqli_query($conn, $query);

	$query = "ALTER TABLE `bulder_grade`
	CHANGE COLUMN `grade` `grade` VARCHAR(25) NOT NULL COLLATE 'utf8mb4_unicode_520_ci' FIRST,
	CHANGE COLUMN `hardness` `hardness` TINYINT(3) UNSIGNED NOT NULL AFTER `grade`,
	ADD UNIQUE INDEX `grade` (`grade`);";

	mysqli_query($conn, $query);

	$query = "INSERT INTO `bulder_grade` (`grade`, `hardness`, `friendlyname`, `cssclass`) VALUES
	('black', 18, 'Black', 'bg-black'),
	('blackwhite', 19, 'Black-White', 'bg-blackwhite'),
	('blue', 14, 'Blue', 'bg-blue'),
	('bluered', 15, 'Blue-Red', 'bg-bluered'),
	('green', 12, 'Green', 'bg-green'),
	('greenblue', 13, 'Green-Blue', 'bg-greenblue'),
	('rainbw', 1, 'Ungraded', 'bg-rainbw'),
	('red', 16, 'Red', 'bg-red'),
	('redblack', 17, 'Red-Black', 'bg-redblack'),
	('white', 20, 'White', 'bg-white'),
	('yellow', 10, 'Yellow', 'bg-yellow'),
	('yellowgreen', 11, 'Yellow-Green', 'bg-yellowgreen');";
	mysqli_query($conn, $query);
}


$query = "SHOW TABLES LIKE 'bulder_setting';";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
	echo "Creating setting table...<br />";
	$query = "CREATE TABLE `bulder_setting` (
		`setting` VARCHAR(20) NULL DEFAULT NULL,
		`value` VARCHAR(500) NULL DEFAULT NULL,
		UNIQUE INDEX `setting` (`setting`)
	)
	COLLATE='utf8mb4_unicode_520_ci'
	;
	";
	
	mysqli_query($conn, $query);

	$query = "INSERT INTO `bulder`.`bulder_setting` (`setting`, `value`) VALUES ('gauth_redirect_uri', 'http://localhost:7000/login.php');";
	mysqli_query($conn, $query);

} else {
	// sjekk om api keys finnes, hvis ikke opprett dem.
	$query = "SELECT * FROM `bulder`.`bulder_setting` WHERE setting = 'placeskey' LIMIT 1;";
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) != 0) {
		$row = mysqli_fetch_assoc($result);
		$placeskey = $row['value'];

	} else {
		$placeskey = "";
	}

	$query = "SELECT * FROM `bulder`.`bulder_setting` WHERE setting = 'gauth_client_id' LIMIT 1;";
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) != 0) {
		$row = mysqli_fetch_assoc($result);
		$gauth_client_id = $row['value'];
	} else {
		$gauth_client_id = "";
	}

	$query = "SELECT * FROM `bulder`.`bulder_setting` WHERE setting = 'gauth_client_secret' LIMIT 1;";
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) != 0) {
		$row = mysqli_fetch_assoc($result);
		$gauth_client_secret = $row['value'];
	} else {
		$gauth_client_secret = "";
	}
	
	$query = "SELECT * FROM `bulder`.`bulder_setting` WHERE setting = 'gauth_redirect_uri' LIMIT 1;";
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) != 0) {
		$row = mysqli_fetch_assoc($result);
		$gauth_redirect_uri = $row['value'];
	} else {
		$gauth_redirect_uri = "http://localhost:7000/login.php";
	}
}
mysqli_close($conn);


?>
<h3>Google Places</h3>
<form action="saveSetup.php" method="post">
        <div class="mb-3">
            <label for="frmPlacesKey" class="form-label">Google Maps Places API key (leave blank if you don't want to use places)</label>
            <input type="text" class="form-control" name="frmPlacesKey" id="frmPlacesKey" value="<?php echo $placeskey; ?>">
        </div>
		<h3>Google Authentication</h3>
        <div class="mb-3">
            <label for="frmGoogleAuthClientId" class="form-label">Client ID</label>
            <input type="text" class="form-control" name="frmGoogleAuthClientId" id="frmGoogleAuthClientId" value="<?php echo $gauth_client_id; ?>">
        </div>
        <div class="mb-3">
            <label for="frmGoogleAuthClientSecret" class="form-label">Client Secret</label>
            <input type="text" class="form-control" name="frmGoogleAuthClientSecret" id="frmGoogleAuthClientSecret" value="<?php echo $gauth_client_secret; ?>">
        </div>
        <div class="mb-3">
            <label for="frmGoogleAuthRedirectUri" class="form-label">Redirect Uri</label>
            <input type="text" class="form-control" name="frmGoogleAuthRedirectUri" id="frmGoogleAuthRedirectUri" value="<?php echo $gauth_redirect_uri; ?>">
        </div>
		<div class="mb-3">
            <input class="btn btn-primary" type="submit" value="Save">
        </div>
    </form>
</form>

</div>
<?php
    include('bottom.php');
?>