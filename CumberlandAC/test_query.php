<?php
        require "DBconn.php";
        //$sql = 'SELECT username FROM login';
        $sql = "SHOW GRANTS";

        mysqli_select_db($database);

        $result = mysqli_query($conn,$sql);
        
        if($result=mysqli_query($conn,$sql))
        {
            // Return the number of rows in result set
            $rowcount=mysqli_num_rows($result);
            printf("Result set has %d rows.\n",$rowcount);
            // Free result set
            mysqli_free_result($result);            
        }
        else {
            echo "Nothing returned from query";
        }
?>