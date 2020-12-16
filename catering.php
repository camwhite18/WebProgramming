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
<table border="1" width="500">
    <th class="head">cost per person (£)→ <br>↓ party size <br></th><th class="head"><?=$_GET['c1']?></th>
    <th class="head"><?=$_GET['c2']?></th><th class="head"><?=$_GET['c3']?></th><th class="head"><?=$_GET['c4']?></th>
    <th class="head"><?=$_GET['c5']?></th>
    <!-- Creates the table -->
    <?php
    for ($i=$_GET['min'];$i<=$_GET['max'];$i+=5) {
        //Loops through from the minimum party size to the maximum in increments of five
        $c1 = intval($_GET['c1'])*intval($i);
        $c2 = intval($_GET['c2'])*intval($i);
        $c3 = intval($_GET['c3'])*intval($i);
        $c4 = intval($_GET['c4'])*intval($i);
        $c5 = intval($_GET['c5'])*intval($i);
        echo "<tr><td class=\"cell1\">$i</td><td class=\"cell1\">$c1</td><td class=\"cell1\">$c2</td><td class=\"cell1\">$c3</td>
              <td class=\"cell1\">$c4</td><td class=\"cell1\">$c5</td></tr>";
        //Adds a row to the table for the number of people and the cot at each catering grade
    }
    ?>
</table>
</body>
</html>