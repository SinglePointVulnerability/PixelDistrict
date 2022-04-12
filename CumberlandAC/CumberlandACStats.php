<?php
$sqlTopThreeMostPopularRaces = "SELECT tblRaceTimes.RaceID, tblRaces.RaceName, count(RaceTime) AS runner_count FROM tblRaceTimes INNER JOIN tblRaces ON tblRaceTimes.RaceID = tblRaces.RaceID WHERE tblRaces.ChampYear = " . $RaceYear . " GROUP BY RaceID ORDER BY runner_count DESC LIMIT 3";

$sqlMenAveragePace = "SELECT SEC_TO_TIME(AVG(1609.344/(tblRaces.RaceDist / TIME_TO_SEC(RaceTime)))) AS 'Average Pace' FROM tblRaceTimes INNER JOIN tblRaces ON tblRaceTimes.RaceID = tblRaces.RaceID INNER JOIN tblRunners ON tblRaceTimes.RunnerID = tblRunners.RunnerID WHERE tblRunners.RunnerSex = 'M' AND tblRaces.ChampYear = " . $RaceYear;

$sqlMenTotalDist = "SELECT (SUM(tblRaces.RaceDist)/1609.344) AS 'Total Distance' FROM tblRaceTimes INNER JOIN tblRaces ON tblRaceTimes.RaceID = tblRaces.RaceID INNER JOIN tblRunners ON tblRaceTimes.RunnerID = tblRunners.RunnerID WHERE tblRunners.RunnerSex = 'M' AND tblRaces.ChampYear = " . $RaceYear;

$sqlLadiesAveragePace = "SELECT SEC_TO_TIME(AVG(1609.344/(tblRaces.RaceDist / TIME_TO_SEC(RaceTime)))) AS 'Average Pace' FROM tblRaceTimes INNER JOIN tblRaces ON tblRaceTimes.RaceID = tblRaces.RaceID INNER JOIN tblRunners ON tblRaceTimes.RunnerID = tblRunners.RunnerID WHERE tblRunners.RunnerSex = 'F' AND tblRaces.ChampYear = " . $RaceYear;

$sqlLadiesTotalDist = "SELECT (SUM(tblRaces.RaceDist)/1609.344) AS 'Total Distance' FROM tblRaceTimes INNER JOIN tblRaces ON tblRaceTimes.RaceID = tblRaces.RaceID INNER JOIN tblRunners ON tblRaceTimes.RunnerID = tblRunners.RunnerID WHERE tblRunners.RunnerSex = 'F' AND tblRaces.ChampYear = " . $RaceYear;

$sqlRunnerStats = "SET @p0='0'; SET @p1='0'; SET @p2='0'; SET @p3='0'; SET @p4='0'; SET @p5='0'; SET @p6='0'; SET @p7='0'; SET @p8='0'; SET @p9='0'; SET @p10='0'; SET @p11='0'; SET @p12='0'; SET @p13='0'; SET @p14='0'; SET @p15='0'; SET @p16='0'; SET @p17='0'; SET @p18='0'; SET @p19='0'; SET @p20='0'; SET @p21='0'; SET @p22='0'; SET @p23='0'; SET @p24='0'; SET @p25='0'; SET @p26='0'; SET @p27='0'; SET @p28='0'; SET @p29='0'; SET @p30='" . $RaceYear . "';" .

"CALL proc_runner_stats(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12, @p13, @p14, @p15, @p16, @p17, @p18, @p19, @p20, @p21, @p22, @p23, @p24, @p25, @p26, @p27, @p28, @p29, @p30); " .

