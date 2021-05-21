<?php
    session_start();// Starting Session
    // Storing Session
    $user_check=$_SESSION['login_user'];

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
                echo "<table>\n<tr>\n"; 

                $sql = "SELECT * FROM tblRaces " .
                "WHERE RaceDate BETWEEN '$ChampionshipYear-01-01' AND '$ChampionshipYear-12-31' " .
                "AND RaceCode IN (1,2,4,9) " .
                "ORDER BY field(RaceCode,1,9,2,4), RaceDate ASC";

                $result = mysqli_query($conn,$sql);

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {


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
                // mysqli_close($conn);
            echo "\n</tr>\n</table>\n";
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
</body>
</html>
