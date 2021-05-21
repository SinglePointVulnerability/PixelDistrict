<?php
    include('session.php');
?>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Cumberland AC DB Admin</title>
  <meta name="description" content="Cumberland AC DB Admin - Update All Runners - Subs Paid">
  <meta name="author" content="West Coast Web Design">

  <link rel="stylesheet" href="css/styles.css<?php echo "?date=" . date("Y-m-d_H-i"); ?>">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>    
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    function subsChange(rID,subStat)
    {
        if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
        } else {  // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.open("GET","updateModule.php?rID="+rID+"&subsPaid="+subStat,true);
        xmlhttp.send();
        //disable the button just used so it can't be changed again until the page is reloaded
        document.getElementById("btn_"+rID).disabled=true;
        document.getElementById("btn_refresh").disabled=false;
     }
    </script>

</head>
<body>    
<?php
if($login_user=='')
{
    // if the user isn't logged in, don't load the page
}
else if ($login_user=='club_stat' || $login_user=='admin')
{
    ?>
    <br>
    <br>    
        <input type="button" id="btn_refresh" class="refresh_button" value="refresh to see changes" onClick="window.location.reload();" disabled=true>
    <br>
    <br>

    <?php    
        require 'DBconn.php';

        $divisionLoop = 1;

        while($divisionLoop <= 3) {
            $sql = "SELECT * FROM viewallrunners WHERE RunnerDiv = $divisionLoop ORDER BY RunnerSurname, RunnerFirstName";
            $result = mysqli_query($conn,$sql);
            $tmpCount = 1;

            echo "<h2>Division $divisionLoop</h2>";
            echo "<table>";
            echo "<tr>";

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $RunnerID = $row["RunnerID"];
                    $RunnerFirstName = $row["RunnerFirstName"];
                    $RunnerSurname = $row["RunnerSurname"];
                    $RunnerDiv = $row["RunnerDiv"];
                    $RunnerSubsPaid = $row["RunnerSubsPaid"];
                    $RunnerSex = $row["RunnerSex"];


                    if ($RunnerSubsPaid == "N") {
                        echo "<td>$RunnerSurname, $RunnerFirstName</td><td><input type=\"button\" id=\"btn_$RunnerID\" value=\"Switch\" onClick=\"subsChange($RunnerID,'Y');\"></td><td style='background-color:red;'>$RunnerSubsPaid</td><td style='background-color:black;'></td>";                    
                    }
                    else {
                        echo "<td>$RunnerSurname, $RunnerFirstName</td><td style='background-color:green;'>$RunnerSubsPaid</td><td><input type=\"button\" id=\"btn_$RunnerID\" value=\"Switch\"  onClick=\"subsChange($RunnerID,'N');\"></td><td style='background-color:black;'>O</td>";                    
                    }

                    if($tmpCount % 5 == 0) {
                        //if it's the end of the row, insert the end row statement and start a new one
                        echo "</tr>";
                        echo "<tr>";
                    }
                    $tmpCount++;
                }
            } else {
                echo "No results";
            }   
            echo "</tr>";
            echo "</table>";

            $divisionLoop++;
        }



        mysqli_close($conn);
}
    ?>
<br>
<br>
    <table>
        <tr>
            <td><a href="index.php">Back</a></td>
        </tr>
    </table>
</body>
</html>