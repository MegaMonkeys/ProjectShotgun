<!DOCTYPE html>
<HTML>

  
   <HEAD>
   
       <!-- jQuery API JavaScript & CSS Do Not Remove (YC)-->
    <script src="./jquery_api/jquery-1.10.2.js"></script>
    <script src="./jquery_api/jquery.min.js"></script> 
    <script src="./jquery_api/jquery-ui.js"></script>
    <link   rel="stylesheet" href="./jquery_api/jquery-ui.css">
		
	<!-- for icon -->
	<link rel="stylesheet" href="font-awesome-4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.css">
	<script src="jquery-1.11.2.js"></script>
    <script src="jquery_api/jquery.min.js"></script>
    <script src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
	<script src="waypoints.js"></script>
    <script src="waypoints-sticky.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.sticky-navigation').waypoint('sticky');
        });
    </script>
      <!-- Custom JavaScript & CSS -->
      <!-- <script src="./keyblock.js"></script> -->
      <script src="./testMakingPage.js"></script>
      <link rel="stylesheet" type="text/css" href="testGradingPage.css">
      <link rel="stylesheet" type="text/css" href="stylesheet.css">
   
   
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