<?php 
session_start();
if ($_SESSION['access'] != 'granted') {
    header("Location: login.php");
}
// Load the database configuration file 
include "dbconfig.php";
$query = "SELECT  `bulder_send`.`send_id`,`bulder_send`.`date`, `bulder_crag`.`name` ,`bulder_send`.style, `bulder_send`.grade, `bulder_grade`.`hardness`
FROM `bulder_send`
INNER JOIN `bulder`.`bulder_grade` ON `bulder_send`.grade = `bulder_grade`.grade
INNER JOIN `bulder`.`bulder_crag` ON `bulder_send`.crag_id = `bulder_crag`.crag_id
WHERE `user_id` = '".$_SESSION['user_id']."'
ORDER BY 'send_id'
";

// get log
$result = mysqli_query($conn, $query);

$log = array();
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
    $log[] = $row;
    }
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=sendlog.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('send_id', 'date', 'name', 'style', 'grade', 'hardness'));

if (count($log) > 0) {
    foreach ($log as $row) {
        fputcsv($output, $row);
    }
}
mysqli_close($conn);
?>