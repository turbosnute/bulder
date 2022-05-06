<style>
       table {
        border-collapse: collapse;
    }
    td {
        border: 1px solid #111;
        padding: 5px;
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

    .day.highlightYellow {
        background: #ff6;
    }
    .day.highlightGreen {
        background: #2f7;
    }

</style>

<?php
$year = 2021;

$headings = ["Su", "Mo","Tu","We","Th","Fr", "Sa"];

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

        // Logic here is random to simulate data from the DB
        // you would need to alter to do checks against the DB etc.
        $highlightClass = (
            !(random_int(1, 100) % 15) && $dayNumber
                ? "highlightYellow"
                : (
                    !(random_int(1, 100) % 35) && $dayNumber ? "highlightGreen" : ""
                )
            );
        echo "<td class='day {$highlightClass}'>{$dayNumber}</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>