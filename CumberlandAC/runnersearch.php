<?php
    require 'DBconn.php';

    $q = $_GET["q"];

    //start - load the championship
    $sql = "SELECT RunnerFirstName, RunnerSurname, RunnerID FROM tblRunners " .
        "WHERE RunnerFirstName LIKE '%{$q}%'";

    $result = mysqli_query($conn,$sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<a href='amendRunner.php?r=" . $row['RunnerID'] . "' style='color:white;'>";
            echo $row['RunnerFirstName'] . " " . $row['RunnerSurname'] . '</a><br>';
        }
    }
    else {
        echo "No suggestions";
    }  
?>