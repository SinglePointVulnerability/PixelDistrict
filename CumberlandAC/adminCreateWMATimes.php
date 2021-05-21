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
}
else {
        $whatInfo = htmlspecialchars($_POST["parentPage"]);
}
    // Populate a php array using the following select statement
    // (this is a one off statement to give everyone a WMATime – not to be used every time a race time is added or updated)

    $sqlSelect = "SELECT tblRaceTimes.RaceTimesID,
	tblRunners.runnerFirstName,
    tblRunners.runnerSurname,
    (YEAR(CURDATE()) - YEAR(tblRunners.runnerDOB) - 1) AS runnerAge,
    (SELECT tblRaces.RaceName FROM tblRaces WHERE tblRaces.RaceID = tblRaceTimes.RaceID) AS RaceName,
    tblRaceTimes.RaceTime,
    (SELECT tblRaces.RaceDist FROM tblRaces WHERE tblRaces.RaceID = tblRaceTimes.RaceID) AS RaceDist,
    (SELECT tblWMA.WMAFactor FROM tblWMA WHERE tblWMA.WMADistance = (SELECT (tblRaces.RaceDist/1000) FROM tblRaces WHERE tblRaces.RaceID = tblRaceTimes.RaceID) AND tblWMA.WMASex = tblRunners.RunnerSex AND tblWMA.WMAAge = runnerAge) AS WMAFactor, TIME_FORMAT(SEC_TO_TIME(TIME_TO_SEC(tblRaceTimes.RaceTime) * (SELECT tblWMA.WMAFactor FROM tblWMA WHERE tblWMA.WMADistance = (SELECT (tblRaces.RaceDist/1000) FROM tblRaces WHERE tblRaces.RaceID = tblRaceTimes.RaceID) AND tblWMA.WMASex = tblRunners.RunnerSex AND tblWMA.WMAAge = runnerAge)),'%H:%i:%s') AS WMATime,
    (SELECT tblWMA.WMAWRTime FROM tblWMA WHERE tblWMA.WMADistance = (SELECT (tblRaces.RaceDist/1000) FROM tblRaces WHERE tblRaces.RaceID = tblRaceTimes.RaceID) AND tblWMA.WMASex = tblRunners.RunnerSex AND tblWMA.WMAAge = runnerAge) /     (TIME_TO_SEC(tblRaceTimes.RaceTime) * (SELECT tblWMA.WMAFactor FROM tblWMA WHERE tblWMA.WMADistance = (SELECT (tblRaces.RaceDist/1000) FROM tblRaces WHERE tblRaces.RaceID = tblRaceTimes.RaceID) AND tblWMA.WMASex = tblRunners.RunnerSex AND tblWMA.WMAAge = runnerAge)) AS RunnerLevel
FROM tblRunners
JOIN tblRaceTimes ON tblRunners.RunnerID = tblRaceTimes.RunnerID WHERE TIME_FORMAT(SEC_TO_TIME(TIME_TO_SEC(tblRaceTimes.RaceTime) * (SELECT tblWMA.WMAFactor FROM tblWMA WHERE tblWMA.WMADistance = (SELECT (tblRaces.RaceDist/1000) FROM tblRaces WHERE tblRaces.RaceID = tblRaceTimes.RaceID) AND tblWMA.WMASex = tblRunners.RunnerSex AND tblWMA.WMAAge = (YEAR(CURDATE()) - YEAR(tblRunners.runnerDOB) - 1))),'%H:%i:%s') > '00:00:00'";

    $result = mysqli_query($conn,$sqlSelect);
    
    // update points in the OPEN CHAMPIONSHIP RACES
    if(mysqli_num_rows($result) > 0)
    {
        // output data of each row
        while($row = $result->fetch_assoc())
        {   
            $sqlUpdate = "UPDATE tblWMARaceTimes SET WMARaceTime='" . $row['WMATime'] . "', WMARunnerLevel='" . $row['RunnerLevel'] . "' WHERE RaceTimesID=" . $row['RaceTimesID'];
            
            echo $sqlUpdate;
        
            if(mysqli_query($conn,$sqlUpdate) === TRUE) {
                echo "<br><br>Runner WMA Race Time and Runner Level added successfully<br><br>";
            } else {
            echo "<br><br>Error updating record: " . $conn->error . "<br><br>" . $sql;
            }
        }
    }

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