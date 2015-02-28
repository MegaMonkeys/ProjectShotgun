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
   image1.src="images/verses/pensacola660.jpg";
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

<div class="courseMenu">
<!-- Start css3menu.com BODY section -->
<input type="checkbox" id="css3menu-switcher" class="c3m-switch-input">
<ul id="css3menu1" class="topmenu">
   <li class="switch"><label onclick="" for="css3menu-switcher"></label></li>
   <li class="topfirst"><a href="#" style="width:54px;"><span>CS 414</span></a>
      <ul>
         <li class="subfirst"><a href="#"><span>Test 1</span></a>
            <ul>
               <li class="subfirst"><a href="#">Modify</a></li>
               <li><a href="#">Publish</a></li>
               <li><a href="#">Grades</a></li>
               <li><a href="#">Delete</a></li>
            </ul></li>
         <li><a href="#">Test 2</a></li>
      </ul></li>
   <li class="topmenu"><a href="#" style="width:54px;">CS 306</a></li>
   <li class="topmenu"><a href="#" style="width:54px;">BA 300</a></li>
   <li class="topmenu"><a href="#" style="width:54px;"><span>CS 346</span></a>
      <ul>
         <li class="subfirst"><a href="#">Item 1 0</a></li>
         <li><a href="#">Item 1 1</a></li>
         <li><a href="#">Item 1 2</a></li>
      </ul></li>
   <li class="topmenu"><a href="#" style="width:54px;">MA 330</a></li>
</ul><p class="_css3m"><a href="http://css3menu.com/">html dropdown menu</a> by Css3Menu.com</p>
<!-- End css3menu.com BODY section -->
</div>
<div class="content">
</div>
<div class="footer"></br>
<img src="images/footerblue.png" class="footerblue"/>
&copy; MegaMonkey Group - Pensacola Christian College 2015

</div>
</BODY>
</HTML>