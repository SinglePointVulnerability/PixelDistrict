<?php
    include('session.php');
?>
<?php
	// open connection to the database
	require 'DBconn.php';
		
	/// collect value of input field
	$email = $_POST["txtEmail"];
	$opt1 = $_POST["txtTotOpt1"];
	$opt2 = $_POST["txtTotOpt2"];
	$opt3 = $_POST["txtTotOpt3"];
	$opt4 = $_POST["txtTotOpt4"];
	$opt5 = $_POST["txtTotOpt5"];
	$opt6 = $_POST["txtTotOpt6"];
	$opt7 = $_POST["txtTotOpt7"];
	$opt8 = $_POST["txtTotOpt8"];
	$opt9 = $_POST["txtTotOpt9"];
	$opt10 = $_POST["txtTotOpt10"];
	$opt11 = $_POST["txtTotOpt11"];
	$opt12 = $_POST["txtTotOpt12"];
	$notes = htmlspecialchars($_POST["txtOrderNotes"]);
	$name = htmlspecialchars($_POST["txtOrderName"]);
	$sendOrderStats = htmlspecialchars($_POST["txtDistributeStats"]);
	
	$bookingQuantities = str_pad( $opt1, 2, '0', STR_PAD_LEFT );
	$bookingQuantities .= "-" . str_pad( $opt2, 2, '0', STR_PAD_LEFT );
	$bookingQuantities .= "-" . str_pad( $opt3, 2, '0', STR_PAD_LEFT );
	$bookingQuantities .= "-" . str_pad( $opt4, 2, '0', STR_PAD_LEFT );
	$bookingQuantities .= "-" . str_pad( $opt5, 2, '0', STR_PAD_LEFT );
	$bookingQuantities .= "-" . str_pad( $opt6, 2, '0', STR_PAD_LEFT );
	$bookingQuantities .= "-" . str_pad( $opt7, 2, '0', STR_PAD_LEFT );
	$bookingQuantities .= "-" . str_pad( $opt8, 2, '0', STR_PAD_LEFT );
	$bookingQuantities .= "-" . str_pad( $opt9, 2, '0', STR_PAD_LEFT );
	$bookingQuantities .= "-" . str_pad( $opt10, 2, '0', STR_PAD_LEFT );
	$bookingQuantities .= "-" . str_pad( $opt11, 2, '0', STR_PAD_LEFT );
	$bookingQuantities .= "-" . str_pad( $opt12, 2, '0', STR_PAD_LEFT );
 
	// prepare the email fields
	$to = $email;
	$subject = "Your Order Confirmation for the Cumberland AC Presentation Night Dinner, 2022!";
	$txt = "Hi $name,\n<br><br>\nThanks for your order!\n<br><br>\n";
	$txt .= "As a quick reminder, here's what you chose:\n<br><br>\n";
	$secondStamp = time();
	
		if($opt1 > 0) { $txt .= "Homemade Vegetable, Lentil and Bacon Soup x " . $opt1 . "\n<br>\n"; }
		if($opt2 > 0) { $txt .= "Chicken and Chorizo Ballontine x " . $opt2 . "\n<br>\n"; }
		if($opt3 > 0) { $txt .= "Melon and Pineapple Carpaccio x " . $opt3 . "\n<br>\n"; }
		if($opt4 > 0) { $txt .= "Smoked Salmon Rosette x " . $opt4 . "\n<br>\n"; }
		if($opt5 > 0) { $txt .= "Roast Sirloin of Beef x " . $opt5 . "\n<br>\n"; }
		if($opt6 > 0) { $txt .= "Chicken Breast x " . $opt6 . "\n<br>\n"; }
		if($opt7 > 0) { $txt .= "Grilled Seabass x " . $opt7 . "\n<br>\n"; }
		if($opt8 > 0) { $txt .= "Wild Mushroom Risotto x " . $opt8 . "\n<br>\n"; }
		if($opt9 > 0) { $txt .= "Bread and Butter Pudding x " . $opt9 . "\n<br>\n"; }
		if($opt10 > 0) { $txt .= "Chocolate Brownie x " . $opt10 . "\n<br>\n"; }
		if($opt11 > 0) { $txt .= "Lemon Cheesecake x " . $opt11 . "\n<br>\n"; }
		if($opt12 > 0) { $txt .= "Fruit Salad x " . $opt12 . "\n<br>\n"; }
		if($notes <> "") { $txt .= "<br><br>\nAdditional Notes:\n<br>\n" . htmlspecialchars_decode($notes) . "\n<br>\n"; }
		$txt .= "<br><br>If you want to change your order, simply click <a href=\"http://www.pixeldistrict.co.uk/CumberlandAC/presentationDinnerBooking.php?orderCode=";
		$txt .= $secondStamp . "\">this link</a> and send in another order under the same email address.\n<br><br>\n";
	$headers = 'MIME-Version: 1.0' . "\r\n" .
			   'Content-type: text/html;charset=UTF-8' . "\r\n" .
			   'From: hello@pixeldistrict.co.uk' . "\r\n" .
			   'Bcc: my.pyne@gmail.com';
	
	if($email <> "") {
		mail($to,$subject,$txt,$headers);
		
		$sql = "INSERT INTO tblPresentationDinnerBookings (BookingName, BookingEmail, BookingCode, BookingQuantities, BookingNotes) " .
			"VALUES ('" . mysqli_real_escape_string($conn, $name) . "', " .
			"'" . $email . "', " .
			$secondStamp . ", " .
			"'" . $bookingQuantities . "', " .
			"'" . mysqli_real_escape_string($conn, $notes) . "')";
		
		if (mysqli_query($conn,$sql) === TRUE) {
			//Order added
		}
		else {
			$to = "my.pyne@gmail.com";
			$subject = "ERROR - CAC Pred Night Dinner, 2022";
			$txt = "SQL ERROR: ". $conn->error;
			$headers = 'MIME-Version: 1.0' . "\r\n" .
		   'Content-type: text/html;charset=UTF-8' . "\r\n" .
		   'From: hello@pixeldistrict.co.uk' . "\r\n";
		   
		   mail($to, $subject, $txt, $headers);
			
		}
		$bookingConfirmation = "Thanks, your booking's been saved and we've sent an email to " . $email . " to confirm :)";
		
	}
	if($sendOrderStats == "true") {
		$email = "my.pyne@gmail.com";
		$subject = "Cumberland AC Presentation Night Online Orders";
		$headers = 'MIME-Version: 1.0' . "\r\n" .
				   'Content-type: text/html;charset=UTF-8' . "\r\n" .
				   'From: hello@pixeldistrict.co.uk' . "\r\n" .
				   'Bcc: my.pyne@gmail.com';
		$sql =  "SELECT t1.BookingName
	,t1.BookingEmail
	,t1.BookingQuantities
	,t1.BookingNotes
FROM tblPresentationDinnerBookings t1
INNER JOIN (
	SELECT DISTINCT BookingName
		,MAX(BookingCode) AS maxBookingCode
	FROM tblPresentationDinnerBookings
	GROUP BY BookingName
	) t2 ON t1.BookingCode = t2.maxBookingCode
ORDER BY t1.BookingName";

		$txt = "<table>\n";
		$txt .= "<tr><th>Booking Name</th><th>Booking Email</th><th>Booking Quantities</th><th>Booking Notes</th></tr>\n";
		// Get the online orders
		if(mysqli_multi_query($conn,$sql))
		{
			do{
				if($result=mysqli_store_result($conn)){
					while($row=mysqli_fetch_assoc($result)){
						$txt .= "<tr>\n<td>\n" . $row["BookingName"] . "</td>\n<td>\n" . $row["BookingEmail"] . "</td>\n<td>\n" . $row["BookingQuantities"] . "</td>\n<td>\n" . $row["BookingNotes"] . "</td>\n</tr>\n";
					}
					mysqli_free_result($result);
				}
				if(mysqli_more_results($conn)) {
					// do nothing
				}
			} while(mysqli_more_results($conn) && mysqli_next_result($conn));
		}
		else {
			echo "Oops! I had a problem retrieving order details for the Presentation Night Dinner\n<br>\n";
		}

		$txt .= "</table>\n";

		mail($email, $subject, $txt, $headers);
	}

	$dtDropDeadDate = date_create('2022-01-23');
