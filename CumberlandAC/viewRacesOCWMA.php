<?php
    session_start();// Starting Session
    // Storing Session
    if(isset($_SESSION['login_user'])) {
        $user_check=$_SESSION['login_user'];
    }
    else {
        $user_check='';
    }
    if(isset($_GET['display'])) {
        $champDisplay=$_GET['display'];
    }
    else {
        $champDisplay='times';
    }
    // to access archived championship records
    if(isset($_GET['champYear'])) {
        $RaceYear = $_GET['champYear'];
    }
    else {
        $RaceYear = date("Y");
    }
    require 'DBconn.php';

    $ChampionshipName = "MASTERS Open Championship";

    $sqlGetOpenChampSprintRaces = "select RaceID, RaceDate, RaceName from tblRaces WHERE RaceCode IN (1,9) AND RaceDate BETWEEN '$RaceYear-01-01' AND '$RaceYear-12-31' ORDER BY RaceDate";

    $sqlGetOpenChampMiddleRaces = "select RaceID, RaceDate, RaceName from tblRaces WHERE RaceCode IN (2) AND RaceDate BETWEEN '$RaceYear-01-01' AND '$RaceYear-12-31' ORDER BY RaceDate";

    $sqlGetOpenChampLongRaces = "select RaceID, RaceDate, RaceName from tblRaces WHERE RaceCode IN (4) AND RaceDate BETWEEN '$RaceYear-01-01' AND '$RaceYear-12-31' ORDER BY RaceDate";

    if($RaceYear == date("Y")) {
        $txtOCWMAView = "viewopenchampwmarunners_currentyear";
    }
    else {
        $txtOCWMAView = "viewopenchampwmarunners";
    }

    $sqlGetOpenChampWMAFRunners = "SELECT * FROM $txtOCWMAView WHERE RunnerSex = 'F' AND ChampYear = $RaceYear ORDER BY OpenChampWMAOverallPoints DESC";

    $sqlGetOpenChampWMAMRunners = "SELECT * FROM $txtOCWMAView WHERE RunnerSex = 'M' AND ChampYear = $RaceYear ORDER BY OpenChampWMAOverallPoints DESC";

    // if it exists, empty the array of raceIDs
    unset($arrRaceIDs);

    // if it exists, empty the array of WMA F RunnerIDs, FirstNames, Surnames, and ChampionshipIDs
    unset($arrWMAFRunnerIDsNamesChampIDs);

    // if it exists, empty the array of Div 1 RunnerIDs, FirstNames, Surnames, and ChampionshipIDs
    unset($arrWMAMRunnerIDsNamesChampIDs);
?>

<html lang="en">
<head>
  <meta charset="utf-8">
    <title>Cumberland AC - <?php echo $ChampionshipName . " " . $RaceYear; ?></title>
    <meta name="description" content="Cumberland AC <?php echo $ChampionshipName . " " . $RaceYear; ?>">
  <link rel="stylesheet" href="css/styles.css<?php echo "?date=" . date("Y-m-d_H-i"); ?>">

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]--> 
</head>
<body>
    <h1>Cumberland AC <?php echo $ChampionshipName . " " . $RaceYear; ?></h1>

<?php

require 'champViewNavTable.php';
    
