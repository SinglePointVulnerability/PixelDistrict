<?php
    include('session.php');
?>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Cumberland AC DB Admin</title>
  <meta name="description" content="Cumberland AC DB Admin - Update Database">
  <meta name="author" content="West Coast Web Design">

  <link rel="stylesheet" href="css/styles.css<?php echo "?date=" . date("Y-m-d_H-i"); ?>">

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>
    
<?php   
    // open connection to the database
    require 'DBconn.php';
    
    // Note: all dates are stored in reverse in SQL e.g. 2017-12-31 for 31st Dec 2017
    //       so convert dates on this page, before they are stored in the DB

    
    

    
if(empty($_POST["parentPage"]))  
{
        $whatInfo = "none";
        // DELETE THIS CODE ONCE TESTING IS FINISHED
    // rankRaceTies(1);
}
else {
        $whatInfo = htmlspecialchars($_POST["parentPage"]);
}

    
if ($whatInfo == "amendRunner") {

    $intRunnerID = htmlspecialchars($_POST["intRunnerID"]);
    $txtRunnerFirstName = htmlspecialchars($_POST["txtRunnerFirstName"]);
    $txtRunnerSurname = htmlspecialchars($_POST["txtRunnerSurname"]);
    $intRunnerDivision = htmlspecialchars($_POST["intRunnerDivision"]);
    $txtRunnerSubsPaid = htmlspecialchars($_POST["txtRunnerSubsPaid"]);
    $dteRunnerDOB = htmlspecialchars($_POST["dteRunnerDOB"]);
    $txtRunnerSex = htmlspecialchars($_POST["txtRunnerSex"]);
    
    $sql = "UPDATE tblRunners SET RunnerFirstName='" . $txtRunnerFirstName .
        "', RunnerSurname='" . $txtRunnerSurname .
        "', RunnerDiv=" . $intRunnerDivision .
        ", RunnerSubsPaid='" . $txtRunnerSubsPaid .
        "', RunnerDOB='" . $dteRunnerDOB .
        "', RunnerSex='" . $txtRunnerSex .
        "' WHERE RunnerID=" . $intRunnerID;
    if (mysqli_query($conn,$sql) === TRUE) {
        echo "<br><br>Runner details changed successfully<br><br>";
    } else {
        echo "<br><br>Error updating record: " . $conn->error . "<br><br>" . $sql;
    } 
}
if ($whatInfo == "addRunner") {

    $txtRunnerFirstName = htmlspecialchars($_POST["txtRunnerFirstName"]);
    $txtRunnerSurname = htmlspecialchars($_POST["txtRunnerSurname"]);
    $intRunnerDivision = htmlspecialchars($_POST["intRunnerDivision"]);
    $txtRunnerSubsPaid = htmlspecialchars($_POST["txtRunnerSubsPaid"]);
    $dteRunnerDOB = htmlspecialchars($_POST["dteRunnerDOB"]);
    $txtRunnerSex = htmlspecialchars($_POST["txtRunnerSex"]);
   
    $sql = "INSERT INTO tblRunners (RunnerFirstName, RunnerSurname, RunnerDiv, RunnerSubsPaid, RunnerDOB, RunnerSex) " .
        "VALUES ('" . $txtRunnerFirstName . "', " .
        "'" . $txtRunnerSurname . "', " .
        $intRunnerDivision . ", " .
        "'" . $txtRunnerSubsPaid . "', " .
        "'" . $dteRunnerDOB . "', " .
        "'" . $txtRunnerSex . "')";

    if (mysqli_query($conn,$sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error . "<br><br>" . $sql;
    } 
}
if ($whatInfo == "addRace") {
/*
    $txtRaceName = htmlspecialchars($_POST["txtRaceName"]);
    $txtRaceDistance = htmlspecialchars($_POST["txtRaceDistance"]);
    $dteRaceDate = htmlspecialchars($_POST["dteRaceDate"]);
    $tmeRaceTime = htmlspecialchars($_POST["tmeRaceTime"]);
    $txtRaceEntryFee = htmlspecialchars($_POST["txtRaceEntryFee"]);
    $intIsOpenChampionship = htmlspecialchars($_POST["intIsOpenChampionship"]);
    $txtOpenChampionshipCategory = htmlspecialchars($_POST["txtOpenChampionshipCategory"]);
    $intIsShortChampionship = htmlspecialchars($_POST["intIsShortChampionship"]);

    // if the date has '/' instead of '-', convert it
    $dteRaceDate = str_replace("/", "-", $dteRaceDate);
    // rearrange the race date so it is in the correct order for SQL
    $dteRaceDate = date("Y-m-d",strtotime($dteRaceDate));
    
    $sql = "INSERT INTO tblraces (raceName, raceDistance, raceDate, raceTime, raceEntryPrice, raceIsOpenChampionship, raceOpenChampionshipCategory, raceIsShortChampionship) " .
        "VALUES ('" . $txtRaceName . "', " .
        "'" . $txtRaceDistance . "', " .
        "'" . $dteRaceDate . "', " .
        "'" . $tmeRaceTime . "', " .
        "'" . $txtRaceEntryFee . "', " .
        "'" . $intIsOpenChampionship . "', " .
        "'" . $txtOpenChampionshipCategory . "', " .
        "'" . $intIsShortChampionship . "')";

    if (mysqli_query($conn,$sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error . "<br><br>" . $sql;
    } */
}
if($whatInfo == "addRaceTime")
{
    $runnersAndTimes = array();
    
    $i = 1;
    // how many rows of runner details to expect
    $fieldCount = htmlspecialchars($_POST['fieldCount']);
    
    $txtChamp = htmlspecialchars($_POST['champSelect']);
    
    if ($txtChamp == "open") {
        $txtRaceID = explode("_",htmlspecialchars($_POST['raceSelect2']));
    }
    else {
        $txtRaceID = explode("_",htmlspecialchars($_POST['raceSelect1']));
    }
        
    while($i <= $fieldCount) {
        //populate the array, whilst ignoring blank values
        if(!empty(htmlspecialchars($_POST["ddl1_runner_$i"]))) {
            $raceTimeFormat = sprintf('%02d:%02d:%02d', htmlspecialchars($_POST["race_time_hours_$i"]), htmlspecialchars($_POST["race_time_minutes_$i"]), htmlspecialchars($_POST["race_time_seconds_$i"]));
            //array: runner division, runner id and name, race time
            array_push($runnersAndTimes,htmlspecialchars($_POST["ddl1_runner_$i"]), htmlspecialchars($_POST["ddl2_runner_$i"]), $raceTimeFormat);
        }
    $i++;
    // print_r($runnersAndTimes);
    }

    // loop through the runners and times array and update the relevant race
    $j = 0;
    while($j < count($runnersAndTimes)) {
        
        $txtRunnerID = explode("_", $runnersAndTimes[($j+1)]);
        $raceTimeFormat = $runnersAndTimes[($j+2)];
        
                
        $sql4 = "SELECT * FROM tblRaceTimes WHERE RaceID='" . $txtRaceID[0] . "' AND RunnerID='" . $txtRunnerID[0] . "'";
                
        $result = mysqli_query($conn,$sql4);
   
        if(mysqli_num_rows($result) > 0)
        {
            //if there's already a time for this race and runner combo, update instead of insert
            $sql2 = "UPDATE tblRaceTimes SET RaceTime='" . $raceTimeFormat . "' WHERE RaceID='" . $txtRaceID[0] . "' AND RunnerID='" . $txtRunnerID[0] . "'";
        }           
        else
        {
            //insert if there isn't already a time for this race and runner combo
            $sql2 = "INSERT INTO tblRaceTimes (RaceID,RunnerID, RaceTime) " .
                "VALUES ('" . $txtRaceID[0] . "', " .
                "'" . $txtRunnerID[0] . "', " .
                "'" . $raceTimeFormat . "')";
        }
        
        if (mysqli_query($conn,$sql2) === TRUE)
        {
            echo "<br>$raceTimeFormat added for $txtRunnerID[1]!<br>";
        }
        else
        {
            echo "Error: " . $sql2 . "<br>" . $conn->error . "<br><br>" . $sql2;
        }


// NEW WMA ENTRY CODE - START
        
        
        // need to check the runner is 35 or over, if not, skip this section of code
        $sqlCheckRunnerAgeOver35 = "SELECT tblRunners.RunnerID FROM tblRunners WHERE tblRunners.RunnerID = $txtRunnerID[0] AND (YEAR(CURDATE()) - YEAR(tblRunners.runnerDOB) - 1) >= 35";
        
        $resultAgeCheck = mysqli_query($conn,$sqlCheckRunnerAgeOver35);
        
        // if no rows are returned with the above query, it means the runner isn't old enough to be WMA eligible
        if($resultAgeCheck->num_rows == 0)
        {
            goto runnerNotWMAEligible;
        }
        
        //check for WMA entry for this runner & race ID
        $sqlCheckForWMATimeEntry = "SELECT tblWMARaceTimes.RaceID, tblWMARaceTimes.RunnerID FROM tblWMARaceTimes WHERE tblWMARaceTimes.RaceID=$txtRaceID[0] AND tblWMARaceTimes.RunnerID = $txtRunnerID[0]";
        
        echo "<br>" . $sqlCheckForWMATimeEntry;
        
        
        $resultWMACheck = mysqli_query($conn,$sqlCheckForWMATimeEntry);
            
        // if a result is found, UPDATE instead of INSERT
        echo "<br>" . $resultWMACheck->num_rows;
        
        if($resultWMACheck->num_rows > 0)
        {
            echo "<br><br>result returned in WMA table. records to be UPDATED.<br><br>";

            // **** when you test this out in future, make sure the runner has a DoB set!!! ****
            
            while($row=mysqli_fetch_assoc($resultWMACheck)){
                $sqlWMA = "UPDATE tblWMARaceTimes SET WMARunnerLevel = (
            SELECT (SELECT tblWMA.WMAFactor FROM tblWMA WHERE tblWMA.WMADistance = (SELECT (tblRaces.RaceDist/1000) FROM tblRaces WHERE tblRaces.RaceID = tblRaceTimes.RaceID) AND tblWMA.WMASex = tblRunners.RunnerSex AND tblWMA.WMAAge = (YEAR(CURDATE()) - YEAR(tblRunners.runnerDOB) - 1) ) AS WMARunnerLevel FROM tblRunners JOIN tblRaceTimes ON tblRunners.RunnerID = tblRaceTimes.RunnerID WHERE tblRaceTimes.RaceID='" . $row['RaceID'] . "' AND tblRaceTimes.RunnerID='" . $row['RunnerID'] . "') WHERE tblWMARaceTimes.RaceID='" . $row['RaceID'] . "' AND tblWMARaceTimes.RunnerID='" . $row['RunnerID'] . "';

            UPDATE tblWMARaceTimes SET WMARaceTime = (
            SELECT TIME_FORMAT(SEC_TO_TIME(TIME_TO_SEC(tblRaceTimes.RaceTime) * (SELECT tblWMA.WMAFactor FROM tblWMA WHERE tblWMA.WMADistance = (SELECT (tblRaces.RaceDist/1000) FROM tblRaces WHERE tblRaces.RaceID = tblRaceTimes.RaceID) AND tblWMA.WMASex = tblRunners.RunnerSex AND tblWMA.WMAAge = (YEAR(CURDATE()) - YEAR(tblRunners.runnerDOB) - 1))),'%H:%i:%s') AS WMARaceTime FROM tblRunners JOIN tblRaceTimes ON tblRunners.RunnerID = tblRaceTimes.RunnerID WHERE tblRaceTimes.RaceID='" . $row['RaceID'] . "' AND tblRaceTimes.RunnerID='" . $row['RunnerID'] . "') WHERE tblWMARaceTimes.RaceID='" . $row['RaceID'] . "' AND tblWMARaceTimes.RunnerID='" . $row['RunnerID'] . "';
            
            UPDATE tblWMARaceTimes SET RaceTime = (
            SELECT tblRaceTimes.RaceTime FROM tblRunners JOIN tblRaceTimes ON tblRunners.RunnerID = tblRaceTimes.RunnerID WHERE tblRaceTimes.RaceID='" . $row['RaceID'] . "' AND tblRaceTimes.RunnerID='" . $row['RunnerID'] . "') WHERE tblWMARaceTimes.RaceID='" . $row['RaceID'] . "' AND tblWMARaceTimes.RunnerID='" . $row['RunnerID'] . "';
            
            ";
            }
        }
        else
        {
            echo "<br><br>result NOT returned in WMA table. records to be INSERTED.<br><br>";
            
            //creates the WMARaceTimes table entry for the WMA procedures to process
            $sqlWMA = "INSERT INTO tblWMARaceTimes (RaceID,RunnerID,RaceTime,WMARunnerLevel,WMARaceTime)
SELECT tblRaceTimes.RaceID, tblRaceTimes.RunnerID, tblRaceTimes.RaceTime, (SELECT tblWMA.WMAFactor FROM tblWMA WHERE tblWMA.WMADistance = (SELECT (tblRaces.RaceDist/1000) FROM tblRaces WHERE tblRaces.RaceID = tblRaceTimes.RaceID) AND tblWMA.WMASex = tblRunners.RunnerSex AND tblWMA.WMAAge = (YEAR(CURDATE()) - YEAR(tblRunners.runnerDOB) - 1) ) AS WMARunnerLevel, TIME_FORMAT(SEC_TO_TIME(TIME_TO_SEC(tblRaceTimes.RaceTime) * (SELECT tblWMA.WMAFactor FROM tblWMA WHERE tblWMA.WMADistance = (SELECT (tblRaces.RaceDist/1000) FROM tblRaces WHERE tblRaces.RaceID = tblRaceTimes.RaceID) AND tblWMA.WMASex = tblRunners.RunnerSex AND tblWMA.WMAAge = (YEAR(CURDATE()) - YEAR(tblRunners.runnerDOB) - 1))),'%H:%i:%s') AS WMARaceTime FROM tblRunners JOIN tblRaceTimes ON tblRunners.RunnerID = tblRaceTimes.RunnerID WHERE tblRaceTimes.RaceID='" . $txtRaceID[0] . "' AND tblRaceTimes.RunnerID='" . $txtRunnerID[0] . "'";
        }            
        
        // execute update or insert query for WMA tables
        
        $sqlMultiWMAUpdate = mysqli_multi_query($conn, $sqlWMA);
        
        if($sqlMultiWMAUpdate)
        {
            do{
                if($result=mysqli_store_result($conn)){
                    while($row=mysqli_fetch_assoc($result)){    
                        //do nothing as this is a multiple UPDATE query            
                        }
                    mysqli_free_result($result);
                    }
                if(mysqli_more_results($conn)) {
                    // do nothing
                    }
            } while(mysqli_more_results($conn) && mysqli_next_result($conn));
        }
        else {
            echo "Error: " . $sqlWMA . "<br>" . $conn->error . "<br><br>"; 
        }
        
runnerNotWMAEligible:

    $j+=3;        
// NEW WMA ENTRY CODE - END
    }
    

    // call the rankRaceTimes function
    /* rankRaceTimes($txtRaceID[0]); DON'T NEED THIS FUNCTION */
    
    // call the rankRaceTies function
    /* rankRaceTies($txtRaceID[0]); DON'T NEED THIS FUNCTION */
    
    // call the champRacePoints function
    /* champRacePoints($txtRaceID[0]); 'CHAMP RACE POINTS' TABLES NO LONGER USED - DON'T NEED THIS FUNCTION */
    
    //
    // OPEN CHAMP FUNCTION CALLS - START
    //
    // call the rankOpenChampDiv1M function
    rankOpenChampDiv1MRace($txtRaceID[0]);
    // call the rankOpenChampDiv1F function
    rankOpenChampDiv1FRace($txtRaceID[0]);
        // call the rankOpenChampDiv1Joint function
        // rankOpenChampDiv1JointRace($txtRaceID[0]);
    // call the rankOpenChampDiv2M function
    rankOpenChampDiv2MRace($txtRaceID[0]);
    // call the rankOpenChampDiv2F function
    rankOpenChampDiv2FRace($txtRaceID[0]);
        // call the rankOpenChampDiv2Joint function
        // rankOpenChampDiv2JointRace($txtRaceID[0]);
    // call the rankOpenChampDiv3M function
    rankOpenChampDiv3MRace($txtRaceID[0]);
    // call the rankOpenChampDiv3F function
    rankOpenChampDiv3FRace($txtRaceID[0]);
        // call the rankOpenChampDiv3Joint function
        // rankOpenChampDiv3JointRace($txtRaceID[0]);

        //
        // MASTERS FUNCTION CALLS - START
        //
        // call the rankOpenChampWMAM function
        rankOpenChampWMAMRace($txtRaceID[0]);
        // call the rankOpenChampWMAF function
        rankOpenChampWMAFRace($txtRaceID[0]);    
        // MASTERS FUNCTION CALLS - END
    //
    // LADIES CHAMP FUNCTION CALLS - START
    //
    // call the rankOpenChampLadies function
    rankOpenChampLadiesRace($txtRaceID[0]);
    // LADIES FUNCTION CALLS - END   
    //
    // OPEN CHAMP FUNCTION CALLS - END
    //
    
    //
    // MT CHALL FUNCTION CALLS - START
    //
    
    // call the rankMTChallMRace function
    rankMTChallMRace($txtRaceID[0]);
    // call the rankMTChallFRace function
    rankMTChallFRace($txtRaceID[0]);
    //
    // MT CHALL FUNCTION CALLS - END
    //

    //
    // SHORT CHAMP FUNCTION CALLS - START
    //
/*
    // call the rankShortChampDiv3Joint function
    rankShortChampDiv3JointRace($txtRaceID[0]);
    // call the rankShortChampDiv2Joint function
    rankShortChampDiv2JointRace($txtRaceID[0]);
    // call the rankShortChampDiv1Joint function
    rankShortChampDiv1JointRace($txtRaceID[0]);

    // call the rankShortChampFRace function
    rankShortChampFRace($txtRaceID[0]);
    // call the rankShortChampMRace function    
    rankShortChampMRace($txtRaceID[0]);
*/    
    // call the rankShortChampDiv3MRace function
    rankShortChampDiv3MRace($txtRaceID[0]);
    // call the rankShortChampDiv2MRace function
    rankShortChampDiv2MRace($txtRaceID[0]);
    // call the rankShortChampDiv1MRace function
    rankShortChampDiv1MRace($txtRaceID[0]);
    // call the rankShortChampDiv3FRace function
    rankShortChampDiv3FRace($txtRaceID[0]);
    // call the rankShortChampDiv2FRace function
    rankShortChampDiv2FRace($txtRaceID[0]);
    // call the rankShortChampDiv1FRace function
    rankShortChampDiv1FRace($txtRaceID[0]);
    
    //
    // SHORT CHAMP FUNCTION CALLS - END
    //

    
    // call the champTotalPoints function
    champTotalPoints($txtRaceID[0]);
    
}

