<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Lakeland Stoves</title>
  <meta name="description" content="Lakeland Stoves">
  <meta name="author" content="Pixel District, West Coast Web Design">

  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/gallery.css">

</head>
<body style="background: black">
    <div class="lakelandStovesSlogan">
    Make your house a cosy home this winter
    </div>
    <img src="images/Logo_HiRes.png" class="LakelandStovesLogo" >
    <div class="NACS_HETAS">
    <img src="images/NACS-Logo.jpg" style="display: block; position: relative; top: 0; left: 0; width: 100%">
    <img src="images/HETAS_hri.gif" style="display: block; position: relative; top: 0; right: 0; width: 100%">
    </div>
    <div class="pixelDistrit">
        <div>
            Website Design:
        </div>
        <a href="http://www.pixeldistrict.co.uk"><img src="images/PD_Logo.png" style="display:block; position: relative; bottom: 0; right: 0; width: 100%" alt="Pixel District Logo"></a>
    </div>
<!-- plagiarised from https://www.w3schools.com/howto/howto_js_slideshow.asp :) --> 
<div class="centralBody">
<div class="slideshow-container">
  <div class="mySlides fade">
    <div class="numbertext">1 / 4</div>
    <center><img src="images/gallery/2017-09-29/1.JPG" style="max-height: 480px; max-width:100%"></center>
    <div class="text">The opening up of the chimney breast</div>
  </div>

  <div class="mySlides fade">
    <div class="numbertext">2 / 4</div>
    <center><img src="images/gallery/2017-09-29/2.JPG" style="max-height: 480px; max-width:100%"></center>
    <div class="text">Opening up of the chimney breast</div>
  </div>

  <div class="mySlides fade">
    <div class="numbertext">3 / 4</div>
    <center><img src="images/gallery/2017-09-29/3.JPG" style="max-height: 480px; max-width:100%"></center>
    <div class="text">Solid natural oak surround with complementing natural dark slate hearth</div>
  </div>

  <div class="mySlides fade">
    <div class="numbertext">4 / 4</div>
    <center><img src="images/gallery/2017-09-29/4.JPG" style="max-height: 480px; max-width:100%"></center>
    <div class="text">Stove in place</div>
  </div>
  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
  <span class="dot" onclick="currentSlide(4)"></span> 
</div>
</div>
<!-- plagiarised from https://www.w3schools.com/howto/howto_js_slideshow.asp :) -->
<script type="text/javascript">
// plagiarised from https://www.w3schools.com/howto/howto_js_slideshow.asp :)
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1} 
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none"; 
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block"; 
  dots[slideIndex-1].className += " active";
}
// plagiarised from https://www.w3schools.com/howto/howto_js_slideshow.asp :)
</script>

    <div class="menuLHS">
            <a class="menuHyperlink" href="index.php">Home</a>
    </div>
    <div class="menuRHS">
            <a class="menuHyperlink" href="contact.php">Contact</a>
    </div>
</body>
</html> 