?>
<html lang="en">
    <head>
      <meta charset="utf-8">

      <title>Cumberland AC Presentation Dinner 2022</title>
      <meta name="description" content="Cumberland AC ">
      <meta name="author" content="West Coast Web Design">

      <link rel="stylesheet" href="css/styles.css<?php echo "?date=" . date("Y-m-d_H-i"); ?>">

      <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
      <![endif]-->
    <style>
		img {
			max-width: 100%;
			max-height: 100%;
		}
		.menuArea {
			background-image: url("images/2022CACMenu_Large.png");
			background-size: cover;
			width: 800px;
			height: 1200px;
			display: grid;
			grid-template-rows: 370px repeat(4, 51px) 98px repeat(4, 51px) 96px repeat(4, 51px);
			text-align: right;
		}
		.belowMenu {
				width: 800px;
				display: grid;
				text-align: right;
		}
		.labelText {
			width: 400px;
		}
		input[type=number] {
			/* Firefox */
			-moz-appearance: textfield;
			width: 20px;
		}
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			/* Chrome, Safari, Edge, Opera */
			-webkit-appearance: none;
			margin: 0;
		}
	</style>
	</head>

    <body>
<?php
	if($bookingConfirmation <> "") {
		print "\n<br><br>\n" . $bookingConfirmation . "\n<br><br>\n";
	}
	if(date('Y-m-d') > date_format($dtDropDeadDate,'Y-m-d')) {
		print "\n<br><br><h3>\n Sorry, no more online foood orders after " . date_format($dtDropDeadDate,'l jS \of F')  . ".</h3>\n<br>\n<b>Save Order</b> button has been disabled.<br><br>\n";
	}
	else {
		print "\n<br><br>\n<h3>Last day for online food orders is <u>" . date_format($dtDropDeadDate,'l jS \of F')  . "</u>.</h3><br><br>\n";
	}
