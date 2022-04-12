<?php
    include('session.php');
?>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Cumberland AC DB Admin - Process Update</title>
  <meta name="description" content="Cumberland AC DB Admin - Update Database">
  <meta name="author" content="West Coast Web Design">

  <link rel="stylesheet" href="css/styles.css<?php echo "?date=" . date("Y-m-d_H-i"); ?>">

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>
    
<?php   
	// create your log file and set to append (a+)
	$myLog = fopen("formPost_log.txt", "a+") or die("Unable to open file!");
	$tDateFormat = "Y-m-d_H-i T (\G\M\T O): ";

	$tLogWrite = "\n- - - Start of log entries for: " . date($tDateFormat) . "\n";
	fwrite($myLog,$tLogWrite);

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

		$tLogWrite = date($tDateFormat) . "Parent page: " . $whatInfo . "\n";
		fwrite($myLog,$tLogWrite);
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
		
		$tLogWrite = date($tDateFormat) . "SQL SUCCESS: " . $sql . "\n";
		fwrite($myLog,$tLogWrite);
    } else {
        echo "<br><br>Oops! There was a problem updating the runner details. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";

		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . $conn->error . "\n";
		fwrite($myLog,$tLogWrite);
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
        echo "<br><br>New runner created successfully</br>";
		
		$tLogWrite = date($tDateFormat) . "SQL SUCCESS: " . $sql . "\n";
		fwrite($myLog,$tLogWrite);
    } else {
        echo "<br><br>Oops! There was a problem adding the new runner. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";

		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . $conn->error . "\n";
		fwrite($myLog,$tLogWrite);
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
    
	$tLogWrite = date($tDateFormat) . "Field Count: " . $fieldCount . ". Championship: " . $txtChamp . "\n";
	fwrite($myLog,$tLogWrite);

    if ($txtChamp == "open") {
        $txtRaceID = explode("_",htmlspecialchars($_POST['raceSelect2']));
    }
    else {
        $txtRaceID = explode("_",htmlspecialchars($_POST['raceSelect1']));
    }
    
	$tLogWrite = date($tDateFormat) . "Race ID: " . $txtRaceID[0] . "\n";
	fwrite($myLog,$tLogWrite);

    
    while($i <= $fieldCount) {
        //populate the array, whilst ignoring blank values
        if(!empty(htmlspecialchars($_POST["ddl1_runner_$i"]))) {
            $raceTimeFormat = sprintf('%02d:%02d:%02d', htmlspecialchars($_POST["race_time_hours_$i"]), htmlspecialchars($_POST["race_time_minutes_$i"]), htmlspecialchars($_POST["race_time_seconds_$i"]));
            //array: runner division, runner id and name, race time
            array_push($runnersAndTimes,htmlspecialchars($_POST["ddl1_runner_$i"]), htmlspecialchars($_POST["ddl2_runner_$i"]), $raceTimeFormat);
			
			$tLogWrite = date($tDateFormat) . "Added to array: Runner Division: " . htmlspecialchars($_POST["ddl1_runner_$i"]);
			$tLogWrite .= ". Name and ID: " . htmlspecialchars($_POST["ddl2_runner_$i"]) . " Race Time: " . $raceTimeFormat . "\n";
			fwrite($myLog,$tLogWrite);
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

		$tLogWrite = date($tDateFormat) . "SQL: " . $sql4 . ". Rows returned: " . mysqli_num_rows($result) . "\n";
		fwrite($myLog,$tLogWrite);
		
        if (mysqli_query($conn,$sql2) === TRUE)
        {
            echo "<br>$raceTimeFormat added for $txtRunnerID[1]!<br>";
			$tLogWrite = date($tDateFormat) . "SQL SUCCESS: " . $sql2 . "\n";
			fwrite($myLog,$tLogWrite);
        }
        else
        {
			echo "<br><br>Oops! There was a problem adding the race time $raceTimeFormat for $txtRunnerID[1]. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";

			$tLogWrite = date($tDateFormat) . "SQL ERROR: " . $conn->error . "\n";
			fwrite($myLog,$tLogWrite);
        }


// NEW WMA ENTRY CODE - START
 
        // need to check the runner is 35 or over on race day, if not, skip this section of code
        $sqlCheckRunnerAgeOver35 = "SELECT tblRunners.RunnerID
	,tblRunners.RunnerFirstName
	,tblRunners.RunnerSurname
	,tblRunners.RunnerSex
	,tblRaceTimes.RaceID
	,FLOOR(DATEDIFF((
				SELECT tblRaces.RaceDate
				FROM tblRaces
				WHERE RaceID = $txtRaceID[0]
				), RunnerDOB) / 365.25) AS AgeAtRaceStart
FROM tblRunners
LEFT JOIN tblRaceTimes ON tblRunners.RunnerID = tblRaceTimes.RunnerID
	AND tblRaceTimes.RaceID = $txtRaceID[0]
WHERE tblRunners.RunnerID = $txtRunnerID[0]
    AND FLOOR(DATEDIFF((
				SELECT tblRaces.RaceDate
				FROM tblRaces
				WHERE RaceID = $txtRaceID[0]
				), RunnerDOB) / 365.25) >= 35";

		$tLogWrite = date($tDateFormat) . "WMA runner age check" . "\n";
		fwrite($myLog,$tLogWrite); 
				
        $resultAgeCheck = mysqli_query($conn,$sqlCheckRunnerAgeOver35);
        
        // if no rows are returned with the above query, it means the runner isn't old enough to be WMA eligible
        if($resultAgeCheck->num_rows == 0)
        {
			$tLogWrite = date($tDateFormat) . "Runner not >=35 on race day." . "\n";
			fwrite($myLog,$tLogWrite); 
            goto runnerNotWMAEligible;
        }

		$tLogWrite = date($tDateFormat) . "Runner >=35 on race day." . "\n";
		fwrite($myLog,$tLogWrite); 
        
        //check for WMA entry for this runner & race ID
        $sqlCheckForWMATimeEntry = "SELECT tblWMARaceTimes.RaceID, tblWMARaceTimes.RunnerID FROM tblWMARaceTimes WHERE tblWMARaceTimes.RaceID=$txtRaceID[0] AND tblWMARaceTimes.RunnerID = $txtRunnerID[0]";
		$tLogWrite = date($tDateFormat) . "SQL: " . $sqlCheckForWMATimeEntry . "\n";
		fwrite($myLog,$tLogWrite); 

        $resultWMACheck = mysqli_query($conn,$sqlCheckForWMATimeEntry);
            
        // if a result is found, UPDATE instead of INSERT       
        if($resultWMACheck->num_rows > 0)
        {
			$tLogWrite = date($tDateFormat) . "Result returned in WMA table. Records to be UPDATED." . "\n";
			fwrite($myLog,$tLogWrite);
            // **** when you test this out in future, make sure the runner has a DoB set!!! ****
            
            while($row=mysqli_fetch_assoc($resultWMACheck)){
                $sqlWMA = "CREATE TEMPORARY TABLE tempTblWMA (
	ID INT auto_increment PRIMARY KEY
	,RunnerID INT
	,RunnerFirstName VARCHAR(32)
	,RunnerSurname VARCHAR(32)
	,RunnerSex VARCHAR(1)
	,RaceID INT
	,AgeAtRaceStart INT
	,WMAFactor DECIMAL(6, 5)
	,RaceTime TIME
	,WMAAdjustedTime TIME
	);

INSERT INTO tempTblWMA (
	RunnerID
	,RunnerFirstName
	,RunnerSurname
	,RunnerSex
	,RaceID
	,AgeAtRaceStart
	,WMAFactor
	,RaceTime
	,WMAAdjustedTime
	)
SELECT tblRunners.RunnerID
	,tblRunners.RunnerFirstName
	,tblRunners.RunnerSurname
	,tblRunners.RunnerSex
	,tblRaceTimes.RaceID
	,FLOOR(DATEDIFF((
				SELECT tblRaces.RaceDate
				FROM tblRaces
				WHERE RaceID = '" . $txtRaceID[0] . "'
				), RunnerDOB) / 365.25) AS AgeAtRaceStart
	,tblWMA.WMAFactor
	,tblRaceTimes.RaceTime
	,SEC_TO_TIME(tblWMA.WMAFactor * TIME_TO_SEC(tblRaceTimes.RaceTime)) AS WMAAdjustedTime
FROM tblRunners
LEFT JOIN tblWMA ON (
		FLOOR(DATEDIFF((
					SELECT tblRaces.RaceDate
					FROM tblRaces
					WHERE RaceID = '" . $txtRaceID[0] . "'
					), RunnerDOB) / 365.25)
		) = tblWMA.WMAAge
	AND tblRunners.RunnerSex = tblWMA.WMASex
LEFT JOIN tblRaceTimes ON tblRunners.RunnerID = tblRaceTimes.RunnerID
	AND tblRaceTimes.RaceID = '" . $txtRaceID[0] . "'
WHERE tblRunners.RunnerID IN (
		SELECT tblWMARaceTimes.RunnerID
		FROM tblWMARaceTimes
		WHERE RaceID = '" . $txtRaceID[0] . "'
		)
	AND tblWMA.WMADistance = (
		SELECT (tblRaces.RaceDist / 1000) AS RaceDistKmToM
		FROM tblRaces
		WHERE RaceID = '" . $txtRaceID[0] . "'
	AND tblRaceTimes.RunnerID='" . $txtRunnerID[0] . "'
		);

UPDATE tblWMARaceTimes AS dest
INNER JOIN tempTblWMA AS source ON dest.RunnerID = source.RunnerID
	AND dest.RaceID = source.RaceID

SET dest.WMARaceTime = source.WMAAdjustedTime
	,dest.WMARunnerLevel = source.WMAFactor";
            }
        }
        else
        {
			$tLogWrite = date($tDateFormat) . "Result not returned in WMA table. Records to be INSERTED." . "\n";
			fwrite($myLog,$tLogWrite);
            
            //creates the WMARaceTimes table entry for the WMA procedures to process
            $sqlWMA = "INSERT INTO tblWMARaceTimes (
	RunnerID
	,RaceID
	,WMARunnerLevel
	,RaceTime
	,WMARaceTime
	)
SELECT tblRunners.RunnerID
	,tblRaceTimes.RaceID
	,tblWMA.WMAFactor
	,tblRaceTimes.RaceTime
	,SEC_TO_TIME(tblWMA.WMAFactor * TIME_TO_SEC(tblRaceTimes.RaceTime)) AS WMAAdjustedTime
FROM tblRunners
LEFT JOIN tblWMA ON (
		FLOOR(DATEDIFF((
					SELECT tblRaces.RaceDate
					FROM tblRaces
					WHERE tblRaces.RaceID = '" . $txtRaceID[0] . "'
					), RunnerDOB) / 365.25)
		) = tblWMA.WMAAge
	AND tblRunners.RunnerSex = tblWMA.WMASex
LEFT JOIN tblRaceTimes ON tblRunners.RunnerID = tblRaceTimes.RunnerID
	AND tblRaceTimes.RaceID = '" . $txtRaceID[0] . "'
LEFT JOIN tblRaces ON tblRaceTimes.RaceID = tblRaces.RaceID
WHERE FLOOR(DATEDIFF((
				SELECT tblRaces.RaceDate
				FROM tblRaces
				WHERE tblRaces.RaceID = '" . $txtRaceID[0] . "'
				), RunnerDOB) / 365.25) >= 35
	AND tblWMA.WMADistance = (
		SELECT (tblRaces.RaceDist / 1000) AS RaceDistKmToM
		FROM tblRaces
		WHERE tblRaces.RaceID = '" . $txtRaceID[0] . "'
		)
	AND tblRaces.RaceID = '" . $txtRaceID[0] . "'
	AND tblRaceTimes.RunnerID='" . $txtRunnerID[0] . "'";
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
			echo "<br><br>Oops! There was a problem adjusting the race time to a WMA race time for $txtRunnerID[1]. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";

			$tLogWrite = date($tDateFormat) . "SQL ERROR: " . $conn->error . "\n";
			fwrite($myLog,$tLogWrite);
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
	$tLogWrite = date($tDateFormat) . "Function calls" . "\n";
	$tLogWrite .= date($tDateFormat) . "rankOpenChampDiv1MRace($txtRaceID[0])" . "\n";
	fwrite($myLog,$tLogWrite);
    rankOpenChampDiv1MRace($txtRaceID[0]);

    // call the rankOpenChampDiv1F function
	$tLogWrite = date($tDateFormat) . "rankOpenChampDiv1FRace($txtRaceID[0])" . "\n";
	fwrite($myLog,$tLogWrite);
    rankOpenChampDiv1FRace($txtRaceID[0]);

        // call the rankOpenChampDiv1Joint function
        // rankOpenChampDiv1JointRace($txtRaceID[0]);

    // call the rankOpenChampDiv2M function
	$tLogWrite = date($tDateFormat) . "rankOpenChampDiv2MRace($txtRaceID[0])" . "\n";
	fwrite($myLog,$tLogWrite);
    rankOpenChampDiv2MRace($txtRaceID[0]);

    // call the rankOpenChampDiv2F function
	$tLogWrite = date($tDateFormat) . "rankOpenChampDiv2FRace($txtRaceID[0])" . "\n";
	fwrite($myLog,$tLogWrite);
    rankOpenChampDiv2FRace($txtRaceID[0]);
	
        // call the rankOpenChampDiv2Joint function
        // rankOpenChampDiv2JointRace($txtRaceID[0]);

    // call the rankOpenChampDiv3M function
	$tLogWrite = date($tDateFormat) . "rankOpenChampDiv3MRace($txtRaceID[0])" . "\n";
	fwrite($myLog,$tLogWrite);
    rankOpenChampDiv3MRace($txtRaceID[0]);

    // call the rankOpenChampDiv3F function
	$tLogWrite = date($tDateFormat) . "rankOpenChampDiv3FRace($txtRaceID[0])" . "\n";
	fwrite($myLog,$tLogWrite);
    rankOpenChampDiv3FRace($txtRaceID[0]);

        // call the rankOpenChampDiv3Joint function
        // rankOpenChampDiv3JointRace($txtRaceID[0]);

        //
        // MASTERS FUNCTION CALLS - START
        //
        // call the rankOpenChampWMAM function
        $tLogWrite = date($tDateFormat) . "rankOpenChampWMAMRace($txtRaceID[0])" . "\n";
		fwrite($myLog,$tLogWrite);
		rankOpenChampWMAMRace($txtRaceID[0]);
        
		// call the rankOpenChampWMAF function
        $tLogWrite = date($tDateFormat) . "rankOpenChampWMAFRace($txtRaceID[0])" . "\n";
		fwrite($myLog,$tLogWrite);		
        rankOpenChampWMAFRace($txtRaceID[0]);    
        // MASTERS FUNCTION CALLS - END
    //
    // LADIES CHAMP FUNCTION CALLS - START
    //
    // call the rankOpenChampLadies function
	$tLogWrite = date($tDateFormat) . "rankOpenChampLadiesRace($txtRaceID[0])" . "\n";
	fwrite($myLog,$tLogWrite);
    rankOpenChampLadiesRace($txtRaceID[0]);
    // LADIES FUNCTION CALLS - END   
    //
    // OPEN CHAMP FUNCTION CALLS - END
    //
    
    //
    // MT CHALL FUNCTION CALLS - START
    //
    
    // call the rankMTChallMRace function
	$tLogWrite = date($tDateFormat) . "rankMTChallMRace($txtRaceID[0])" . "\n";
	fwrite($myLog,$tLogWrite);
    rankMTChallMRace($txtRaceID[0]);
    // call the rankMTChallFRace function
	$tLogWrite = date($tDateFormat) . "rankMTChallFRace($txtRaceID[0])" . "\n";
	fwrite($myLog,$tLogWrite);
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
	$tLogWrite = date($tDateFormat) . "rankShortChampDiv3MRace($txtRaceID[0])" . "\n";
	fwrite($myLog,$tLogWrite);
    rankShortChampDiv3MRace($txtRaceID[0]);

    // call the rankShortChampDiv2MRace function
	$tLogWrite = date($tDateFormat) . "rankShortChampDiv2MRace($txtRaceID[0])" . "\n";
	fwrite($myLog,$tLogWrite);
    rankShortChampDiv2MRace($txtRaceID[0]);

    // call the rankShortChampDiv1MRace function
	$tLogWrite = date($tDateFormat) . "rankShortChampDiv1MRace($txtRaceID[0])" . "\n";
	fwrite($myLog,$tLogWrite);
    rankShortChampDiv1MRace($txtRaceID[0]);

    // call the rankShortChampDiv3FRace function
	$tLogWrite = date($tDateFormat) . "rankShortChampDiv3FRace($txtRaceID[0])" . "\n";
	fwrite($myLog,$tLogWrite);
    rankShortChampDiv3FRace($txtRaceID[0]);

    // call the rankShortChampDiv2FRace function
	$tLogWrite = date($tDateFormat) . "rankShortChampDiv2FRace($txtRaceID[0])" . "\n";
	fwrite($myLog,$tLogWrite);
    rankShortChampDiv2FRace($txtRaceID[0]);

    // call the rankShortChampDiv1FRace function
	$tLogWrite = date($tDateFormat) . "rankShortChampDiv1FRace($txtRaceID[0])" . "\n";
	fwrite($myLog,$tLogWrite);
    rankShortChampDiv1FRace($txtRaceID[0]);
    
    //
    // SHORT CHAMP FUNCTION CALLS - END
    //

    
    // call the champTotalPoints function
	$tLogWrite = date($tDateFormat) . "champTotalPoints($txtRaceID[0])" . "\n";
	fwrite($myLog,$tLogWrite);
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

	global $tDateFormat, $myLog;
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankDiv1M = 'CALL proc_openChamp_Div1M_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
	$tLogWrite = date($tDateFormat) . "SQL: " . $sqlRankDiv1M . "\n";
	fwrite($myLog,$tLogWrite);
	
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
			echo "<br><br>Oops! There was a problem ranking the race. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
			$tLogWrite = date($tDateFormat) . "SQL ERROR: " . mysqli_error() . "\n";
			fwrite($myLog,$tLogWrite);
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

	global $tDateFormat, $myLog;
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsDiv1M = sprintf('CALL proc_openChamp_Div1M_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsDiv1M) === TRUE)
    {
		$tLogWrite = date($tDateFormat) . "SQL SUCCESS: " . $sqlPointsDiv1M . "\n";
		fwrite($myLog,$tLogWrite);
    }
    else
    {
		echo "<br><br>Oops! There was a problem assigning a rank to this runner for the race. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . mysqli_error() . "\n";
		fwrite($myLog,$tLogWrite);
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

	global $tDateFormat, $myLog;
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankDiv1F = 'CALL proc_openChamp_Div1F_rank(' . $RID . '); SELECT RaceID, RunnerID, RaceTime, rank;';

	$tLogWrite = date($tDateFormat) . "SQL: " . $sqlRankDiv1F . "\n";
	fwrite($myLog,$tLogWrite);
    
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
		echo "<br><br>Oops! There was a problem ranking the race. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . mysqli_error() . "\n";
		fwrite($myLog,$tLogWrite);
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

	global $tDateFormat, $myLog;
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsDiv1F = sprintf('CALL proc_openChamp_Div1F_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsDiv1F) === TRUE)
    {
		$tLogWrite = date($tDateFormat) . "SQL SUCCESS: " . $sqlPointsDiv1F . "\n";
		fwrite($myLog,$tLogWrite);
    }
    else
    {
		echo "<br><br>Oops! There was a problem assigning a rank to this runner for the race. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . mysqli_error() . "\n";
		fwrite($myLog,$tLogWrite);
    }

}
// Set the Division 1 Ladies Race Points
//
// END 


// Rank the Division 2 Mens Race
//
// START
function rankOpenChampDiv2MRace($RID) {
    require 'DBconn.php';

	global $tDateFormat, $myLog;
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankDiv2M = 'CALL proc_openChamp_Div2M_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
	$tLogWrite = date($tDateFormat) . "SQL: " . $sqlRankDiv2M . "\n";
	fwrite($myLog,$tLogWrite);
    
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
		echo "<br><br>Oops! There was a problem ranking the race. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . mysqli_error() . "\n";
		fwrite($myLog,$tLogWrite);
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

	global $tDateFormat, $myLog;
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsDiv2M = sprintf('CALL proc_openChamp_Div2M_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsDiv2M) === TRUE)
    {
		$tLogWrite = date($tDateFormat) . "SQL SUCCESS: " . $sqlPointsDiv2M . "\n";
		fwrite($myLog,$tLogWrite);
    }
    else
    {
		echo "<br><br>Oops! There was a problem assigning a rank to this runner for the race. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . mysqli_error() . "\n";
		fwrite($myLog,$tLogWrite);
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

	global $tDateFormat, $myLog;
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankDiv2F = 'CALL proc_openChamp_Div2F_rank(' . $RID . '); SELECT RaceID, RunnerID, RaceTime, rank;';
	$tLogWrite = date($tDateFormat) . "SQL: " . $sqlRankDiv2F . "\n";
	fwrite($myLog,$tLogWrite);
    
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
		echo "<br><br>Oops! There was a problem ranking the race. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . mysqli_error() . "\n";
		fwrite($myLog,$tLogWrite);
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

	global $tDateFormat, $myLog;
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsDiv2F = sprintf('CALL proc_openChamp_Div2F_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsDiv2F) === TRUE)
    {
		$tLogWrite = date($tDateFormat) . "SQL SUCCESS: " . $sqlPointsDiv2F . "\n";
		fwrite($myLog,$tLogWrite);
    }
    else
    {
		echo "<br><br>Oops! There was a problem assigning a rank to this runner for the race. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . mysqli_error() . "\n";
		fwrite($myLog,$tLogWrite);
    }

}
// Set the Division 2 Ladies Race Points
//
// END     


// Rank the Division 3 Mens Race
//
// START
function rankOpenChampDiv3MRace($RID) {
    require 'DBconn.php';

	global $tDateFormat, $myLog;
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankDiv3M = 'CALL proc_openChamp_Div3M_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
	$tLogWrite = date($tDateFormat) . "SQL: " . $sqlRankDiv3M . "\n";
	fwrite($myLog,$tLogWrite);
    
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
		echo "<br><br>Oops! There was a problem ranking the race. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . mysqli_error() . "\n";
		fwrite($myLog,$tLogWrite);
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

	global $tDateFormat, $myLog;
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsDiv3M = sprintf('CALL proc_openChamp_Div3M_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsDiv3M) === TRUE)
    {
		$tLogWrite = date($tDateFormat) . "SQL SUCCESS: " . $sqlPointsDiv3M . "\n";
		fwrite($myLog,$tLogWrite);
    }
    else
    {
		echo "<br><br>Oops! There was a problem assigning a rank to this runner for the race. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . mysqli_error() . "\n";
		fwrite($myLog,$tLogWrite);
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

	global $tDateFormat, $myLog;
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankDiv3F = 'CALL proc_openChamp_Div3F_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
	$tLogWrite = date($tDateFormat) . "SQL: " . $sqlRankDiv3F . "\n";
	fwrite($myLog,$tLogWrite);
	
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
		echo "<br><br>Oops! There was a problem ranking the race. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . mysqli_error() . "\n";
		fwrite($myLog,$tLogWrite);
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

	global $tDateFormat, $myLog;
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsDiv3F = sprintf('CALL proc_openChamp_Div3F_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);

    if (mysqli_multi_query($conn,$sqlPointsDiv3F) === TRUE)
    {
		$tLogWrite = date($tDateFormat) . "SQL SUCCESS: " . $sqlPointsDiv3F . "\n";
		fwrite($myLog,$tLogWrite);
    }
    else
    {
		echo "<br><br>Oops! There was a problem assigning a rank to this runner for the race. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . mysqli_error() . "\n";
		fwrite($myLog,$tLogWrite);
    }

}
// Set the Division 3 Ladies Race Points
//
// END    

// Rank the Male MASTERS - START (NEW CODE)
//
// START
function rankOpenChampWMAMRace($RID) {    //
    require 'DBconn.php';   //

	global $tDateFormat, $myLog;
    
    // the subsequent SELECT statement returns the results of the stored procedure //
    $sqlRankWMAM = 'CALL proc_openChamp_WMA_M_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;'; //
	$tLogWrite = date($tDateFormat) . "SQL: " . $sqlRankWMAM . "\n";
	fwrite($myLog,$tLogWrite);
    
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
		echo "<br><br>Oops! There was a problem ranking the race. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . mysqli_error() . "\n";
		fwrite($myLog,$tLogWrite);
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

	global $tDateFormat, $myLog;
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsWMAM = sprintf('CALL proc_openChamp_WMA_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);  //

    if (mysqli_multi_query($conn,$sqlPointsWMAM) === TRUE)    //
    {
		$tLogWrite = date($tDateFormat) . "SQL SUCCESS: " . $sqlPointsWMAM . "\n";
		fwrite($myLog,$tLogWrite);
    }
    else
    {
		echo "<br><br>Oops! There was a problem assigning a rank to this runner for the race. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . mysqli_error() . "\n";
		fwrite($myLog,$tLogWrite);
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

	global $tDateFormat, $myLog;
    
    // the second SELECT statement is important as it returns the results of the stored procedure //
    $sqlRankWMAF = 'CALL proc_openChamp_WMA_F_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;'; //
	$tLogWrite = date($tDateFormat) . "SQL: " . $sqlRankWMAF . "\n";
	fwrite($myLog,$tLogWrite);    
	
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
		echo "<br><br>Oops! There was a problem ranking the race. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . mysqli_error() . "\n";
		fwrite($myLog,$tLogWrite);
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

	global $tDateFormat, $myLog;
    
    // using a SQL stored procedure so DB can check if a record already exists for this RaceID, RunnerID combo before inserting a new record
    
    // %1$s = RaceID, %2$s = RunnerID, %3$s = Rank
    $sqlPointsWMAF = sprintf('CALL proc_openChamp_WMA_points(%1$s,%2$s,%3$s)', $RaceID,$RunnerID,$Rank);  //

    if (mysqli_multi_query($conn,$sqlPointsWMAF) === TRUE)    //
    {
		$tLogWrite = date($tDateFormat) . "SQL SUCCESS: " . $sqlPointsWMAF . "\n";
		fwrite($myLog,$tLogWrite);
    }
    else
    {
		echo "<br><br>Oops! There was a problem assigning a rank to this runner for the race. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
		$tLogWrite = date($tDateFormat) . "SQL ERROR: " . mysqli_error() . "\n";
		fwrite($myLog,$tLogWrite);
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

//
// function to update all championship points entries for the raceID passed to it - START
//
function champTotalPoints($RID)
{
    // open and close a separate DB connection within each function.
    require 'DBconn.php';

	global $tDateFormat, $myLog, $RaceYear;
    
    // in this function, the RaceID is used only to determine which championship(s) and which open championship category to update - only change the affected data!
    
    // select the RunnerIDs and RaceIDs from tblRaceTimes for that specific championship and the current championship year
    
    // for each RunnerID SUM the top X racepoints (depending on the championship type)
    
    // write the total points to the overall points table against the championshipID and runnerID
    
    $sqlFindChamp = "SELECT RaceCode FROM tblRaces WHERE RaceID=$RID";
	$tLogWrite = date($tDateFormat) . "SQL: " . $sqlFindChamp . "\n";
	fwrite($myLog,$tLogWrite); 
	
    $result = mysqli_query($conn,$sqlFindChamp);
    
    if(mysqli_num_rows($result) > 0)
    {
        // output data of each row
        while($row = $result->fetch_assoc())
        {   
            $RaceCode = $row["RaceCode"];
			$tLogWrite = date($tDateFormat) . "Race Code: " . $RaceCode . "\n";
			fwrite($myLog,$tLogWrite); 
        }
    }           
    else
    {
		echo "<br><br>Oops! There's a problem with the race details. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
		$tLogWrite = date($tDateFormat) . "Either no rows returned, or SQL ERROR: " . mysqli_error() . "\n";
		fwrite($myLog,$tLogWrite);
    }

    
/* OpenChamp Sprint distance */
    if($RaceCode == "1" || $RaceCode == "9")
    {
		$tLogWrite = date($tDateFormat) . "Open Champ: Sprint distance race point tally" . "\n";
		fwrite($myLog,$tLogWrite);
        //
        // select all runners who have ran a sprint distance race (1, or 9) for the current year
        // START
        $sqlSelectRunners = 'SELECT DISTINCT RunnerID FROM tblOpenChampDivGenRacePoints WHERE RaceID IN (Select RaceID FROM tblRaces WHERE RaceCode IN (1,9) AND ChampYear=' . $RaceYear . ')';
		$tLogWrite = date($tDateFormat) . "SQL: " . $sqlSelectRunners . "\n";
		fwrite($myLog,$tLogWrite);
    
        $result = mysqli_query($conn,$sqlSelectRunners);
    
        if(mysqli_num_rows($result) > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $RunnerID = $row["RunnerID"];

                $sqlUpdatePoints = sprintf('CALL proc_openChamp_sprint_points(%1$s,%2$s);',$RunnerID, $RID);
				$tLogWrite = date($tDateFormat) . "SQL: " . $sqlUpdatePoints . "\n";
				fwrite($myLog,$tLogWrite);
                $result2 = mysqli_query($conn,$sqlUpdatePoints);
                
                $sqlUpdatePoints2 = sprintf('CALL proc_openChamp_sprint_Divs_top2(%1$s,%2$s);',$RunnerID, $RID);
				$tLogWrite = date($tDateFormat) . "SQL: " . $sqlUpdatePoints2 . "\n";
				fwrite($myLog,$tLogWrite);                
                $result3 = mysqli_query($conn,$sqlUpdatePoints2);

                $sqlUpdatePoints3 = sprintf('CALL proc_openChamp_WMA_sprint_top2(%1$s,%2$s);',$RunnerID, $RID);
				$tLogWrite = date($tDateFormat) . "SQL: " . $sqlUpdatePoints3 . "\n";
				fwrite($myLog,$tLogWrite);                
                $result4 = mysqli_query($conn,$sqlUpdatePoints3);

                $sqlUpdatePoints4 = sprintf('CALL proc_openChamp_ladies_sprint_top2(%1$s,%2$s);',$RunnerID, $RID);
				$tLogWrite = date($tDateFormat) . "SQL: " . $sqlUpdatePoints4 . "\n";
				fwrite($myLog,$tLogWrite);                
                $result5 = mysqli_query($conn,$sqlUpdatePoints4);
            }
        }           
        else
        {
			echo "<br><br>Oops! There's a problem with the race details. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
			$tLogWrite = date($tDateFormat) . "Either no rows returned or SQL ERROR: " . mysqli_error() . "\n";
			fwrite($myLog,$tLogWrite);
        }        
        // END
        // select all runners who have ran a sprint distance race (1, or 9) for the current year
        //
    }
/* OpenChamp Sprint distance */


/* OpenChamp Middle distance */
    if($RaceCode == "2")
    {
		$tLogWrite = date($tDateFormat) . "Open Champ: Middle distance race point tally" . "\n";
		fwrite($myLog,$tLogWrite);
		
        $sqlSelectRunners = 'SELECT DISTINCT RunnerID FROM tblOpenChampDivGenRacePoints WHERE RaceID IN (Select RaceID FROM tblRaces WHERE RaceCode = 2 AND ChampYear=' . $RaceYear . ')';
		$tLogWrite = date($tDateFormat) . "SQL: " . $sqlSelectRunners . "\n";
		fwrite($myLog,$tLogWrite);
		
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
			echo "<br><br>Oops! There's a problem with the race details. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
			$tLogWrite = date($tDateFormat) . "SQL ERROR: Either no rows returned or SQL ERROR: " . mysqli_error() . "\n";
			fwrite($myLog,$tLogWrite);
        }        
    }
/* OpenChamp Middle distance */    

    
/* OpenChamp Long distance */
    if($RaceCode == "4")
    {
		$tLogWrite = date($tDateFormat) . "Open Champ: Long distance race point tally" . "\n";
		fwrite($myLog,$tLogWrite);
		
        $sqlSelectRunners = 'SELECT DISTINCT RunnerID FROM tblOpenChampDivGenRacePoints WHERE RaceID IN (Select RaceID FROM tblRaces WHERE RaceCode = 4 AND ChampYear=' . $RaceYear . ')';
		$tLogWrite = date($tDateFormat) . "SQL: " . $sqlSelectRunners . "\n";
		fwrite($myLog,$tLogWrite);
		
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
			echo "<br><br>Oops! There's a problem with the race details. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
			$tLogWrite = date($tDateFormat) . "SQL ERROR: Either no rows returned or SQL ERROR: " . mysqli_error() . "\n";
			fwrite($myLog,$tLogWrite);
        }        
    }
/* OpenChamp Long distance */   


/* OpenChamp SprintMed distance */
    if($RaceCode == "32")
    {
		$tLogWrite = date($tDateFormat) . "Open Champ: Sprint-Med distance race point tally" . "\n";
		fwrite($myLog,$tLogWrite);
		
        $sqlSelectRunners = 'SELECT DISTINCT RunnerID FROM tblOpenChampDivGenRacePoints WHERE RaceID IN (Select RaceID FROM tblRaces WHERE RaceCode = 32 AND ChampYear=' . $RaceYear . ')';
		$tLogWrite = date($tDateFormat) . "SQL: " . $sqlSelectRunners . "\n";
		fwrite($myLog,$tLogWrite);
		
        $result = mysqli_query($conn,$sqlSelectRunners);
    
        if(mysqli_num_rows($result) > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $RunnerID = $row["RunnerID"];

                $sqlUpdatePoints = sprintf('CALL proc_openChamp_sprintMed_points(%1$s,%2$s);',$RunnerID, $RID);

                $result2 = mysqli_query($conn,$sqlUpdatePoints);
                
                $sqlUpdatePoints2 = sprintf('CALL proc_openChamp_sprintMed_Divs_top2(%1$s,%2$s);',$RunnerID, $RID);
                
                $result3 = mysqli_query($conn,$sqlUpdatePoints2);

                $sqlUpdatePoints3 = sprintf('CALL proc_openChamp_WMA_sprintMed_top2(%1$s,%2$s);',$RunnerID, $RID);
                
                $result4 = mysqli_query($conn,$sqlUpdatePoints3);

				//commented out as this is running the long procedure again for ladies unnecessarily
                //$sqlUpdatePoints4 = sprintf('CALL proc_openChamp_ladies_long_top2(%1$s,%2$s);',$RunnerID, $RID);
                
                //$result5 = mysqli_query($conn,$sqlUpdatePoints4);
            }
        }           
        else
        {
			echo "<br><br>Oops! There's a problem with the race details. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
			$tLogWrite = date($tDateFormat) . "SQL ERROR: Either no rows returned or SQL ERROR: " . mysqli_error() . "\n";
			fwrite($myLog,$tLogWrite);
        }        
    }
/* OpenChamp SprintMed distance */   
    
    
/* ShortChamp races */
    if($RaceCode == "8" || $RaceCode == "9")
    {
		$tLogWrite = date($tDateFormat) . "Short Champ: Race point tally" . "\n";
		fwrite($myLog,$tLogWrite);
		
        $sqlSelectRunners = 'SELECT DISTINCT RunnerID FROM tblShortChampDivGenRacePoints WHERE RaceID IN (Select RaceID FROM tblRaces WHERE RaceCode IN (8,9) AND ChampYear=' . $RaceYear . ')';
		$tLogWrite = date($tDateFormat) . "SQL: " . $sqlSelectRunners . "\n";
		fwrite($myLog,$tLogWrite);
    
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
			echo "<br><br>Oops! There's a problem with the race details. The error has been saved to the error log. <b><u>Please let Stu know and he'll try to fix it</u></b> :)";
			$tLogWrite = date($tDateFormat) . "SQL ERROR: Either no rows returned or SQL ERROR: " . mysqli_error() . "\n";
			fwrite($myLog,$tLogWrite);
        }       
    }    
/* ShortChamp races */
    
/* Multi-Terrain Challenge races */
    if($RaceCode == "16")
    {
        $sqlSelectRunners = 'SELECT DISTINCT RunnerID FROM tblMTChallDivGenRacePoints WHERE RaceID IN (Select RaceID FROM tblRaces WHERE RaceCode IN (16) AND ChampYear=' . $RaceYear . ')';
    
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

	global $tLogWrite, $myLog, $tDateFormat;  
    
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankM = 'CALL proc_shortChamp_Div3M_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankM))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
					$tLogWrite = date($tDateFormat) . "Function rankShortChampDiv3MRace, setting race points for:- RaceID: " . $row['RaceID'] . ", RunnerID: " . $row['RunnerID'] . ", Rank: " . $row['rank'] . "\n";
					fwrite($myLog,$tLogWrite);
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
 
	global $tLogWrite, $myLog, $tDateFormat;  
	
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankM = 'CALL proc_shortChamp_Div3F_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankM))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
					$tLogWrite = date($tDateFormat) . "Function rankShortChampDiv3FRace, setting race points for:- RaceID: " . $row['RaceID'] . ", RunnerID: " . $row['RunnerID'] . ", Rank: " . $row['rank'] . "\n";
					fwrite($myLog,$tLogWrite);
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

	global $tLogWrite, $myLog, $tDateFormat;     
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankM = 'CALL proc_shortChamp_Div2M_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankM))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
					$tLogWrite = date($tDateFormat) . "Function rankShortChampDiv2MRace, setting race points for:- RaceID: " . $row['RaceID'] . ", RunnerID: " . $row['RunnerID'] . ", Rank: " . $row['rank'] . "\n";
					fwrite($myLog,$tLogWrite);
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

	global $tLogWrite, $myLog, $tDateFormat;     
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankM = 'CALL proc_shortChamp_Div2F_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankM))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
					$tLogWrite = date($tDateFormat) . "Function rankShortChampDiv2FRace, setting race points for:- RaceID: " . $row['RaceID'] . ", RunnerID: " . $row['RunnerID'] . ", Rank: " . $row['rank'] . "\n";
					fwrite($myLog,$tLogWrite);
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

	global $tLogWrite, $myLog, $tDateFormat;     
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankM = 'CALL proc_shortChamp_Div1M_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankM))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
					$tLogWrite = date($tDateFormat) . "Function rankShortChampDiv1MRace, setting race points for:- RaceID: " . $row['RaceID'] . ", RunnerID: " . $row['RunnerID'] . ", Rank: " . $row['rank'] . "\n";
					fwrite($myLog,$tLogWrite);
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

	global $tLogWrite, $myLog, $tDateFormat;     
    // the second SELECT statement is important as it returns the results of the stored procedure
    $sqlRankM = 'CALL proc_shortChamp_Div1F_rank('.$RID.'); SELECT RaceID, RunnerID, RaceTime, rank;';
    
    if(mysqli_multi_query($conn,$sqlRankM))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
					$tLogWrite = date($tDateFormat) . "Function rankShortChampDiv1FRace, setting race points for:- RaceID: " . $row['RaceID'] . ", RunnerID: " . $row['RunnerID'] . ", Rank: " . $row['rank'] . "\n";
					fwrite($myLog,$tLogWrite);
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
    
	$tLogWrite = "- - - End of log entries for: " . date("Y-m-d_H-i") . "\n";
	fwrite($myLog,$tLogWrite);
	fclose($myLog);
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