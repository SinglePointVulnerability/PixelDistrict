<?php
    include('session.php');
?>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Cumberland AC DB Admin</title>
  <meta name="description" content="Cumberland AC DB Admin - Add Runner">
  <meta name="author" content="West Coast Web Design">

  <link rel="stylesheet" href="css/styles.css<?php echo "?date=" . date("Y-m-d_H-i"); ?>">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
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
</head>
<body>
<form action="formPost.php" method="post">
    <br>
    <table>
        <tr>
            <th colspan="2">Add a new runner</th>
        </tr>
        <tr>
        </tr>
        <tr class="tblLabel">
            <td>First Name:</td>
            <td>Last Name:</td>
        </tr>
        <tr>
            <td><input type="text" name="txtRunnerFirstName" id="txtRunnerFirstName"></td>
            <td><input type="text" name="txtRunnerSurname" id="txtRunnerSurname"></td>
        </tr>
        <tr class="tblLabel">
            <td>Date of birth:</td>
            <td>Sex:</td>
        </tr>
        <tr>
            <td><input type="text" name="dteRunnerDOB" id="dteRunnerDOB"></td>
            <td>
                <select name="txtRunnerSex" id="txtRunnerSex">
                    <option value="F">Female</option>
                    <option value="M">Male</option>
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
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </td>
            <td>
                <select name="txtRunnerSubsPaid" id="txtRunnerSubsPaid">
                    <option value="N">No</option>
                    <option value="Y">Yes</option>
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
<input type="hidden" name="parentPage" id="parentPage" value="addRunner">
</form>
</body>
</html>