<?php
   session_start();
   include_once 'sessionCheck.php';
   user_type_check('Teacher');
   if(!isset($_POST['gradeButton']))
      header('Location: ./teacherHomePage.php');
?>
<!DOCTYPE html>
<HTML>
<link rel="stylesheet" type="text/css" href="tooltip.css">
<link rel="stylesheet" type="text/css" href="testGradingPage.css">
<link rel="stylesheet" type="text/css" href="stylesheet.css">
<script src="tabcontent.js" type="text/javascript"></script>
<script src="./jquery-1.11.2.js"></script>
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
<?php include_once 'testGradingPage_control.php'; ?>
<HEAD>
    <style>
         div#load_screen{
            opacity:0.7;
            position:fixed;
            z-index:10;
            top: 30%;
            width:100%;
            height:100%;
         }
		 #imageLoad{
		 display: block;
		margin-left: auto;
		margin-right: auto ;
		 }

    </style>
    <script>
        window.addEventListener("load", function(){
            var load_screen = document.getElementById("load_screen");
            document.body.removeChild(load_screen);
        });
		$( window ).resize(function() {
			page_resize();
		});
		$(function() {
			page_resize();
		});
		function page_resize() {
			//alert( $(window).height() + " " + $(document).height());
			$("#studentInformation").css("max-height", $(window).height() - 300);
         $(".testQuestions").css("min-height", $(window).height() - 244);
		}
    </script>
    <TITLE>
       INGENIOUS
    </TITLE>
    <link rel="icon" type="logo/png" href="images/monkeyhead2.png">
</HEAD>

<BODY style="font-family:Calibri;" class="cbp-spmenu-push">

<div id="load_screen"><img src="images/monkeyload.gif" id="imageLoad"/></div>
<!-- body has the class "cbp-spmenu-push" -->
<!-- body has the class "cbp-spmenu-push" -->
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
   <span id="name_tab"><?php echo $_SESSION['user_name'][0].' '.$_SESSION['user_name'][1]; ?></span>
   <a href='teacherHomePage.php'><i class="fa fa-home"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Home</span></a>
   <a href='aboutUs.php'><i class="fa fa-info"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;About Us</span></a>
   <a href='teampage.php'><i class="fa fa-user"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Developers</span></a>
   <a href='helpPage.php'><i class="fa fa-question"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Need Help?</span></a>
   <a href='logout.php' class="last"><i class="fa fa-sign-out"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sign Out</span></a>
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

<div class="container" >
   <div class="header">
      <!--<img src="images/header.png" class="header"/>-->
      <a href="teacherHomePage.php" id="logo"><img src="images/logo.png" alt="Ingenious logo" style="width:250px;"></a>
   </div>
   <div class="sticky-navigation"></div>

   <div id="wrapper">
      <div id="test_info">
         <table>
            <tr>
               <td><b>Test</b></td>
               <td><b>Student</b></td>
               <td><b>Actual</b></td>
               <td><b>Total</b></td>
               <td><b>%</b></td>
               <td id="f_save" rowspan="2"><button id="t_save" class="tooltip-bottom" type="button" data-tooltip="Save" onclick="testing()"></button></td>
            </tr>
            <tr>
               <td id="f_t_name"></td>
               <td id="f_s_name"></td>
               <td id="f_s_point"></td>
               <td id="f_t_point"></td>
               <td id="f_percent"></td>
               
            </tr>
         </table>
      </div>

      <div class="content">
         <div id="studentList"><h2>Students</h2></div>
         <div id="studentInformation">
            <table id="studentTable">
               <?php get_student_list(); ?>
            </table>
         </div>

         <span id='classTitle'></span><br />

         <div class="testQuestions">
            <div class="loader"></div>
            <table id="test_table" class="table_border_style">
                <!-- Table Elements Generated By AJAX Script -->
            </table>
         </div>
      </div>
      <div class="footer">
         &copy; MegaMonkeys, Inc.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/monkeyhead2.png" class="monkeyheadfooter"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pensacola Christian College 2015
      </div>
   </div>
</div>

</BODY>
</HTML>

