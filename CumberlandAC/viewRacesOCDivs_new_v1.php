<?php
    include('session.php');

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

    $ChampionshipName = "Open Championship";

    // if it exists, empty the array of raceIDs
    unset($arrRaceDetails);

    // if it exists, empty the array of Div 3 RunnerIDs, FirstNames, Surnames, and ChampionshipIDs
    unset($arrDiv3RunnerIDsNamesChampIDs);

    // if it exists, empty the array of Div 2 RunnerIDs, FirstNames, Surnames, and ChampionshipIDs
    unset($arrDiv2RunnerIDsNamesChampIDs);

    // if it exists, empty the array of Div 1 RunnerIDs, FirstNames, Surnames, and ChampionshipIDs
    unset($arrDiv1RunnerIDsNamesChampIDs);

    $sqlGetOpenChampSprintRaces = "select RaceID, RaceDate, RaceName from tblRaces WHERE RaceCode IN (1,9) AND RaceDate BETWEEN '$RaceYear-01-01' AND '$RaceYear-12-31' ORDER BY RaceDate";

    $sqlGetOpenChampSprintMedRaces = "select RaceID, RaceDate, RaceName from tblRaces WHERE RaceCode IN (32) AND RaceDate BETWEEN '$RaceYear-01-01' AND '$RaceYear-12-31' ORDER BY RaceDate";

    $sqlGetOpenChampMiddleRaces = "select RaceID, RaceDate, RaceName from tblRaces WHERE RaceCode IN (2) AND RaceDate BETWEEN '$RaceYear-01-01' AND '$RaceYear-12-31' ORDER BY RaceDate";

    $sqlGetOpenChampLongRaces = "select RaceID, RaceDate, RaceName from tblRaces WHERE RaceCode IN (4) AND RaceDate BETWEEN '$RaceYear-01-01' AND '$RaceYear-12-31' ORDER BY RaceDate";

    //run the queries and populate the multi-dimensional array $arrRaceDetails
    $arrRaceDetails = array();

    // a multi dimensional array of RunnerIDs, RunnerNames, RaceIDs, RaceTimes and RacePoints
    $arrRunnerDetails = array();

        // Get the sprint races
        if(mysqli_multi_query($conn,$sqlGetOpenChampSprintRaces))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){
                        array_push($arrRaceDetails,
                            array(
                                  "RaceID" => $row["RaceID"],
                                  "RaceName" => $row["RaceName"],
                                  "RaceDate" => $row["RaceDate"],
                                  "RaceCategory" => "sprint",
                                  "RaceChampionship" => "open"
                                 )
                        );
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
        // Get the sprintMed races
        if(mysqli_multi_query($conn,$sqlGetOpenChampSprintMedRaces))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){
                        array_push($arrRaceDetails,
                            array(
                                  "RaceID" => $row["RaceID"],
                                  "RaceName" => $row["RaceName"],
                                  "RaceDate" => $row["RaceDate"],
                                  "RaceCategory" => "sprintMed",
                                  "RaceChampionship" => "open"
                                 )
                        );
                    }
                    mysqli_free_result($result);
                }
                if(mysqli_more_results($conn)) {
                    // do nothing
                }
            } while(mysqli_more_results($conn) && mysqli_next_result($conn));
        }    
        else {
            echo "Oops! I couldn't find any open championship sprintMed distance races for $RaceYear!";
        }
        // Get the middle races
        if(mysqli_multi_query($conn,$sqlGetOpenChampMiddleRaces))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){
                        array_push($arrRaceDetails,
                            array(
                                  "RaceID" => $row["RaceID"],
                                  "RaceName" => $row["RaceName"],
                                  "RaceDate" => $row["RaceDate"],
                                  "RaceCategory" => "middle",
                                  "RaceChampionship" => "open"
                                 )
                        );
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
                        array_push($arrRaceDetails,
                            array(
                                  "RaceID" => $row["RaceID"],
                                  "RaceName" => $row["RaceName"],
                                  "RaceDate" => $row["RaceDate"],
                                  "RaceCategory" => "long",
                                  "RaceChampionship" => "open"
                                 )
                        );
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

    // count the size of $arrRaceDetails for use in the code
    $arrRaceDetails_items = count($arrRaceDetails);

    // since the divisions were combined sex for 2018 only, keep the 2018 queries separate
    if($RaceYear == 2018) {
        $sqlGetOpenChampDiv3Runners  = "SELECT * FROM viewopenchamprunners2018 WHERE RunnerDiv = 3 ORDER BY OpenChampDivGenOverallPoints DESC";        
        $sqlGetOpenChampDiv2Runners  = "SELECT * FROM viewopenchamprunners2018 WHERE RunnerDiv = 2 ORDER BY OpenChampDivGenOverallPoints DESC";        
        $sqlGetOpenChampDiv1Runners  = "SELECT * FROM viewopenchamprunners2018 WHERE RunnerDiv = 1 ORDER BY OpenChampDivGenOverallPoints DESC";
    }
    else {
        if($RaceYear == 2022)
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
    
    // check the $RaceYear
    if ($RaceYear <> 2018)
    {
        // Get the Div 1 Men Race Times
        if(mysqli_multi_query($conn,$sqlGetOpenChampDiv1MRunners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){
                        array_push($arrRunnerDetails,
                            array(
                                  "RunnerID" => $row["RunnerID"],
                                  "RunnerName" => $row["RunnerFirstName"] . " " . $row["RunnerSurname"],
                                  "RunnerSex" => $row["RunnerSex"],
                                  "RunnerDiv" => $row["RunnerDiv"],
                                  "RunnerOverallPoints" => $row["OpenChampDivGenOverallPoints"]
                                 )
                        );
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
        // Get the Div 1 Women Race Times
        if(mysqli_multi_query($conn,$sqlGetOpenChampDiv1FRunners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){
                        array_push($arrRunnerDetails,
                            array(
                                  "RunnerID" => $row["RunnerID"],
                                  "RunnerName" => $row["RunnerFirstName"] . " " . $row["RunnerSurname"],
                                  "RunnerSex" => $row["RunnerSex"],
                                  "RunnerDiv" => $row["RunnerDiv"],
                                  "RunnerOverallPoints" => $row["OpenChampDivGenOverallPoints"]
                                 )
                        );
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
        // Get the Div 2 Men Race Times
        if(mysqli_multi_query($conn,$sqlGetOpenChampDiv2MRunners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){
                        array_push($arrRunnerDetails,
                            array(
                                  "RunnerID" => $row["RunnerID"],
                                  "RunnerName" => $row["RunnerFirstName"] . " " . $row["RunnerSurname"],
                                  "RunnerSex" => $row["RunnerSex"],
                                  "RunnerDiv" => $row["RunnerDiv"],
                                  "RunnerOverallPoints" => $row["OpenChampDivGenOverallPoints"]
                                 )
                        );
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
        // Get the Div 2 Women Race Times
        if(mysqli_multi_query($conn,$sqlGetOpenChampDiv2FRunners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){
                        array_push($arrRunnerDetails,
                            array(
                                  "RunnerID" => $row["RunnerID"],
                                  "RunnerName" => $row["RunnerFirstName"] . " " . $row["RunnerSurname"],
                                  "RunnerSex" => $row["RunnerSex"],
                                  "RunnerDiv" => $row["RunnerDiv"],
                                  "RunnerOverallPoints" => $row["OpenChampDivGenOverallPoints"]
                                 )
                        );
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
        // Get the Div 3 Men Race Times
        if(mysqli_multi_query($conn,$sqlGetOpenChampDiv3MRunners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){
                        array_push($arrRunnerDetails,
                            array(
                                  "RunnerID" => $row["RunnerID"],
                                  "RunnerName" => $row["RunnerFirstName"] . " " . $row["RunnerSurname"],
                                  "RunnerSex" => $row["RunnerSex"],
                                  "RunnerDiv" => $row["RunnerDiv"],
                                  "RunnerOverallPoints" => $row["OpenChampDivGenOverallPoints"]
                                 )
                        );
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
        // Get the Div 3 Women Race Times
        if(mysqli_multi_query($conn,$sqlGetOpenChampDiv3FRunners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){
                        array_push($arrRunnerDetails,
                            array(
                                  "RunnerID" => $row["RunnerID"],
                                  "RunnerName" => $row["RunnerFirstName"] . " " . $row["RunnerSurname"],
                                  "RunnerSex" => $row["RunnerSex"],
                                  "RunnerDiv" => $row["RunnerDiv"],
                                  "RunnerOverallPoints" => $row["OpenChampDivGenOverallPoints"]
                                 )
                        );
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
    }
    else
    {
        //If $RaceYear is 2018, male and female are combined into single divisions
        
        // Get the Div 1 Joint Race Times
        if(mysqli_multi_query($conn,$sqlGetOpenChampDiv1Runners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){
                        array_push($arrRunnerDetails,
                            array(
                                  "RunnerID" => $row["RunnerID"],
                                  "RunnerName" => $row["RunnerFirstName"] . " " . $row["RunnerSurname"],
                                  "RunnerSex" => $row["RunnerSex"],
                                  "RunnerDiv" => $row["RunnerDiv"],
                                  "RunnerOverallPoints" => $row["OpenChampDivGenOverallPoints"]
                                 )
                        );
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
        // Get the Div 2 Joint Race Times
        if(mysqli_multi_query($conn,$sqlGetOpenChampDiv2Runners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){
                        array_push($arrRunnerDetails,
                            array(
                                  "RunnerID" => $row["RunnerID"],
                                  "RunnerName" => $row["RunnerFirstName"] . " " . $row["RunnerSurname"],
                                  "RunnerSex" => $row["RunnerSex"],
                                  "RunnerDiv" => $row["RunnerDiv"],
                                  "RunnerOverallPoints" => $row["OpenChampDivGenOverallPoints"]
                                 )
                        );
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
        // Get the Div 3 Joint Race Times
        if(mysqli_multi_query($conn,$sqlGetOpenChampDiv3Runners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){
                        array_push($arrRunnerDetails,
                            array(
                                  "RunnerID" => $row["RunnerID"],
                                  "RunnerName" => $row["RunnerFirstName"] . " " . $row["RunnerSurname"],
                                  "RunnerSex" => $row["RunnerSex"],
                                  "RunnerDiv" => $row["RunnerDiv"],
                                  "RunnerOverallPoints" => $row["OpenChampDivGenOverallPoints"]
                                 )
                        );
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
    }
?>

<html lang="en">
<head>
  <meta charset="utf-8">
    <title>Cumberland AC - <?php echo $ChampionshipName . " " . $RaceYear; ?></title>
    <meta name="description" content="Cumberland AC <?php echo $ChampionshipName . " " . $RaceYear; ?>">
  <link rel="stylesheet" href="css/styles-20190528.css<?php echo "?date=" . date("Y-m-d_H-i"); ?>">

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]--> 
</head>
<body>
    <h1>Cumberland AC <?php echo $ChampionshipName . " " . $RaceYear; ?></h1>

<?php

require 'champViewNavTable.php';

echo "<br>";
    
echo "<table class=\"tblTimesPointsOuterOpen\">";

    // first row: Race Names
    echo "<tr height=\"250px\">";
    echo "<td class = \"tblTimesPointsOuterSpacer\"></td>";

    //loop through the $arrRaceDetails array
    foreach($arrRaceDetails as $arrRaceDetail)
    {
        echo "<td>";

        if($arrRaceDetail["RaceCategory"] == "sprint")
        {
            echo "<div class='fntSprint rotate90'>";   
        }
        if($arrRaceDetail["RaceCategory"] == "sprintMed")
        {
            echo "<div class='fntSprint rotate90'>";   
        }
        if($arrRaceDetail["RaceCategory"] == "middle")
        {
            echo "<div class='fntMiddle rotate90'>";   
        }
        if($arrRaceDetail["RaceCategory"] == "long")
        {
            echo "<div class='fntLong rotate90'>";   
        }

        echo $arrRaceDetail["RaceName"];
        echo "</div>";
        echo "</td>";              
    }

    //second row: Race Dates
    echo "<tr>";
    echo "<td class = \"tblTimesPointsOuterSpacer\"></td>";

    //loop through the $arrRaceDetails array, this time for the dates
    foreach($arrRaceDetails as $arrRaceDetail)
    {
        echo "<th>";

        if($arrRaceDetail["RaceCategory"] == "sprint")
        {
            echo "<div class='fntSprint'>";   
        }
        if($arrRaceDetail["RaceCategory"] == "sprintMed")
        {
            echo "<div class='fntSprint'>";   
        }
        if($arrRaceDetail["RaceCategory"] == "middle")
        {
            echo "<div class='fntMiddle'>";   
        }
        if($arrRaceDetail["RaceCategory"] == "long")
        {
            echo "<div class='fntLong'>";   
        }

        $createDate = date_create($arrRaceDetail["RaceDate"]);
        echo date_format($createDate,"D");
        echo "<br>";
        echo date_format($createDate,"d");        
        echo "<br>";
        echo date_format($createDate,"M");
        echo "</div>";
        echo "</th>";
    }

    echo "<th style='background-color:black;'></th>";
    echo "</tr>";
    

    //loop through the $arrRaceDetails array, this time wrapped by the $arrRunnerDetails array, to get the runners, race times and race points
    for($divisionCounter = 3; $divisionCounter >= 1; $divisionCounter--)
    {
        //array filter taken from https://www.codexworld.com/how-to/filter-multidimensional-array-key-value-php/

        // set the division you want to filter the array by
        $whichDivision = strval($divisionCounter);

        $filteredByDivision = array_filter($arrRunnerDetails, function ($item) use ($whichDivision) {
            if (stripos($item['RunnerDiv'], $whichDivision) !== false) {
                return true;
            }
            return false;
        });

        for($sexCounter = 1; $sexCounter <=2; $sexCounter++)
        {
            // set the sex you want to filter the array by
            // depending on $RaceYear
            if($RaceYear==2018)
            {
                $sexCounter = 2;
                $whichSex = 'Joint';
            }
            else
            {
                if($sexCounter==1) { $whichSex = 'F'; }
                if($sexCounter==2) { $whichSex = 'M'; }                
            }

            echo "<tbody class=\"labels\" ><tr><td colspan='" . ($arrRaceDetails_items + 2) . "'><label for='Div" . $whichDivision . $whichSex . "'>Division $whichDivision: $whichSex </label><input type=\"checkbox\" name=\"Div" . $whichDivision . $whichSex . "\" id=\"Div" . $whichDivision . $whichSex . "\" data-toggle=\"toggle\"></td></tr></tbody>";
            echo "<tbody class=\"hide\">";

            $filteredBySexAndDivision = array_filter($filteredByDivision, function ($item) use ($whichSex) {
                if (stripos($item['RunnerSex'], $whichSex) !== false) {
                    return true;
                }
                return false;
            });

            foreach($filteredBySexAndDivision as $arrRunnerDetail)
            {
                echo "<tr class=\"tblTimesPointsInner\">";
                echo "<td class=\"tblTimesPointsInnerNames\">" . $arrRunnerDetail["RunnerName"] . "</td>";
                //loop through the $arrRaceDetails array
                foreach($arrRaceDetails as $arrRaceDetail)
                {
                    echo "<td class=\"tblTimesPointsInner\">";
                        //select statement to get the race points and time for this runner - - - - - based on proc_openChamp_Divs_getTimesPoints
                        $sqlLoadRaceTimesPoints = "SELECT tblRaceTimes.RaceID AS RaceID, tblRaceTimes.RaceTime AS RaceTime, tblOpenChampDivGenRacePoints.OpenChampDivGenRacePoints AS RacePoints " .
                            "FROM tblRaceTimes " .
                                "INNER JOIN tblOpenChampDivGenRacePoints ON tblRaceTimes.RunnerID = tblOpenChampDivGenRacePoints.RunnerID " .
                                "AND tblRaceTimes.RaceID = tblOpenChampDivGenRacePoints.RaceID " .
                            "WHERE tblRaceTimes.RaceID=" . $arrRaceDetail["RaceID"] . " " .
                            "AND tblOpenChampDivGenRacePoints.RunnerID=" . $arrRunnerDetail["RunnerID"] . " " .
                            "AND tblOpenChampDivGenRacePoints.RunnerSex='". $arrRunnerDetail["RunnerSex"] . "';";

                    // Get the Race Points and Times

                    $result = mysqli_query($conn, $sqlLoadRaceTimesPoints);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            // display points / time as per the URL. defaults at race times
                            if($champDisplay == "times") {
                                echo "<div class=\"fontRaceTime\" style='display:inline'>" . $row["RaceTime"] . "</div>\n";            
                            }
                            else if($champDisplay == "points") {
                                echo "<div class=\"fontRacePoints\" style='display:inline'>" . $row["RacePoints"] . "</div>\n";
                            }
                        }
                    } else {
                        //no results returned
                    }

                    echo "</td>";              
                }
                echo "<td>" . $arrRunnerDetail["RunnerOverallPoints"] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";            
        }
    }
    
    echo "</table>";
    echo "<br>";

include 'champViewNavTable.php';

 
?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
	$('[data-toggle="toggle"]').change(function(){
		$(this).parents().next('.hide').toggle();
	});
});
</script>
</body>
</html>