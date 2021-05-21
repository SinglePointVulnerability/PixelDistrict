<?php
    $url=strtok($_SERVER["REQUEST_URI"],'?');

    // to access archived championship records
    if(isset($_GET['champYear'])) {
        $RaceYear = $_GET['champYear'];
    }
    else {
        $RaceYear = date("Y");
    }
?>
<div class='tblNavBar'>
    <table>
        <tr>
            <td><div class='fontSeeRacePoints'><a href="<?php echo $url; ?>?display=points&champYear=<?php echo $RaceYear; ?>">SEE RACE POINTS</a></div></td>
            <td><div class='fontSeeRaceTimes'><a href="<?php echo $url; ?>?display=times&champYear=<?php echo $RaceYear; ?>">SEE RACE TIMES</a></div></td>
            <td><div class='fontSeeArchive'><a href="<?php echo $url; ?>?display=times&champYear=2018">SEE 2018</a></div></td>
            <td><div class='fontBack'><a href="index.php?champYear=<?php echo $RaceYear; ?>">BACK</a></div></td>
        </tr>
    </table>
</div>