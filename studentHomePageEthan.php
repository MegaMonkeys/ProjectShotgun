<!DOCTYPE html>
<HTML>
<HEAD>

   <link rel="stylesheet" type="text/css" href="studentHomePage.css">
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
   <div class="title"><img src="images/logo.png" class="logo"/></div>
   <form action="loginPage.php" method="post">
      <input type="submit" value="Sign out" class="logout-button">
   </form>
</div>
<div id='cssmenu'>
   <ul>
      <li class='loginPage.html'><a href='#'><span>Home</span></a></li>
      <li><a href='#'><span>About</span></a></li>
      <li><a href='#'><span>Team</span></a></li>
      <li class='last'><a href='#'><span>Contact</span></a></li>
   </ul>
</div>

<div class="content">

<img src="images/Ethan2.jpg" name="slide"  height="600" class="slideshow">


</div>
<div id="footer">
   &copy; MegaMonkey Inc. - Pensacola Christian College 2015
</div>
<img src="images/footerblue.png" class="footerblue"/>

</BODY>
</HTML>