//
// OPEN CHAMP - START
//
    
// Rank the Division 1 Mens Race
//
// START
function rankOpenChampDiv1MRace($RID) {
    require 'DBconn.php';
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankDiv1M = 'CALL proc_openChamp_Div1M_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankDiv1M))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){    
                    setOpenChampDiv1MRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank Div1M race";
    }

}
// Rank the Division 1 Mens Race
//
// END
    
// Set the Division 1 Mens Race Points
//
// START    
function setOpenChampDiv1MRacePoints($RaceID,$RunnerID,$Rank) {
    require 'DBconn.php';
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsDiv1M = sprintf('CALL proc_openChamp_Div1M_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsDiv1M) === TRUE)
    {
        //echo "<br>Race points added!<br>";
    }
    else
    {
        echo "Error: " . $sqlPointsDiv1M . "<br><br>" . mysqli_error() . "<br><br>";
    }

}
// Set the Division 1 Mens Race Points
//
// END     


// Rank the Division 1 Ladies Race
//
// START
function rankOpenChampDiv1FRace($RID) {
    require 'DBconn.php';
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankDiv1F = 'CALL proc_openChamp_Div1F_rank(' . $RID . '); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankDiv1F))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){    
                    setOpenChampDiv1FRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank Div1F race";
    }

}
// Rank the Division 1 Ladies Race
//
// END
    
