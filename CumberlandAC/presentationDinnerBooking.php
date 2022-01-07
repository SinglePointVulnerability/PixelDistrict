<?php
    include('session.php');
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
		<form>
			<div class="menuArea">
				<div></div>
				<div><input type = "button" value="+" id="btnIncOpt1" name="btnIncOpt1" class="btnInc"><input type="number" id="txtTotOpt1" name="txtTotOpt1" value = "0"><input type = "button" value="-" id="btnDecOpt1" name="btnDecOpt1" class="btnDec"></div>
				<div><input type = "button" value="+" id="btnIncOpt2" name="btnIncOpt2" class="btnInc"><input type="number" id="txtTotOpt2" name="txtTotOpt2" value = "0"><input type = "button" value="-" id="btnDecOpt2" name="btnDecOpt2" class="btnDec"></div>
				<div><input type = "button" value="+" id="btnIncOpt3" name="btnIncOpt3" class="btnInc"><input type="number" id="txtTotOpt3" name="txtTotOpt3" value = "0"><input type = "button" value="-" id="btnDecOpt3" name="btnDecOpt3" class="btnDec"></div>
				<div><input type = "button" value="+" id="btnIncOpt4" name="btnIncOpt4" class="btnInc"><input type="number" id="txtTotOpt4" name="txtTotOpt4" value = "0"><input type = "button" value="-" id="btnDecOpt4" name="btnDecOpt4" class="btnDec"></div>
				<div></div>
				<div><input type = "button" value="+" id="btnIncOpt5" name="btnIncOpt5" class="btnInc"><input type="number" id="txtTotOpt5" name="txtTotOpt5" value = "0"><input type = "button" value="-" id="btnDecOpt5" name="btnDecOpt5" class="btnDec"></div>
				<div><input type = "button" value="+" id="btnIncOpt6" name="btnIncOpt6" class="btnInc"><input type="number" id="txtTotOpt6" name="txtTotOpt6" value = "0"><input type = "button" value="-" id="btnDecOpt6" name="btnDecOpt6" class="btnDec"></div>
				<div><input type = "button" value="+" id="btnIncOpt7" name="btnIncOpt7" class="btnInc"><input type="number" id="txtTotOpt7" name="txtTotOpt7" value = "0"><input type = "button" value="-" id="btnDecOpt7" name="btnDecOpt7" class="btnDec"></div>
				<div><input type = "button" value="+" id="btnIncOpt8" name="btnIncOpt8" class="btnInc"><input type="number" id="txtTotOpt8" name="txtTotOpt8" value = "0"><input type = "button" value="-" id="btnDecOpt8" name="btnDecOpt8" class="btnDec"></div>
				<div></div>
				<div><input type = "button" value="+" id="btnIncOpt9" name="btnIncOpt9" class="btnInc"><input type="number" id="txtTotOpt9" name="txtTotOpt9" value = "0"><input type = "button" value="-" id="btnDecOpt9" name="btnDecOpt9" class="btnDec"></div>
				<div><input type = "button" value="+" id="btnIncOpt10" name="btnIncOpt10" class="btnInc"><input type="number" id="txtTotOpt10" name="txtTotOpt10" value = "0"><input type = "button" value="-" id="btnDecOpt10" name="btnDecOpt10" class="btnDec"></div>
				<div><input type = "button" value="+" id="btnIncOpt11" name="btnIncOpt11" class="btnInc"><input type="number" id="txtTotOpt11" name="txtTotOpt11" value = "0"><input type = "button" value="-" id="btnDecOpt11" name="btnDecOpt11" class="btnDec"></div>
				<div><input type = "button" value="+" id="btnIncOpt12" name="btnIncOpt12" class="btnInc"><input type="number" id="txtTotOpt12" name="txtTotOpt12" value = "0"><input type = "button" value="-" id="btnDecOpt12" name="btnDecOpt12" class="btnDec"></div>
			</div>
		</form>
		<script>
			const btnsInc = document.querySelectorAll('.btnInc');
			const btnsDec = document.querySelectorAll('.btnDec');
			
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

			function optionIncrease(btnID) {
				var txt = "txtTotOpt" + btnID.substring(9);
				document.getElementById(txt).value ++;
			}
			
			function optionDecrease(btnID) {
				var txt = "txtTotOpt" + btnID.substring(9);
				document.getElementById(txt).value --;
			}
		</script>

    </body>
</html>