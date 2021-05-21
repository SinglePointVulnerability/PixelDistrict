<?php
    include('session.php');
?>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Cumberland AC DB Admin</title>
  <meta name="description" content="Cumberland AC DB Admin - Amend Runner">
  <meta name="author" content="West Coast Web Design">

  <link rel="stylesheet" href="css/styles.css<?php echo "?date=" . date("Y-m-d_H-i"); ?>">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!--<link rel="stylesheet" href="/resources/demos/style.css"> -->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  <!--http://jqueryui.com/datepicker/ -->
  $( function() {
    $( "#dteRunnerDOB" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: "yy-mm-dd"
    });
  } );
  <!--http://jqueryui.com/datepicker/ -->
  </script>
    
  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
<script>
function showResult(str) {
  if (str.length==0) { 
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML=this.responseText;
      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","runnersearch.php?q="+str,true);
  xmlhttp.send();
}
</script>
</head>
<body>    
<?php    
    require 'DBconn.php';

    if(isset($_GET["r"])) {
        $r = $_GET["r"];
        
        $sql = "SELECT * FROM tblRunners WHERE RunnerID=$r";
        $result = mysqli_query($conn,$sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $RunnerID = $row["RunnerID"];
                $RunnerFirstName = $row["RunnerFirstName"];
                $RunnerSurname = $row["RunnerSurname"];
                $RunnerDiv = $row["RunnerDiv"];
                $RunnerSubsPaid = $row["RunnerSubsPaid"];
                $RunnerDOB = $row["RunnerDOB"];
                $RunnerSex = $row["RunnerSex"];
            }
        } else {
            echo "No results";
        }
        mysqli_close($conn);    
    }
    else {
        $r='';
    }  
?>
<form action="formPost.php" method="post">
Search by first name: <input type="text" size="30" onkeyup="showResult(this.value)">
<div id="livesearch"></div>

    
    <br>
    <br>
    <table>
        <tr>
            <th colspan="2">Change runner details</th>
        </tr>
        <tr>
        </tr>
        <tr class="tblLabel">
            <td>First Name:</td>
            <td>Last Name:</td>
        </tr>
        <tr>
            <td><input type="text" name="txtRunnerFirstName" id="txtRunnerFirstName" value="<?php echo $RunnerFirstName; ?>"></td>
            <td><input type="text" name="txtRunnerSurname" id="txtRunnerSurname" value="<?php echo $RunnerSurname; ?>"></td>
        </tr>
        <tr class="tblLabel">
            <td>Date of birth:</td>
            <td>Sex:</td>
        </tr>
        <tr>
            <td><input type="text" name="dteRunnerDOB" id="dteRunnerDOB" value="<?php echo $RunnerDOB; ?>"></td>
            <td>
                <select name="txtRunnerSex" id="txtRunnerSex">
                    <option value='M' <?php if($RunnerSex=="M") { echo "selected"; } ?> >Male</option>
                    <option value='F' <?php if($RunnerSex=="F") { echo "selected"; } ?> >Female</option>
                </select>
            </td>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr class="tblLabel">
            <td>Runner Division:</td>
            <td>Club sub's paid?:</td>
        </tr>
        <tr>
            <td>
                <select name="intRunnerDivision" id="intRunnerDivision">
                    <option value="1" <?php if($RunnerDiv==1) { echo 'selected'; } ?> >1</option>
                    <option value="2" <?php if($RunnerDiv==2) { echo 'selected'; } ?> >2</option>
                    <option value="3" <?php if($RunnerDiv==3) { echo 'selected'; } ?> >3</option>
                </select>
            </td>
            <td>
                <select name="txtRunnerSubsPaid" id="txtRunnerSubsPaid">
                    <option value="N" <?php if($RunnerSubsPaid=='N') { echo 'selected'; } ?> >No</option>
                    <option value="Y" <?php if($RunnerSubsPaid=='Y') { echo 'selected'; } ?> >Yes</option>
                </select>
            </td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td><a href="index.php">Back</a></td>
            <td><input type="submit" name="submitRunnerUpdate" id="submitRunnerUpdate"></td>
        </tr>
    </table>
<input type="hidden" name="parentPage" id="parentPage" value="amendRunner">
<input type="hidden" name="intRunnerID" id="intRunnerID" value="<?php echo $RunnerID; ?>">
</form>
</body>
</html>