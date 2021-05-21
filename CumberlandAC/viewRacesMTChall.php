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


    $ChampionshipName = "Multi-Terrain Challenge";

    $sqlGetMTChallRaces = "select RaceID, RaceDate, RaceName from tblRaces WHERE RaceCode=16 AND RaceDate BETWEEN '$RaceYear-01-01' AND '$RaceYear-12-31' ORDER BY RaceDate";

/*            $sqlGetMTChallMRunners = "select DISTINCT tblMTChallDivGenOverallPoints.RunnerID, tblRunners.RunnerFirstName, tblRunners.RunnerSurname, tblMTChallDivGenOverallPoints.MTChallDivGenOverallPoints, tblMTChallDivGenOverallPoints.ChampionshipID FROM tblMTChallDivGenOverallPoints INNER JOIN tblRunners ON tblMTChallDivGenOverallPoints.RunnerID = tblRunners.RunnerID WHERE tblMTChallDivGenOverallPoints.RunnerSex = 'M' AND tblMTChallDivGenOverallPoints.MTChallDivGenOverallPoints > 0 AND tblMTChallDivGenOverallPoints.ChampYear = $RaceYear ORDER BY tblMTChallDivGenOverallPoints.MTChallDivGenOverallPoints DESC";

            $sqlGetMTChallFRunners = "select DISTINCT tblMTChallDivGenOverallPoints.RunnerID, tblRunners.RunnerFirstName, tblRunners.RunnerSurname, tblMTChallDivGenOverallPoints.MTChallDivGenOverallPoints, tblMTChallDivGenOverallPoints.ChampionshipID FROM tblMTChallDivGenOverallPoints INNER JOIN tblRunners ON tblMTChallDivGenOverallPoints.RunnerID = tblRunners.RunnerID WHERE tblMTChallDivGenOverallPoints.RunnerSex = 'F ' AND tblMTChallDivGenOverallPoints.MTChallDivGenOverallPoints > 0 AND tblMTChallDivGenOverallPoints.ChampYear = $RaceYear ORDER BY tblMTChallDivGenOverallPoints.MTChallDivGenOverallPoints DESC";*/
    
    if($RaceYear == date("Y")) {
        $txtMTChallView = "viewmtchallrunners_currentyear";
    }
    else {
        $txtMTChallView = "viewmtchallrunners";        
    }

    $sqlGetMTChallMRunners = "SELECT * FROM $txtMTChallView WHERE RunnerSex = 'M' AND ChampYear = $RaceYear ORDER BY MTChallDivGenOverallPoints DESC;";

    $sqlGetMTChallFRunners = "SELECT * FROM $txtMTChallView WHERE RunnerSex = 'F' AND ChampYear = $RaceYear ORDER BY MTChallDivGenOverallPoints DESC;";

    // if it exists, empty the array of raceIDs
    unset($arrRaceIDs);

    // if it exists, empty the array of Div 3 RunnerIDs, FirstNames, Surnames, and ChampionshipIDs
    unset($arrDiv3RunnerIDsNamesChampIDs);

    // if it exists, empty the array of Div 2 RunnerIDs, FirstNames, Surnames, and ChampionshipIDs
    unset($arrDiv2RunnerIDsNamesChampIDs);

    // if it exists, empty the array of Div 1 RunnerIDs, FirstNames, Surnames, and ChampionshipIDs
    unset($arrDiv1RunnerIDsNamesChampIDs);
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
    