// Set the Division 1 Ladies Race Points
//
// START    
function setOpenChampDiv1FRacePoints($RaceID,$RunnerID,$Rank) {
    require 'DBconn.php';
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsDiv1F = sprintf('CALL proc_openChamp_Div1F_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsDiv1F) === TRUE)
    {
        //echo "<br>Race points added!<br>";
    }
    else
    {
        echo "Error: " . $sqlPointsDiv1F . "<br><br>" . mysqli_error() . "<br><br>";
    }

}
// Set the Division 1 Ladies Race Points
//
// END 


/*
        // Rank the Division 1 Joint Race
        //
        // START
        function rankOpenChampDiv1JointRace($RID) {
            require 'DBconn.php';

            // the second SELECT statement is important as it returns the results of the stored procedure
            $sqlRankDiv1Joint = 'CALL proc_openChamp_Div1Joint_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';

            if(mysqli_multi_query($conn,$sqlRankDiv1Joint))
            {
                do{
                    if($result=mysqli_store_result($conn)){
                        while($row=mysqli_fetch_assoc($result)){    
                            setOpenChampDiv1JointRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                        }
                        mysqli_free_result($result);
                    }
                    if(mysqli_more_results($conn)) {
                        // do nothing
                    }
                } while(mysqli_more_results($conn) && mysqli_next_result($conn));
            }
            else {
                echo "Couldn't rank Div1Joint race";
            }

        }
        // Rank the Division 1 Joint Race
        //
        // END

        // Set the Division 1 Joint Race Points
        //
        // START    
        function setOpenChampDiv1JointRacePoints($RaceID,$RunnerID,$Rank) {
            require 'DBconn.php';

            // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record

            // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
            $sqlPointsDiv1Joint = sprintf('CALL proc_openChamp_Div1Joint_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

            if (mysqli_multi_query($conn,$sqlPointsDiv1Joint) === TRUE)
            {
                //echo "<br>Race points added!<br>";
            }
            else
            {
                echo "Error: " . $sqlPointsDiv1Joint . "<br><br>" . mysqli_error() . "<br><br>";
            }

        }
        // Set the Division 1 Joint Race Points
        //
        // END   */

    
// Rank the Division 2 Mens Race
//
// START
function rankOpenChampDiv2MRace($RID) {
    require 'DBconn.php';
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankDiv2M = 'CALL proc_openChamp_Div2M_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankDiv2M))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){    
                    setOpenChampDiv2MRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank Div2M race";
    }

}
// Rank the Division 2 Mens Race
//
// END
    
// Set the Division 2 Mens Race Points
//
// START    
function setOpenChampDiv2MRacePoints($RaceID,$RunnerID,$Rank) {
    require 'DBconn.php';
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsDiv2M = sprintf('CALL proc_openChamp_Div2M_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsDiv2M) === TRUE)
    {
        //echo "<br>Race points added!<br>";
    }
    else
    {
        echo "Error: " . $sqlPointsDiv2M . "<br><br>" . mysqli_error() . "<br><br>";
    }

}
// Set the Division 2 Mens Race Points
//
// END       
    
    
// Rank the Division 2 Ladies Race
//
// START
function rankOpenChampDiv2FRace($RID) {
    require 'DBconn.php';
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankDiv2F = 'CALL proc_openChamp_Div2F_rank(' . $RID . '); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankDiv2F))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){    
                    setOpenChampDiv2FRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank Div2F race";
    }

}
// Rank the Division 2 Ladies Race
//
// END
    
