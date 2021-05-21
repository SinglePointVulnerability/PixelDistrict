<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message



if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "Username or Password is invalid";
    }
    else
    {
        // Define $notRootUsername and $notRootPassword
        $notRootUsername=$_POST['username'];
        $notRootPassword=$_POST['password'];
        // Establishing Connection with Server by passing server_name, user_id and password as a parameter
        
        //REMEMBER the different connection requirement for online server versus local server
        require 'DBconn.php'; // online
        // require 'DBconn.php'; // local
        
        //$connection = mysql_connect("localhost", "root", "");
        // To protect MySQL injection for Security purpose

        $notRootUsername = stripslashes($notRootUsername);
        $notRootPassword = stripslashes($notRootPassword);

        //$notRootUsername = mysqli_real_escape_string($conn, $notRootUsername);
        //$notRootPassword = mysqli_real_escape_string($conn, $notRootPassword);

        // SQL query to fetch information of registerd users and finds user match.
        $sql = "SELECT * FROM login WHERE password='" . $notRootPassword . "' AND username='" . $notRootUsername . "'";
        /*$sql = "SELECT * FROM login";*/
        
        $result = mysqli_query($conn,$sql);
        
        if($result=mysqli_query($conn,$sql))
        {
            // Return the number of rows in result set
            $rowcount=mysqli_num_rows($result);
            // printf("Result set has %d rows.\n",$rowcount);
            // Free result set
            mysqli_free_result($result);            
        }
        
        //echo $sql;
        
        if ($rowcount == 1) {
            $_SESSION['login_user']=$notRootUsername; // Initializing Session
            header("location: index.php"); // Redirecting To Other Page
        }
        else {
            $error = "Username or Password is invalid - 2";
        }
            mysqli_close($conn); // Closing Connection
    }
}
?>