echo "<table id='outerTable' class=\"tblTimesPointsOuterMT\">";
echo "<tr>";
echo "<th class = \"tblTimesPointsOuterSpacer\"></th>";

    // Get the sprint races
    if(mysqli_multi_query($conn,$sqlGetMTChallRaces))
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
                    
                    echo "<th class='rotate'><div class='fntMultiTerrain'><span>" . $row['RaceName'] . "<br>" . $row['RaceDate'] . "</span></div></th>";
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Oops! I couldn't find any short championship sprint distance races for $RaceYear!";
    }

    echo "<th style='background-color:black; width: 50px;'></th>";
    echo "</tr>";
    
    echo "<tr><td colspan='20' class=\"tblTimesPointsOuter\">";
    echo "<button class=\"accordion\">Men's Multi-Terrain Challenge</button><div class=\"panel\">";
    echo "<table id=\"innerTableMensMT\" class='tblTimesPointsInner'>"; // inner table to contain collapsible content


    // Get the runner details
    if(mysqli_multi_query($conn,$sqlGetMTChallMRunners))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    
                    // combine the rows into a multi-dimensional array
                    //array_push($arrDiv3RunnerIDsNamesChampIDs, $row['RunnerID'], $row['RunnerFirstName'], $row['RunnerSurname'], $row['OpenChampDivGenOverallPoints'], $row['ChampionshipID']);

                    $RunnerID = $row['RunnerID'];
                    $RunnerName = $row['RunnerFirstName'] . " " . $row['RunnerSurname'];
                    $ChampPoints = $row['MTChallDivGenOverallPoints'];
                    
                    
                    echo "\n<tr>\n<td class=\"tblTimesPointsInnerNames\">$RunnerName</td>\n";
                    
                        // procedure call for each runnerID, to return a list of raceIDs, times and points
                        $sqlLoadRunnerTimes = sprintf('SET @race_1=%1$s; SET @race_2=%2$s; SET @race_3=%3$s; SET @race_4=%4$s; SET @race_5=%5$s; SET @race_6=%6$s; SET @race_7=%7$s; SET @race_8=%8$s; SET @race_9=%9$s;
                        CALL proc_MTChall_MF_getTimesPoints(%10$s,@race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9);', $arrRaceIDs[0], $arrRaceIDs[1], $arrRaceIDs[2], $arrRaceIDs[3], $arrRaceIDs[4], $arrRaceIDs[5], $arrRaceIDs[6], $arrRaceIDs[7], $arrRaceIDs[8], $RunnerID);

                        $sqlGetRunnerTimes = "SELECT @race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9;";

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
                                                    splitRunnerTimePoints($row['@race_9']);
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
                    
                    // echo $row['RunnerID'] . " " . $row['RunnerFirstName'] . " " . $row['RunnerSurname'] . " " . $row['OpenChampDivGenOverallPoints'] . " " . $row['ChampionshipID'] . "<br>";
                                        
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
        echo "Oops! I couldn't find any Men's MT Challenge runners for $RaceYear!";
    }
    echo "</table></div></td></tr></div>"; // inner table to contain collapsible content
    
    
    echo "<tr><td colspan='20' class=\"tblTimesPointsOuter\">";
    echo "<button class=\"accordion\">Ladies Multi-Terrain Challenge</button><div class=\"panel\">";
    echo "<table id='innerTableLadiesMT' class='tblTimesPointsInner'>"; // inner table to contain collapsible content

    // Get the runner details
    if(mysqli_multi_query($conn,$sqlGetMTChallFRunners))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    
                    // combine the rows into a multi-dimensional array
                    //array_push($arrDiv2RunnerIDsNamesChampIDs, $row['RunnerID'], $row['RunnerFirstName'], $row['RunnerSurname'], $row['OpenChampDivGenOverallPoints'], $row['ChampionshipID']);

                    $RunnerID = $row['RunnerID'];
                    $RunnerName = $row['RunnerFirstName'] . " " . $row['RunnerSurname'];
                    $ChampPoints = $row['MTChallDivGenOverallPoints'];
                    
                    
                    echo "\n<tr>\n<td class=\"tblTimesPointsInnerNames\">$RunnerName</td>\n";
                    
                        // procedure call for each runnerID, to return a list of raceIDs, times and points
                        $sqlLoadRunnerTimes = sprintf('SET @race_1=%1$s; SET @race_2=%2$s; SET @race_3=%3$s; SET @race_4=%4$s; SET @race_5=%5$s; SET @race_6=%6$s; SET @race_7=%7$s; SET @race_8=%8$s; SET @race_9=%9$s;
                        CALL proc_MTChall_MF_getTimesPoints(%10$s,@race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9);', $arrRaceIDs[0], $arrRaceIDs[1], $arrRaceIDs[2], $arrRaceIDs[3], $arrRaceIDs[4], $arrRaceIDs[5], $arrRaceIDs[6], $arrRaceIDs[7], $arrRaceIDs[8], $RunnerID);
                    
                        $sqlGetRunnerTimes = "SELECT @race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9;";
                    
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
                                                    splitRunnerTimePoints($row['@race_9']);
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
                    
                    // echo $row['RunnerID'] . " " . $row['RunnerFirstName'] . " " . $row['RunnerSurname'] . " " . $row['OpenChampDivGenOverallPoints'] . " " . $row['ChampionshipID'] . "<br>";
                                        
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
        echo "Oops! I couldn't find any Ladies MT Challenge runners for $RaceYear!";
    }
    echo "</table></div></td></tr></div>"; // inner table to contain collapsible division 1 content
    echo "</table>";
    echo "<br>";

function splitRunnerTimePoints($RaceIDTimePoints){
    //need to define the global variables you are accessing from within the function
    global $champDisplay;
    
    // function to split the runner times and points from the mysqli_multi_line query
    if(strlen($RaceIDTimePoints) < 5) {
        return "<td class=\"tblTimesPointsInnerMT\"></td>\n";
    }
    else {
        $Pieces = explode("//",$RaceIDTimePoints);

        // display points / time as per the URL. defaults at race times
        if($champDisplay == "times") {
            return "<td class=\"tblTimesPointsInnerMT\"><div class=\"fontRaceTime\" style='display:inline'>$Pieces[1]</div><div class=\"fontRacePoints\" style='display:none'>$Pieces[2]</div></td>\n";            
        }
        else if($champDisplay == "points") {
            return "<td class=\"tblTimesPointsInnerMT\"><div class=\"fontRaceTime\" style='display:none'>$Pieces[1]</div><div class=\"fontRacePoints\" style='display:inline'>$Pieces[2]</div></td>\n";
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