?>
		<form id="formMenu" name="formMenu" action="#">
			<div class="menuArea">
				<div></div>
				<div><input type = "button" value="-" id="btnDecOpt1" name="btnDecOpt1" class="btnDec"><input type="number" id="txtTotOpt1" name="txtTotOpt1" value = "0"><input type = "button" value="+" id="btnIncOpt1" name="btnIncOpt1" class="btnInc"></div>
				<div><input type = "button" value="-" id="btnDecOpt2" name="btnDecOpt2" class="btnDec"><input type="number" id="txtTotOpt2" name="txtTotOpt2" value = "0"><input type = "button" value="+" id="btnIncOpt2" name="btnIncOpt2" class="btnInc"></div>
				<div><input type = "button" value="-" id="btnDecOpt3" name="btnDecOpt3" class="btnDec"><input type="number" id="txtTotOpt3" name="txtTotOpt3" value = "0"><input type = "button" value="+" id="btnIncOpt3" name="btnIncOpt3" class="btnInc"></div>
				<div><input type = "button" value="-" id="btnDecOpt4" name="btnDecOpt4" class="btnDec"><input type="number" id="txtTotOpt4" name="txtTotOpt4" value = "0"><input type = "button" value="+" id="btnIncOpt4" name="btnIncOpt4" class="btnInc"></div>
				<div></div>
				<div><input type = "button" value="-" id="btnDecOpt5" name="btnDecOpt5" class="btnDec"><input type="number" id="txtTotOpt5" name="txtTotOpt5" value = "0"><input type = "button" value="+" id="btnIncOpt5" name="btnIncOpt5" class="btnInc"></div>
				<div><input type = "button" value="-" id="btnDecOpt6" name="btnDecOpt6" class="btnDec"><input type="number" id="txtTotOpt6" name="txtTotOpt6" value = "0"><input type = "button" value="+" id="btnIncOpt6" name="btnIncOpt6" class="btnInc"></div>
				<div><input type = "button" value="-" id="btnDecOpt7" name="btnDecOpt7" class="btnDec"><input type="number" id="txtTotOpt7" name="txtTotOpt7" value = "0"><input type = "button" value="+" id="btnIncOpt7" name="btnIncOpt7" class="btnInc"></div>
				<div><input type = "button" value="-" id="btnDecOpt8" name="btnDecOpt8" class="btnDec"><input type="number" id="txtTotOpt8" name="txtTotOpt8" value = "0"><input type = "button" value="+" id="btnIncOpt8" name="btnIncOpt8" class="btnInc"></div>
				<div></div>
				<div><input type = "button" value="-" id="btnDecOpt9" name="btnDecOpt9" class="btnDec"><input type="number" id="txtTotOpt9" name="txtTotOpt9" value = "0"><input type = "button" value="+" id="btnIncOpt9" name="btnIncOpt9" class="btnInc"></div>
				<div><input type = "button" value="-" id="btnDecOpt10" name="btnDecOpt10" class="btnDec"><input type="number" id="txtTotOpt10" name="txtTotOpt10" value = "0"><input type = "button" value="+" id="btnIncOpt10" name="btnIncOpt10" class="btnInc"></div>
				<div><input type = "button" value="-" id="btnDecOpt11" name="btnDecOpt11" class="btnDec"><input type="number" id="txtTotOpt11" name="txtTotOpt11" value = "0"><input type = "button" value="+" id="btnIncOpt11" name="btnIncOpt11" class="btnInc"></div>
				<div><input type = "button" value="-" id="btnDecOpt12" name="btnDecOpt12" class="btnDec"><input type="number" id="txtTotOpt12" name="txtTotOpt12" value = "0"><input type = "button" value="+" id="btnIncOpt12" name="btnIncOpt12" class="btnInc"></div>
			</div>
			<div class="belowMenu">
				<div><div class="labelText"><label for="txtOrderNotes">Order Notes:</label></div><textarea id="txtOrderNotes" name="txtOrderNotes" rows="4" cols="64"></textarea></div>
				<div><div class="labelText"><label for="txtOrderName">Order Name:</label></div><input type="text" id="txtOrderName" name="txtOrderName" size="64"></div>
				<div><div class="labelText"><label for="txtEmail">Order Email:</label></div><input type="text" id="txtEmail" name="txtEmail" size="64"></div>
				<div><input type="button" value="Save Order" id="btnSaveOrder" name="btnSaveOrder" class="btnSave" <?php if(date('Y-m-d') > date_format($dtDropDeadDate,'Y-m-d')) { print "disabled"; } ?>></div>
			</div>
			<input type="hidden" value = "" id="txtDistributeStats" name="txtDistributeStats">
			<?php if($user_check=="admin") { ?><input type="button" value = "Send Stats" id="btnStats" name="btnStats" class = "btnStat" ><?php } ?>
		</form>
		<script>
			const btnsInc = document.querySelectorAll('.btnInc');
			const btnsDec = document.querySelectorAll('.btnDec');
			const btnSave = document.querySelectorAll('.btnSave');
			const btnStats = document.querySelectorAll('.btnStat');
			
			btnsInc.forEach(function(currentBtn){
				currentBtn.addEventListener('click', function(event) {
					optionIncrease(event.target.id);
				});
			});
			
			btnsDec.forEach(function(currentBtn){
				currentBtn.addEventListener('click', function(event) {
					optionDecrease(event.target.id);
				});
			});
			
			btnSave.forEach(function(currentBtn){
				currentBtn.addEventListener('click', function(event) {
					ValidateEmail(document.formMenu.txtEmail);
				});
			});

			btnStats.forEach(function(currentBtn){
				currentBtn.addEventListener('click', function(event) {
					BriefStats('true');
				});
			});

			function optionIncrease(btnID) {
				var txt = "txtTotOpt" + btnID.substring(9);
				document.getElementById(txt).value ++;
			}
			
			function optionDecrease(btnID) {
				var txt = "txtTotOpt" + btnID.substring(9);
				document.getElementById(txt).value --;
			}
			
			function ValidateEmail(inputText)
			{
				var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
				if(inputText.value.match(mailformat))
				{
					document.formMenu.txtEmail.focus();
					document.formMenu.action = "presentationDinnerBooking.php";
					document.formMenu.method = "post";
					document.formMenu.submit();
					return true;
				}
				else
				{
					alert("Oops! I think you've entered an invalid email address!");
					document.formMenu.txtEmail.focus();
					return false;
				}
			}
			
			function BriefStats(briefBool)
			{
				alert("Mailing Stat's!");
				document.formMenu.txtDistributeStats.value = "true";
				document.formMenu.action = "presentationDinnerBooking.php";
				document.formMenu.method = "post";
				document.formMenu.submit();
				return true;
			}
		</script>
	<table>
		<tr>
			<td><a href="index.php">Back</a></td>
		</tr>
	</table>
    </body>
</html>