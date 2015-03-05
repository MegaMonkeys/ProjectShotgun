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
	<div class="title">Teacher - Grades</div>

   <form action="logout.php">
      <input type="submit" value="Sign out" class="logout-button">
   </form>
</div>

<div class="content">

</div>
<div class="footer"></br>
   <img src="images/footerblue.png" class="footerblue"/>
   <ft>&copy; MegaMonkeys, Inc. - Pensacola Christian College 2015</ft>
</div>
</BODY>
</HTML>