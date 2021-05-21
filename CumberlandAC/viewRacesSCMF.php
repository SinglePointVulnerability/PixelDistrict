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

    $ChampionshipName = "Short Championship";

    $sqlGetShortChampRaces = "select RaceID, RaceDate, RaceName from tblRaces WHERE RaceCode IN (8,9) AND RaceDate BETWEEN '$RaceYear-01-01' AND '$RaceYear-12-31' ORDER BY RaceDate";

    /*
        NOTE: in 2018 the short championship was divided by male / female, as well as the correct runner division, an additional
        entry into the table was made with the runner division set to 99 by default as a catch-all. Because of this there will
        need to be a case statement to check which championship year is being requested
    */

    // since the divisions were combined sex for 2018 only, keep the 2018 queries separate
    if($RaceYear == 2018) {
        $sqlGetShortChampDiv3Runners  = "SELECT * FROM viewshortchamprunners2018 WHERE RunnerDiv = 3 ORDER BY ShortChampDivGenOverallPoints DESC";        
        $sqlGetShortChampDiv2Runners  = "SELECT * FROM viewshortchamprunners2018 WHERE RunnerDiv = 2 ORDER BY ShortChampDivGenOverallPoints DESC";        
        $sqlGetShortChampDiv1Runners  = "SELECT * FROM viewshortchamprunners2018 WHERE RunnerDiv = 1 ORDER BY ShortChampDivGenOverallPoints DESC";
    }
    else {
        if($RaceYear == date("Y"))
        {
            // if it's the current year, the correct divisions will be found in the tblRunners table
            $txtViewSCRunners = "viewshortchamprunners_currentyear";
        }
        else
        {
            // if it's an earlier year, the correct divisions will be found in the tblMembershipArchive table
            $txtViewSCRunners = "viewshortchamprunners";        
        }
        // MEN
        $sqlGetShortChampDiv3MRunners = "SELECT * FROM $txtViewSCRunners WHERE RunnerDiv = 3 AND RunnerSex = 'M' AND ChampYear = $RaceYear ORDER BY ShortChampDivGenOverallPoints DESC";
        $sqlGetShortChampDiv2MRunners = "SELECT * FROM $txtViewSCRunners WHERE RunnerDiv = 2 AND RunnerSex = 'M' AND ChampYear = $RaceYear ORDER BY ShortChampDivGenOverallPoints DESC";
        $sqlGetShortChampDiv1MRunners = "SELECT * FROM $txtViewSCRunners WHERE RunnerDiv = 1 AND RunnerSex = 'M' AND ChampYear = $RaceYear ORDER BY ShortChampDivGenOverallPoints DESC";

        // LADIES
        $sqlGetShortChampDiv3FRunners = "SELECT * FROM $txtViewSCRunners WHERE RunnerDiv = 3 AND RunnerSex = 'F' AND ChampYear = $RaceYear ORDER BY ShortChampDivGenOverallPoints DESC";
        $sqlGetShortChampDiv2FRunners = "SELECT * FROM $txtViewSCRunners WHERE RunnerDiv = 2 AND RunnerSex = 'F' AND ChampYear = $RaceYear ORDER BY ShortChampDivGenOverallPoints DESC";
        $sqlGetShortChampDiv1FRunners = "SELECT * FROM $txtViewSCRunners WHERE RunnerDiv = 1 AND RunnerSex = 'F' AND ChampYear = $RaceYear ORDER BY ShortChampDivGenOverallPoints DESC";        
    }

    // queries for 2018 races - start
    $sqlGetShortChampFRunners = "select DISTINCT tblShortChampDivGenOverallPoints.RunnerID, tblRunners.RunnerFirstName, tblRunners.RunnerSurname, tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints, tblShortChampDivGenOverallPoints.ChampionshipID
    FROM tblShortChampDivGenOverallPoints
        INNER JOIN tblRunners ON tblShortChampDivGenOverallPoints.RunnerID = tblRunners.RunnerID
    WHERE tblShortChampDivGenOverallPoints.RunnerSex='F' 
        AND tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints > 0 
        AND tblShortChampDivGenOverallPoints.ChampYear = $RaceYear
    ORDER BY tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints DESC";

    $sqlGetShortChampMRunners = "select DISTINCT tblShortChampDivGenOverallPoints.RunnerID, tblRunners.RunnerFirstName, tblRunners.RunnerSurname, tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints, tblShortChampDivGenOverallPoints.ChampionshipID
    FROM tblShortChampDivGenOverallPoints
        INNER JOIN tblRunners ON tblShortChampDivGenOverallPoints.RunnerID = tblRunners.RunnerID
    WHERE tblShortChampDivGenOverallPoints.RunnerSex='M'
        AND tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints > 0
        AND tblShortChampDivGenOverallPoints.ChampYear = $RaceYear
    ORDER BY tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints DESC";
    // queries for 2018 races - end

    // if it exists, empty the array of raceIDs
    unset($arrRaceIDs);

    // if it exists, empty the array of M RunnerIDs, FirstNames, Surnames, and ChampionshipIDs
    unset($arrMRunnerIDsNamesChampIDs);

    // if it exists, empty the array of F RunnerIDs, FirstNames, Surnames, and ChampionshipIDs
    unset($arrFRunnerIDsNamesChampIDs);
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
    
