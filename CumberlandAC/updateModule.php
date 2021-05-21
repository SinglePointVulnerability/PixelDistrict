<?php
    require 'DBconn.php';
    
    $var = $_GET["subsPaid"];
    $var2 = $_GET["rID"];

    $sql = "UPDATE tblRunners SET RunnerSubsPaid = \"" . $var . "\" WHERE RunnerID = $var2";

    $result = mysqli_query($conn,$sql);
?>