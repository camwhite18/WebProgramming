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

$minCapacity = $_GET['minCapacity'];
$maxCapacity = $_GET['maxCapacity'];
//Gets the min and max capacity entered by the user

$sql = "SELECT * FROM `venue` WHERE capacity BETWEEN $minCapacity AND $maxCapacity";
//SQL statement to fetch all the venues that have a capacity in between the values entered by the user

$res =& $db->query($sql);

if(PEAR::isError($res)){
    die($res->getMessage());
}

if ($minCapacity < 0 || $maxCapacity < 0 || $maxCapacity < $minCapacity) {
    echo "Invalid values entered";
    //Validates the user input
} else {
    if ($res->numRows() > 0) {
        echo "<th scope=\"col\">Venue ID</th><th scope=\"col\">Name</th><th scope=\"col\">Capacity</th><th scope=\"col\">Weekend Price</th><th scope=\"col\">Weekday Price</th><th scope=\"col\">Licensed</th>";
        // output data of each row
        while ($row = $res->fetchRow()) {
            if ($row["licensed"] == 1) {
                //Only gets the row if the venue is licensed
                $licensed = "yes";
                $venueID = $row["venue_id"];
                $name = $row["name"];
                $capacity = $row["capacity"];
                $weekendPrice = $row["weekend_price"];
                $weekdayPrice = $row["weekday_price"];
                echo "<tr><td>$venueID</td><td>$name</td><td>$capacity</td><td>$weekendPrice</td><td>$weekdayPrice</td><td>$licensed</td></tr>";
                //Adds a new row to the table
            }
        }
    } else {
        echo "<p class='center'>Venue not found</p>";
        //Outputs a suitable message if a venue isn't found
    }
}
?>

</body>
</html>