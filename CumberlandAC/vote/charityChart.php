<?php
//SELECT VerifiedVote, tblcharities.CharityTitle, COUNT(*) as charityVotes FROM `tblcharityvotes` LEFT JOIN tblcharities ON tblcharityvotes.VerifiedVote = tblcharities.CharityID WHERE VerifiedVote IN (SELECT DISTINCT VerifiedVote FROM tblcharityvotes) GROUP BY VerifiedVote ORDER BY COUNT(*) DESC LIMIT 3
?>
<html>
	<head>
	  <style>
		table {
		  width: 500px;
		  border: none;
		  border-top: 1px solid #EEEEEE;
		  font-family: arial, sans-serif;
		  border-collapse: collapse;
		}

		td,
		th {
		  border: 1px solid #EEEEEE;
		  border-top: none;
		  text-align: left;
		  padding: 8px;
		  color: #363D41;
		  font-size: 14px;
		}

		tr {
		  background-color: #fff;
		  border: none;
		  cursor: pointer;
		  display: grid;
		  grid-template-columns: repeat(2, 1fr);
		  justify-content: flex-start;
		}

		tr:first-child:hover {
		  cursor: default;
		  background-color: #fff;
		}

		tr:hover {
		  background-color: #EEF4FD;
		}

		.expanded-row-content {
		  border-top: none;
		  display: grid;
		  grid-column: 1/-1;
		  justify-content: flex-start;
		  color: #AEB1B3;
		  font-size: 13px;
		  background-color: #fff;
		}

		.hide-row {
		  display: none;
		}
	  </style>
	</head>
	<body>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			google.charts.load("current", {packages:['corechart']});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart() {
			  var data = google.visualization.arrayToDataTable([
				["Charity", "Rank", { role: "style" } ]
<?php
	require '../DBconn.php';
	
	$sqlCharityByRank = "SELECT VerifiedVote AS charityID, " .
							   "tblcharities.CharityTitle AS charityTitle, " . 
							   "COUNT(*) as charityVotesCount " .
						"FROM tblcharityvotes " .
						"LEFT JOIN tblcharities " .
							"ON tblcharityvotes.VerifiedVote = tblcharities.CharityID " .
						"WHERE VerifiedVote IN " .
							"(SELECT DISTINCT VerifiedVote " .
							"FROM tblcharityvotes) " .
						"GROUP BY VerifiedVote " .
						"ORDER BY COUNT(*) DESC " .
						"LIMIT 3";
//print "//" . $sqlCharityByRank;

	$result = mysqli_query($conn,$sqlCharityByRank);
	$loopCount = 0;
	
	while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$loopCount = $loopCount + 1;
		
		if ($loopCount == 3) {
			$hexColour = '#b87333';
		}
		elseif ($loopCount == 2) {
			$hexColour = 'silver';
		}
		elseif ($loopCount == 1) {
			$hexColour = 'gold';
		}
		echo "\n, [\"" . $row['charityTitle'] . "\", " . $loopCount . ", \"" . $hexColour . "\"]" ;
	}	
				// ["GNAA", 8.94, "#b87333"],
				// ["Team Evie", 10.49, "silver"],
				// ["MIND", 19.30, "gold"],
				// ["NHS", 21.45, "color: #e5e4e2"]
			?>]);

			  var view = new google.visualization.DataView(data);
			  view.setColumns([0, 1,
							   { calc: "stringify",
								 sourceColumn: 1,
								 type: "string",
								 role: "annotation" },
							   2]);

			  var options = {
				title: "Cumberland AC Charity of the year, 2021 (top three)",
				width: 600,
				height: 400,
				bar: {groupWidth: "95%"},
				vAxis: {
					textPosition: "none",
				},
				legend: { position: "none" },
			  };
			  var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
			  chart.draw(view, options);
		  }
		</script>
		<div id="columnchart_values" style="width: 900px; height: 300px;"></div>
		
		
		<?php

		
		if (isset($_POST["whichForm"]))
		{

			// open connection to the database
			require '../DBconn.php';

			$charityVote = mysqli_real_escape_string($conn, htmlspecialchars($_POST["txtCharity"]));
			$email = mysqli_real_escape_string($conn, htmlspecialchars($_POST["txtEmail"]));

			if($_POST["whichForm"] == "firstForm")
			{

				$sql = "SELECT COUNT(*) AS emailFound FROM tblcharityvotes WHERE email = '" . $email . "'";
				
				// create the 4-digit random verification code
				$verificationCode = random_int(1000,9999);
				
				// prepare the email fields
				$to = $email;
				$subject = "Cumberland AC Validation Code - make your vote count!";
				$txt = "Hi, thanks for voting!"
					 . "<br><br> Make your vote count! Please enter your unique code <b>" . $verificationCode . "</b> into the text box on the Cumberland AC charity voting page";
				$headers = 'MIME-Version: 1.0' . "\r\n" .
						   'Content-type: text/html;charset=UTF-8' . "\r\n" .
						   'From: hello@pixeldistrict.co.uk' . "\r\n" .
						   'Bcc: my.pyne@gmail.com';
				
				// send the email
				mail($to,$subject,$txt,$headers);
			
				// check if email already exists in table
				$result = mysqli_query($conn,$sql);
				// Since there will always be exactly 1 row, fetch it.
				$row = mysqli_fetch_assoc($result);
				
				if ($row['emailFound'] >= 1) {
					//echo "Email already present";
					
					// since the email's already in there, add unverified vote and verification code here
					$sqlAddUnverifiedCode = "UPDATE tblcharityvotes " . 
											"SET VerificationCode=" . $verificationCode . ", " .
											"UnverifiedVote=" . $charityVote . ", " .
											"VerificationCodeSent='" . date("Y-m-d") . "' " . 
											"WHERE email = '" . $email . "'" ;
					
					if (mysqli_query($conn,$sqlAddUnverifiedCode) === TRUE) {
					// echo "Unverified vote and verification code added to email successfully";
					} else {
						echo "Error: <br><br>" . $conn->error . "<br><br> SQL String --> " . $sqlAddUnverifiedCode . " <--";
					}
				}
				if ($row['emailFound'] == 0) {
					// echo "Email doesn't exist yet";
					
					$sqlAddEmailCodeUnverifiedVote = "INSERT INTO tblcharityvotes (email, UnverifiedVote, VerificationCode, VerificationCodeSent)" . 
											"VALUES ('" . $email . "', " . 
											$charityVote . ", ".
											"" . $verificationCode . ", " .
											"'" . date("Y-m-d") . "')" ;
					
					if (mysqli_query($conn,$sqlAddEmailCodeUnverifiedVote) === TRUE) {
					// echo "Unverified vote, verification code and email added successfully";
					} else {
						echo "Error: <br><br>" . $conn->error . "<br><br> SQL String --> " . $sqlAddEmailCodeUnverifiedVote . " <--";
					}
				}
			
				

				print "<br><br><br><br><br>\n\n";
				print "<form id=\"secondForm\" name=\"secondForm\" method=\"POST\" action=\"charityChart.php\">\n\n";
				print "<br><br>Email: " . $email . "\n\n";
				displayCharity($charityVote);
				print "<input type=\"hidden\" id=\"txtEmail\" name=\"txtEmail\" value=\"" . $email . "\">\n\n";
				print "<input type = \"hidden\" id=\"whichForm\" name=\"whichForm\" value=\"secondForm\">\n\n";
				print "<input type = \"hidden\" id=\"txtCharity\" name=\"txtCharity\" value=\"" . $charityVote . "\">\n\n";
				print "<br><br><br>Please make your vote count! Check your emails and \n";
				print "<br><br>enter your 4-digit verification code here: <input type = \"text\" id=\"txtVerificationCode\" name=\"txtVerificationCode\" >\n\n";
				print "<br><br><input type=\"submit\" id=\"Submit\" name=\"Submit\" value=\"Confirm my vote\">\n\n";
				print "</form>\n\n";
			}
 			if($_POST["whichForm"] == "secondForm")
			{
				$verificationCode = mysqli_real_escape_string($conn, htmlspecialchars($_POST["txtVerificationCode"]));
				
				// code here to confirm verification code entered correctly (and unverified vote becomes verified vote with its own timestamp
				$sqlConfirmVerificationCode = "SELECT COUNT(*) AS codeFound " .
											  "FROM tblcharityvotes " .
											  "WHERE email = '" . $email . "' " .
											  "AND VerificationCode = " . $verificationCode;

				// check if email already exists in table
				$result = mysqli_query($conn,$sqlConfirmVerificationCode);
				// Since there will always be exactly 1 row, fetch it.
				$row = mysqli_fetch_assoc($result);
				
				if ($row['codeFound'] >= 1) {
					print "<br><br><br><br><br><br><br>Thanks! Your vote is verified\n\n";
					
					print "<br><br><a href='charityChart.php'>Click here</a> to refresh the chart\n\n";
					
					// function / routine to get charity (using id) and dispay it to the user to confirm their vote
					displayCharity($charityVote);
					
					// set up a new random code
					$verificationOverwrite = random_int(1000,9999);
					
					// set up unverified vote as a default number
					$unverifiedVote = 99;
					
					// set the verified vote
					$verifiedVote = $charityVote;
					
					// set the date verified
					$dateVerified = date("Y-m-d");
					
					// update the record with the verified details
					$sqlAddVerifiedVote = "UPDATE tblcharityvotes " . 
										  "SET VerificationCode=" . $verificationOverwrite . ", " .
										  "UnverifiedVote=" . $unverifiedVote . ", " .
										  "VerificationCodeSent='" . date("Y-m-d") . "', " . 
									      "VerifiedVote=" . $verifiedVote . ", " . 
										  "VoteVerifiedDate='" . $dateVerified . "' " .
										  "WHERE email = '" . $email . "'" ;
					
					if (mysqli_query($conn,$sqlAddVerifiedVote) === TRUE) {
					 // echo "Verified vote added to email successfully";
					 
					 // Post / Redirect / Get (PRG) code to avoid form resumbission
					 header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
					 exit();
					 
					} else {
						echo "Error: <br><br>" . $conn->error . "<br><br> SQL String --> " . $sqlAddVerifiedVote . " <--";
					}					
				}
			}
		}
		else
		{
			// if statement to check if this is a reloaded page with form details to process
			print "<br><br><br><br><br><br><br>\n\n";
			print "<form id=\"firstForm\" name=\"firstForm\" method=\"POST\" action=\"charityChart.php\">\n\n";
			print "<label for=\"txtCharity\">Vote for a charity:</label>\n\n";
			print "<select name=\"txtCharity\" id=\"txtCharity\">\n\n";
			print "<option value=\"1\">Copeland Citizens Advice</option>\n";
			print "<option value=\"2\">Every Life Matters</option>\n";
			print "<option value=\"3\">Hospice at Home West Cumbria</option>\n";
			print "<option value=\"4\">Team Evie</option>\n";
			print "</select>\n\n";
			print "<br>Email: <input type=\"text\" id=\"txtEmail\" name=\"txtEmail\">\n\n";
			print "<br><br><input type=\"submit\" id=\"Submit\" name=\"Submit\" value=\"Submit my vote\">\n\n";
			print "<input type = \"hidden\" id=\"whichForm\" name=\"whichForm\" value=\"firstForm\">\n\n";
			print "</form>\n\n";
		}

		

		
		/*
		Charts taken from Google Charts
		
		vote numbers are anonymised to the public by using its rank.
		(actual votes are available on a separate chart that contains all the nominated charities that is only available to admin)
		
		To protect against one person voting multiple times, users enter their email address. The site emails a random four-digit number for the vote to count.
		
		Once the code has been confirmed and entered into the database, the second random code takes its place in the unvalidated vote slot (to ensure the same code does not occupy both the validated and unvalidated columns)
		
		All email addresses will be deleted the day after the winning charity is announced
		*/
