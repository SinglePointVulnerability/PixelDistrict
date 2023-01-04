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
        $RaceYear = 2022;
    }

    require 'DBconn.php';


    $ChampionshipName = "Multi-Terrain Challenge";

    $sqlGetMTChallRaces = "select RaceID, RaceDate, RaceName from tblRaces WHERE RaceCode=16 AND RaceDate BETWEEN '$RaceYear-01-01' AND '$RaceYear-12-31' ORDER BY RaceDate";
    
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

    //run the queries and populate the multi-dimensional array $arrRaceDetails
    $arrRaceDetails = array();

    // Get the MT challenge races
    if(mysqli_multi_query($conn,$sqlGetMTChallRaces))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    array_push($arrRaceDetails,
                        array(
                              "RaceID" => $row["RaceID"],
                              "RaceName" => $row["RaceName"],
                              "RaceDate" => $row["RaceDate"],
                              "RaceCategory" => "Multi-Terrain",
                              "RaceChampionship" => "Multi-Terrain Challenge"
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
        echo "Oops! I couldn't find any Multi-Terrain Challenge races for $RaceYear!";
    }

    // count the size of $arrRaceDetails for use in the code
    $arrRaceDetails_items = count($arrRaceDetails);

    // a multi dimensional array of RunnerIDs, RunnerNames, RaceIDs, RaceTimes and RacePoints
    $arrRunnerDetails = array();


    // Build the $arrRunnerDetails array
    //
    // Get the Men's Race Times
    if(mysqli_multi_query($conn,$sqlGetMTChallMRunners))
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
                              "RunnerOverallPoints" => $row["MTChallDivGenOverallPoints"]
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
        echo "Oops! I couldn't find any Men's Multi-Terrain Challenge results for $RaceYear!";
    }
    //
    // Get the Ladies Race Times
    if(mysqli_multi_query($conn,$sqlGetMTChallFRunners))
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
                              "RunnerOverallPoints" => $row["MTChallDivGenOverallPoints"]
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
        echo "Oops! I couldn't find any Ladies Multi-Terrain Challenge results for $RaceYear!";
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

        if($arrRaceDetail["RaceCategory"] == "Multi-Terrain")
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

    for($sexCounter = 1; $sexCounter <=2; $sexCounter++)
    {
        // set the sex you want to filter the array by

        if($sexCounter==1) { $whichSex = 'F'; }
        if($sexCounter==2) { $whichSex = 'M'; }                 

        echo "<tbody class=\"labels\" ><tr><td colspan='" . ($arrRaceDetails_items + 2) . "'><label for='Div" . $whichSex . "'>: $whichSex </label><input type=\"checkbox\" name=\"Div" . $whichSex . "\" id=\"Div" . $whichSex . "\" data-toggle=\"toggle\"></td></tr></tbody>";
        echo "<tbody class=\"hide\">";

        $filteredBySex = array_filter($arrRunnerDetails, function ($item) use ($whichSex) {
            if (stripos($item['RunnerSex'], $whichSex) !== false) {
                return true;
            }
            return false;
        });

        foreach($filteredBySex as $arrRunnerDetail)
        {
            echo "<tr class=\"tblTimesPointsInner\">";
            echo "<td class=\"tblTimesPointsInnerNames\">" . $arrRunnerDetail["RunnerName"] . "</td>";
            //loop through the $arrRaceDetails array
            foreach($arrRaceDetails as $arrRaceDetail)
            {
                echo "<td class=\"tblTimesPointsInner\">";
                    //select statement to get the race points and time for this runner - - - - - based on proc_shortChamp_Divs_getTimesPoints
                    $sqlLoadRaceTimesPoints = "SELECT tblRaceTimes.RaceID AS RaceID, tblRaceTimes.RaceTime AS RaceTime, tblMTChallDivGenRacePoints.MTChallDivGenRacePoints AS RacePoints " .
                        "FROM tblRaceTimes " .
                            "INNER JOIN tblMTChallDivGenRacePoints ON tblRaceTimes.RunnerID = tblMTChallDivGenRacePoints.RunnerID " .
                            "AND tblRaceTimes.RaceID = tblMTChallDivGenRacePoints.RaceID " .
                        "WHERE tblRaceTimes.RaceID=" . $arrRaceDetail["RaceID"] . " " .
                        "AND tblMTChallDivGenRacePoints.RunnerID=" . $arrRunnerDetail["RunnerID"] . " " .
                        "AND tblMTChallDivGenRacePoints.RunnerSex='". $arrRunnerDetail["RunnerSex"] . "';";

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