// Set the Division 2 Ladies Race Points
//
// START    
function setOpenChampDiv2FRacePoints($RaceID,$RunnerID,$Rank) {
    require 'DBconn.php';
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsDiv2F = sprintf('CALL proc_openChamp_Div2F_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsDiv2F) === TRUE)
    {
        //echo "<br>Race points added!<br>";
    }
    else
    {
        echo "Error: " . $sqlPointsDiv2F . "<br><br>" . mysqli_error() . "<br><br>";
    }

}
// Set the Division 2 Ladies Race Points
//
// END     


/*
        // Rank the Division 2 Joint Race
        //
        // START
        function rankOpenChampDiv2JointRace($RID) {
            require 'DBconn.php';

            // the second SELECT statement is important as it returns the results of the stored procedure
            $sqlRankDiv2Joint = 'CALL proc_openChamp_Div2Joint_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';

            if(mysqli_multi_query($conn,$sqlRankDiv2Joint))
            {
                do{
                    if($result=mysqli_store_result($conn)){
                        while($row=mysqli_fetch_assoc($result)){    
                            setOpenChampDiv2JointRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                        }
                        mysqli_free_result($result);
                    }
                    if(mysqli_more_results($conn)) {
                        // do nothing
                    }
                } while(mysqli_more_results($conn) && mysqli_next_result($conn));
            }
            else {
                echo "Couldn't rank Div2Joint race";
            }

        }
        // Rank the Division 2 Joint Race
        //
        // END

        // Set the Division 2 Joint Race Points
        //
        // START    
        function setOpenChampDiv2JointRacePoints($RaceID,$RunnerID,$Rank) {
            require 'DBconn.php';

            // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record

            // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
            $sqlPointsDiv2Joint = sprintf('CALL proc_openChamp_Div2Joint_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

            if (mysqli_multi_query($conn,$sqlPointsDiv2Joint) === TRUE)
            {
                //echo "<br>Race points added!<br>";
            }
            else
            {
                echo "Error: " . $sqlPointsDiv2Joint . "<br><br>" . mysqli_error() . "<br><br>";
            }

        }
        // Set the Division 2 Joint Race Points
        //
        // END */
    
    
// Rank the Division 3 Mens Race
//
// START
function rankOpenChampDiv3MRace($RID) {
    require 'DBconn.php';
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankDiv3M = 'CALL proc_openChamp_Div3M_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankDiv3M))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){    
                    setOpenChampDiv3MRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank Div3M race";
    }

}
// Rank the Division 3 Mens Race
//
// END
    
// Set the Division 3 Mens Race Points
//
// START    
function setOpenChampDiv3MRacePoints($RaceID,$RunnerID,$Rank) {
    require 'DBconn.php';
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsDiv3M = sprintf('CALL proc_openChamp_Div3M_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsDiv3M) === TRUE)
    {
        //echo "<br>Race points added!<br>";
    }
    else
    {
        echo "Error: " . $sqlPointsDiv3M . "<br><br>" . mysqli_error() . "<br><br>";
    }

}
// Set the Division 3 Mens Race Points
//
// END        
    
    
// Rank the Division 3 Ladies Race
//
// START
function rankOpenChampDiv3FRace($RID) {
    require 'DBconn.php';
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankDiv3F = 'CALL proc_openChamp_Div3F_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankDiv3F))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){    
                    setOpenChampDiv3FRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank Div3M race";
    }

}
// Rank the Division 3 Ladies Race
//
// END
    
// Set the Division 3 Ladies Race Points
//
// START    
function setOpenChampDiv3FRacePoints($RaceID,$RunnerID,$Rank) {
    require 'DBconn.php';
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsDiv3F = sprintf('CALL proc_openChamp_Div3F_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsDiv3F) === TRUE)
    {
        //echo "<br>Race points added!<br>";
    }
    else
    {
        echo "Error: " . $sqlPointsDiv3F . "<br><br>" . mysqli_error() . "<br><br>";
    }

}
// Set the Division 3 Ladies Race Points
//
// END    


/*
        // Rank the Division 3 Joint Race
        //
        // START
        function rankOpenChampDiv3JointRace($RID) {
            require 'DBconn.php';

            // the second SELECT statement is important as it returns the results of the stored procedure
            $sqlRankDiv3Joint = 'CALL proc_openChamp_Div3Joint_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';

            if(mysqli_multi_query($conn,$sqlRankDiv3Joint))
            {
                do{
                    if($result=mysqli_store_result($conn)){
                        while($row=mysqli_fetch_assoc($result)){
                            setOpenChampDiv3JointRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                        }
                        mysqli_free_result($result);
                    }
                    if(mysqli_more_results($conn)) {
                        // do nothing
                    }
                } while(mysqli_more_results($conn) && mysqli_next_result($conn));
            }
            else {
                echo "Couldn't rank Div3Joint race";
            }
        }
        // Rank the Division 3 Joint Race
        //
        // END

        // Set the Division 3 Joint Race Points
        //
        // START    
        function setOpenChampDiv3JointRacePoints($RaceID,$RunnerID,$Rank) {
            require 'DBconn.php';

            // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record

            // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
            $sqlPointsDiv3Joint = sprintf('CALL proc_openChamp_Div3Joint_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

            if (mysqli_multi_query($conn,$sqlPointsDiv3Joint) === TRUE)
            {
                //echo "<br>Race points added!<br>";
            }
            else
            {
                echo "Error: " . $sqlPointsDiv3Joint . "<br><br>" . mysqli_error() . "<br><br>";
            }
        }
        // Set the Division 3 Joint Race Points
        //
        // END */

// Rank the Male MASTERS - START (NEW CODE)
//
// START
function rankOpenChampWMAMRace($RID) {    //
    require 'DBconn.php';   //
    
    // the subsequent SELECT statement returns the results of the stored procedure //
    $sqlRankWMAM = 'CALL proc_openChamp_WMA_M_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;'; //
    
    if(mysqli_multi_query($conn,$sqlRankWMAM))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    setOpenChampWMAMRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);   //               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // comment out when this code works
                // echo "<br>Open Championship (Ladies Championship) race times ranked!<br>";
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank Open Championship (Men's MASTERS) race";
    }
}
// Rank the Male MASTERS - END (NEW CODE)
//
// END
    
// Set the Male MASTERS Race Points - START (NEW CODE)
//
// START    
function setOpenChampWMAMRacePoints($RaceID,$RunnerID,$Rank) {    //
    require 'DBconn.php';   //
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsWMAM = sprintf('CALL proc_openChamp_WMA_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);  //

    if (mysqli_multi_query($conn,$sqlPointsWMAM) === TRUE)    //
    {
        // comment out when it's working properly
        echo "<br>Open Championship (Men's MASTERS) race points added!<br>$sqlPointsWMAM";
    }
    else
    {
        echo "Error: " . $sqlPointsWMAM . "<br><br>" . mysqli_error() . "<br><br>";
    }
}
// Set the Male Masters Race Points - END (NEW CODE)
//
// END   
    
// Rank the Ladies MASTERS - START (NEW CODE)
//
// START
function rankOpenChampWMAFRace($RID) {    //
    require 'DBconn.php';   //
    
    // the second SELECT statement is important as it returns the results of the stored procedure //
    $sqlRankWMAF = 'CALL proc_openChamp_WMA_F_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;'; //
    
    if(mysqli_multi_query($conn,$sqlRankWMAF))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    setOpenChampWMAFRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);   //               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // comment out when this code works
                // echo "<br>Open Championship (Ladies Championship) race times ranked!<br>";
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank Open Championship (Ladies MASTERS) race";
    }
}
// Rank the Ladies MASTERS - END (NEW CODE)
//
// END
    
// Set the Ladies MASTERS Race Points - START (NEW CODE)
//
// START    
function setOpenChampWMAFRacePoints($RaceID,$RunnerID,$Rank) {    //
    require 'DBconn.php';   //
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsWMAF = sprintf('CALL proc_openChamp_WMA_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);  //

    if (mysqli_multi_query($conn,$sqlPointsWMAF) === TRUE)    //
    {
        // comment out when it's working properly
        echo "<br>Open Championship (Ladies MASTERS) race points added!<br>$sqlPointsWMAF";
    }
    else
    {
        echo "Error: " . $sqlPointsWMAF . "<br><br>" . mysqli_error() . "<br><br>";
    }
}
// Set the Ladies Masters Race Points - END (NEW CODE)
//
// END   
    
    
    
// Rank the LADIES Race - START (NEW CODE)
//
// START
function rankOpenChampLadiesRace($RID) {    //
    require 'DBconn.php';   //
    
    // the second SELECT statement is important as it returns the results of the stored procedure //
    $sqlRankLadies = 'CALL proc_openChamp_ladies_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;'; //
    
    if(mysqli_multi_query($conn,$sqlRankLadies))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    setOpenChampLadiesRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);   //               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank Open Championship (Ladies Championship) race";
    }
}
// Rank the LADIES Race - END (NEW CODE)
//
// END
    
