<!DOCTYPE html>
<HTML>
   <link rel="stylesheet" type="text/css" href="templateStyle.css">
   <HEAD>
   <style>
   div#load_screen{
	background:#FFF;
	opacity:0.7;
	position:fixed;
	z-index:10;
	top: 0px;
	width:100%;
	height:100%;
   }
   </style>
   <script>
   window.addEventListener("load", function(){
   
	var load_screen = document.getElementById("load_screen");
	document.body.removeChild(load_screen);
   });
      </script>
      <TITLE>
	  MegaTest - Online Testing Application
      </TITLE>
	  
   </HEAD>
<BODY>
<div id="load_screen"><img src="images/megamonkeysloading.png" />loading document</div>
<div class="header">
	<img src="images/header.png" class="header"/>
	<img src="images/wikitest.png" class="testLogo"/>
	<div class="title">Teacher Home</div>

	<input type="submit" value="Sign out" class="logout-button">
</div>
<div class="content">

<div id="navigation">
     <ul>
          <li><a href="#"><span>Home</span></a></li>
          <li><a href="#"><span>About</span></a></li>
          <li><a href="#"><span>Our Work</span></a></li>
          <li><a href="#"><span>Products</span></a></li>
          <li class="last"><a href="#"><span>Contact Us</span></a></li>
     </ul>
</div>

</div>
<div class="footer"></br>
<img src="images/footerblue.png" class="footerblue"/>
&copy; MegaMonkey Group - Pensacola Christian College 2015

</div>
</BODY>
</HTML>