<!DOCTYPE html>
<HTML>
<HEAD>

   <link rel="stylesheet" type="text/css" href="loginStyle.css">

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
   <script type="text/javascript">

      var image1 = new Image();
      image1.src="images/Ethan2.jpg";
   </script>
</HEAD>

<BODY>

<div id="load_screen"><img src="images/megamonkeysloading.png" />loading document</div>
<img src="verses/verse5.png" name="slide"  height="600" class="slideshow">
<script type="text/javascript">
   <!--
   var step=1
   function slideit(){
      document.images.slide.src=eval("image"+step+".src");
      if(step<5)
         step++;
      else
         step=1;
      setTimeout("slideit()",5500);
   }
   slideit();
   -->
</script>
<div class="header">
   <img src="images/header.png" class="header"/>
   <div class="title"><img src="images/logo.png" class="logo"/></div>
</div>

<div class="content">
</div>
<div class="footer"></br>
   <img src="images/footerblue.png" class="footerblue"/>
   &copy; MegaMonkey Group - Pensacola Christian College 2015

</div>
</BODY>
</HTML>