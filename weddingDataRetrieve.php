<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<body>
<table id="MyTable" border="1">

<?php
function getDatesFromRange($startDate, $endDate) {
    $tmpDate = new DateTime($startDate);
    $tmpEndDate = new DateTime($endDate);

    $outArray = array();
    do {
        $outArray[] = $tmpDate->format('Y-m-d');
    } while ($tmpDate->modify('+1 day') <= $tmpEndDate);
    //Creates an array with each of the dates in between the two entered by the user in
    return $outArray;
}

$startDate = $_POST['date'];
$startDate = str_replace('/', '-', $startDate);
$startDate = date("Y-m-d", strtotime($startDate));
$endDate = $_POST['endDate'];
$endDate = str_replace('/', '-', $endDate);
$endDate = date("Y-m-d", strtotime($endDate));
$partySize = $_POST['partySize'];
$cateringGrade = $_POST['cateringGrade'];
//Gets the values entered by the user into the table

$dateRange = getDatesFromRange($startDate, $endDate);

require_once 'MDB2.php';
include "coa123-mysql-connect.php";

$host='localhost';
$dbName = "coa123wdb";

// make connection to the server
$dsn = "mysql://$username:$password@$host/$dbName";
//Gets the username and password for the database from the 'coa123-mysql-connect' file
$db =& MDB2::connect($dsn);
//Initialises the database

if(PEAR::isError($db)){
    die($db->getMessage());
}

if ($partySize < 1 || $partySize > 1000 || $cateringGrade < 1 || $cateringGrade > 5) {
    echo "<p class='center'>Invalid value(s) entered</p>";
    //Validates the user input
} else {
$db->setFetchMode(MDB2_FETCHMODE_ASSOC);
echo "<th scope=\"col\">Name</th><th scope=\"col\">Capacity</th><th scope=\"col\">Weekend Price</th>
    <th scope=\"col\">Weekday Price</th><th scope=\"col\">Licensed</th><th scope=\"col\">Catering price per person </th>";
foreach ($dateRange as $date) {
    $sql = "SELECT DISTINCT venue.name, venue.capacity, venue.weekend_price, venue.weekday_price, venue.licensed, catering.cost
FROM `venue` JOIN `catering` ON venue.venue_id = catering.venue_id JOIN `venue_booking` ON venue.venue_id = venue_booking.venue_id
WHERE venue_booking.venue_id NOT IN (SELECT venue_id FROM venue_booking WHERE date_booked = '$date') AND catering.grade = $cateringGrade AND venue.capacity >= $partySize";
//SQL statement to get the venue details for the venues available on the given dates and with the correct capacity and catering grade

    $res =& $db->query($sql);

    if (PEAR::isError($res)) {
        die($res->getMessage());
    }
        if ($res->numRows() > 0) {
            $date = date("d-m-Y", strtotime($date));
            $date = str_replace('-', '/', $date);
            //Converts date to correct format
            echo "<tr><td colspan='100%' style='font-weight: bold'>$date</td></tr>";
            while ($row = $res->fetchRow()) {
                if ($row["licensed"] == 1) {
                    $licensed = "yes";
                } else {
                    $licensed = "no";
                }
                $name = $row["name"];
                $capacity = $row["capacity"];
                $weekendPrice = $row["weekend_price"];
                $weekdayPrice = $row["weekday_price"];
                $cateringPrice = $row["cost"];
                echo "<tr><td>$name</td><td>$capacity</td><td>£$weekendPrice</td><td>£$weekdayPrice</td><td>$licensed</td><td>£$cateringPrice</td></tr>";
                // output data of each row
            }
        } else {
            echo "<p class='center'>Venue not found on $date</p>";
            //Outputs a suitable message if a venue isn't found
        }
    }
}
echo "<button onclick=\"location.reload()\" class='center' style='height: 70px;width: 80px'>Enter different details</button>";
//Reloads the web page if the button is clicked and displays the initial table.
?>
</body>
