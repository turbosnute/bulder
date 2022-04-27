<?php

include "dbconfig.php";

// check if db connection is ok.

// check if table exsists.
$query = "SHOW TABLES LIKE 'bulder_user';";

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// use exec() because no results are returned
$conn->exec($query);

// Create tables
$query = "CREATE TABLE `bulder_user` (
	`user_id` INT NOT NULL,
	`name` VARCHAR(50) NOT NULL DEFAULT '',
	`email` VARCHAR(50) NOT NULL DEFAULT '',
	`lastcrag_id` INT NOT NULL DEFAULT 0,
	`password` VARCHAR(128) NOT NULL DEFAULT '0',
	PRIMARY KEY (`user_id`)
)
COLLATE='utf8mb4_unicode_520_ci'
;";

$query = "CREATE TABLE `bulder_crag` (
	`crag_id` INT NOT NULL,
	`name` INT NOT NULL,
	`lon` DOUBLE NOT NULL DEFAULT 0,
	`lat` DOUBLE NOT NULL DEFAULT 0,
	`city` VARCHAR(30) NOT NULL DEFAULT '0',
	PRIMARY KEY (`crag_id`)
)
COLLATE='utf8mb4_unicode_520_ci'
;
";


$query = "CREATE TABLE `bulder_ascent` (
	`ascent_id` INT NOT NULL,
	`user_id` INT NOT NULL,
	`crag_id` INT NOT NULL,
	`style` VARCHAR(15) NOT NULL DEFAULT 'send',
	`grade` VARCHAR(15) NOT NULL,
	`terrain` VARCHAR(15) NOT NULL DEFAULT 'indoor',
	PRIMARY KEY (`ascent_id`)
)
COLLATE='utf8mb4_unicode_520_ci'
;
";


// Maps api key.


?>