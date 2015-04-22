<?php
   session_start();
   include_once 'sessionCheck.php';
?>
<!DOCTYPE html>
<HTML>
   <link rel="stylesheet" type="text/css" href="tooltip.css">
   <link rel="stylesheet" type="text/css" href="helpPage.css">
   <link rel="stylesheet" type="text/css" href="stylesheet.css">
   <link rel="stylesheet" href="font-awesome-4.3.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.css">
   <script src="tabcontent.js" type="text/javascript"></script>
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
<script>
  $(function() {
    $( "#accordion" ).accordion();
  });
  </script>
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
        INGENIOUS
    </TITLE>
    <link rel="icon" type="logo/png" href="images/monkeyhead2.png">
	<!-- Start Google map -->
	<script src="http://maps.googleapis.com/maps/api/js"></script>
<script>
function initialize() {
	var myLatlng = new google.maps.LatLng(30.470972, -87.232464);
	var mapOptions = {
    zoom: 12,
    center: myLatlng}
	var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

	var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Hello World!'
	});

      }
      google.maps.event.addDomListener(window, 'load', initialize);
</script>
<!-- End Google map-->

<!-- Accordion -->

 


</HEAD>

<BODY style="background:#F6F9FC; font-family:Calibri;" class="cbp-spmenu-push">
<div id="load_screen"><img src="images/monkeyload.gif" />loading document</div>
<!-- body has the class "cbp-spmenu-push" -->
<!-- body has the class "cbp-spmenu-push" -->
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
<span id="name_tab"><?php echo $_SESSION['user_name'][0].' '.$_SESSION['user_name'][1]; ?></span>
<a href='javascript: history.go(-1)'><i class="fa fa-hand-o-left"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Back</span></a>
<a href='./'><i class="fa fa-home"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Home</span></a>
<a href='aboutUs.php'><i class="fa fa-info"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;About Us</span></a>
<a href='teampage.php'><i class="fa fa-user"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Developers</span></a>
<!--<a href='#'><i class="fa fa-question"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Need Help?</span></a>-->
<a href='logout.php' class="last"><i class="fa fa-sign-out"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sign Out</span></a>
</nav>
<div class="container">
    <div class="main">
        <section class="buttonset">
            <!-- Class "cbp-spmenu-open" gets applied to menu and "cbp-spmenu-push-toleft" or "cbp-spmenu-push-toright" to the body -->
            <a href="#" id="showRightPush" class="button"><!--<img src="images/menu.png" class="menuImage" />--></a>
        </section>
    </div>
</div>

<!-- START of JavaScript to make Hidden Side Menu Work -->
<script>
    /*!
     * classie v1.0.1
     * class helper functions
     * from bonzo https://github.com/ded/bonzo
     * MIT license
     *
     * classie.has( elem, 'my-class' ) -> true/false
     * classie.add( elem, 'my-new-class' )
     * classie.remove( elem, 'my-unwanted-class' )
     * classie.toggle( elem, 'my-class' )
     */

    /*jshint browser: true, strict: true, undef: true, unused: true */
    /*global define: false, module: false */

    ( function( window ) {

        'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

        function classReg( className ) {
            return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
        }

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
        var hasClass, addClass, removeClass;

        if ( 'classList' in document.documentElement ) {
            hasClass = function( elem, c ) {
                return elem.classList.contains( c );
            };
            addClass = function( elem, c ) {
                elem.classList.add( c );
            };
            removeClass = function( elem, c ) {
                elem.classList.remove( c );
            };
        }
        else {
            hasClass = function( elem, c ) {
                return classReg( c ).test( elem.className );
            };
            addClass = function( elem, c ) {
                if ( !hasClass( elem, c ) ) {
                    elem.className = elem.className + ' ' + c;
                }
            };
            removeClass = function( elem, c ) {
                elem.className = elem.className.replace( classReg( c ), ' ' );
            };
        }

        function toggleClass( elem, c ) {
            var fn = hasClass( elem, c ) ? removeClass : addClass;
            fn( elem, c );
        }

        var classie = {
            // full names
            hasClass: hasClass,
            addClass: addClass,
            removeClass: removeClass,
            toggleClass: toggleClass,
            // short names
            has: hasClass,
            add: addClass,
            remove: removeClass,
            toggle: toggleClass
        };

// transport
        if ( typeof define === 'function' && define.amd ) {
            // AMD
            define( classie );
        } else if ( typeof exports === 'object' ) {
            // CommonJS
            module.exports = classie;
        } else {
            // browser global
            window.classie = classie;
        }

    })( window );


    var menuRight = document.getElementById( 'cbp-spmenu-s2' ),
        showRightPush = document.getElementById( 'showRightPush' ),
        body = document.body;

    showRightPush.onclick = function() {
        classie.toggle( this, 'active' );
        classie.toggle( body, 'cbp-spmenu-push-toleft' );
        classie.toggle( menuRight, 'cbp-spmenu-open' );
    };
