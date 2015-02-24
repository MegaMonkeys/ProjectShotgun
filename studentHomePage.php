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
	<div class="title">Student Home - Tests</div>

	<input type="submit" value="Sign out" class="logout-button">
</div>

<script src="jquery-1.11.2.js"></script>
<script>
jQuery(document).ready(function() {
    jQuery('.tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = jQuery(this).attr('href');
 
        // Show/Hide Tabs
        jQuery('.tabs ' + currentAttrValue).slideDown(400).siblings().slideUp(400);
 
        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
 
        e.preventDefault();
    });
});
</script>

<div class="tabs">
    <ul class="tab-links">
        <li class="active"><a href="#tab1">Tab #1</a></li>
        <li><a href="#tab2">Tab #2</a></li>
    </ul>

 
<div class="tab-content">
	<div id="tab1" class="tab active">
		<p>CS 414 - Test 5 - DUE 02/23/15</p>
		<p>CS 306 - Test 3 - DUE 02/25/15</p>
	</div>

	<div id="tab2" class="tab">
		<form id="buttonArea" >
			<div class="questionType-button"><br /><br />
			<input onclick="#" type="button" value="CS 414" id="instruction"/><br />
			<input onclick="#" type="button" value="CS 306" /><br />
			<input onclick="#" type="button" value="CS 368" /><br />
			<input onclick="#" type="button" value="CS 346" /><br />
			<input onclick="#" type="button" value="MA 330" /><br />
			<input onclick="#" type="button" value="BA 300" />
			</div>
		</form>
	</div>
</div>

<div class="content">

</div>
<div class="footer"></br>
<img src="images/footerblue.png" class="footerblue"/>
&copy; MegaMonkey Group - Pensacola Christian College 2015

</div>
</BODY>
</HTML>