// Set the lADIES Race Points - START (NEW CODE)
//
// START    
function setOpenChampLadiesRacePoints($RaceID,$RunnerID,$Rank) {    //
    require 'DBconn.php';   //
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsLadies = sprintf('CALL proc_openChamp_ladies_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);  //

    if (mysqli_multi_query($conn,$sqlPointsLadies) === TRUE)    //
    {
        // comment out when it's working properly
        // echo "<br>Open Championship (Ladies Championship) race points added!<br>$sqlPointsLadies";
    }
    else
    {
        echo "Error: " . $sqlPointsLadies . "<br><br>" . mysqli_error() . "<br><br>";
    }
}
// Set the LADIES Race Points - END (NEW CODE)
//
// END    



//
// function to rank all times for the raceID passed to it.
//
function rankRaceTimes($RID) {
    // open and close a separate DB connection within each function.   
    require 'DBconn.php';
    
    // This will allocate all runners of a race the correct points, but will not account for ties
    $sqlRankRaceTimes = "SET @r=101; UPDATE tblRaceTimes SET RacePoints= @r:= (@r-1) WHERE RaceID = $RID ORDER BY RaceTime ASC;";  
    
        if (mysqli_multi_query($conn,$sqlRankRaceTimes) === TRUE)
        {
            echo "<br>Race times ranked!<br>";
        }
        else
        {
            echo "Error: " . $sqlRankRaceTimes . "<br><br>" . mysqli_error() . "<br><br>";
        }
    mysqli_close($conn);
}
/////////////////////  

//
// function to rank all ties (note TIES not TIMES) for the raceID passed to it.
//    
function rankRaceTies($RID) {    
    // open and close a separate DB connection within each function.
    require 'DBconn.php';
    
    // This will select the Max race points for each tied time in this race (if there are any!)
    //   It selects the max points because, in a tie situation, the maximum points are given to all runners with that time
    $sqlFindTies = "SELECT a.RaceID, a.RaceTime, Max(a.RacePoints) FROM tblRaceTimes a INNER JOIN ( SELECT RaceTime FROM tblRaceTimes GROUP BY RaceTime HAVING COUNT(RaceID) > 1 ) temp ON a.RaceTime = temp.RaceTime WHERE RaceID = $RID GROUP BY a.RaceTime";

    $result = mysqli_query($conn,$sqlFindTies);
    
    // update points in the OPEN CHAMPIONSHIP RACES
    if(mysqli_num_rows($result) > 0)
    {
        // output data of each row
        while($row = $result->fetch_assoc())
        {   
            $sqlRankTies = "UPDATE tblRaceTimes SET RacePoints = " . $row["Max(a.RacePoints)"] . " WHERE RaceID = $RID AND RaceTime = '" . $row["RaceTime"] . "'";
            
            if (mysqli_query($conn,$sqlRankTies) === TRUE)
            {
                echo "<br>Ties for " . $row["RaceTime"] . " ranked!<br>";
            }
            else
            {
                echo "Error: " . $sqlRankTies . "<br><br>";
            }                
        }
    }           
    else
    {
        // There were no ties in this race, wahoo!
        echo "Wahoo! There were no ties in this race! ";
    }
    mysqli_close($conn);
}      
///////////////////// 
//
// function to update all championship points entries for the raceID passed to it
//
function champRacePoints($RID)
{
    // open and close a separate DB connection within each function.
    require 'DBconn.php';

    $sqlFindChamp = "SELECT RaceCode FROM tblRaces WHERE RaceID=$RID";

    $result = mysqli_query($conn,$sqlFindChamp);
    
    if(mysqli_num_rows($result) > 0)
    {
        // output data of each row
        while($row = $result->fetch_assoc())
        {   
            $RaceCode = $row["RaceCode"];
        }
    }           
    else
    {
        // There were no codes for this race!
        echo "There were no codes for this race! : " . $sqlFindChamp . " or there was an ERROR: " . mysqli_error($result);
    }

    switch ($RaceCode) {
            // Note 1: Use single quotes in format string otherwise you will get PHP Notice: Undefined variable: s... error
            //
            // Note 2: %2$s is a placeholder for the RunnerID
            //         %1$s is a placeholder for the RacePoints
            //         $RID is a placeholder for the RaceID
        case 1:
        case 2:
        case 4:
            // Race codes 1, 2, and 4 are for Open Champ races only. So procedure is identical.
            //
            // re-use the procedure by assigning a number to each type of open championship:
            //     1: General open championship
            //     2: Open Championship, Division 1 Men
            //     3: Open Championship, Division 1 Ladies
            //     4: Open Championship, Division 2 Men
            //     5: Open Championship, Division 2 Ladies
            //     6: Open Championship, Division 3 Men
            //     7: Open Championship, Division 3 Ladies
            
            $sqlUpdateChampPoints = 'CALL proc_openChamp_add_points(%2$s,' . $RID . ',%1$s, 1)';
        break;
        case 8:
            // Race code 8 is for Short Champ races only.
            /*$sqlUpdateChampPoints = 'CALL proc_shortChamp_add_points(%2$s,' . $RID . ',%1$s)'; FUNCTION NOT USED */
        break;
        case 9:
            // Race code 9 is for Open Champ races and Short Champ: Sprint races. Join both procedures.
            $sqlUpdateChampPoints = 'CALL proc_openChamp_add_points(%2$s,' . $RID . ',%1$s, 1);' . 
                                    'CALL proc_shortChamp_add_points(%2$s,' . $RID . ',%1$s);';
        break;        
        case 16:
            // Race code 16 is for MT Chall races only.
            $sqlUpdateChampPoints = 'CALL proc_MTChall_add_points(%2$s,' . $RID . ',%1$s)';
        break;
    }
    
    $sqlSelectRunnersPoints = "SELECT RunnerID, RacePoints FROM tblRaceTimes WHERE RaceID=$RID";
    
    $result = mysqli_query($conn,$sqlSelectRunnersPoints);
    
    if(mysqli_num_rows($result) > 0)
    {
        // output data of each row
        while($row = $result->fetch_assoc())
        {   
            $RunnerID = $row["RunnerID"];
            $RacePoints = $row["RacePoints"];

            $sqlUpdatePoints = sprintf($sqlUpdateChampPoints,$RacePoints,$RunnerID);
            
            if (mysqli_multi_query($conn,$sqlUpdatePoints) === TRUE)
            {
                echo "<br>$RacePoints points added for runner $RunnerID!<br>";
            }
            else
            {
                echo "Error: " . $sqlUpdatePoints . "<br><br>" . mysqli_error(mysqli_multi_query($conn,$sqlUpdatePoints)) . "<br>";
            }            
        }
    }           
    else
    {
        // Couldn't find any runners or times for this race!
        echo "Couldn't find any runners or times for this race! : " . $sqlSelectRunnersPoints . " or there was an ERROR: " . $mysqli->errno;
    }
    
    
    mysqli_close($conn);
}
/////////////////////

//
// function to update all championship points entries for the raceID passed to it - START
//
function champTotalPoints($RID)
{
    // open and close a separate DB connection within each function.
    require 'DBconn.php';
    
    // in this function, the RaceID is used only to determine which championship(s) and which open championship category to update - only change the affected data!
    
    // select the RunnerIDs and RaceIDs from tblRaceTimes for that specific championship and the current championship year
    
    // for each RunnerID SUM the top X racepoints (depending on the championship type)
    
    // write the total points to the overall points table against the championshipID and runnerID
    
    $sqlFindChamp = "SELECT RaceCode FROM tblRaces WHERE RaceID=$RID";

    $result = mysqli_query($conn,$sqlFindChamp);
    
    if(mysqli_num_rows($result) > 0)
    {
        // output data of each row
        while($row = $result->fetch_assoc())
        {   
            $RaceCode = $row["RaceCode"];
        }
    }           
    else
    {
        // There were no codes for this race!
        echo "There were no codes for this race! : " . $sqlFindChamp . " or there was an ERROR: " . mysqli_error($result);
    }

    
/* OpenChamp Sprint distance */
    if($RaceCode == "1" || $RaceCode == "9")
    {
        //
        // select all runners who have ran a sprint distance race (1, or 9) for the current year
        // START
        $sqlSelectRunners = 'SELECT DISTINCT RunnerID FROM tblOpenChampDivGenRacePoints WHERE RaceID IN (Select RaceID FROM tblRaces WHERE RaceCode IN (1,9) AND ChampYear=' . date("Y") . ')';
    
        $result = mysqli_query($conn,$sqlSelectRunners);
    
        if(mysqli_num_rows($result) > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                //$RunnerID = $row["RunnerID"];

                //$sqlUpdatePoints = sprintf('CALL proc_openChamp_sprint_points(%1$s,%2$s); proc_openChamp_sprint_Div1_top2(%1$s,%2$s);',$RunnerID, $RID);
                
                $RunnerID = $row["RunnerID"];

                $sqlUpdatePoints = sprintf('CALL proc_openChamp_sprint_points(%1$s,%2$s);',$RunnerID, $RID);

                $result2 = mysqli_query($conn,$sqlUpdatePoints);
                
                $sqlUpdatePoints2 = sprintf('CALL proc_openChamp_sprint_Divs_top2(%1$s,%2$s);',$RunnerID, $RID);
                
                $result3 = mysqli_query($conn,$sqlUpdatePoints2);

                $sqlUpdatePoints3 = sprintf('CALL proc_openChamp_WMA_sprint_top2(%1$s,%2$s);',$RunnerID, $RID);
                
                $result4 = mysqli_query($conn,$sqlUpdatePoints3);

                $sqlUpdatePoints4 = sprintf('CALL proc_openChamp_ladies_sprint_top2(%1$s,%2$s);',$RunnerID, $RID);
                
                $result5 = mysqli_query($conn,$sqlUpdatePoints4);
            }
        }           
        else
        {
            // Couldn't find any runners or times for this race!
            echo "Couldn't find any runners or times for this Open Championship Sprint distance race! : " . $sqlSelectRunnersPoints . " or there was an ERROR: " . $mysqli->errno;
        }        
        // END
        // select all runners who have ran a sprint distance race (1, or 9) for the current year
        //
    }
/* OpenChamp Sprint distance */


/* OpenChamp Middle distance */
    if($RaceCode == "2")
    {
        $sqlSelectRunners = 'SELECT DISTINCT RunnerID FROM tblOpenChampDivGenRacePoints WHERE RaceID IN (Select RaceID FROM tblRaces WHERE RaceCode = 2 AND ChampYear=' . date("Y") . ')';
    
        $result = mysqli_query($conn,$sqlSelectRunners);
    
        if(mysqli_num_rows($result) > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $RunnerID = $row["RunnerID"];

                $sqlUpdatePoints = sprintf('CALL proc_openChamp_mid_points(%1$s,%2$s);',$RunnerID, $RID);

                $result2 = mysqli_query($conn,$sqlUpdatePoints);        

                $sqlUpdatePoints2 = sprintf('CALL proc_openChamp_mid_Divs_top2(%1$s,%2$s);',$RunnerID, $RID);
                
                $result3 = mysqli_query($conn,$sqlUpdatePoints2);

                $sqlUpdatePoints3 = sprintf('CALL proc_openChamp_WMA_mid_top2(%1$s,%2$s);',$RunnerID, $RID);
                
                $result4 = mysqli_query($conn,$sqlUpdatePoints3);           

                $sqlUpdatePoints4 = sprintf('CALL proc_openChamp_ladies_mid_top2(%1$s,%2$s);',$RunnerID, $RID);
                
                $result5 = mysqli_query($conn,$sqlUpdatePoints4); 
            }
        }           
        else
        {
            // Couldn't find any runners or times for this race!
            echo "Couldn't find any runners or times for this Open Championship Middle distance race! : " . $sqlSelectRunnersPoints . " or there was an ERROR: " . $mysqli->errno;
        }        
    }
