<?php
    session_start();// Starting Session
    // Storing Session
    if(isset($_SESSION['login_user'])) {
        $user_check=$_SESSION['login_user'];
    }
    else {
        $user_check='';
    }

    require 'DBconn.php';

    $viewChampionship = $_GET['champ_id'];



    //start - load the championship
    $sql = "SELECT * FROM tblChampionships " .
        "WHERE ChampionshipID = " . $viewChampionship;

    $result = mysqli_query($conn,$sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $ChampionshipID = $viewChampionship;
            $ChampionshipName = $row["ChampionshipName"];
            $ChampionshipYear = $row["ChampYear"];
        }
    }
    else {
        $ChampionshipName = "<br> Sorry, no championship found for champ_id = " . $viewChampionship;
        $ChampionshipYear = "";
    }    
    //end - load the championship

?>
<html lang="en">
<head>
  <meta charset="utf-8">
    <title>Cumberland AC - <?php echo $ChampionshipName . " " . $ChampionshipYear; ?></title>
    <meta name="description" content="Cumberland AC <?php echo $ChampionshipName . " " . $ChampionshipYear; ?>">
  <link rel="stylesheet" href="css/styles.css<?php echo "?date=" . date("Y-m-d_H-i"); ?>">

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]--> 
</head>
<body>
    <h1>Cumberland AC <?php echo $ChampionshipName . " " . $ChampionshipYear; ?></h1>
    <table>
<?php