</script>
<!-- END of JavaScript to make Hidden Side Menu Work -->

   <div class="container" >
      <div class="header">
         <a href="./teacherHomePage.php" id="logo"><img src="images/logo.png" alt="Ingenious logo" style="width:250px;"></a>
         <!-- <span id="menu"><img src="images/menu.png" alt="Ingenious logo" style="width:70px;"> </span>-->
      </div>

    <div class="sticky-navigation"></div>
    <div class="contents" >
		<div class="in-contents">
		  <div id="title">FAQs </div>
		  <hr>
		  <a href="images/logo.png" download>Download user manual</a><br /><br />
			<!--<span id="thetitle">Teacher: </span><br />-->
			<div id="accordion">
				<h3><span id="questiontitle">Q: Are the test questions graded automatically?</span></h3>
				<div><p>A: Every test question is graded automatically, except for the essay and short answer questions.<br />
				Tests with essay questions will be submitted to the teacher to finalize the grade,<br />
				then they will be available for the student to see.</p></div>
				<h3><span id="questiontitle">Q: What is the difference between saving a test and publishing it?</span></h3>
				<div><p>A: Saving a test allows you to exit and edit it later. <br />
				Publishing a test makes it viewable for students to take within the specified time <br />
				period and disallows you from editing any further.</p></div>
				<h3><span id="questiontitle">Q: When I delete a test, does that make it unavailable for my students to take?</span></h3>
				<div><p>A: Yes, deleting a test also makes it unavailable for any students enrolled in that course.</p></div>

			<!--	//<span id="thetitle">Students: </span><br />-->
				<h3><span id="questiontitle">Q: I was in the middle of taking a test, and my browser crashed. Now what?</span></h3>
				<div><p>A: Your test is still available to be completed, just go to your home page and click the Take Test button.<br />
				However none of your answers were saved, and the time is still counting down from when you started the test.</p></div>
				<h3><span id="questiontitle">Q: What happends if I click the "I cheated" button?</span></h3>
				<div><p>A: You will get a zero on your test. If you accidently click the button, please contact your teacher.</p></div>
			</div>
				<span id="emailus">Can't find your answer? Please contact us at <a href="mailto:megamonkeys12345@gmail.com?subject=Questions">
				megamonkeys12345@gmail.com</a></span>
				  
			<br /><br />
			<div id="title2">Where are we? </div>
			<hr>
			<br />
			<table>
			<tr>
			<td width="540px"><div id="map-canvas"></div></td>
			<td><i class="fa fa-map-marker">
			</i> &nbsp;250 Brent Lane, Pensacola, FL 32503<br />
			<i class="fa fa-envelope-o"></i> megamonkeys@gmail.com<br />
			<i class="fa fa-phone"></i> (850) 261-7818 or (850) 291-1816<br /></td>
			</tr>
			</table>
			
			
			</ol>
		</div>
   </div>

	<div class="footer">
	&copy; MegaMonkeys, Inc.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/monkeyhead2.png" class="monkeyheadfooter"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pensacola Christian College 2015
	</div>
</BODY>
</HTML>
