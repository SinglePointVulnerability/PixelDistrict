<?php
    include('session.php');
?>
<html lang="en">
<?php
    // open connection to the database
    require 'DBconn.php';
    
    
    // to access archived championship records
    if(isset($_GET['champYear'])) {
        $RaceYear = $_GET['champYear'];
    }
    else {
        $RaceYear = date("Y");
    }    


    
    
    /* PHP set up meal titles and descriptions */
    $starter1title = "Tomato and Roasted Red Pepper Soup";
    $starter1desc = "With Herb Croutons";
    $starter2title = "Pressed Ham Hock and Apricot Terrine";
    $starter2desc = "Served with Plum and Damson Chutney";
    $starter3title = "Melon Rose with Pineapple Carpaccio";
    $starter3desc = "Fruit Salsa and Champagne Sorbet";
    $starter4title = "Smoked Haddock Fishcakes";
    $starter4desc = "With Sweet Chilli Aioli";

    $main1title = "Roasted Chicken";
    $main1desc = "With Sage and Onion Stuffing, Chipolata <br> Bacon Roll, Cranberry Sauce and Roast Gravy";
    $main2title = "Slow Cooked Feather Blade of Beef";
    $main2desc = "Port and Red Wine Jus and Parsnip Crisps";
    $main3title = "Pan Roasted Cumbrian Lamb Rump";
    $main3desc = "Braised Red Cabbage and Red Currant Jus";
    $main4title = "Oven Roasted Salmon with a Herb Crust";
    $main4desc = "With Wilted Spinach, Roast Cherry Tomatoes <br> and a Tarragon and White Wine Cream Sauce";
    $main5title = "Tagliatelle with Mediterranean Vegetables";
    $main5desc = "Tomato and Basil Sauce and Parmesan Shavings";

    $dessert1title = "Traditional Christmas Pudding";
    $dessert1desc = "With Brandy Sauce";
    $dessert2title = "Mixed Berry Cheesecake";
    $dessert2desc = "With Raspberry Compote";
    $dessert3title = "Chocolate Nemesis";
    $dessert3desc = "Chocolate Sauce and White Chocolate Ice Cream";
    $dessert4title = "Glazed Lemon Tart";
    $dessert4desc = "With Eton Mess Cream";
    
?>
    <head>
      <meta charset="utf-8">

      <title>Cumberland AC <?php echo $RaceYear;?></title>
      <meta name="description" content="Cumberland AC Championship <?php echo $RaceYear;?>">
      <meta name="author" content="West Coast Web Design">

      <link rel="stylesheet" href="css/styles.css<?php echo "?date=" . date("Y-m-d_H-i"); ?>">

      <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
      <![endif]-->
    </head>

    <body>
<?php
            /* add an entry into the database */
            $sql = "SELECT BookingEmail, BookingName, PeopleAgainstBooking FROM viewpresdinnerbookings_peopleperbooking;";
    
            $result = mysqli_query($conn,$sql);

            if (mysqli_num_rows($result) > 0) {
                
                echo "<table>";
                echo "<tr>";
                echo "<th colspan='3'>CAC Presentation Dinner Bookings Summary Table</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>Booking Email</th>";
                echo "<th>Booking Name</th>";
                echo "<th>People Against the Booking</th>";
                echo "</tr>";

                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $BookingEmail = $row["BookingEmail"];
                    $BookingName = $row["BookingName"];
                    $PeopleAgainstBooking = $row["PeopleAgainstBooking"];
                    $total_bookings = $total_bookings + $PeopleAgainstBooking;
                    
                    echo "<tr>";
                    echo "<td>" . $BookingEmail . "</td>";
                    echo "<td>" . $BookingName . "</td>";
                    echo "<td>" . $PeopleAgainstBooking . "</td>";
                    echo "</tr>";
                }
                    echo "<tr>";
                    echo "<td colspan = '2' style='text-align:right'>Total Bookings: </td>";
                    echo "<td>" . $total_bookings . "</td>";
                    echo "</tr>";                
                echo "</table>";
            }
            else {
                echo "<br> Sorry, no booking data found for the presentation dinner";
            }    
?>

        <table>
            <tr>
                <td><a href="index.php">Back</a></td>
            </tr>
        </table>
    </body>
</html>