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

    // if it exists, empty the array of raceIDs
    unset($arrRaceDetails);

    // if it exists, empty the array of Div 3 RunnerIDs, FirstNames, Surnames, and ChampionshipIDs
    unset($arrDiv3RunnerIDsNamesChampIDs);

    // if it exists, empty the array of Div 2 RunnerIDs, FirstNames, Surnames, and ChampionshipIDs
    unset($arrDiv2RunnerIDsNamesChampIDs);

    // if it exists, empty the array of Div 1 RunnerIDs, FirstNames, Surnames, and ChampionshipIDs
    unset($arrDiv1RunnerIDsNamesChampIDs);

    $sqlGetShortChampRaces = "select RaceID, RaceDate, RaceName from tblRaces WHERE RaceCode IN (8,9) AND RaceDate BETWEEN '$RaceYear-01-01' AND '$RaceYear-12-31' ORDER BY RaceDate";

    //run the queries and populate the multi-dimensional array $arrRaceDetails
    $arrRaceDetails = array();

    // Get the short champ races
    if(mysqli_multi_query($conn,$sqlGetShortChampRaces))
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
                              "RaceChampionship" => "short"
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
        echo "Oops! I couldn't find any short championship races for $RaceYear!";
    }

    // count the size of $arrRaceDetails for use in the code
    $arrRaceDetails_items = count($arrRaceDetails);

    // a multi dimensional array of RunnerIDs, RunnerNames, RaceIDs, RaceTimes and RacePoints
    $arrRunnerDetails = array();

    // Because the divisions were combined and the short champ was split only by sex for 2018, keep the 2018 queries separate
    if($RaceYear == 2018) {

        // queries for 2018 races only - start
        //
        //get the ladies' results
        $sqlGetShortChampFRunners = "select DISTINCT tblShortChampDivGenOverallPoints.RunnerID, tblRunners.RunnerFirstName, tblRunners.RunnerSurname, tblShortChampDivGenOverallPoints.RunnerSex, tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints, tblShortChampDivGenOverallPoints.ChampionshipID
        FROM tblShortChampDivGenOverallPoints
            INNER JOIN tblRunners ON tblShortChampDivGenOverallPoints.RunnerID = tblRunners.RunnerID
        WHERE tblShortChampDivGenOverallPoints.RunnerSex='F' 
            AND tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints > 0 
            AND tblShortChampDivGenOverallPoints.ChampYear = $RaceYear
        ORDER BY tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints DESC";
        
        //
        // get the men's results
        $sqlGetShortChampMRunners = "select DISTINCT tblShortChampDivGenOverallPoints.RunnerID, tblRunners.RunnerFirstName, tblRunners.RunnerSurname, tblShortChampDivGenOverallPoints.RunnerSex, tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints, tblShortChampDivGenOverallPoints.ChampionshipID
        FROM tblShortChampDivGenOverallPoints
            INNER JOIN tblRunners ON tblShortChampDivGenOverallPoints.RunnerID = tblRunners.RunnerID
        WHERE tblShortChampDivGenOverallPoints.RunnerSex='M'
            AND tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints > 0
            AND tblShortChampDivGenOverallPoints.ChampYear = $RaceYear
        ORDER BY tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints DESC";
        // queries for 2018 races - end
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

    // check the $RaceYear then build the $arrRunnerDetails array
    if ($RaceYear <> 2018)
    {
        // Get the Div 1 Men Race Times
        if(mysqli_multi_query($conn,$sqlGetShortChampDiv1MRunners))
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
                                  "RunnerOverallPoints" => $row["ShortChampDivGenOverallPoints"]
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
            echo "Oops! I couldn't find any short championship races for $RaceYear!";
        }
        // Get the Div 2 Men Race Times
        if(mysqli_multi_query($conn,$sqlGetShortChampDiv2MRunners))
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
                                  "RunnerOverallPoints" => $row["ShortChampDivGenOverallPoints"]
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
            echo "Oops! I couldn't find any short championship races for $RaceYear!";
        }
        // Get the Div 3 Men Race Times
        if(mysqli_multi_query($conn,$sqlGetShortChampDiv3MRunners))
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
                                  "RunnerOverallPoints" => $row["ShortChampDivGenOverallPoints"]
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
            echo "Oops! I couldn't find any short championship races for $RaceYear!";
        }
        
        // Get the Div 1 Ladies Race Times
        if(mysqli_multi_query($conn,$sqlGetShortChampDiv1FRunners))
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
                                  "RunnerOverallPoints" => $row["ShortChampDivGenOverallPoints"]
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
            echo "Oops! I couldn't find any short championship races for $RaceYear!";
        }
        // Get the Div 2 Ladies Race Times
        if(mysqli_multi_query($conn,$sqlGetShortChampDiv2FRunners))
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
                                  "RunnerOverallPoints" => $row["ShortChampDivGenOverallPoints"]
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
            echo "Oops! I couldn't find any short championship races for $RaceYear!";
        }
        // Get the Div 3 Ladies Race Times
        if(mysqli_multi_query($conn,$sqlGetShortChampDiv3FRunners))
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
                                  "RunnerOverallPoints" => $row["ShortChampDivGenOverallPoints"]
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
            echo "Oops! I couldn't find any short championship races for $RaceYear!";
        }
    }
    else
    {
        //If $RaceYear is 2018: The divisions were combined and the short champ was split only by sex
        
        // Get the Ladies Combined Division Race Times
        if(mysqli_multi_query($conn,$sqlGetShortChampFRunners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){
                        array_push($arrRunnerDetails,
                            array(
                                  "RunnerID" => $row["RunnerID"],
                                  "RunnerName" => $row["RunnerFirstName"] . " " . $row["RunnerSurname"],
                                  "RunnerSex" => $row["RunnerSex"],
                                  "RunnerDiv" => "99",
                                  "RunnerOverallPoints" => $row["ShortChampDivGenOverallPoints"]
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
            echo "Oops! I couldn't find any short championship races for $RaceYear!";
        }

        // Get the Men's Combined Division Race Times
        if(mysqli_multi_query($conn,$sqlGetShortChampMRunners))
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){
                        array_push($arrRunnerDetails,
                            array(
                                  "RunnerID" => $row["RunnerID"],
                                  "RunnerName" => $row["RunnerFirstName"] . " " . $row["RunnerSurname"],
                                  "RunnerSex" => $row["RunnerSex"],
                                  "RunnerDiv" => "99",
                                  "RunnerOverallPoints" => $row["ShortChampDivGenOverallPoints"]
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
            echo "Oops! I couldn't find any short championship races for $RaceYear!";
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

        // set the division to '99' by default for 2018 races only
        // depending on $RaceYear
        if($RaceYear==2018)
        {
            $divisionCounter = 99;
        }
        
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
            
            if($sexCounter==1) { $whichSex = 'F'; }
            if($sexCounter==2) { $whichSex = 'M'; }                 

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
                        //select statement to get the race points and time for this runner - - - - - based on proc_shortChamp_Divs_getTimesPoints
                        $sqlLoadRaceTimesPoints = "SELECT tblRaceTimes.RaceID AS RaceID, tblRaceTimes.RaceTime AS RaceTime, tblShortChampDivGenRacePoints.ShortChampDivGenRacePoints AS RacePoints " .
                            "FROM tblRaceTimes " .
                                "INNER JOIN tblShortChampDivGenRacePoints ON tblRaceTimes.RunnerID = tblShortChampDivGenRacePoints.RunnerID " .
                                "AND tblRaceTimes.RaceID = tblShortChampDivGenRacePoints.RaceID " .
                            "WHERE tblRaceTimes.RaceID=" . $arrRaceDetail["RaceID"] . " " .
                            "AND tblShortChampDivGenRacePoints.RunnerID=" . $arrRunnerDetail["RunnerID"] . " " .
                            "AND tblShortChampDivGenRacePoints.RunnerSex='". $arrRunnerDetail["RunnerSex"] . "';";

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
        }
        
        //if $divisionCounter is '99' i.e. the championship year is 2018, break out of the $divisionCounter loop
        if ($divisionCounter == 99) { break; }
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
