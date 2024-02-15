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

    $site = "diary";
    include('top.php');
?>
  <div class="bg-light p-5 rounded">
    <h1>Bouldering Diary</h1>
<style>
    table {
        border-collapse: collapse;
        font-size: 0.80rem;
        /* margin: 0 auto; */
    }
    td {
        border: 1px solid #111;
        padding: 2px;
        text-align: center;
    }
    tr {
    }
    .monthName {
        width: 15ch;
    }
    .day {
        width: 2.5ch;
    }
    
    .day:nth-child(7n), .day:nth-child(7n+1)  {
        background: #aaa;
    }

    .day.highlightGreen {
        background: #43db2c;
    }
    .day.today {
        font-weight: bold;
        color: red;
    }
</style>

<?php
$date = date('Y-m-d');

$currentYear = date('Y');
//echo "<strong>".date("Y-m-d", strtotime("2011-1-7"))."</strong>";
$haystack = array(); // all unique dates from the current user within the same year.
//in_array(mixed $needle, array $haystack
include "dbconfig.php";

$yearQuery = "SELECT distinct YEAR(`date`) AS 'year' FROM bulder_send WHERE user_id = '$user_id' ORDER BY YEAR DESC";
$yearResult = mysqli_query($conn, $yearQuery);

if (isset($_POST['frmYear'])) {
   $frmYear = $_POST['frmYear'];
   if ((intval($frmYear) > 1990) && (intval($frmYear < 2050))) {
     $year = intval($frmYear);
   } else {
     $year = $currentYear;
   }
} else {
   $year = $currentYear;
}



$query = "SELECT DISTINCT `bulder_send`.`date`
          FROM `bulder_send`
          WHERE `user_id` = '".$_SESSION['user_id']."' AND YEAR(`date`) IN ($year)";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    array_push($haystack,$row['date']);
  }
}

$headings = ["Su", "Mo","Tu","We","Th","Fr", "Sa"];


//$num = mysqli_num_rows($yearResult);
//echo "num: $num";
?>
<form action="diary2.php" method="POST">
<select name="frmYear" id="year" onchange="this.form.submit()">
<?php

if (mysqli_num_rows($yearResult) > 0) {
  while($row = mysqli_fetch_assoc($yearResult)) {
    echo "   <option value='".$row['year']."'";

    if ($year == $row['year']) {
      echo " selected";
    }

    echo ">".$row['year']."</optioin>";
  }
} else {
    echo "   <option value='$year'>$year</option>";
}
mysqli_close($conn);

?>
</select>
</form>
<?php


echo "<table class=calendar>";           // Create the table
echo "<tr><td><b>Months</b></td>";       // Column heading for months
for ($x = 1; $x <= 37; $x++) {           // Column headings for days
    $title = ($headings[($x % 7) ]);
    echo "<td class=day>{$title}</td>";
}
echo "</tr>";

// Cycle through each month of the year
for ($month = 1; $month <= 12; $month++) {
    $thisMonth   = new DateTime("{$year}-{$month}");   // Create date object (defaults to 1st of month)
    $daysInMonth = $thisMonth->format("t");            // Get the number of days in the month
    $monthName   = $thisMonth->format("F");            // Get the month in textual form
    echo "<tr class=month><td class=monthName>{$monthName}</td>";
    $dayOffsetArray = [
        "Monday"    => 0,
        "Tuesday"   => 1,
        "Wednesday" => 2,
        "Thursday"  => 3,
        "Friday"    => 4,
        "Saturday"  => 5,
        "Sunday"    => 6,
    ];


    // Get the number of days to pad the month row with and output blank cells in a loop
    $offset = $dayOffsetArray[$thisMonth->format("l")];
    for ($i = 0; $i < $offset; $i++){
        echo "<td class=day></td>";
    }

    // Output the individual days
    for ($day = 1; $day <= 37  - $offset; $day++) {
        $dayNumber      = ($day <= $daysInMonth) ? $day : "";
        
        //echo "$day $month $year<br />";
        $processingDate = date("Y-m-d", strtotime("$year-$month-$dayNumber"));

        // Logic here is random to simulate data from the DB
        // you would need to alter to do checks against the DB etc.
        if (in_array($processingDate, $haystack)) {
            $highlightClass = ' highlightGreen';
        } else {
            $highlightClass = '';
        }
        
        if ($processingDate == $date) {
            $highlightClass  = "$highlightClass today";
        } 

        echo "<td class='day$highlightClass'>{$dayNumber}</td>";
    }
    echo "</tr>";
}
echo "</table></div>";

include('bottom.php');
?>