echo "<table id='outerTable' class=\"tblTimesPointsOuterOpen\">";
echo "<tr>";
echo "<th class = \"tblTimesPointsOuterSpacer\"></th>";

    // Get the sprint races
    if(mysqli_multi_query($conn,$sqlGetOpenChampSprintRaces))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    // rearrange the race date from SQL format
                    $row["RaceDate"] = date("d-m-Y",strtotime($row["RaceDate"]));
                    // give the date '/' instead of '-'
                    $row["RaceDate"] = str_replace("-", "/", $row["RaceDate"]);
                    
                    // combine the rows into a multi-dimensional array
                    $arrRaceIDs[] = $row["RaceID"];
                    
                    echo "<th class='rotate'><div class='fntSprint'><span>" . $row['RaceName'] . "<br>" . $row['RaceDate'] . "</span></div></th>";
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Oops! I couldn't find any Open Championship sprint distance races for $RaceYear!";
    }

    // Get the middle races
    if(mysqli_multi_query($conn,$sqlGetOpenChampMiddleRaces))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    // rearrange the race date from SQL format
                    $row["RaceDate"] = date("d-m-Y",strtotime($row["RaceDate"]));
                    // give the date '/' instead of '-'
                    $row["RaceDate"] = str_replace("-", "/", $row["RaceDate"]);
                    
                    // combine the rows into a multi-dimensional array
                    $arrRaceIDs[] = $row["RaceID"];
                    
                    echo "<th class='rotate'><div class='fntMiddle'><span>" . $row['RaceName'] . "<br>" . $row['RaceDate'] . "</span></div></th>";
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Oops! I couldn't find any Open Championship middle distance races for $RaceYear!";
    }

    // Get the long races
    if(mysqli_multi_query($conn,$sqlGetOpenChampLongRaces))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    // rearrange the race date from SQL format
                    $row["RaceDate"] = date("d-m-Y",strtotime($row["RaceDate"]));
                    // give the date '/' instead of '-'
                    $row["RaceDate"] = str_replace("-", "/", $row["RaceDate"]);
                    
                    // combine the rows into an array
                    $arrRaceIDs[] = $row["RaceID"];
                    
                    echo "<th class='rotate'><div class='fntLong'><span>" . $row['RaceName'] . "<br>" . $row['RaceDate'] . "</span></div></th>";
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Oops! I couldn't find any Open Championship long distance races for $RaceYear!";
    }

    echo "<th style='background-color:black; width: 50px;'></th>";
    echo "</tr>";
    
    echo "<tr><td colspan='20' class=\"tblTimesPointsOuter\">";
    echo "<button class=\"accordion\">Ladies Masters Open Championship</button><div class=\"panel\">";
    echo "<table id=\"innerTableWMALadies\" class='tblTimesPointsInner'>"; // inner table to contain collapsible ladies division content    
    
    // Get the runner details
    if(mysqli_multi_query($conn,$sqlGetOpenChampWMAFRunners))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    
                    $RunnerID = $row['RunnerID'];
                    $RunnerName = $row['RunnerFirstName'] . " " . $row['RunnerSurname'];
                    $ChampPoints = $row['OpenChampWMAOverallPoints'];
                    
                    
                    echo "\n<tr>\n<td class=\"tblTimesPointsInnerNames\">$RunnerName</td>\n";

                        // procedure call for each runnerID, to return a list of raceIDs, times and points
                        $sqlLoadRunnerTimes = sprintf('SET @race_1=%1$s; SET @race_2=%2$s; SET @race_3=%3$s; SET @race_4=%4$s; SET @race_5=%5$s; SET @race_6=%6$s;
                        SET @race_7=%7$s; SET @race_8=%8$s; SET @race_9=%9$s; SET @race_10=%10$s; SET @race_11=%11$s; SET @race_12=%12$s;
                        SET @race_13=%13$s; SET @race_14=%14$s; SET @race_15=%15$s; SET @race_16=%16$s; SET @race_17=%17$s; SET @race_18=%18$s;
                        CALL proc_openChamp_WMA_getTimesPoints(%19$s,@race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12, @race_13, @race_14, @race_15, @race_16, @race_17, @race_18);', $arrRaceIDs[0], $arrRaceIDs[1], $arrRaceIDs[2], $arrRaceIDs[3], $arrRaceIDs[4], $arrRaceIDs[5], $arrRaceIDs[6], $arrRaceIDs[7], $arrRaceIDs[8], $arrRaceIDs[9], $arrRaceIDs[10], $arrRaceIDs[11], $arrRaceIDs[12], $arrRaceIDs[13], $arrRaceIDs[14], $arrRaceIDs[15], $arrRaceIDs[16], $arrRaceIDs[17],$RunnerID);

                        $sqlGetRunnerTimes = "SELECT @race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12, @race_13, @race_14, @race_15, @race_16, @race_17, @race_18;";

                        //join the queries
                        $sqlComboQuery = $sqlLoadRunnerTimes . ' ' . $sqlGetRunnerTimes;
                        
                                if (mysqli_multi_query($conn,$sqlComboQuery))
                                {
                                    do{
                                        if($result2 = mysqli_store_result($conn)){
                                            while($row = mysqli_fetch_assoc($result2)){
                                                echo splitRunnerTimePoints($row['@race_1']) . 
                                                    splitRunnerTimePoints($row['@race_2']) . 
                                                    splitRunnerTimePoints($row['@race_3']) .
                                                    splitRunnerTimePoints($row['@race_4']) . 
                                                    splitRunnerTimePoints($row['@race_5']) . 
                                                    splitRunnerTimePoints($row['@race_6']) .
                                                    splitRunnerTimePoints($row['@race_7']) . 
                                                    splitRunnerTimePoints($row['@race_8']) .
                                                    splitRunnerTimePoints($row['@race_9']) . 
                                                    splitRunnerTimePoints($row['@race_10']) . 
                                                    splitRunnerTimePoints($row['@race_11']) .
                                                    splitRunnerTimePoints($row['@race_12']) .
                                                    splitRunnerTimePoints($row['@race_13']) . 
                                                    splitRunnerTimePoints($row['@race_14']) .
                                                    splitRunnerTimePoints($row['@race_15']) . 
                                                    splitRunnerTimePoints($row['@race_16']) . 
                                                    splitRunnerTimePoints($row['@race_17']) .
                                                    splitRunnerTimePoints($row['@race_18']);
                                            }
                                            mysqli_free_result($result2);
                                        }
                                    
                                        if(mysqli_more_results($conn)) {
                                            //printf("\n");
                                        }
                                        
                                    } while(mysqli_more_results($conn) && mysqli_next_result($conn));
                                }
                                else {
                                    echo "<td>No RT!</td>";
                                }
                                        
                    echo "<td>$ChampPoints</td></tr>";
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Oops! I couldn't find any Open Championship Ladies Masters runners for $RaceYear!";
    }
    echo "</table></div></td></tr></div>"; // inner table to contain collapsible ladies masters content

    echo "<tr><td colspan='20' class=\"tblTimesPointsOuter\">";
    echo "<button class=\"accordion\">Men's Masters Open Championship</button><div class=\"panel\">";
    echo "<table id='innerTableWMAMen' class='tblTimesPointsInner'>"; // inner table to contain collapsible men's masters content

    // Get the runner details
    if(mysqli_multi_query($conn,$sqlGetOpenChampWMAMRunners))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    
                    $RunnerID = $row['RunnerID'];
                    $RunnerName = $row['RunnerFirstName'] . " " . $row['RunnerSurname'];
                    $ChampPoints = $row['OpenChampWMAOverallPoints'];
                    
                    
                    echo "\n<tr>\n<td class=\"tblTimesPointsInnerNames\">$RunnerName</td>\n";

                        // procedure call for each runnerID, to return a list of raceIDs, times and points
                        $sqlLoadRunnerTimes = sprintf('SET @race_1=%1$s; SET @race_2=%2$s; SET @race_3=%3$s; SET @race_4=%4$s; SET @race_5=%5$s; SET @race_6=%6$s;
                        SET @race_7=%7$s; SET @race_8=%8$s; SET @race_9=%9$s; SET @race_10=%10$s; SET @race_11=%11$s; SET @race_12=%12$s;
                        SET @race_13=%13$s; SET @race_14=%14$s; SET @race_15=%15$s; SET @race_16=%16$s; SET @race_17=%17$s; SET @race_18=%18$s;
                        CALL proc_openChamp_WMA_getTimesPoints(%19$s,@race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12, @race_13, @race_14, @race_15, @race_16, @race_17, @race_18);', $arrRaceIDs[0], $arrRaceIDs[1], $arrRaceIDs[2], $arrRaceIDs[3], $arrRaceIDs[4], $arrRaceIDs[5], $arrRaceIDs[6], $arrRaceIDs[7], $arrRaceIDs[8], $arrRaceIDs[9], $arrRaceIDs[10], $arrRaceIDs[11], $arrRaceIDs[12], $arrRaceIDs[13], $arrRaceIDs[14], $arrRaceIDs[15], $arrRaceIDs[16], $arrRaceIDs[17],$RunnerID);

                        $sqlGetRunnerTimes = "SELECT @race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12, @race_13, @race_14, @race_15, @race_16, @race_17, @race_18;";

                        //join the queries
                        $sqlComboQuery = $sqlLoadRunnerTimes . ' ' . $sqlGetRunnerTimes;
                        
                                if (mysqli_multi_query($conn,$sqlComboQuery))
                                {
                                    do{
                                        if($result2 = mysqli_store_result($conn)){
                                            while($row = mysqli_fetch_assoc($result2)){
                                                echo splitRunnerTimePoints($row['@race_1']) . 
                                                    splitRunnerTimePoints($row['@race_2']) . 
                                                    splitRunnerTimePoints($row['@race_3']) .
                                                    splitRunnerTimePoints($row['@race_4']) . 
                                                    splitRunnerTimePoints($row['@race_5']) . 
                                                    splitRunnerTimePoints($row['@race_6']) .
                                                    splitRunnerTimePoints($row['@race_7']) . 
                                                    splitRunnerTimePoints($row['@race_8']) .
                                                    splitRunnerTimePoints($row['@race_9']) . 
                                                    splitRunnerTimePoints($row['@race_10']) . 
                                                    splitRunnerTimePoints($row['@race_11']) .
                                                    splitRunnerTimePoints($row['@race_12']) .
                                                    splitRunnerTimePoints($row['@race_13']) . 
                                                    splitRunnerTimePoints($row['@race_14']) .
                                                    splitRunnerTimePoints($row['@race_15']) . 
                                                    splitRunnerTimePoints($row['@race_16']) . 
                                                    splitRunnerTimePoints($row['@race_17']) .
                                                    splitRunnerTimePoints($row['@race_18']);
                                            }
                                            mysqli_free_result($result2);
                                        }
                                    
                                        if(mysqli_more_results($conn)) {
                                            //printf("\n");
                                        }
                                        
                                    } while(mysqli_more_results($conn) && mysqli_next_result($conn));
                                }
                                else {
                                    echo "<td>No RT!</td>";
                                }
                    echo "<td>$ChampPoints</td></tr>";
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Oops! I couldn't find any Open Championship Men's Masters runners for $RaceYear!";
    }
    echo "</table></div></td></tr></div>"; // inner table to contain collapsible men's masters content
    echo "</table>";
    echo "<br>";
    
function splitRunnerTimePoints($RaceIDTimePoints){
    //need to define the global variables you are accessing from within the function
    global $champDisplay;
    
    // function to split the runner times and points from the mysqli_multi_line query
    if(strlen($RaceIDTimePoints) < 5) {
        return "<td class=\"tblTimesPointsInner\"></td>\n";
    }
    else {
        $Pieces = explode("//",$RaceIDTimePoints);

        // display points / time as per the URL. defaults at race times
        if($champDisplay == "times") {
            return "<td class=\"tblTimesPointsInner\"><div class=\"fontRaceTime\" style='display:inline'>$Pieces[1]</div><div class=\"fontRacePoints\" style='display:none'>$Pieces[2]</div></td>\n";            
        }
        else if($champDisplay == "points") {
            return "<td class=\"tblTimesPointsInner\"><div class=\"fontRaceTime\" style='display:none'>$Pieces[1]</div><div class=\"fontRacePoints\" style='display:inline'>$Pieces[2]</div></td>\n";
        }
    }
}

include 'champViewNavTable.php';
    
?>
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
</script>
</body>
</html>