echo "<table id='outerTable' class=\"tblTimesPointsOuterShort\">";
echo "<tr>";
echo "<th class = \"tblTimesPointsOuterSpacer\"></th>";

    // Get the sprint races
    if(mysqli_multi_query($conn,$sqlGetShortChampRaces))
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
                    
                    echo "<th class='rotate'><div class='fntShort'><span>" . $row['RaceName'] . "<br>" . $row['RaceDate'] . "</span></div></th>";
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Oops! I couldn't find any short championship races for $RaceYear!";
    }

    echo "<th style='background-color:black; width: 50px;'></th>";
    echo "</tr>";

    if($RaceYear == 2018) 
    {
        // Short Champ 2018 - Start

        echo "<tr><td colspan='20' class=\"tblTimesPointsOuter\">";
        echo "<button class=\"accordion\">Ladies Short Championship</button><div class=\"panel\">";
        echo "<table id=\"innerTableLadiesShort\" class='tblTimesPointsInner'>"; // inner table to contain collapsible content

        // Get the Ladies runner details
        if(mysqli_multi_query($conn,$sqlGetShortChampFRunners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){

                        // combine the rows into a multi-dimensional array
                        //array_push($arrFRunnerIDsNamesChampIDs, $row['RunnerID'], $row['RunnerFirstName'], $row['RunnerSurname'], $row['ShortChampDivGenOverallPoints'], $row['ChampionshipID']);

                        $RunnerID = $row['RunnerID'];
                        $RunnerName = $row['RunnerFirstName'] . " " . $row['RunnerSurname'];
                        $ChampPoints = $row['ShortChampDivGenOverallPoints'];


                        echo "\n<tr>\n<td class=\"tblTimesPointsInnerNames\">$RunnerName</td>\n";

                            // procedure call for each runnerID, to return a list of raceIDs, times and points
                            $sqlLoadRunnerTimes = sprintf('SET @race_1=%1$s; SET @race_2=%2$s; SET @race_3=%3$s; SET @race_4=%4$s; SET @race_5=%5$s; SET @race_6=%6$s; SET @race_7=%7$s; SET @race_8=%8$s; SET @race_9=%9$s; SET @race_10=%10$s; SET @race_11=%11$s; SET @race_12=%12$s;
                            CALL proc_shortChamp_MF_getTimesPoints(%13$s,@race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12);', $arrRaceIDs[0], $arrRaceIDs[1], $arrRaceIDs[2], $arrRaceIDs[3], $arrRaceIDs[4], $arrRaceIDs[5], $arrRaceIDs[6], $arrRaceIDs[7], $arrRaceIDs[8], $arrRaceIDs[9],$arrRaceIDs[10],$arrRaceIDs[11], $RunnerID);

                            $sqlGetRunnerTimes = "SELECT @race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12;";

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
                                                        splitRunnerTimePoints($row['@race_12']);
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
            echo "Oops! I couldn't find any Ladies short championship runners for $RaceYear!";
        }

        echo "</table></div></td></tr></div>"; // inner table to contain collapsible content

        echo "<tr><td colspan='20' class=\"tblTimesPointsOuter\">";
        echo "<button class=\"accordion\">Men's Short Championship</button><div class=\"panel\">";
        echo "<table id='innerTableMensShort' class='tblTimesPointsInner'>"; // inner table to contain collapsible content

        // Get the Men's runner details
        if(mysqli_multi_query($conn,$sqlGetShortChampMRunners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){

                        // combine the rows into a multi-dimensional array
                        //array_push($arrMRunnerIDsNamesChampIDs, $row['RunnerID'], $row['RunnerFirstName'], $row['RunnerSurname'], $row['ShortChampDivGenOverallPoints'], $row['ChampionshipID']);

                        $RunnerID = $row['RunnerID'];
                        $RunnerName = $row['RunnerFirstName'] . " " . $row['RunnerSurname'];
                        $ChampPoints = $row['ShortChampDivGenOverallPoints'];


                        echo "\n<tr>\n<td class=\"tblTimesPointsInnerNames\">$RunnerName</td>\n";

                            // procedure call for each runnerID, to return a list of raceIDs, times and points
                            $sqlLoadRunnerTimes = sprintf('SET @race_1=%1$s; SET @race_2=%2$s; SET @race_3=%3$s; SET @race_4=%4$s; SET @race_5=%5$s; SET @race_6=%6$s;
                            SET @race_7=%7$s; SET @race_8=%8$s; SET @race_9=%9$s; SET @race_10=%10$s; SET @race_11=%11$s; SET @race_12=%12$s;
                            CALL proc_shortChamp_MF_getTimesPoints(%13$s,@race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12);', $arrRaceIDs[0], $arrRaceIDs[1], $arrRaceIDs[2], $arrRaceIDs[3], $arrRaceIDs[4], $arrRaceIDs[5], $arrRaceIDs[6], $arrRaceIDs[7], $arrRaceIDs[8], $arrRaceIDs[9],$arrRaceIDs[10],$arrRaceIDs[11], $RunnerID);

                            $sqlGetRunnerTimes = "SELECT @race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12;";

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
                                                        splitRunnerTimePoints($row['@race_12']);
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

                        // echo $row['RunnerID'] . " " . $row['RunnerFirstName'] . " " . $row['RunnerSurname'] . " " . $row['ShortChampDivGenOverallPoints'] . " " . $row['ChampionshipID'] . "<br>";

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
            echo "Oops! I couldn't find any Male short championship runners for $RaceYear!";
        }
        echo "</table></div></td></tr></div>"; // inner table to contain collapsible division 1 content
        echo "</table>";
        echo "<br>";
        // Short Champ 2018 - END
    }
    elseif ($RaceYear > 2018)
    {
    //
    // - - View Races Short Championship Divisions: START
    //
    
        // loop through the table set-up twice to retrieve separate male and female division results
        $loopLimit = 2;
    
    $loopCount = 0;
        
    do {
        $loopCount++;

        if($RaceYear > 2018 && $loopCount == 1) {   
            // if the year is AFTER 2018 and if this is the first pass, retrieve the MENs results, otherwise retrieve the LADIES results
            
            // MEN     
            $sqlGetShortChampDiv3Runners = $sqlGetShortChampDiv3MRunners;
            $sqlGetShortChampDiv2Runners = $sqlGetShortChampDiv2MRunners;
            $sqlGetShortChampDiv1Runners = $sqlGetShortChampDiv1MRunners;
        
            $txtDivisionTitle = "Men";
            $txtLoadRunnerSex = "M";
        }
        elseif ($RaceYear > 2018 && $loopCount == 2) {
            // LADIES     
            $sqlGetShortChampDiv3Runners = $sqlGetShortChampDiv3FRunners;
            $sqlGetShortChampDiv2Runners = $sqlGetShortChampDiv2FRunners;
            $sqlGetShortChampDiv1Runners = $sqlGetShortChampDiv1FRunners;
        
            $txtDivisionTitle = "Ladies";  
            $txtLoadRunnerSex = "F";
        }
        
        echo "<tr><td colspan='20' class=\"tblTimesPointsOuter\">";
        echo "<button class=\"accordion\">Division 3: $txtDivisionTitle</button><div class=\"panel\">";
        echo "<table id=\"innerTableDiv3\" class='tblTimesPointsInner'>"; // inner table to contain collapsible division 3 content

        // Get the runner details
        if(mysqli_multi_query($conn,$sqlGetShortChampDiv3Runners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){

                        // combine the rows into a multi-dimensional array
                        //array_push($arrMRunnerIDsNamesChampIDs, $row['RunnerID'], $row['RunnerFirstName'], $row['RunnerSurname'], $row['ShortChampDivGenOverallPoints'], $row['ChampionshipID']);

                        $RunnerID = $row['RunnerID'];
                        $RunnerName = $row['RunnerFirstName'] . " " . $row['RunnerSurname'];
                        $ChampPoints = $row['ShortChampDivGenOverallPoints'];


                        echo "\n<tr>\n<td class=\"tblTimesPointsInnerNames\">$RunnerName</td>\n";

                            // procedure call for each runnerID, to return a list of raceIDs, times and points
                            $sqlLoadRunnerTimes = sprintf('SET @race_1=%1$s; SET @race_2=%2$s; SET @race_3=%3$s; SET @race_4=%4$s; SET @race_5=%5$s; SET @race_6=%6$s;
                            SET @race_7=%7$s; SET @race_8=%8$s; SET @race_9=%9$s; SET @race_10=%10$s; SET @race_11=%11$s; SET @race_12=%12$s;
                            CALL proc_shortChamp_Divs_getTimesPoints(%13$s,"%14$s",@race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12);', $arrRaceIDs[0], $arrRaceIDs[1], $arrRaceIDs[2], $arrRaceIDs[3], $arrRaceIDs[4], $arrRaceIDs[5], $arrRaceIDs[6], $arrRaceIDs[7], $arrRaceIDs[8], $arrRaceIDs[9],$arrRaceIDs[10],$arrRaceIDs[11], $RunnerID, $txtLoadRunnerSex);

                            $sqlGetRunnerTimes = "SELECT @race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12;";

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
                                                        splitRunnerTimePoints($row['@race_12']);
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

                        // echo $row['RunnerID'] . " " . $row['RunnerFirstName'] . " " . $row['RunnerSurname'] . " " . $row['ShortChampDivGenOverallPoints'] . " " . $row['ChampionshipID'] . "<br>";

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
            echo "Oops! I couldn't find any Division 3 short championship runners for $RaceYear!";
        }
        echo "</table></div></td></tr></div>"; // inner table to contain collapsible division 3 content


        echo "<tr><td colspan='20' class=\"tblTimesPointsOuter\">";
        echo "<button class=\"accordion\">Division 2: $txtDivisionTitle</button><div class=\"panel\">";
        echo "<table id='innerTableDiv2' class='tblTimesPointsInner'>"; // inner table to contain collapsible division 2 content

        // Get the runner details
        if(mysqli_multi_query($conn,$sqlGetShortChampDiv2Runners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){

                        // combine the rows into a multi-dimensional array
                        //array_push($arrMRunnerIDsNamesChampIDs, $row['RunnerID'], $row['RunnerFirstName'], $row['RunnerSurname'], $row['ShortChampDivGenOverallPoints'], $row['ChampionshipID']);

                        $RunnerID = $row['RunnerID'];
                        $RunnerName = $row['RunnerFirstName'] . " " . $row['RunnerSurname'];
                        $ChampPoints = $row['ShortChampDivGenOverallPoints'];


                        echo "\n<tr>\n<td class=\"tblTimesPointsInnerNames\">$RunnerName</td>\n";

                            // procedure call for each runnerID, to return a list of raceIDs, times and points
                            $sqlLoadRunnerTimes = sprintf('SET @race_1=%1$s; SET @race_2=%2$s; SET @race_3=%3$s; SET @race_4=%4$s; SET @race_5=%5$s; SET @race_6=%6$s;
                            SET @race_7=%7$s; SET @race_8=%8$s; SET @race_9=%9$s; SET @race_10=%10$s; SET @race_11=%11$s; SET @race_12=%12$s;
                            CALL proc_shortChamp_Divs_getTimesPoints(%13$s,"%14$s",@race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12);', $arrRaceIDs[0], $arrRaceIDs[1], $arrRaceIDs[2], $arrRaceIDs[3], $arrRaceIDs[4], $arrRaceIDs[5], $arrRaceIDs[6], $arrRaceIDs[7], $arrRaceIDs[8], $arrRaceIDs[9],$arrRaceIDs[10],$arrRaceIDs[11], $RunnerID, $txtLoadRunnerSex);

                            $sqlGetRunnerTimes = "SELECT @race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12;";

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
                                                        splitRunnerTimePoints($row['@race_12']);
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

                        // echo $row['RunnerID'] . " " . $row['RunnerFirstName'] . " " . $row['RunnerSurname'] . " " . $row['ShortChampDivGenOverallPoints'] . " " . $row['ChampionshipID'] . "<br>";

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
            echo "Oops! I couldn't find any Division 2 short championship runners for $RaceYear!";
        }
        echo "</table></div></td></tr></div>"; // inner table to contain collapsible division 2 content

        echo "<tr><td colspan='20' class=\"tblTimesPointsOuter\">";
        echo "<button class=\"accordion\">Division 1: $txtDivisionTitle</button><div class=\"panel\">";
        echo "<table id='innerTableDiv2' class='tblTimesPointsInner'>"; // inner table to contain collapsible division 1 content    

        // Get the runner details
        if(mysqli_multi_query($conn,$sqlGetShortChampDiv1Runners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){

                        // combine the rows into a multi-dimensional array
                        //array_push($arrMRunnerIDsNamesChampIDs, $row['RunnerID'], $row['RunnerFirstName'], $row['RunnerSurname'], $row['ShortChampDivGenOverallPoints'], $row['ChampionshipID']);

                        $RunnerID = $row['RunnerID'];
                        $RunnerName = $row['RunnerFirstName'] . " " . $row['RunnerSurname'];
                        $ChampPoints = $row['ShortChampDivGenOverallPoints'];


                        echo "\n<tr>\n<td class=\"tblTimesPointsInnerNames\">$RunnerName</td>\n";

                            // procedure call for each runnerID, to return a list of raceIDs, times and points
                            $sqlLoadRunnerTimes = sprintf('SET @race_1=%1$s; SET @race_2=%2$s; SET @race_3=%3$s; SET @race_4=%4$s; SET @race_5=%5$s; SET @race_6=%6$s;
                            SET @race_7=%7$s; SET @race_8=%8$s; SET @race_9=%9$s; SET @race_10=%10$s; SET @race_11=%11$s; SET @race_12=%12$s;
                            CALL proc_shortChamp_Divs_getTimesPoints(%13$s,"%14$s",@race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12);', $arrRaceIDs[0], $arrRaceIDs[1], $arrRaceIDs[2], $arrRaceIDs[3], $arrRaceIDs[4], $arrRaceIDs[5], $arrRaceIDs[6], $arrRaceIDs[7], $arrRaceIDs[8], $arrRaceIDs[9],$arrRaceIDs[10],$arrRaceIDs[11], $RunnerID, $txtLoadRunnerSex);

                            $sqlGetRunnerTimes = "SELECT @race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12;";

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
                                                        splitRunnerTimePoints($row['@race_12']);
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

                        // echo $row['RunnerID'] . " " . $row['RunnerFirstName'] . " " . $row['RunnerSurname'] . " " . $row['ShortChampDivGenOverallPoints'] . " " . $row['ChampionshipID'] . "<br>";

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
            echo "Oops! I couldn't find any Division 1 short championship runners for $RaceYear!";
        }
        echo "</table></div></td></tr></div>"; // inner table to contain collapsible division 1 content
    } while($loopCount <= ($loopLimit-1)); //loop limit - 1 to avoid extra loop

    //
    // - - View Races Short Championship Divisions: END
    //        
    }


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
