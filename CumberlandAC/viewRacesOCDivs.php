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

    $ChampionshipName = "Open Championship";

    $sqlGetOpenChampSprintRaces = "select RaceID, RaceDate, RaceName from tblRaces WHERE RaceCode IN (1,9) AND RaceDate BETWEEN '$RaceYear-01-01' AND '$RaceYear-12-31' ORDER BY RaceDate";

    $sqlGetOpenChampMiddleRaces = "select RaceID, RaceDate, RaceName from tblRaces WHERE RaceCode IN (2) AND RaceDate BETWEEN '$RaceYear-01-01' AND '$RaceYear-12-31' ORDER BY RaceDate";

    $sqlGetOpenChampLongRaces = "select RaceID, RaceDate, RaceName from tblRaces WHERE RaceCode IN (4) AND RaceDate BETWEEN '$RaceYear-01-01' AND '$RaceYear-12-31' ORDER BY RaceDate";

    // since the divisions were combined sex for 2018 only, keep the 2018 queries separate
    if($RaceYear == 2018) {
        $sqlGetOpenChampDiv3Runners  = "SELECT * FROM viewopenchamprunners2018 WHERE RunnerDiv = 3 ORDER BY OpenChampDivGenOverallPoints DESC";        
        $sqlGetOpenChampDiv2Runners  = "SELECT * FROM viewopenchamprunners2018 WHERE RunnerDiv = 2 ORDER BY OpenChampDivGenOverallPoints DESC";        
        $sqlGetOpenChampDiv1Runners  = "SELECT * FROM viewopenchamprunners2018 WHERE RunnerDiv = 1 ORDER BY OpenChampDivGenOverallPoints DESC";
    }
    else {
        if($RaceYear == date("Y"))
        {
            // if it's the current year, the correct divisions will be found in the tblRunners table
            $txtViewOCRunners = "viewopenchamprunners_currentyear";
        }
        else
        {
            // if it's an earlier year, the correct divisions will be found in the tblMembershipArchive table
            $txtViewOCRunners = "viewopenchamprunners";        
        }
        // MEN
        $sqlGetOpenChampDiv3MRunners = "SELECT * FROM $txtViewOCRunners WHERE RunnerDiv = 3 AND RunnerSex = 'M' AND ChampYear = $RaceYear ORDER BY OpenChampDivGenOverallPoints DESC";
        $sqlGetOpenChampDiv2MRunners = "SELECT * FROM $txtViewOCRunners WHERE RunnerDiv = 2 AND RunnerSex = 'M' AND ChampYear = $RaceYear ORDER BY OpenChampDivGenOverallPoints DESC";
        $sqlGetOpenChampDiv1MRunners = "SELECT * FROM $txtViewOCRunners WHERE RunnerDiv = 1 AND RunnerSex = 'M' AND ChampYear = $RaceYear ORDER BY OpenChampDivGenOverallPoints DESC";

        // LADIES
        $sqlGetOpenChampDiv3FRunners = "SELECT * FROM $txtViewOCRunners WHERE RunnerDiv = 3 AND RunnerSex = 'F' AND ChampYear = $RaceYear ORDER BY OpenChampDivGenOverallPoints DESC";
        $sqlGetOpenChampDiv2FRunners = "SELECT * FROM $txtViewOCRunners WHERE RunnerDiv = 2 AND RunnerSex = 'F' AND ChampYear = $RaceYear ORDER BY OpenChampDivGenOverallPoints DESC";
        $sqlGetOpenChampDiv1FRunners = "SELECT * FROM $txtViewOCRunners WHERE RunnerDiv = 1 AND RunnerSex = 'F' AND ChampYear = $RaceYear ORDER BY OpenChampDivGenOverallPoints DESC";        
    }


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
        echo "Oops! I couldn't find any open championship sprint distance races for $RaceYear!";
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
        echo "Oops! I couldn't find any open championship middle distance races for $RaceYear!";
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
                    
                    //capture the dummy race ID with the below statement; don't output anything
                    if($row["RaceID"] == "9999")
                    {
                        //don't output anything
                    }
                    else
                    {
                        echo "<th class='rotate'><div class='fntLong'><span>" . $row['RaceName'] . "<br>" . $row['RaceDate'] . "</span></div></th>";
                    }
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Oops! I couldn't find any open championship long distance races for $RaceYear!";
    }

    echo "<th style='background-color:black; width: 50px;'></th>";
    echo "</tr>";
    


    //
    // - - View Races Open Championship Divisions: START
    //
    
    if($RaceYear == 2018) {   
        // loop through the table set-up once since only one pass is needed to retrieve joint (male and female) division results
        $loopLimit = 1;
        
        $sqlGetOpenChampDiv3Runners = $sqlGetOpenChampDiv3Runners;
        $sqlGetOpenChampDiv2Runners = $sqlGetOpenChampDiv2Runners;
        $sqlGetOpenChampDiv1Runners = $sqlGetOpenChampDiv1Runners;
        
        $txtDivisionTitle = "Joint Men & Women";
        $txtLoadRunnerSex = "Joint";
    }
    else {
        // loop through the table set-up twice to retrieve separate male and female division results
        $loopLimit = 2;
    }
    
    $loopCount = 0;
        
    do {
        $loopCount++;

        if($RaceYear > 2018 && $loopCount == 1) {   
            // if the year is AFTER 2018 and if this is the first pass, retrieve the MENs results, otherwise retrieve the LADIES results
            
            // MEN     
            $sqlGetOpenChampDiv3Runners = $sqlGetOpenChampDiv3MRunners;
            $sqlGetOpenChampDiv2Runners = $sqlGetOpenChampDiv2MRunners;
            $sqlGetOpenChampDiv1Runners = $sqlGetOpenChampDiv1MRunners;
        
            $txtDivisionTitle = "Men";
            $txtLoadRunnerSex = "M";
        }
        elseif ($RaceYear > 2018 && $loopCount == 2) {
            // LADIES     
            $sqlGetOpenChampDiv3Runners = $sqlGetOpenChampDiv3FRunners;
            $sqlGetOpenChampDiv2Runners = $sqlGetOpenChampDiv2FRunners;
            $sqlGetOpenChampDiv1Runners = $sqlGetOpenChampDiv1FRunners;
        
            $txtDivisionTitle = "Ladies";  
            $txtLoadRunnerSex = "F";
        }
        
        echo "<tr><td colspan='20' class=\"tblTimesPointsOuter\">";
        echo "<button class=\"accordion\">Division 3: $txtDivisionTitle</button><div class=\"panel\">";
        echo "<table id=\"innerTableDiv3\" class='tblTimesPointsInner'>"; // inner table to contain collapsible division 3 content
        
        // Get the runner details
        if(mysqli_multi_query($conn,$sqlGetOpenChampDiv3Runners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){

                        // combine the rows into a multi-dimensional array
                        //array_push($arrDiv3RunnerIDsNamesChampIDs, $row['RunnerID'], $row['RunnerFirstName'], $row['RunnerSurname'], $row['OpenChampDivGenOverallPoints'], $row['ChampionshipID']);

                        $RunnerID = $row['RunnerID'];
                        $RunnerName = $row['RunnerFirstName'] . " " . $row['RunnerSurname'];
                        $ChampPoints = $row['OpenChampDivGenOverallPoints'];


                        echo "\n<tr>\n<td class=\"tblTimesPointsInnerNames\">$RunnerName</td>\n";

                            // procedure call for each runnerID, to return a list of raceIDs, times and points
                            $sqlLoadRunnerTimes = sprintf('SET @race_1=%1$s; SET @race_2=%2$s; SET @race_3=%3$s; SET @race_4=%4$s; SET @race_5=%5$s; SET @race_6=%6$s;
                            SET @race_7=%7$s; SET @race_8=%8$s; SET @race_9=%9$s; SET @race_10=%10$s; SET @race_11=%11$s; SET @race_12=%12$s;
                            SET @race_13=%13$s; SET @race_14=%14$s; SET @race_15=%15$s; SET @race_16=%16$s; SET @race_17=%17$s; SET @race_18=%18$s; SET @race_19=%19$s;
                            CALL proc_openChamp_Divs_getTimesPoints(%20$s,"%21$s",@race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12, @race_13, @race_14, @race_15, @race_16, @race_17, @race_18, @race_19);', $arrRaceIDs[0], $arrRaceIDs[1], $arrRaceIDs[2], $arrRaceIDs[3], $arrRaceIDs[4], $arrRaceIDs[5], $arrRaceIDs[6], $arrRaceIDs[7], $arrRaceIDs[8], $arrRaceIDs[9], $arrRaceIDs[10], $arrRaceIDs[11], $arrRaceIDs[12], $arrRaceIDs[13], $arrRaceIDs[14], $arrRaceIDs[15], $arrRaceIDs[16], $arrRaceIDs[17],$arrRaceIDs[18],$RunnerID,$txtLoadRunnerSex);

                            $sqlGetRunnerTimes = "SELECT @race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12, @race_13, @race_14, @race_15, @race_16, @race_17, @race_18, @race_19;";

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
                                                        splitRunnerTimePoints($row['@race_18']) .
                                                        splitRunnerTimePoints($row['@race_19']);
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
            echo "Oops! I couldn't find any Division 3 open championship runners for $RaceYear!";
        }
        echo "</table></div></td></tr></div>"; // inner table to contain collapsible division 3 content


        echo "<tr><td colspan='20' class=\"tblTimesPointsOuter\">";
        echo "<button class=\"accordion\">Division 2: $txtDivisionTitle</button><div class=\"panel\">";
        echo "<table id='innerTableDiv2' class='tblTimesPointsInner'>"; // inner table to contain collapsible division 2 content

        // Get the runner details
        if(mysqli_multi_query($conn,$sqlGetOpenChampDiv2Runners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){

                        // combine the rows into a multi-dimensional array
                        //array_push($arrDiv2RunnerIDsNamesChampIDs, $row['RunnerID'], $row['RunnerFirstName'], $row['RunnerSurname'], $row['OpenChampDivGenOverallPoints'], $row['ChampionshipID']);

                        $RunnerID = $row['RunnerID'];
                        $RunnerName = $row['RunnerFirstName'] . " " . $row['RunnerSurname'];
                        $ChampPoints = $row['OpenChampDivGenOverallPoints'];


                        echo "\n<tr>\n<td class=\"tblTimesPointsInnerNames\">$RunnerName</td>\n";

                            // procedure call for each runnerID, to return a list of raceIDs, times and points
                            $sqlLoadRunnerTimes = sprintf('SET @race_1=%1$s; SET @race_2=%2$s; SET @race_3=%3$s; SET @race_4=%4$s; SET @race_5=%5$s; SET @race_6=%6$s;
                            SET @race_7=%7$s; SET @race_8=%8$s; SET @race_9=%9$s; SET @race_10=%10$s; SET @race_11=%11$s; SET @race_12=%12$s;
                            SET @race_13=%13$s; SET @race_14=%14$s; SET @race_15=%15$s; SET @race_16=%16$s; SET @race_17=%17$s; SET @race_18=%18$s; SET @race_19=%19$s;
                            CALL proc_openChamp_Divs_getTimesPoints(%20$s,"%21$s",@race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12, @race_13, @race_14, @race_15, @race_16, @race_17, @race_18, @race_19);', $arrRaceIDs[0], $arrRaceIDs[1], $arrRaceIDs[2], $arrRaceIDs[3], $arrRaceIDs[4], $arrRaceIDs[5], $arrRaceIDs[6], $arrRaceIDs[7], $arrRaceIDs[8], $arrRaceIDs[9], $arrRaceIDs[10], $arrRaceIDs[11], $arrRaceIDs[12], $arrRaceIDs[13], $arrRaceIDs[14], $arrRaceIDs[15], $arrRaceIDs[16], $arrRaceIDs[17], $arrRaceIDs[18], $RunnerID,$txtLoadRunnerSex);

                            $sqlGetRunnerTimes = "SELECT @race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12, @race_13, @race_14, @race_15, @race_16, @race_17, @race_18, @race_19;";

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
                                                        splitRunnerTimePoints($row['@race_18']) .
                                                        splitRunnerTimePoints($row['@race_19']);
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
            echo "Oops! I couldn't find any Division 2 open championship runners for $RaceYear!";
        }
        echo "</table></div></td></tr></div>"; // inner table to contain collapsible division 2 content

        echo "<tr><td colspan='20' class=\"tblTimesPointsOuter\">";
        echo "<button class=\"accordion\">Division 1: $txtDivisionTitle</button><div class=\"panel\">";
        echo "<table id='innerTableDiv2' class='tblTimesPointsInner'>"; // inner table to contain collapsible division 1 content    

        // Get the runner details
        if(mysqli_multi_query($conn,$sqlGetOpenChampDiv1Runners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){

                        // combine the rows into a multi-dimensional array
                        //array_push($arrDiv1RunnerIDsNamesChampIDs, $row['RunnerID'], $row['RunnerFirstName'], $row['RunnerSurname'], $row['OpenChampDivGenOverallPoints'], $row['ChampionshipID']);

                        $RunnerID = $row['RunnerID'];
                        $RunnerName = $row['RunnerFirstName'] . " " . $row['RunnerSurname'];
                        $ChampPoints = $row['OpenChampDivGenOverallPoints'];


                        echo "\n<tr>\n<td class=\"tblTimesPointsInnerNames\">$RunnerName</td>\n";

                            // procedure call for each runnerID, to return a list of raceIDs, times and points
                            $sqlLoadRunnerTimes = sprintf('SET @race_1=%1$s; SET @race_2=%2$s; SET @race_3=%3$s; SET @race_4=%4$s; SET @race_5=%5$s; SET @race_6=%6$s;
                            SET @race_7=%7$s; SET @race_8=%8$s; SET @race_9=%9$s; SET @race_10=%10$s; SET @race_11=%11$s; SET @race_12=%12$s;
                            SET @race_13=%13$s; SET @race_14=%14$s; SET @race_15=%15$s; SET @race_16=%16$s; SET @race_17=%17$s; SET @race_18=%18$s; SET @race_19=%19$s;
                            CALL proc_openChamp_Divs_getTimesPoints(%20$s,"%21$s",@race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12, @race_13, @race_14, @race_15, @race_16, @race_17, @race_18, @race_19);', $arrRaceIDs[0], $arrRaceIDs[1], $arrRaceIDs[2], $arrRaceIDs[3], $arrRaceIDs[4], $arrRaceIDs[5], $arrRaceIDs[6], $arrRaceIDs[7], $arrRaceIDs[8], $arrRaceIDs[9], $arrRaceIDs[10], $arrRaceIDs[11], $arrRaceIDs[12], $arrRaceIDs[13], $arrRaceIDs[14], $arrRaceIDs[15], $arrRaceIDs[16], $arrRaceIDs[17], $arrRaceIDs[18], $RunnerID,$txtLoadRunnerSex);

                            $sqlGetRunnerTimes = "SELECT @race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12, @race_13, @race_14, @race_15, @race_16, @race_17, @race_18, @race_19;";

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
                                                        splitRunnerTimePoints($row['@race_18']) .
                                                        splitRunnerTimePoints($row['@race_19']);
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
            echo "Oops! I couldn't find any Division 1 open championship runners for $RaceYear!";
        }
        echo "</table></div></td></tr></div>"; // inner table to contain collapsible division 1 content
    } while($loopCount <= ($loopLimit-1)); //loop limit - 1 to avoid extra loop

    //
    // - - View Races Open Championship Divisions: END
    //

    
    echo "</table>";
    echo "<br>";



function splitRunnerTimePoints($RaceIDTimePoints){
    //need to define the global variables you are accessing from within the function
    global $champDisplay;
    


    
    
    // function to split the runner times and points from the mysqli_multi_line query    
    if(substr($RaceIDTimePoints,0,4) == "9999")
    {
        //because there are 6 long distance races in total in the 2018 championship, but 6 long distance races PLUS a marathon from 2019 onwards, a dummy / placeholder race has been entered under race id 9999 to avoid an error with the proc_openChamp_Divs_getTimesPoints by ensuring there are 19 items in the $arrRaceIDs array
        
        //don't do anything if this is the dummy race ID, since there are only actually 18 sets of races and times for 2018
    }
    elseif(substr($RaceIDTimePoints,0,4) <> "9999" AND strlen($RaceIDTimePoints) < 5) {
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