"SELECT @p0 AS 'paid_up_members', @p1 AS 'paid_up_members_div1', @p2 AS 'paid_up_members_div2', @p3 AS 'paid_up_members_div3', @p4 AS 'paid_up_members_div1_men', @p5 AS 'paid_up_members_div1_ladies', @p6 AS 'paid_up_members_div2_men', @p7 AS 'paid_up_members_div2_ladies', @p8 AS 'paid_up_members_div3_men', @p9 AS 'paid_up_members_div3_ladies', @p10 AS 'active_runners', @p11 AS 'active_runners_div1', @p12 AS 'active_runners_div2', @p13 AS 'active_runners_div3', @p14 AS 'active_runners_div1_men', @p15 AS 'active_runners_div1_ladies', @p16 AS 'active_runners_div2_men', @p17 AS 'active_runners_div2_ladies', @p18 AS 'active_runners_div3_men', @p19 AS 'active_runners_div3_ladies', @p20 AS 'inactive_runners', @p21 AS 'inactive_runners_div1', @p22 AS 'inactive_runners_div2', @p23 AS 'inactive_runners_div3', @p24 AS 'inactive_runners_div1_men', @p25 AS 'inactive_runners_div1_ladies', @p26 AS 'inactive_runners_div2_men', @p27 AS 'inactive_runners_div2_ladies', @p28 AS 'inactive_runners_div3_men', @p29 AS 'inactive_runners_div3_ladies';";


echo "<br><br><h3 id=\"statsHeader1\" class=\"statsHeader\">Cumberland AC Membership, " . $RaceYear . ":</h3>";

