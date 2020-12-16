<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title></title>
    <style type="text/css">
        body {
            font-family: "Apple Chancery", Times, serif;
            background-color: #D6D6D6;
        }
        .center {
            text-align:center;
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }
        body,td,th {
            color: #06F;
        }
        table {
            margin-left:auto;
            margin-right:auto;
        }
        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
<h1 class="center">Result:</h1>
<table id="MyTable" border="1">

<?php
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

$db->setFetchMode(MDB2_FETCHMODE_ASSOC);

$date = $_GET['date'];
$date = str_replace('/', '-', $date);
$date = date("Y-m-d", strtotime($date));
//Gets the date that the user entered and changes its format
$partySize = $_GET['partySize'];
//Gets the party size entered by the user
$sql = "SELECT DISTINCT venue.name, venue.weekend_price, venue.weekday_price
FROM `venue` JOIN `venue_booking` ON venue.venue_id = venue_booking.venue_id
WHERE venue_booking.venue_id NOT IN (SELECT venue_id FROM venue_booking WHERE date_booked = '$date') AND venue.capacity >= $partySize";

$res =& $db->query($sql);
//SQL statement to get the costs of each of the venues on the given date that are available

if(PEAR::isError($res)){
    die($res->getMessage());
}

if ($partySize<0) {
    echo "Invalid value entered";
    //Validates the user input
} else {
    if ($res->numRows() > 0) {
        echo "<th scope=\"col\">Name</th><th scope=\"col\">Weekend Price (£)</th><th scope=\"col\">Weekday Price (£)</th>";
        // output data of each row
        while ($row = $res->fetchRow()) {
            $name = $row["name"];
            $weekendPrice = $row["weekend_price"];
            $weekdayPrice = $row["weekday_price"];
            echo "<tr><td>$name</td><td>$weekendPrice</td><td>$weekdayPrice</td></tr>";
        }
    } else {
        echo "<p class='center'>Venue not found</p>";
        //Outputs a suitable message if a venue isn't found
    }
}
?>

</body>
</html>