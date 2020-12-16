<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Wedding Venue Finder</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
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
        .larger {
            font-size:larger;
            text-align:right;
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
    <script type="text/javascript">
        $(function(){
            $("#submit").click(function () {
                <!-- Uses jQuery to run the function if the submit button is clicked -->
                var date = $("#date").val();
                var endDate = $("#endDate").val();
                var partySize = $("#partySize").val();
                var cateringGrade = $("#cateringGrade").val();
                <!-- Gets the values entered into the input fields -->
                $("#MyTable").hide();
                $.post("weddingDataRetrieve.php", {date: date, endDate: endDate, partySize: partySize, cateringGrade:cateringGrade}, function (data, statusTxt){
                    //Passes the data to the other php file
                    if (statusTxt === "success") {
                        $("#result").html(data);
                        //Outputs the data if it is successfully sent
                    }
                    if (statusTxt === "error") {
                        document.getElementById("result").innerHTML = "Error";
                    }
                })
            });
        });
    </script>
</head>
<body>
<h3 class="center">COA123 - Server-Side Programming</h3>
<h2 class="center">Individual Coursework - Wedding Planner</h2>

<h1 class="center">Task 5 - Wedding Venue Planner</h1>
<p>
    <img src="weddingVenue.jpg"
         style="width: 600px;height: 500px"
         class="center"
         alt="Picture of wedding venue" />
    <!-- Source: https://pixabay.com/photos/events-venue-banquet-hall-wedding-2609526/ (Copyright free) -->
</p>
<table id="MyTable" border="1">
    <tr>
        <th scope="col">Key</th>
        <th scope="col">Value</th>
    </tr>
    <tr>
        <td><label for="date">First available date of wedding (dd/mm/yyyy)</label></td>
        <td>
            <input name="date" type="date" class="larger" id="date" value="2020-01-17" size="12" />
        </td>
    </tr>
    <tr>
        <td><label for="endDate">Last available date of wedding (dd/mm/yyyy)</label></td>
        <td>
            <input name="endDate" type="date" class="larger" id="endDate" value="2020-01-20" size="12" />
        </td>
    </tr>
    <!-- Gets the user to enter a range of dates -->
    <tr>
        <td><label for="partySize">Party size (1-1000)</label></td>
        <td><input name="partySize" type="text" class="larger" id="partySize" value="100" size="12" /></td>
    </tr>
    <tr>
        <td><label for="cateringGrade">Catering grade (1-5)</label></td>
        <td><input name="cateringGrade" type="number" class="larger" id="cateringGrade" value="3" size="12" min="1" max="5"/></td>
    </tr>
    <tr>
        <td>List suitable wedding venues from date, party size and catering grade</td>
        <td><input type="submit" name="submit" id="submit" value="Submit" class="larger" /></td>
    </tr>
</table>
<!-- Creates a table with input fields for the user to enter values into -->

<p id="result"></p>

</body>
</html>