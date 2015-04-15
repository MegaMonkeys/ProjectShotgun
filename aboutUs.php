<!DOCTYPE html>
<HTML>
<link rel="stylesheet" type="text/css" href="loginStyle.css">
<link rel="stylesheet" type="text/css" href="stylesheet.css">
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.css">
<link rel="stylesheet" href="font-awesome-4.3.0/css/font-awesome.min.css">
<script src="jquery_api/jquery.min.js"></script>
<script src="tabcontent.js" type="text/javascript"></script>
<script src="jquery-1.11.2.js"></script>
<script src="jquery_api/jquery.min.js"></script>
<script src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<!--<script src="jquery.min.js"></script>-->
<!--The above script is commented out because it somehow disables Ethan's stats dialog-->
<script src="waypoints.js"></script>
<script src="waypoints-sticky.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.sticky-navigation').waypoint('sticky');
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
   </HEAD>
<BODY style="font-family:Calibri;" class="cbp-spmenu-push">
   <div id="load_screen"><img src="images/monkeyload.gif" /></div>
   
<!-- body has the class "cbp-spmenu-push" -->
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
<a href='javascript: history.go(-1)'><i class="fa fa-hand-o-left"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Back</span></a>
<a href='aboutUs.php'><i class="fa fa-info"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;About Us</span></a>
<a href='teampage.php'><i class="fa fa-user"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Developers</span></a>
<a href='#'><i class="fa fa-question"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Need Help?</span></a>
<a href='logout.php' class="last"><i class="fa fa-sign-out"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sign Out</span></a>
<!--<form action="logout.php"><input type="submit" value="Sign out" class="logout-button"></form>-->
</nav>
<div class="container">
    <div class="main">
        <section class="buttonset">
            <!-- Class "cbp-spmenu-open" gets applied to menu and "cbp-spmenu-push-toleft" or "cbp-spmenu-push-toright" to the body -->
            <a href="#" id="showRightPush" class="button"></a>
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
   
    <div class="container">
        <div class="header">
            <img src="images/logo.png" alt="Ingenious logo" style="width:250px;">
        </div>
        <div class="sticky-navigation">
        </div>
        <div class="contents">
		</div>
        <div class="footer">
            &copy; MegaMonkeys, Inc.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/monkeyhead2.png" class="monkeyheadfooter"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pensacola Christian College 2015
        </div>
	</div>
</BODY>
</HTML>