function displayCharity($CharityID) {
	require '../DBconn.php';
	
	$sqlLoadCharity = "SELECT CharityTitle FROM tblcharities WHERE CharityID = " . $CharityID;

	// get charity title
	$result = mysqli_query($conn,$sqlLoadCharity);
	
	// Since there will always be exactly 1 row, fetch it.
	$row = mysqli_fetch_assoc($result);
	
	print "<br><br>Charity: " . $row['CharityTitle'];

}

		?>
	<br><br>
	<h2>Read a little more about the charities here:</h2>
	  <table>
		<tr>
		  <th>Logo</th>
		  <th>Charity</th>
		</tr>
		<tr onClick='toggleRow(this)'>
		  <td><img src="img\CitAdv50px.png"/></td>
		  <td>Copeland Citizens Advice<br>(click for more)</td>
		  <td class='expanded-row-content hide-row'><img src="img\CitAdv150px.png" />Citizens Advice Copeland is an 
			independent charity which provides free, confidential, impartial, independent information and advice to
			people who live and work in the borough of Copeland and their rights and responsibilities.
			<br><br>For more info please visit:</td>
		</tr>
		<tr onClick='toggleRow(this)'>
		  <td><img src="img\EvyLfe50px.png" /></td>
		  <td>Every Life Matters<br>(click for more)</td>
		  <td class='expanded-row-content hide-row'><img src="img\EvyLfe150px.png" />Promoting Suicide Safer Communities
		  and providing Suicide Bereavement Support across Cumbria
		  <br><br>For more info please visit <a href="http://www.every-life-matters.org.uk">Every-Life-Matters.org.uk</a></td>
		</tr>
		<tr onClick='toggleRow(this)'>
		  <td><img src="img\HAtHme50px.png" /></td>
		  <td>Hospice at Home West Cumbria<br>(click for more)</td>
		  <td class='expanded-row-content hide-row'><img src="img\HAtHme150px.png" />Hospice at Home West Cumbria 
			provides high quality, palliative and end of life care to people living in West Cumbria. 
			<br><br>For more info please visit <a href="http://www.hospiceathomewestcumbria.org.uk">HospiceAtHomeWestCumbria.org.uk</a></td>
		</tr>

	  </table>

	  <script>
		const toggleRow = (element) => {
		  element.getElementsByClassName('expanded-row-content')[0].classList.toggle('hide-row');
		  console.log(event);
		}
	  </script>
	</body>
</html>