<script type="text/javascript">
   $(document).ready(function() { $.ajaxSetup({ cache: false }); });
   $(".loader").fadeOut(1);
   var test_info = <?php echo json_encode(get_test_info($_POST['gradeButton'])) ?>;
   f_t_name.innerHTML = test_info[0];
   s_id = <?php echo ($st_id) ?>;
   t_id = <?php echo $_POST['gradeButton']; ?>;

   
   get_student_test(t_id,s_id,<?php echo json_encode($st_name); ?>);
   

   function get_student_test(test_id, student_id, s_name) {
      //alert(test_id + " " + student_id);
      student_selected(student_id);
      var data = 'testGradingPage_control.php?action=get&test_id='+test_id+'&student_id='+student_id;
      $("#test_table").fadeOut(1);
      $(".loader").fadeIn("slow");
      $('#test_table').load(data, function (responseText, textStatus, XMLHttpRequest) {
         if (textStatus == "success") {
            calculate_total();
			document.getElementById("t_save").style.backgroundImage = "url('images/options/save.png')";
            document.getElementById("t_save").disabled = true;
            $(".loader").fadeOut(1);
            $("#test_table").fadeIn("slow");
         }
         if (textStatus == "error") {
            // oh noes!
         }
      });
      f_s_name.innerHTML = s_name;
      s_id = student_id;
   }
   
   function student_selected(student_id) {
      for (i = 0; i < $('#studentTable td').length; i++) {
         if( $('#studentTable td').eq(i).attr('value') == student_id )
            $('#studentTable td').eq(i).css('background-color', 'rgb(0,150,210)');
         else
            $('#studentTable td').eq(i).css('background-color', '#FF9900');
      }
   }

   $(document).ajaxComplete(function() {

   });

   function calculate_total() {
      var s_total = 0;
      var t_total = 0;
      var loop_limit = document.getElementById("test_table").rows.leng;
      //for (i = 1; i <= loop_limit; i++) {
         //var current = parseInt(document.getElementById("p"+i).value);

      var i = 1;
      while (document.getElementById("p"+i) != null) {
         var current = document.getElementById("p"+i);
         if( ! $.isNumeric(current.value) )
            current.value = 0;
         document.getElementById("p"+i).value = parseInt(document.getElementById("p"+i).value);
         s_total += parseInt(document.getElementById("p"+i).value);
         t_total += parseInt((document.getElementById("pointBox"+i).innerText).replace( /^\D+/g, ''));
         i++;
      }
         //t_total += parseInt((document.getElementById("pointBox1").innerText).substring(1));
      //}
      f_s_point.innerHTML = s_total;
      f_t_point.innerHTML = t_total;
      var percent = parseFloat(s_total/t_total*100.00).toFixed(2);
      f_percent.innerHTML = ((!$.isNumeric(percent))?parseFloat(0).toFixed(2):percent);
      document.getElementById("t_save").disabled = false;
	  document.getElementById("t_save").style.backgroundImage = "url('images/options/saveEnable.png')";
   }

   function testing() {
      var q_num = document.getElementById("test_table").rows.length;
      if( q_num != 0) {
         $("#test_table").fadeOut(1);
         $(".loader").fadeIn("slow");
         //TEST NO CAUTION !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         // NEED TO SET STUDENT ID
         var data = 'testGradingPage_control.php?s_id='+s_id+'&action=save&t_id='+t_id+'&count='+q_num;
         //for (i = 1; i <= q_num; i++) {
         var i = 1;
         while (document.getElementById("p"+i) != null) {
            data += "&n"+i+"=" + document.getElementById("p"+i).value;
            i++;
         }
         //#f_save
         $(this).load(data, function (responseText, textStatus, XMLHttpRequest) {
            if (textStatus == "success") {
               //alert("saved");
               $(".loader").fadeOut(10);
               $("#test_table").fadeIn("slow");
               document.getElementById("t_save").style.backgroundImage = "url('images/options/save.png')";
               document.getElementById("t_save").disabled = true;
            }
            if (textStatus == "error") {
               // oh noes!
            }
         });
      }
   }

   function isNumberKey(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
         return false;
      return true;
   }

</script>