/* OpenChamp Middle distance */    

    
/* OpenChamp Long distance */
    if($RaceCode == "4")
    {
        $sqlSelectRunners = 'SELECT DISTINCT RunnerID FROM tblOpenChampDivGenRacePoints WHERE RaceID IN (Select RaceID FROM tblRaces WHERE RaceCode = 4 AND ChampYear=' . date("Y") . ')';
    
        $result = mysqli_query($conn,$sqlSelectRunners);
    
        if(mysqli_num_rows($result) > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $RunnerID = $row["RunnerID"];

                $sqlUpdatePoints = sprintf('CALL proc_openChamp_long_points(%1$s,%2$s);',$RunnerID, $RID);

                $result2 = mysqli_query($conn,$sqlUpdatePoints);
                
                $sqlUpdatePoints2 = sprintf('CALL proc_openChamp_long_Divs_top2(%1$s,%2$s);',$RunnerID, $RID);
                
                $result3 = mysqli_query($conn,$sqlUpdatePoints2);

                $sqlUpdatePoints3 = sprintf('CALL proc_openChamp_WMA_long_top2(%1$s,%2$s);',$RunnerID, $RID);
                
                $result4 = mysqli_query($conn,$sqlUpdatePoints3);

                $sqlUpdatePoints4 = sprintf('CALL proc_openChamp_ladies_long_top2(%1$s,%2$s);',$RunnerID, $RID);
                
                $result5 = mysqli_query($conn,$sqlUpdatePoints4);
            }
        }           
        else
        {
            // Couldn't find any runners or times for this race!
            echo "Couldn't find any runners or times for this Open Championship Long distance race! : " . $sqlSelectRunnersPoints . " or there was an ERROR: " . $mysqli->errno;
        }        
    }
/* OpenChamp Long distance */   


    
    
/*

THE PROCEDURE FOR OVERALL POINTS ISN'T USED

*/

    /* OpenChamp Overall points */
    if($RaceCode == "1" || $RaceCode == "2" || $RaceCode == "4" || $RaceCode == "9")
    {     
        $sqlSelectRunners = 'SELECT DISTINCT RunnerID FROM tblOpenChampDivGenRacePoints WHERE RaceID IN (Select RaceID FROM tblRaces WHERE RaceCode IN (1,2,4,9) AND ChampYear=' . date("Y") . ')';
    
        $result = mysqli_query($conn,$sqlSelectRunners);
    
        if(mysqli_num_rows($result) > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $RunnerID = $row["RunnerID"];
                
                $sqlUpdatePoints = sprintf('CALL proc_openChamp_overall_points(%1$s,%2$s);',$RunnerID, $RID);
                
                $result2 = mysqli_query($conn,$sqlUpdatePoints);

                $sqlUpdatePoints2 = sprintf('CALL proc_openChamp_Divs_totalPoints(%1$s,%2$s);',$RunnerID, $RID);
                
                $result3 = mysqli_query($conn,$sqlUpdatePoints2);
                
                $sqlUpdatePoints3 = sprintf('CALL proc_openChamp_WMA_totalPoints(%1$s,%2$s);',$RunnerID, $RID);
                
                $result4 = mysqli_query($conn,$sqlUpdatePoints3);

                $sqlUpdatePoints4 = sprintf('CALL proc_openChamp_ladies_totalPoints(%1$s,%2$s);',$RunnerID, $RID);
                
                $result5 = mysqli_query($conn,$sqlUpdatePoints4);
            }
        }           
        else
        {
            // Couldn't find any runners or times for this race!
            echo "Couldn't find any runners or times for this Open Championship Long distance race! : " . $sqlSelectRunnersPoints . " or there was an ERROR: " . $mysqli->errno;
        }        
    }
/* OpenChamp Overall points */
    

