<?php
require('DBconn.php');

session_start();// Starting Session
// Storing Session
if(isset($_SESSION['login_user'])) {
    $user_check=$_SESSION['login_user'];    
}
else {
    $user_check='';
}

// to access archived championship records
if(isset($_GET['champYear'])) {
    $RaceYear = $_GET['champYear'];
}
else {
	// commented out to have manual year entry in session variable - mitigates year end bug of all race times disappearing
    //$RaceYear = date("Y");
	$RaceYear = 2021;
}   

// SQL Query To Fetch Complete Information Of User
$sql = "select username from login where username='$user_check'";

$result = mysqli_query($conn,$sql);
/* 2019-03-15: all '$conn-->query(' sections of code replaced with 'mysqli_query($conn,'*/

    if (mysqli_num_rows($result) > 0)
    {
        while($row = $result->fetch_assoc()) {
            $login_user = $row['username'];
            
            echo "<h1>Cumberland AC " . $RaceYear . "</h1>\n";            
            echo "<br>Logged in as: " . $login_user . "<br><br>";
            
            if(!isset($login_user)){
                mysqli_close($conn);   // Closing Connection
                echo "<h1>Cumberland AC " . $RaceYear . "</h1>\n";
                echo "<br><a href='CumberlandACLogin.php' class='txtLogin'>Admin Log In</a><br><br>";
                header('Location: CumberlandACLogin.php'); // Redirecting To Login Page
            }
        }
    }
    else
    {
        //if the user isn't logged in, display the link to the login page
        echo "<h1>Cumberland AC " . $RaceYear . "</h1>\n";
        echo "<br><a href='CumberlandACLogin.php' class='txtLogin'>Admin Log In</a><br><br>";
        //header('Location: CumberlandACLogin.php'); // Redirecting To Login Page
        
        $login_user = '';
    }
?>