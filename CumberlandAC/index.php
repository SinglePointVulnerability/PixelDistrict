<?php
    include('session.php');
?>
<html lang="en">
<?php
    // to access archived championship records
    if(isset($_GET['champYear'])) {
        $RaceYear = $_GET['champYear'];
    }
    else {
		// commented out to have manual year entry in session variable - mitigates year end bug of all race times disappearing
		//$RaceYear = date("Y");
		$RaceYear = 2021;
    }    
?>
    <head>
      <meta charset="utf-8">

      <title>Cumberland AC <?php echo $RaceYear;?></title>
      <meta name="description" content="Cumberland AC Championship <?php echo $RaceYear;?>">
      <meta name="author" content="West Coast Web Design">

      <link rel="stylesheet" href="css/styles.css<?php echo "?date=" . date("Y-m-d_H-i"); ?>">

      <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
      <![endif]-->
    </head>

    <body>
        <div id="tab-wrapper" class="tab-wrapper">
            <?php
                if($RaceYear==2019){
                    echo "<div id=\"tab-selected\" class=\"orangePaperTabSelected\"><a href=\"index.php?champYear=2019\">2019</a></div>" . 
                        "<div id=\"tab-unselected\" class=\"orangePaperTabUnselected\"><a href=\"index.php?champYear=2018\">2018</a></div>";
                }
                if($RaceYear==2018){
                    echo "<div id=\"tab-selected\" class=\"orangePaperTabUnselected\"><a href=\"index.php?champYear=2019\">2019</a></div>" . 
                        "<div id=\"tab-unselected\" class=\"orangePaperTabSelected\"><a href=\"index.php?champYear=2018\">2018</a></div>";
                }
            ?>
        </div>
        <div id="orangePaperBackground" class="orangePaperBackground">
    <?php
        //check which user is logged in and tailor the layout accordingly
        if($user_check=="admin")
        {
    ?>
            <table>
                <tr>
                    <th>Action</th>
                </tr>
                <tr>
                    <td><a href="addRace.php">Add a new race</a></td>
                </tr>
                <tr>
                    <td><a href="addRunner.php">Add a new runner</a></td>
                </tr>
                <tr>
                    <td><a href="addRaceTime.php">Add a race time</a></td>
                </tr>
                <tr>
                    <td><hr/></td>
                </tr>
                <tr>
                    <td>Change details</td>
                </tr>
                <tr>
                    <td><a href="amendRunner.php?champYear=<?php echo $RaceYear; ?>">Change runner details</a></td>
                </tr>
                <tr>
                    <td><a href="updateRunnersSubsPaid.php?champYear=<?php echo $RaceYear; ?>">Check if runner subs are marked as paid</a></td>
                </tr>
                <tr>
                    <td>Change race time</td>
                </tr>
                <tr>
                    <td><hr/></td>
                </tr>
                <tr>
                    <td><a href="viewRacesOCDivs_new_v1.php?champYear=<?php echo $RaceYear; ?>">See Open Championship Results</a></td>
                </tr>
                <tr>
                    <td><a href="viewRacesOCLadies.php?champYear=2018">See Open Championship Ladies Results (2018 ONLY)</a></td>
                </tr>
                <tr>
                    <td><a href="viewRacesOCWMA_new_v1.php?champYear=<?php echo $RaceYear; ?>">See Open Championship MASTERS Results</a></td>
                </tr>
                <tr>
                    <td><a href="viewRacesSCDivs_new_v1.php?champYear=<?php echo $RaceYear; ?>">See Short Championship Results</a></td>
                </tr>
                <tr>
                    <td><a href="viewRacesMTChall_new_v1.php?champYear=<?php echo $RaceYear; ?>">See Multi-Terrain Challenge Results</a></td>
                </tr>
                <tr>
                    <td><hr/></td>
                </tr>
                <tr>
                    <td><a href="logout.php?champYear=<?php echo $RaceYear; ?>">Log Out</a></td>
                </tr>
            </table>
        <?php
            }
            elseif($user_check=="club_stat")
            {
        ?>
            <table>
                <tr>
                    <th>Action</th>
                </tr>
                <tr>
                    <td><a href="addRaceTime.php">Add a race time</a></td>
                </tr>
                <tr>
                    <td><hr/></td>
                </tr>
                <tr>
                    <td>Change details</td>
                </tr>
                <tr>
                    <td><a href="amendRunner.php?champYear=<?php echo $RaceYear; ?>">Change runner details</a></td>
                </tr>
                <tr>
                    <td><a href="updateRunnersSubsPaid.php?champYear=<?php echo $RaceYear; ?>">Check if runner subs are marked as paid</a></td>
                </tr>
                <tr>
                    <td><hr/></td>
                </tr>
                <tr>
                    <td><a href="viewChamps.php?champYear=<?php echo $RaceYear; ?>?champ_id=1">See Open Championship Races</a></td>
                </tr>
                <tr>
                    <td><a href="viewRacesOCDivs_new_v1.php?champYear=<?php echo $RaceYear; ?>">See Open Championship Results</a></td>
                </tr>
                <tr>
                    <td><a href="viewRacesOCWMA_new_v1.php?champYear=<?php echo $RaceYear; ?>">See Open Championship MASTERS Results</a></td>
                </tr>
                <tr>
                    <td><a href="viewRacesOCLadies.php?champYear=2018">See Open Championship Ladies Results (2018 ONLY)</a></td>
                </tr>
                <tr>
                    <td><a href="viewRacesSCDivs_new_v1.php?champYear=<?php echo $RaceYear; ?>">See Short Championship Results</a></td>
                </tr>
                <tr>
                    <td><a href="viewRacesMTChall_new_v1.php?champYear=<?php echo $RaceYear; ?>">See Multi-Terrain Challenge Results</a></td>
                </tr>
                <tr>
                    <td><hr/></td>
                </tr>
                <tr>
                    <td><a href="logout.php?champYear=<?php echo $RaceYear; ?>">Log Out</a></td>
                </tr>
            </table>
        <?php
            }
            else
            {
/*             <table>
                <tr>
                    <th>Cumberland AC Presentation Dinner</th>
                </tr>
                <tr>
                    <td><a href="presentationDinnerBooking.php"><b>Click here</b> to book your meal for Sat 25th Jan, 2020</a></td>
                </tr>
            </table>
            <br />
            <br /> */
		?>
            <table>
                <tr>
                    <th>View Championships</th>
                </tr>
                <tr>
                    <td>2021 Alternative Club Championship</td>
                </tr>
                <tr>
                    <td>
                        <ul>
                            <li><a href="viewRacesOCDivs_new_v1.php?champYear=<?php echo $RaceYear; ?>">Open Championship - Division 1/2/3</a></li>
                            <li><a href="viewRacesOCWMA_new_v1.php?champYear=<?php echo $RaceYear; ?>">Open Championship - MASTERS</a></li>
		<?php
                            // <li><a href="viewRacesOCLadies.php?champYear=2018">Open Championship - Ladies (2018 ONLY)</a></li>
		?>
                        </ul>
                    </td>
                </tr>
		<?php
/*                 <tr>
                    <td>Short Championship</td>
                </tr>
                <tr>
                    <td>
                        <ul>
                            <li><a href="viewRacesSCDivs_new_v1.php?champYear=<?php echo $RaceYear; ?>">Short Championship - Male/Female</a></li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Multi-Terrain Challenge</td>
                </tr>
                <tr>
                    <td>
                        <ul>
                            <li><a href="viewRacesMTChall_new_v1.php?champYear=<?php echo $RaceYear; ?>">Multi-Terrain Challenge - Male/Female</a></li>
                        </ul>
                    </td>
                </tr> */
		?>
            </table>
    <?php
        }

        include("CumberlandACStats.php");
    ?>
        </div>
    </body>
</html>