<?php
//$host_name = 'db5000024162.hosting-data.io';
//$database = 'dbs19408';
//$user_name = 'name'; //'o19408';//'dbu28406';
//$password = 'temporarypassword1';

echo $host_name;
echo $user_name;

$conn = mysqli_connect($host_name, $user_name, $password, $database);

$sql = 'SELECT * FROM login';

echo $sql;

if (mysqli_errno()) {
    die('<p>Failed to connect to MySQL: '.mysqli_error().'</p>');
} else {
    echo '<p>Connection to MySQL server successfully established.</p >';
    
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
}
?>