function splitRunnerTimePoints($RaceIDTimePoints){
// function to split the runner times and points from the mysqli_multi_line query
    if(strlen($RaceIDTimePoints) < 5) {
        return "<td></td>\n";
    }
    else {
        $Pieces = explode("//",$RaceIDTimePoints);
        return "<td><div class=\"raceTime\" style='display:inline'>$Pieces[1]</div><div class=\"racePoints\" style='display:none'>$Pieces[2]</div></td>\n";
    }
}

        // the first switch block is for the sub-options
    switch($ChampionshipName) {
        case "Open Championship": {
            echo "<tr>\n<th>\n $ChampionshipName View \n</th>\n</tr>\n";
            echo "<tr>\n<td>\n Divisions \n</td>\n</tr>\n";
            echo "<tr>\n<td>\n Ladies \n</td>\n</tr>\n";
            echo "<tr>\n<td>\n Age Related \n</td>\n</tr>\n";
            break;
        }
        case "Multi-Terrain Challenge": // The case statement is set out like this because both of these have the same sub-options
        case "Short Championship": {
            echo "<tr>\n<th>\n $ChampionshipName View \n</th>\n</tr>\n";
            echo "<tr>\n<td>\n Men's \n</td>\n</tr>\n";
            echo "<tr>\n<td>\n Ladies \n</td>\n</tr>\n";
            break;
        }
        default: {
            echo "<tr>\n<th>\n No View Available \n</th>\n</tr>\n";
            echo "<tr>\n<td>\n <a href='index.php'>Click to Go Back</a>\n</td>\n</tr>\n";

            break;
        }
    }

    // the second switch block is for the table of races
    switch($ChampionshipName) {
        case "Open Championship": {
                echo "<table>\n<tr><th style='background-color:black;'></th>\n"; 

                $sql = "SELECT RaceID, RaceDate, RaceName, RaceCode FROM tblRaces " .
                "WHERE RaceDate BETWEEN '$ChampionshipYear-01-01' AND '$ChampionshipYear-12-31' " .
                "AND RaceCode IN (1,2,4,9) " .
                "ORDER BY field(RaceCode,1,9,2,4), RaceDate ASC";

                $result = mysqli_query($conn,$sql);
                
                // if it exists, empty the array of raceIDs
                unset($arrRaceIDs);
                

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

                        //create an array of raceIDs for later use
                        $arrRaceIDs[] = $row["RaceID"];
                        
                        // rearrange the race date from SQL format
                        $row["RaceDate"] = date("d-m-Y",strtotime($row["RaceDate"]));
                        // give the date '/' instead of '-'
                        $row["RaceDate"] = str_replace("-", "/", $row["RaceDate"]);
                        if($row["RaceCode"] == '1' || $row["RaceCode"] == '9')
                        {
                            echo "<th class='rotate'><div class='fntSprint'><span>" . $row["RaceDate"].
                            " - " . $row["RaceName"]. "</span></div></th>\n";
                        }
                        elseif($row["RaceCode"]=='2')
                        {
                            echo "<th class='rotate'><div class='fntMiddle'><span>" . $row["RaceDate"].
                            " - " . $row["RaceName"]. "</span></div></th>\n";
                        }
                        elseif($row["RaceCode"]=='4')
                        {
                            echo "<th class='rotate'><div class='fntLong'><span>" . $row["RaceDate"].
                            " - " . $row["RaceName"]. "</span></div></th>\n";
                        }
                    }
                } else {
                    echo "0 results";
                }

                echo "<th style='background-color:black;'></th>\n</tr>\n";
            
                // mysqli_close($conn);
            
                //select statement to get list of runnerIDs from tblOpenChampOverall, ordered by overall points  
                $sqlOCRunners = "SELECT DISTINCT tblOpenChampOverall.RunnerID,tblOpenChampOverall.OpenChampOverallPoints, tblRunners.RunnerFirstName, tblRunners.RunnerSurname FROM tblOpenChampOverall INNER JOIN tblRunners ON tblOpenChampOverall.RunnerID=tblRunners.RunnerID WHERE tblOpenChampOverall.ChampionshipID=1 ORDER BY OpenChampOverallPoints DESC";
            
                $result = mysqli_query($conn,$sqlOCRunners);

                $positionCounter=1;

                if(mysqli_num_rows($result) > 0)
                {
                    while($row = $result->fetch_assoc()) {
                        
                        $RunnerName = "(" . $positionCounter . ") " . $row['RunnerFirstName'] . " " . $row['RunnerSurname'];
                        // $RunnerID for the first row, $ChampPoints for the last row
                        $RunnerID = $row['RunnerID'];
                        $ChampPoints = $row['OpenChampOverallPoints'];
                        // once you have confirmed this works, add runner name to above select statement as well as RunnerID
                    
                        echo "\n<tr>\n<td>$RunnerName</td>\n";                

                        // procedure call for each runnerID, to return a list of raceIDs, times and points
                        $sqlLoadRunnerTimes = sprintf('SET @race_1=%1$s; SET @race_2=%2$s; SET @race_3=%3$s; SET @race_4=%4$s; SET @race_5=%5$s; SET @race_6=%6$s;
                        SET @race_7=%7$s; SET @race_8=%8$s; SET @race_9=%9$s; SET @race_10=%10$s; SET @race_11=%11$s; SET @race_12=%12$s;
                        SET @race_13=%13$s; SET @race_14=%14$s; SET @race_15=%15$s; SET @race_16=%16$s; SET @race_17=%17$s; SET @race_18=%18$s;
                        CALL proc_openChamp_runnerTimes(%19$s,@race_1, @race_2, @race_3, @race_4, @race_5, @race_6, @race_7, @race_8, @race_9, @race_10, @race_11, @race_12, @race_13, @race_14, @race_15, @race_16, @race_17, @race_18);', $arrRaceIDs[0], $arrRaceIDs[1], $arrRaceIDs[2], $arrRaceIDs[3], $arrRaceIDs[4], $arrRaceIDs[5], $arrRaceIDs[6], $arrRaceIDs[7], $arrRaceIDs[8], $arrRaceIDs[9], $arrRaceIDs[10], $arrRaceIDs[11], $arrRaceIDs[12], $arrRaceIDs[13], $arrRaceIDs[14], $arrRaceIDs[15], $arrRaceIDs[16], $arrRaceIDs[17],$RunnerID);

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
                        echo "\n<td>" . $ChampPoints . "</td>"; 
                        echo "\n</tr>\n";
                        
                        $positionCounter++;
                    }
                }
            
                //loop through the returned race times; If the variable is empty or NULL, then the procedure will an empty table cell '<td></td>', otherwise it will return a time and points for each race '<td><div1>45:00</div1><div2>95</div2></td>' 
            echo "\n</table>\n";
            break;
        }
        case "Short Championship": {
                echo "<table>\n<tr>\n"; 

                $sql = "SELECT * FROM tblRaces " .
                "WHERE RaceDate BETWEEN '$ChampionshipYear-01-01' AND '$ChampionshipYear-12-31' " .
                "AND RaceCode IN (8,9) " .
                "ORDER BY RaceDate ASC";

                $result = mysqli_query($conn,$sql);

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        // rearrange the race date from SQL format
                        $row["RaceDate"] = date("d-m-Y",strtotime($row["RaceDate"]));
                        // give the date '/' instead of '-'
                        $row["RaceDate"] = str_replace("-", "/", $row["RaceDate"]);

                        echo "<th class='rotate'><div class='fntShort'><span>" . $row["RaceDate"].
                        " - " . $row["RaceName"]. "</span></div></th>\n";
                    }
                } else {
                    echo "0 results";
                }
                // mysqli_close($conn);
            echo "\n</tr>\n</table>\n";
            break;            
        }
        case "Multi-Terrain Challenge": {
                echo "<table>\n<tr>\n"; 

                $sql = "SELECT * FROM tblRaces " .
                "WHERE RaceDate BETWEEN '$ChampionshipYear-01-01' AND '$ChampionshipYear-12-31' " .
                "AND RaceCode = 16 " .
                "ORDER BY RaceDate ASC";

                $result = mysqli_query($conn,$sql);

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        // rearrange the race date from SQL format
                        $row["RaceDate"] = date("d-m-Y",strtotime($row["RaceDate"]));
                        // give the date '/' instead of '-'
                        $row["RaceDate"] = str_replace("-", "/", $row["RaceDate"]);

                        echo "<th class='rotate'><div class='fntMultiTerrain'><span>" . $row["RaceDate"].
                        " - " . $row["RaceName"]. "</span></div></th>\n";
                    }
                } else {
                    echo "0 results";
                }
                // mysqli_close($conn);
            echo "\n</tr>\n</table>\n";
            break;            
        }
    }
?>
    </table>
<table>
    <tr>
        <td><a href="index.php">Back</a></td>
    </tr>
</table>
</body>
</html>
