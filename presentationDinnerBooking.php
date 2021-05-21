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
    
    /* PHP process form submissions */
    if (isset($_POST["txtreservationname"]))
    {
        $reservationname = htmlspecialchars($_POST["txtreservationname"]);
        $reservationemail = htmlspecialchars($_POST["txtreservationemail"]);    
        
        /* STARTERS */        
        $starter1chosen = htmlspecialchars($_POST["starter1chosen"]);
        $starter1qty = htmlspecialchars($_POST["qtystarter1"]);
        $starter1notes = htmlspecialchars($_POST["txtstarter1"]);

        $starter2chosen = htmlspecialchars($_POST["starter2chosen"]);
        $starter2qty = htmlspecialchars($_POST["qtystarter2"]);
        $starter2notes = htmlspecialchars($_POST["txtstarter2"]);

        $starter3chosen = htmlspecialchars($_POST["starter3chosen"]);
        $starter3qty = htmlspecialchars($_POST["qtystarter3"]);
        $starter3notes = htmlspecialchars($_POST["txtstarter3"]);

        $starter4chosen = htmlspecialchars($_POST["starter4chosen"]);
        $starter4qty = htmlspecialchars($_POST["qtystarter4"]);
        $starter4notes = htmlspecialchars($_POST["txtstarter4"]);    

        /* MAINS */

        $main1chosen = htmlspecialchars($_POST["main1chosen"]);
        $main1qty = htmlspecialchars($_POST["qtymain1"]);
        $main1notes = htmlspecialchars($_POST["txtmain1"]);

        $main2chosen = htmlspecialchars($_POST["main2chosen"]);
        $main2qty = htmlspecialchars($_POST["qtymain2"]);
        $main2notes = htmlspecialchars($_POST["txtmain2"]);

        $main3chosen = htmlspecialchars($_POST["main3chosen"]);
        $main3qty = htmlspecialchars($_POST["qtymain3"]);
        $main3notes = htmlspecialchars($_POST["txtmain3"]);

        $main4chosen = htmlspecialchars($_POST["main4chosen"]);
        $main4qty = htmlspecialchars($_POST["qtymain4"]);
        $main4notes = htmlspecialchars($_POST["txtmain4"]);       

        $main5chosen = htmlspecialchars($_POST["main5chosen"]);
        $main5qty = htmlspecialchars($_POST["qtymain5"]);
        $main5notes = htmlspecialchars($_POST["txtmain5"]);   

        /* DESSERTS */

        $dessert1chosen = htmlspecialchars($_POST["dessert1chosen"]);
        $dessert1qty = htmlspecialchars($_POST["qtydessert1"]);
        $dessert1notes = htmlspecialchars($_POST["txtdessert1"]);

        $dessert2chosen = htmlspecialchars($_POST["dessert2chosen"]);
        $dessert2qty = htmlspecialchars($_POST["qtydessert2"]);
        $dessert2notes = htmlspecialchars($_POST["txtdessert2"]);

        $dessert3chosen = htmlspecialchars($_POST["dessert3chosen"]);
        $dessert3qty = htmlspecialchars($_POST["qtydessert3"]);
        $dessert3notes = htmlspecialchars($_POST["txtdessert3"]);

        $dessert4chosen = htmlspecialchars($_POST["dessert4chosen"]);
        $dessert4qty = htmlspecialchars($_POST["qtydessert4"]);
        $dessert4notes = htmlspecialchars($_POST["txtdessert4"]);          
    }


    
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
        /* only ouput here if there are order details to show */
        if(!empty($reservationname)) {
            echo "Booking made for " . $reservationname . " (" . $reservationemail . ")";
            echo "<br>";
            
            $starterstextblock = $starterstextblock . "<br><br>STARTER:<br>";
            
            if($starter1chosen == "YES") {
                $starterstextblock = $starterstextblock . "<br>" .
                    "<b>" . $starter1title . "</b> x " . $starter1qty . " (<i>" . $starter1notes . "</i>)";                
            }
            if($starter2chosen == "YES") {
                $starterstextblock = $starterstextblock . "<br>" .
                    "<b>" . $starter2title . "</b> x " . $starter2qty . " (<i>" . $starter2notes . "</i>)";
            }
            if($starter3chosen == "YES") {
                $starterstextblock = $starterstextblock . "<br>" .
                    "<b>" . $starter3title . "</b> x " . $starter3qty . " (<i>" . $starter3notes . "</i>)";
            }
            if($starter4chosen == "YES") {
                $starterstextblock = $starterstextblock . "<br>" .
                     "<b>" . $starter4title . "</b> x " . $starter4qty . " (<i>" . $starter4notes . "</i>)";
            }
            echo $starterstextblock;
            echo "<br>";
            echo "<br>";
            
            
            $mainstextblock = $mainstextblock . "<br><br>MAIN:<br>";
            
            if($main1chosen == "YES") {
                $mainstextblock = $mainstextblock . "<br>" .
                    "<b>" . $main1title . "</b> x " . $main1qty . " (<i>" . $main1notes . "</i>)";                
            }
            if($main2chosen == "YES") {
                $mainstextblock = $mainstextblock . "<br>" .
                    "<b>" . $main2title . "</b> x " . $main2qty . " (<i>" . $main2notes . "</i>)";
            }
            if($main3chosen == "YES") {
                $mainstextblock = $mainstextblock . "<br>" .
                    "<b>" . $main3title . "</b> x " . $main3qty . " (<i>" . $main3notes . "</i>)";
            }
            if($main4chosen == "YES") {
                $mainstextblock = $mainstextblock . "<br>" .
                     "<b>" . $main4title . "</b> x " . $main4qty . " (<i>" . $main4notes . "</i>)";
            }
            if($main5chosen == "YES") {
                $mainstextblock = $mainstextblock . "<br>" .
                     "<b>" . $main5title . "</b> x " . $main5qty . " (<i>" . $main5notes . "</i>)";
            }
            echo $mainstextblock;
            echo "<br>";
            echo "<br>";            

            
            $dessertstextblock = $dessertstextblock . "<br><br>DESSERT:<br>";
            
            if($dessert1chosen == "YES") {
                $dessertstextblock = $dessertstextblock . "<br>" .
                    "<b>" . $dessert1title . "</b> x " . $dessert1qty . " (<i>" . $dessert1notes . "</i>)";                
            }
            if($dessert2chosen == "YES") {
                $dessertstextblock = $dessertstextblock . "<br>" .
                    "<b>" . $dessert2title . "</b> x " . $dessert2qty . " (<i>" . $dessert2notes . "</i>)";
            }
            if($dessert3chosen == "YES") {
                $dessertstextblock = $dessertstextblock . "<br>" .
                    "<b>" . $dessert3title . "</b> x " . $dessert3qty . " (<i>" . $dessert3notes . "</i>)";
            }
            if($dessert4chosen == "YES") {
                $dessertstextblock = $dessertstextblock . "<br>" .
                     "<b>" . $dessert4title . "</b> x " . $dessert4qty . " (<i>" . $dessert4notes . "</i>)";
            }
            echo $dessertstextblock;
            echo "<br>";
            echo "<br>";
            
            echo "Please check your emails for confirmation <br>(including your spam / junk in case it appears in there!) :)";
            echo "<br><br>";
            echo "<i>The cost is £22.50 <b>PER PERSON</b>. We are trying to reduce the physical cash handling, so please pay this via online transfer to:<br><br>S/C 77-56-07 <br>A/C 52712660 <br> <i>Account Name is Tracey Owen</i>.<br><br>When doing this it is really important that as the payment reference you make it clear who you are so please, please put as much information as your online banking will allow - as a minimum your initial and surname</i>";
            echo "<br><br>";
            
            /* send out the confirmation email to the admin team and the customer's given email address*/

            $to = $reservationemail;
            $subject = "Cumberland AC Presentation Dinner";
            $txt = "Hi $reservationname, thanks for booking on to the 2020 presentation dinner! "
                 . "<br><br> Your order details are as follows:" . $starterstextblock . $mainstextblock . $dessertstextblock . "<br><br>"
                 . "<i>The cost is £22.50 <b>PER PERSON</b>. We are trying to reduce the physical cash handling, so please pay this via online transfer to:<br><br>S/C 77-56-07 <br>A/C 52712660 <br> <i>Account Name is Tracey Owen</i>.<br><br>When doing this it is really important that as the payment reference you make it clear who you are so please, please put as much information as your online banking will allow - as a minimum your initial and surname</i>";
            $headers = 'MIME-Version: 1.0' . "\r\n" .
                       'Content-type: text/html;charset=UTF-8' . "\r\n" .
                       'From: hello@pixeldistrict.co.uk' . "\r\n" .
                       'Bcc: my.pyne@gmail.com, t-owen@hotmail.co.uk';
            
            /* send the email */
            mail($to,$subject,$txt,$headers);

            
            
            /* add an entry into the database */
            $sql = "INSERT INTO tblPresentationDinnerBookings (BookingName,
                                                               BookingEmail" .
                                                               ($starter1qty <> "" ? ",Starter1Qty" : "") .
                                                               ($starter1notes <> "" ? ",Starter1Notes" : "") .
                                                               ($starter2qty <> "" ? ",Starter2Qty" : "") .
                                                               ($starter2notes <> "" ? ",Starter2Notes" : "") .
                                                               ($starter3qty <> "" ? ",Starter3Qty" : "") .
                                                               ($starter3notes <> "" ? ",Starter3Notes" : "") .
                                                               ($starter4qty <> "" ? ",Starter4Qty" : "") .
                                                               ($starter4notes <> "" ? ",Starter4Notes" : "") .
                                                               ($main1qty <> "" ? ",Main1Qty" : "") .
                                                               ($main1notes <> "" ? ",Main1Notes" : "") .
                                                               ($main2qty <> "" ? ",Main2Qty" : "") .
                                                               ($main2notes <> "" ? ",Main2Notes" : "") .
                                                               ($main3qty <> "" ? ",Main3Qty" : "") .
                                                               ($main3notes <> "" ? ",Main3Notes" : "") .
                                                               ($main4qty <> "" ? ",Main4Qty" : "") .
                                                               ($main4notes <> "" ? ",Main4Notes" : "") .
                                                               ($main5qty <> "" ? ",Main5Qty" : "") .
                                                               ($main5notes <> "" ? ",Main5Notes" : "") .
                                                               ($dessert1qty <> "" ? ",Dessert1Qty" : "") .
                                                               ($dessert1notes <> "" ? ",Dessert1Notes" : "") .
                                                               ($dessert2qty <> "" ? ",Dessert2Qty" : "") .
                                                               ($dessert2notes <> "" ? ",Dessert2Notes" : "") .
                                                               ($dessert3qty <> "" ? ",Dessert3Qty" : "") .
                                                               ($dessert3notes <> "" ? ",Dessert3Notes" : "") .
                                                               ($dessert4qty <> "" ? ",Dessert4Qty" : "") .
                                                               ($dessert4notes <> "" ? ",Dessert4Notes" : "") .
                                                               ") " .
                "VALUES ('" . mysqli_real_escape_string($conn,$reservationname) . "', " .
                        "'" . mysqli_real_escape_string($conn,$reservationemail) . "'" .
                        ($starter1qty <> "" ? "," . mysqli_real_escape_string($conn,$starter1qty) : "") .
                        ($starter1notes <> "" ? ",'" . mysqli_real_escape_string($conn,$starter1notes) . "'" : "") .
                        ($starter2qty <> "" ? "," . mysqli_real_escape_string($conn,$starter2qty) : "") .
                        ($starter2notes <> "" ? ",'" . mysqli_real_escape_string($conn,$starter2notes) . "'" : "") .
                        ($starter3qty <> "" ? "," . mysqli_real_escape_string($conn,$starter3qty) : "") .
                        ($starter3notes <> "" ? ",'" . mysqli_real_escape_string($conn,$starter3notes) . "'" : "") .
                        ($starter4qty <> "" ? "," . mysqli_real_escape_string($conn,$starter4qty) : "") .
                        ($starter4notes <> "" ? ",'" . mysqli_real_escape_string($conn,$starter4notes) . "'" : "") .
                        ($main1qty <> "" ? "," . mysqli_real_escape_string($conn,$main1qty) : "") .
                        ($main1notes <> "" ? ",'" . mysqli_real_escape_string($conn,$main1notes) . "'" : "") .
                        ($main2qty <> "" ? "," . mysqli_real_escape_string($conn,$main2qty) : "") .
                        ($main2notes <> "" ? ",'" . mysqli_real_escape_string($conn,$main2notes) . "'" : "") .
                        ($main3qty <> "" ? "," . mysqli_real_escape_string($conn,$main3qty) : "") .
                        ($main3notes <> "" ? ",'" . mysqli_real_escape_string($conn,$main3notes) . "'" : "") .
                        ($main4qty <> "" ? "," . mysqli_real_escape_string($conn,$main4qty) : "") .
                        ($main4notes <> "" ? ",'" . mysqli_real_escape_string($conn,$main4notes) . "'" : "") .
                        ($main5qty <> "" ? "," . mysqli_real_escape_string($conn,$main5qty) : "") .
                        ($main5notes <> "" ? ",'" . mysqli_real_escape_string($conn,$main5notes) . "'" : "") .
                        ($dessert1qty <> "" ? "," . mysqli_real_escape_string($conn,$dessert1qty) : "") .
                        ($dessert1notes <> "" ? ",'" . mysqli_real_escape_string($conn,$dessert1notes) . "'" : "") .
                        ($dessert2qty <> "" ? "," . mysqli_real_escape_string($conn,$dessert2qty) : "") .
                        ($dessert2notes <> "" ? ",'" . mysqli_real_escape_string($conn,$dessert2notes) . "'" : "") .
                        ($dessert3qty <> "" ? "," . mysqli_real_escape_string($conn,$dessert3qty) : "") .
                        ($dessert3notes <> "" ? ",'" . mysqli_real_escape_string($conn,$dessert3notes) . "'" : "") .
                        ($dessert4qty <> "" ? "," . mysqli_real_escape_string($conn,$dessert4qty) : "") .
                        ($dessert4notes <> "" ? ",'" . mysqli_real_escape_string($conn,$dessert4notes) . "'" : "") .
                        ");";
    
            if (mysqli_query($conn,$sql) === TRUE) {
                // echo "New record created successfully";
            } else {
                echo "Error: <br><br>" . $conn->error . "<br><br> SQL String --> " . $sql . " <--";
            } 
        
        
        } else {

            ?>

            <script type="text/javascript">
                function checkBoxToggle(arg1)
                {
                    var selectedCheckBox = document.getElementById(arg1);
                    var selectedQuantity = document.getElementById("qty" + arg1);

                    if (selectedCheckBox.checked == true) {
                        selectedQuantity.value = "1";
                        selectedQuantity.style.display = '';
                    } else {
                        selectedQuantity.value = "";
                        selectedQuantity.style.display = 'none';
                    }
                }
                function checkForm()
                {
                    var iStarters;
                    var iStartersNotOkay = 0; /* incremented when a chosen starter doesn't have a qty against it */

                    for (iStarters = 1; iStarters <= 4; iStarters++)
                    {
                        var st = document.getElementById("starter" + iStarters);
                        var st_hdn = document.getElementById("starter" + iStarters + "chosen");
                        var st_qty = document.getElementById("qtystarter" + iStarters);

                        st_qty.style.backgroundColor = "white"; /* default background */

                        if (st.checked == true) {
                            st_hdn.value = "YES";
                            if (st_qty.value == "") {
                                alert("Please ensure there's a quantity for each of your chosen starters");
                                st_qty.style.backgroundColor = "yellow";
                                iStartersNotOkay = iStartersNotOkay + 1;
                            }
                        } else {
                            st_hdn.value = "NO";
                        }                    
                    }


                    /* MAINS */
                    var iMains;
                    var iMainsNotOkay = 0; /* incremented when a chosen main doesn't have a qty against it */

                    for (iMains = 1; iMains <= 5; iMains++)
                    {
                        var mn = document.getElementById("main" + iMains);
                        var mn_hdn = document.getElementById("main" + iMains + "chosen");
                        var mn_qty = document.getElementById("qtymain" + iMains);

                        mn_qty.style.backgroundColor = "white"; /* default background */

                        if (mn.checked == true) {
                            mn_hdn.value = "YES";
                            if (mn_qty.value == "") {
                                alert("Please ensure there's a quantity for each of your chosen mains");
                                mn_qty.style.backgroundColor = "yellow";
                                iMainsNotOkay = iMainsNotOkay + 1;
                            }
                        } else {
                            mn_hdn.value = "NO";
                        }                    
                    }


                    /* DESSERTS */
                    var iDesserts;
                    var iDessertsNotOkay = 0; /* incremented when a chosen dessert doesn't have a qty against it */

                    for (iDesserts = 1; iDesserts <= 4; iDesserts++)
                    {
                        var ds = document.getElementById("dessert" + iDesserts);
                        var ds_hdn = document.getElementById("dessert" + iDesserts + "chosen");
                        var ds_qty = document.getElementById("qtydessert" + iDesserts);

                                ds_qty.style.backgroundColor = "white"; /* default background */

                        if (ds.checked == true) {
                            ds_hdn.value = "YES";
                            if (ds_qty.value == "") {
                                alert("Please ensure there's a quantity for each of your chosen desserts");
                                ds_qty.style.backgroundColor = "yellow";
                                iDessertsNotOkay = iDessertsNotOkay + 1;
                            }
                        } else {
                            ds_hdn.value = "NO";
                        }                    
                    }








                    /*

                        Check the booking reference and the email address have been entered

                    */
                    if(document.getElementById("txtreservationname").value=="") {
                        alert("Please enter the name this booking is being made under");
                        document.getElementById("txtreservationname").style.backgroundColor="yellow";
                    } else {
                        document.getElementById("txtreservationname").style.backgroundColor="white";
                    }

                    if(document.getElementById("txtreservationemail").value=="") {
                        alert("Please enter an email address for the booking confirmation");
                        document.getElementById("txtreservationemail").style.backgroundColor="yellow";
                    } else {
                        document.getElementById("txtreservationemail").style.backgroundColor="white";
                    }

                    /* submit the form if everything is okay */

                    if (iStartersNotOkay == 0 && iMainsNotOkay == 0 && iDessertsNotOkay == 0 && document.getElementById("txtreservationname").value!="" && document.getElementById("txtreservationemail").value!="") {

                        alert("Thanks! Everything looks okay from here. Click OK to continue. :) ");

                        document.getElementById("formPresDinnBook").action="presentationDinnerBooking.php";
                        document.getElementById("formPresDinnBook").submit();
                    }
                }
            </script>
        <table>
            <tr>
                <td><a href="index.php">Back</a></td>
            </tr>
        </table>
        <div id="orangePaperBackground" class="orangePaperBackground">
                <form id="formPresDinnBook" name="formPresDinnBook" action="presentationDinnerBooking.php" method="post">
                    <br>
                    <font style="color:black;"><b>Booking Name:</b> </font><input type="text" id="txtreservationname" name="txtreservationname" maxlength="56">
                    <br>
                    <font style="color:black;"><b>Email (for booking confirmation):</b> </font><input type="email" id="txtreservationemail" name="txtreservationemail" maxlength="128">
                    <br>
                    <table>
                    <table>
                        <tr>
                            <th colspan="3">
                                Cumberland AC Presentation Dinner for the 2019-20 Season
                            </th>
                        </tr>
                        <tr>
                            <td>
                                STARTERS:
                            </td>
                            <td>
                                CHOICES:
                            </td>
                            <td>
                                NOTES:
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b><?php echo $starter1title; ?></b>
                                <input type="hidden" id="starter1chosen" name="starter1chosen" value="">
                                <br />
                                <i><?php echo $starter1desc; ?></i>
                            </td>
                            <td>
                                <input type="checkbox" id ="starter1" name="starter1" onClick="checkBoxToggle('starter1');">
                                <input type="number" id="qtystarter1" name="qtystarter1" min="1" max="9" style="display:none">
                            </td>
                            <td>
                                <input type="text" id="txtstarter1" name="txtstarter1" maxlength="128">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b><?php echo $starter2title; ?></b>
                                <input type="hidden" id="starter2chosen" name="starter2chosen" value="">
                                <br />
                                <i><?php echo $starter2desc; ?></i>
                            <td>
                                <input type="checkbox" id="starter2" name="starter2" onClick="checkBoxToggle('starter2');">
                                <input type="number" id="qtystarter2" name="qtystarter2" min="1" max="9" style="display:none">
                            </td>
                            <td>
                                <input type="text" id="txtstarter2" name="txtstarter2" maxlength="128">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b><?php echo $starter3title; ?></b>
                                <input type="hidden" id="starter3chosen" name="starter3chosen" value="">
                                <br />
                                <i><?php echo $starter3desc; ?></i>
                            </td>
                            <td>
                                <input type="checkbox" id="starter3" name="starter3" onClick="checkBoxToggle('starter3');">
                                <input type="number" id="qtystarter3" name="qtystarter3" min="1" max="9" style="display:none">
                            </td>
                            <td>
                                <input type="text" id="txtstarter3" name="txtstarter3" maxlength="128">
                            </td>
                        </tr>
                        <tr>
                        <tr>
                            <td>
                                <b><?php echo $starter4title; ?></b>
                                <input type="hidden" id="starter4chosen" name="starter4chosen" value="">
                                <br />
                                <i><?php echo $starter4desc; ?></i>
                            </td>
                            <td>
                                <input type="checkbox" id="starter4" name="starter4" onClick="checkBoxToggle('starter4');">
                                <input type="number" id="qtystarter4" name="qtystarter4" min="1" max="9" style="display:none">
                            </td>
                            <td>
                                <input type="text" id="txtstarter4" name="txtstarter4" maxlength="128">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:center">
                                <br />
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                MAINS:
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b><?php echo $main1title; ?></b>
                                <input type="hidden" id="main1chosen" name="main1chosen" value="">
                                <br />
                                <i><?php echo $main1desc; ?></i>
                            </td>
                            <td>
                                <input type="checkbox" id="main1" name="main1" onClick="checkBoxToggle('main1');">
                                <input type="number" id="qtymain1" name="qtymain1" min="1" max="9" style="display:none">
                            </td>
                            <td>
                                <input type="text" id="txtmain1" name="txtmain1" maxlength="128">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b><?php echo $main2title; ?></b>
                                <input type="hidden" id="main2chosen" name="main2chosen" value="">
                                <br />
                                <i><?php echo $main2desc; ?></i>
                            </td>
                            <td>
                                <input type="checkbox" id="main2" name="main2" onClick="checkBoxToggle('main2');">
                                <input type="number" id="qtymain2" name="qtymain2" min="1" max="9" style="display:none">
                            </td>
                            <td>
                                <input type="text" id="txtmain2" name="txtmain2" maxlength="128">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b><?php echo $main3title; ?></b>
                                <input type="hidden" id="main3chosen" name="main3chosen" value="">
                                <br />
                                <i><?php echo $main3desc; ?></i>
                            </td>
                            <td>
                                <input type="checkbox" id="main3" name="main3" onClick="checkBoxToggle('main3');">
                                <input type="number" id="qtymain3" name="qtymain3" min="1" max="9" style="display:none">
                            </td>
                            <td>
                                <input type="text" id="txtmain3" name="txtmain3" maxlength="128">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b><?php echo $main4title; ?></b>
                                <input type="hidden" id="main4chosen" name="main4chosen" value="">
                                <br />
                                <i><?php echo $main4desc; ?></i>
                            </td>
                            <td>
                                <input type="checkbox" id="main4" name="main4" onClick="checkBoxToggle('main4');">
                                <input type="number" id="qtymain4" name="qtymain4" min="1" max="9" style="display:none">
                            </td>
                            <td>
                                <input type="text" id="txtmain4" name="txtmain4" maxlength="128">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b><?php echo $main5title; ?></b>
                                <input type="hidden" id="main5chosen" name="main5chosen" value="">
                                <br />
                                <i><?php echo $main5desc; ?></i>
                            </td>
                            <td>
                                <input type="checkbox" id="main5" name="main5" onClick="checkBoxToggle('main5');">
                                <input type="number" id="qtymain5" name="qtymain5" min="1" max="9" style="display:none">
                            </td>
                            <td>
                                <input type="text" id="txtmain5" name="txtmain5" maxlength="128">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:center">
                                <br />
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                DESSERTS:
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b><?php echo $dessert1title; ?></b>
                                <input type="hidden" id="dessert1chosen" name="dessert1chosen" value="">
                                <br />
                                <i><?php echo $dessert1desc; ?></i>
                            </td>
                            <td>
                                <input type="checkbox" id="dessert1" name="dessert1" onClick="checkBoxToggle('dessert1');">
                                <input type="number" id="qtydessert1" name="qtydessert1" min="1" max="9" style="display:none">
                            </td>
                            <td>
                                <input type="text" id="txtdessert1" name="txtdessert1" maxlength="128">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b><?php echo $dessert2title; ?></b>
                                <input type="hidden" id="dessert2chosen" name="dessert2chosen" value="">
                                <br />
                                <i><?php echo $dessert2desc; ?></i>
                            </td>
                            <td>
                                <input type="checkbox" id="dessert2" name="dessert2" onClick="checkBoxToggle('dessert2');">
                                <input type="number" id="qtydessert2" name="qtydessert2" min="1" max="9" style="display:none">
                            </td>
                            <td>
                                <input type="text" id="txtdessert2" name="txtdessert2" maxlength="128">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b><?php echo $dessert3title; ?></b>
                                <input type="hidden" id="dessert3chosen" name="dessert3chosen" value="">
                                <br />
                                <i><?php echo $dessert3desc; ?></i>
                            </td>
                            <td>
                                <input type="checkbox" id="dessert3" name="dessert3" onClick="checkBoxToggle('dessert3');">
                                <input type="number" id="qtydessert3" name="qtydessert3" min="1" max="9" style="display:none">
                            </td>
                            <td>
                                <input type="text" id="txtdessert3" name="txtdessert3" maxlength="128">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b><?php echo $dessert4title; ?></b>
                                <input type="hidden" id="dessert4chosen" name="dessert4chosen" value="">
                                <br />
                                <i><?php echo $dessert4desc; ?></i>
                            </td>
                            <td>
                                <input type="checkbox" id="dessert4" name="dessert4" onClick="checkBoxToggle('dessert4');">
                                <input type="number" id="qtydessert4" name="qtydessert4" min="1" max="9" style="display:none">
                            </td>
                            <td>
                                <input type="text" id="txtdessert4" name="txtdessert4" maxlength="128">
                            </td>
                        </tr>
                    </table>

                    <input type = "button" value="Send my order" onClick="checkForm()">
                </form>
            </div>
<?php
        }
?>
        <table>
            <tr>
                <td><a href="index.php">Back</a></td>
            </tr>
        </table>
    </body>
</html>