/* ShortChamp races */
    if($RaceCode == "8" || $RaceCode == "9")
    {
        $sqlSelectRunners = 'SELECT DISTINCT RunnerID FROM tblShortChampDivGenRacePoints WHERE RaceID IN (Select RaceID FROM tblRaces WHERE RaceCode IN (8,9) AND ChampYear=' . date("Y") . ')';
    
        $result = mysqli_query($conn,$sqlSelectRunners);
    
        if(mysqli_num_rows($result) > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $RunnerID = $row["RunnerID"];

                $sqlUpdatePoints = sprintf('CALL proc_shortChamp_overall_points(%1$s,%2$s);',$RunnerID, $RID);

                $result2 = mysqli_query($conn,$sqlUpdatePoints);                          

                $sqlUpdatePoints2 = sprintf('CALL proc_shortChamp_Divs_top6(%1$s,%2$s);',$RunnerID, $RID);
                
                $result3 = mysqli_query($conn,$sqlUpdatePoints2);                
            }
        }           
        else
        {
            // Couldn't find any runners or times for this race!
            echo "Couldn't find any runners or times for this race! : " . $sqlSelectRunnersPoints . " or there was an ERROR: " . $mysqli->errno;
        }       
    }    
/* ShortChamp races */
    
/* Multi-Terrain Challenge races */
    if($RaceCode == "16")
    {
        $sqlSelectRunners = 'SELECT DISTINCT RunnerID FROM tblMTChallDivGenRacePoints WHERE RaceID IN (Select RaceID FROM tblRaces WHERE RaceCode IN (16) AND ChampYear=' . date("Y") . ')';
    
        $result = mysqli_query($conn,$sqlSelectRunners);
    
        if(mysqli_num_rows($result) > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $RunnerID = $row["RunnerID"];

                $sqlUpdatePoints = sprintf('CALL proc_MTChall_overall_points(%1$s,%2$s);',$RunnerID, $RID);

                
                $result2 = mysqli_query($conn,$sqlUpdatePoints);
                
                //$sqlUpdatePoints2 = sprintf('CALL proc_MTChall_MF_top5(%1$s,%2$s);',$RunnerID, $RID);
                $sqlUpdatePoints2 = sprintf('CALL proc_MTChall_MF_top_results(%1$s,%2$s);',$RunnerID, $RID);
                
                $result3 = mysqli_query($conn,$sqlUpdatePoints2);   
                                
                // because no results are returned from the CALL type query, there is no way of checking for errors!
            }
        }           
        else
        {
            // Couldn't find any runners or times for this race!
            echo "Couldn't find any runners or times for this race! : " . $sqlSelectRunnersPoints . " or there was an ERROR: " . $mysqli->errno;
        }       
    }  
/* Multi-Terrain Challenge races */
    
    // close connections to the database
    mysqli_close($conn);
}

//
// OPEN CHAMP - END
//

    
//
// SHORT CHAMP - START
//

/*
// Rank the Division 1 Joint Race
        //
        // START
        function rankShortChampDiv1JointRace($RID) {
            require 'DBconn.php';

            // the second SELECT statement is important as it returns the results of the stored procedure
            $sqlRankDiv1Joint = 'CALL proc_shortChamp_Div1Joint_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';

            if(mysqli_multi_query($conn,$sqlRankDiv1Joint))
            {
                do{
                    if($result=mysqli_store_result($conn)){
                        while($row=mysqli_fetch_assoc($result)){
                            setShortChampDiv1JointRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                        }
                        mysqli_free_result($result);
                    }
                    if(mysqli_more_results($conn)) {
                        // do nothing
                    }
                } while(mysqli_more_results($conn) && mysqli_next_result($conn));
            }
            else {
                echo "Couldn't rank Div1Joint race";
            }
        }
        // Rank the Division 1 Joint Race
        //
        // END

        // Set the Division 1 Joint Race Points
        //
        // START    
        function setShortChampDiv1JointRacePoints($RaceID,$RunnerID,$Rank) {
            require 'DBconn.php';

            // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record

            // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
            $sqlPointsDiv1Joint = sprintf('CALL proc_shortChamp_Div1Joint_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

            if (mysqli_multi_query($conn,$sqlPointsDiv1Joint) === TRUE)
            {
                //echo "<br>Race points added!<br>";
            }
            else
            {
                echo "Error: " . $sqlPointsDiv1Joint . "<br><br>" . mysqli_error() . "<br><br>";
            }
        }
        // Set the Division 1 Joint Race Points
        //
        // END

        // Rank the Division 2 Joint Race
        //
        // START
        function rankShortChampDiv2JointRace($RID) {
            require 'DBconn.php';

            // the second SELECT statement is important as it returns the results of the stored procedure
            $sqlRankDiv2Joint = 'CALL proc_shortChamp_Div2Joint_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';

            if(mysqli_multi_query($conn,$sqlRankDiv2Joint))
            {
                do{
                    if($result=mysqli_store_result($conn)){
                        while($row=mysqli_fetch_assoc($result)){
                            setShortChampDiv2JointRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                        }
                        mysqli_free_result($result);
                    }
                    if(mysqli_more_results($conn)) {
                        // do nothing
                    }
                } while(mysqli_more_results($conn) && mysqli_next_result($conn));
            }
            else {
                echo "Couldn't rank Div2Joint race";
            }
        }
        // Rank the Division 2 Joint Race
        //
        // END

        // Set the Division 2 Joint Race Points
        //
        // START    
        function setShortChampDiv2JointRacePoints($RaceID,$RunnerID,$Rank) {
            require 'DBconn.php';

            // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record

            // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
            $sqlPointsDiv2Joint = sprintf('CALL proc_shortChamp_Div2Joint_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

            if (mysqli_multi_query($conn,$sqlPointsDiv2Joint) === TRUE)
            {
                //echo "<br>Race points added!<br>";
            }
            else
            {
                echo "Error: " . $sqlPointsDiv2Joint . "<br><br>" . mysqli_error() . "<br><br>";
            }
        }
        // Set the Division 2 Joint Race Points
        //
        // END

        // Rank the Division 3 Joint Race
        //
        // START
        function rankShortChampDiv3JointRace($RID) {
            require 'DBconn.php';

            // the second SELECT statement is important as it returns the results of the stored procedure
            $sqlRankDiv3Joint = 'CALL proc_shortChamp_Div3Joint_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';

            if(mysqli_multi_query($conn,$sqlRankDiv3Joint))
            {
                do{
                    if($result=mysqli_store_result($conn)){
                        while($row=mysqli_fetch_assoc($result)){
                            setShortChampDiv3JointRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                        }
                        mysqli_free_result($result);
                    }
                    if(mysqli_more_results($conn)) {
                        // do nothing
                    }
                } while(mysqli_more_results($conn) && mysqli_next_result($conn));
            }
            else {
                echo "Couldn't rank Div3Joint race";
            }
        }
        // Rank the Division 3 Joint Race
        //
        // END

        // Set the Division 3 Joint Race Points
        //
        // START    
        function setShortChampDiv3JointRacePoints($RaceID,$RunnerID,$Rank) {
            require 'DBconn.php';

            // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record

            // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
            $sqlPointsDiv3Joint = sprintf('CALL proc_shortChamp_Div3Joint_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

            if (mysqli_multi_query($conn,$sqlPointsDiv3Joint) === TRUE)
            {
                //echo "<br>Race points added!<br>";
            }
            else
            {
                echo "Error: " . $sqlPointsDiv3Joint . "<br><br>" . mysqli_error() . "<br><br>";
            }
        }
        // Set the Division 3 Joint Race Points
        //
        // END*/

// Rank the Ladies Race
//
// START
function rankShortChampFRace($RID) {
    require 'DBconn.php';
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankF = 'CALL proc_shortChamp_F_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankF))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    setShortChampFRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank F race";
    }
}
// Rank the Ladies Race
//
// END
    