// show the runner stat's for the year
if (mysqli_multi_query($conn,$sqlRunnerStats))
{
    do{
        if($result2 = mysqli_store_result($conn)){
            while($row = mysqli_fetch_assoc($result2)){
                                                
                echo "<table><tr><th></th><th>Total</th><th>Division</th><th>Gender</th></tr>";
                echo "<tr><td rowspan='6'>Paid up members for " . $RaceYear . "</td>"; 
                echo "<td rowspan='6'>" . $row['paid_up_members'] . "</td>";
                echo "<td rowspan='2'>1) " . $row['paid_up_members_div1'] . "</td>";
                echo "<td>M) " . $row['paid_up_members_div1_men'] . "</td></tr>";
                echo "<tr><td>F) " . $row['paid_up_members_div1_ladies'] . "</td></tr>";
                echo "<tr><td rowspan='2'>2) " . $row['paid_up_members_div2'] . "</td>";
                echo "<td>M) " . $row['paid_up_members_div2_men'] . "</td></tr>";
                echo "<tr><td>F) " . $row['paid_up_members_div2_ladies'] . "</td></tr>";
                echo "<tr><td rowspan='2'>3) " . $row['paid_up_members_div3'] . "</td>";
                echo "<td>M) " . $row['paid_up_members_div3_men'] . "</td></tr>";
                echo "<tr><td>F) " . $row['paid_up_members_div3_ladies'] . "</td></tr>";
                                                
                echo "<tr><td rowspan='6'>Runners who've raced in " . $RaceYear . "</td>"; 
                echo "<td rowspan='6'>" . $row['active_runners'] . "</td>";
                echo "<td rowspan='2'>1) " . $row['active_runners_div1'] . "</td>";
                echo "<td>M) " . $row['active_runners_div1_men'] . "</td></tr>";
                echo "<tr><td>F) " . $row['active_runners_div1_ladies'] . "</td></tr>";
                echo "<tr><td rowspan='2'>2) " . $row['active_runners_div2'] . "</td>";
                echo "<td>M) " . $row['active_runners_div2_men'] . "</td></tr>";
                echo "<tr><td>F) " . $row['active_runners_div2_ladies'] . "</td></tr>";
                echo "<tr><td rowspan='2'>3) " . $row['active_runners_div3'] . "</td>";
                echo "<td>M) " . $row['active_runners_div3_men'] . "</td></tr>";
                echo "<tr><td>F) " . $row['active_runners_div3_ladies'] . "</td></tr>";

                echo "<tr><td rowspan='6'>Runners who haven't raced in " . $RaceYear . "</td>"; 
                echo "<td rowspan='6'>" . $row['inactive_runners'] . "</td>";
                echo "<td rowspan='2'>1) " . $row['inactive_runners_div1'] . "</td>";
                echo "<td>M) " . $row['inactive_runners_div1_men'] . "</td></tr>";
                echo "<tr><td>F) " . $row['inactive_runners_div1_ladies'] . "</td></tr>";
                echo "<tr><td rowspan='2'>2) " . $row['inactive_runners_div2'] . "</td>";
                echo "<td>M) " . $row['inactive_runners_div2_men'] . "</td></tr>";
                echo "<tr><td>F) " . $row['inactive_runners_div2_ladies'] . "</td></tr>";
                echo "<tr><td rowspan='2'>3) " . $row['inactive_runners_div3'] . "</td>";
                echo "<td>M) " . $row['inactive_runners_div3_men'] . "</td></tr>";
                echo "<tr><td>F) " . $row['inactive_runners_div3_ladies'] . "</td></tr>";
                                                
                echo "</table>";
            }
            mysqli_free_result($result2);
        }
    
        if(mysqli_more_results($conn)) {
            //printf("\n");
        }
        
    } while(mysqli_more_results($conn) && mysqli_next_result($conn));
}
else {
    echo $sqlRunnerStats;;
}

    // Show the three most popular races of the year so far
    echo "<div id=\"statsPopularRaces\" class=\"statsText\">";

    $counter = 0;
    if(mysqli_multi_query($conn,$sqlTopThreeMostPopularRaces))
    {
        do{
            if($result=mysqli_store_result($conn)){
                echo "<h3 id=\"statsHeader2\" class=\"statsHeader\">The three most popular races in " . $RaceYear . ":</h3><br>";
                while($row=mysqli_fetch_assoc($result)){
                    $counter++;
                    
                    echo "$counter) <b><u>" . $row['RaceName'] . "</u></b> with <b>" . $row['runner_count'] . "</b> Cumberland AC runners taking part <br>";
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "No race times have been recorded in" . $RaceYear;
    }

    echo "</div>";

echo "<br><br><h3 id=\"statsHeader3\" class=\"statsHeader\">Cumberland AC Live Runner Stat's, " . $RaceYear . ":</h3>";

echo "<div id=\"statsAveragePace\" class=\"statsText\">";

// Show the average male pace for the current year
    if(mysqli_multi_query($conn,$sqlMenAveragePace))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    echo "<br>In " . $RaceYear . ", Cumberland AC men have recorded an average race pace of " . substr($row['Average Pace'], 3, 5) . " /mile";             
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "No average male pace available: No men have recorded a race in " . $RaceYear;
    }

// Show the total distance men have raced for the current year
    if(mysqli_multi_query($conn,$sqlMenTotalDist))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    echo " over " . number_format($row['Total Distance'], 2, '.',',') . " miles";             
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "No total male distance ran: No men have recorded a race in " . $RaceYear;
    }

// Show the average ladies pace for the current year
    if(mysqli_multi_query($conn,$sqlLadiesAveragePace))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    echo "<br>In " . $RaceYear . ", Cumberland AC ladies have recorded an average race pace of " . substr($row['Average Pace'], 3, 5) . " /mile";             
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "No average female pace available: No ladies have recorded a race in " . $RaceYear;
    }

// Show the total distance women have raced for the current year
    if(mysqli_multi_query($conn,$sqlLadiesTotalDist))
    {
        do{
            if($result=mysqli_store_result($conn)){
                while($row=mysqli_fetch_assoc($result)){
                    echo " over " . number_format($row['Total Distance'], 2, '.',',') . " miles";             
                }
                mysqli_free_result($result);
            }
            if(mysqli_more_results($conn)) {
                // do nothing
            }
        } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    }
    else {
        echo "No total female distance ran: No ladies have recorded a race in " . $RaceYear;
    }

    echo "</div>";
?>