// Set the Ladies Race Points
//
// START    
function setShortChampFRacePoints($RaceID,$RunnerID,$Rank) {
    require 'DBconn.php';
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsF = sprintf('CALL proc_shortChamp_F_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsF) === TRUE)
    {
        //echo "<br>Race points added!<br>";
    }
    else
    {
        echo "Error: " . $sqlPointsF . "<br><br>" . mysqli_error() . "<br><br>";
    }
}
// Set the Ladies Race Points
//
// END

// Rank the Men's Race
//
// START
function rankShortChampMRace($RID) {
    require 'DBconn.php';
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankM = 'CALL proc_shortChamp_M_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankM))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    setShortChampMRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank M race";
    }
}
// Rank the Men's Race
//
// END
    
// Set the Men's Race Points
//
// START    
function setShortChampMRacePoints($RaceID,$RunnerID,$Rank) {
    require 'DBconn.php';
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsM = sprintf('CALL proc_shortChamp_M_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsM) === TRUE)
    {
        //echo "<br>Race points added!<br>";
    }
    else
    {
        echo "Error: " . $sqlPointsM . "<br><br>" . mysqli_error() . "<br><br>";
    }
}
// Set the Men's Race Points
//
// END    


// Rank the Men's Div 3 Race
//
// START
function rankShortChampDiv3MRace($RID) {
    require 'DBconn.php';
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankM = 'CALL proc_shortChamp_Div3M_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankM))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    setShortChampDiv3MRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank Div 3 Men's race";
    }
}
// Rank the Men's Div 3 Race
//
// END
    
// Set the Men's Div 3 Race Points
//
// START    
function setShortChampDiv3MRacePoints($RaceID,$RunnerID,$Rank) {
    require 'DBconn.php';
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsM = sprintf('CALL proc_shortChamp_Div3M_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsM) === TRUE)
    {
        //echo "<br>Race points added!<br>";
    }
    else
    {
        echo "Error: " . $sqlPointsM . "<br><br>" . mysqli_error() . "<br><br>";
    }
}
// Set the Men's Div 3 Race Points
//
// END

// Rank the Ladies Div 3 Race
//
// START
function rankShortChampDiv3FRace($RID) {
    require 'DBconn.php';
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankM = 'CALL proc_shortChamp_Div3F_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankM))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    setShortChampDiv3FRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank Div 3 Ladies race";
    }
}
// Rank the Ladies Div 3 Race
//
// END
    
// Set the Ladies Div 3 Race Points
//
// START    
function setShortChampDiv3FRacePoints($RaceID,$RunnerID,$Rank) {
    require 'DBconn.php';
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsM = sprintf('CALL proc_shortChamp_Div3F_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsM) === TRUE)
    {
        //echo "<br>Race points added!<br>";
    }
    else
    {
        echo "Error: " . $sqlPointsM . "<br><br>" . mysqli_error() . "<br><br>";
    }
}
// Set the Ladies Div 3 Race Points
//
// END

// Rank the Men's Div 2 Race
//
// START
function rankShortChampDiv2MRace($RID) {
    require 'DBconn.php';
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankM = 'CALL proc_shortChamp_Div2M_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankM))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    setShortChampDiv2MRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank Div 2 Men's race";
    }
}
// Rank the Men's Div 2 Race
//
// END
    
// Set the Men's Div 2 Race Points
//
// START    
function setShortChampDiv2MRacePoints($RaceID,$RunnerID,$Rank) {
    require 'DBconn.php';
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsM = sprintf('CALL proc_shortChamp_Div2M_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsM) === TRUE)
    {
        //echo "<br>Race points added!<br>";
    }
    else
    {
        echo "Error: " . $sqlPointsM . "<br><br>" . mysqli_error() . "<br><br>";
    }
}
// Set the Men's Div 2 Race Points
//
// END

// Rank the Ladies Div 2 Race
//
// START
function rankShortChampDiv2FRace($RID) {
    require 'DBconn.php';
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankM = 'CALL proc_shortChamp_Div2F_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankM))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    setShortChampDiv2FRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank Div 2 Ladies race";
    }
}
// Rank the Ladies Div 2 Race
//
// END
    
// Set the Ladies Div 2 Race Points
//
// START    
function setShortChampDiv2FRacePoints($RaceID,$RunnerID,$Rank) {
    require 'DBconn.php';
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsM = sprintf('CALL proc_shortChamp_Div2F_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsM) === TRUE)
    {
        //echo "<br>Race points added!<br>";
    }
    else
    {
        echo "Error: " . $sqlPointsM . "<br><br>" . mysqli_error() . "<br><br>";
    }
}
// Set the Ladies Div 2 Race Points
//
// END

    
// Rank the Men's Div 1 Race
//
// START
function rankShortChampDiv1MRace($RID) {
    require 'DBconn.php';
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankM = 'CALL proc_shortChamp_Div1M_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankM))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    setShortChampDiv1MRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank Div 1 Men's race";
    }
}
// Rank the Men's Div 1 Race
//
// END
    
// Set the Men's Div 1 Race Points
//
// START    
function setShortChampDiv1MRacePoints($RaceID,$RunnerID,$Rank) {
    require 'DBconn.php';
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsM = sprintf('CALL proc_shortChamp_Div1M_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsM) === TRUE)
    {
        //echo "<br>Race points added!<br>";
    }
    else
    {
        echo "Error: " . $sqlPointsM . "<br><br>" . mysqli_error() . "<br><br>";
    }
}
// Set the Men's Div 1 Race Points
//
// END

// Rank the Ladies Div 1 Race
//
// START
function rankShortChampDiv1FRace($RID) {
    require 'DBconn.php';
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankM = 'CALL proc_shortChamp_Div1F_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankM))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    setShortChampDiv1FRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank Div 1 Ladies race";
    }
}
// Rank the Ladies Div 1 Race
//
// END
    
// Set the Ladies Div 1 Race Points
//
// START    
function setShortChampDiv1FRacePoints($RaceID,$RunnerID,$Rank) {
    require 'DBconn.php';
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsM = sprintf('CALL proc_shortChamp_Div1F_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsM) === TRUE)
    {
        //echo "<br>Race points added!<br>";
    }
    else
    {
        echo "Error: " . $sqlPointsM . "<br><br>" . mysqli_error() . "<br><br>";
    }
}
// Set the Ladies Div 1 Race Points
//
// END

//
// SHORT CHAMP - END
//

    
//
// Multi-Terrain Chall - START
//

// Rank the Men's Race
//
// START
function rankMTChallMRace($RID) {
    require 'DBconn.php';
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankMTChallM = 'CALL proc_MTChall_M_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankMTChallM))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    setMTChallMRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank MT Chall Men's race";
    }
}
// Rank the Men's Race
//
// END
    
// Set the Men's Race Points
//
// START    
function setMTChallMRacePoints($RaceID,$RunnerID,$Rank) {
    require 'DBconn.php';
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsMTChallM = sprintf('CALL proc_MTChall_M_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsMTChallM) === TRUE)
    {
        //echo "<br>Race points added!<br>";
    }
    else
    {
        echo "Error: " . $sqlPointsMTChallM . "<br><br>" . mysqli_error() . "<br><br>";
    }
}
// Set the Men's Race Points
//
// END


// Rank the Ladies Race
//
// START
function rankMTChallFRace($RID) {
    require 'DBconn.php';
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankMTChallF = 'CALL proc_MTChall_F_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankMTChallF))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    setMTChallFRacePoints($row['RaceID'], $row['RunnerID'], $row['rank']);               
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "Couldn't rank MT Chall Ladies race";
    }
}
// Rank the Ladies Race
//
// END
    
// Set the Ladies Race Points
//
// START    
function setMTChallFRacePoints($RaceID,$RunnerID,$Rank) {
    require 'DBconn.php';
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsMTChallF = sprintf('CALL proc_MTChall_F_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsMTChallF) === TRUE)
    {
        //echo "<br>Race points added!<br>";
    }
    else
    {
        echo "Error: " . $sqlPointsMTChallF . "<br><br>" . mysqli_error() . "<br><br>";
    }
}
// Set the Ladies Race Points
//
// END
    
    
//
// Multi-Terrain Chall - END
//    
    
/////////////////////    
    

?>
<body>
<br><br>
    Tables updated...
<br><br>
<table>
    <tr>
        <td><a href="index.php">Back</a></td>
    </tr>
</table>
</body>
</html>