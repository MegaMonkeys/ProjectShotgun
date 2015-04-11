<?php
   session_start();
   include_once 'sessionCheck.php';
   user_type_check('Teacher');
?>

<!DOCTYPE html>
<HTML>
   <HEAD>
      <!-- jQuery API JavaScript & CSS Do Not Remove (YC)-->
      <script src="./jquery_api/jquery-1.10.2.js"></script>
      <script src="./jquery_api/jquery.min.js"></script>
      <script src="./jquery_api/jquery-ui.js"></script>
      <link   rel="stylesheet" href="./jquery_api/jquery-ui.css">

      <!-- Custom JavaScript & CSS -->
      <!-- <script src="./keyblock.js"></script> -->
      <script src="./testMakingPage.js"></script>
      <link rel="stylesheet" type="text/css" href="testMakingPage.css">
      <link rel="stylesheet" type="text/css" href="stylesheet.css">
      <?php include_once 'testMakingPage_control.php'; ?>

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

            $(document).ready(function(){
               $("button").click(function(){
               //$("p:first").replaceWith("Hello world!");
            });
         });
      </script>

      <TITLE>
         INGENIOUS - Online Testing Center
      </TITLE>
      <link rel="icon" type="logo/png" href="images/monkeyhead.png">
   </HEAD>

   <BODY style="background:#F6F9FC; font-family:Arial;" class="cbp-spmenu-push"><!-- oncontextmenu="return false" onselectstart="return false" ondragstart="return false">-->
   <div class="container">
        <div class="header">
            <img src="images/logo.png" alt="Ingenious logo" style="width:250px;">
			<div class="main">
			 <section class="buttonset">
				<!-- Class "cbp-spmenu-open" gets applied to menu and "cbp-spmenu-push-toleft" or "cbp-spmenu-push-toright" to the body -->
				<a href="#" id="showRightPush" class="button"><img src="images/menu.png" class="menuImage" /></a>
			 </section>
			</div>
        </div>
        <div class="sticky-navigation">
        </div>
        <div class="contents">
   <!-- body has the class "cbp-spmenu-push" -->
   <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
      <a href='teacherHomePage.php'><span>Home</span></a>
      <a href='#'><span>About</span></a>
      <a href='teampage.php'><span>Developers</span></a>
      <a href='#'><span>Help</span></a>
      <a href='logout.php' class="last"><span>Sign Out</span></a>
      <!--<form action="logout.php"><input type="submit" value="Sign out" class="logout-button"></form>-->
   </nav>

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

      <div id="load_screen"><img src="images/monkeyload.gif" /> </div>

   <div id="wrap">
      <div class="loader" align="center"></div>
         <div id="content">
            <form method="post" action="javascript:void(0);">
               <table>
                  <tr>
                     <td id="left">
                         
                        <div class="informationForm">
                           Class : &nbsp;
                           <select id="courseNo" name="courseNo" class="inputs" style="width:80px;" onchange="get_sections()">
                              <?php get_course_list(); get_section_list(); ?>
                           </select>
                           Section :
                           <select id="sectionNo" name="sectionNo" class="inputs" style="width:50px;">

                           </select><br />
                           <script>
                              function get_sections() {
                                 //reset section_list
                                 document.getElementById('sectionNo').innerHTML = <?php echo json_encode($GLOBALS['section_list']); ?>;
                                 //display only select course sections
                                 var html_code = "";
                                 for( i=0;i<document.getElementsByClassName($('#courseNo').val()).length;i++ )
                                    html_code += document.getElementsByClassName($('#courseNo').val())[i].outerHTML;
                                 document.getElementById('sectionNo').innerHTML = html_code;
                                 var course = "."+$('#courseNo').val();
                                 $('#sectionNo').val( $("option"+course).first().val() );
                              }
                           </script>
                           <!--Start : &nbsp;&nbsp;&nbsp;&nbsp;<input type="date" id="startDate"  name="startDate" class="inputs"> <input type="time" class="inputs" id="startTime" name="startTime"><br />
                           End : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" id="endDate" name="endDate" class="inputs"> <input type="time" class="inputs" id="endTime" name="endTime"><br />
                           Time limit : &nbsp;<input type="number" id="hours" name="hours" min="0" max="10" class="inputs" placeholder="0" size="2"> hr &nbsp;
                           &nbsp;&nbsp;&nbsp;
                           <input type="number" id="minutes" name="minutes" min="0" max="60" class="inputs" placeholder="50" size="2"> min-->
                           <table>
                              <tr>
                                 <td style="width:110px">Start</td>
                                 <td>
                                    <input type="date" class="inputs" id="startDate" name="startDate" style="width:135px;">
                                    <input type="time" class="inputs" id="startTime" name="startTime" style="width:90px;">
                                 </td>
                              </tr>
                              <tr>
                                 <td>End</td>
                                 <td>
                                    <input type="date" class="inputs" id="endDate" name="endDate" style="width:135px;">
                                    <input type="time" class="inputs" id="endTime" name="endTime" style="width:90px;">
                                 </td>
                              </tr>
                              <tr>
                                 <td>Time limit</td>
                                 <td>
                                    <input type="number" id="hours" name="hours" min="0" max="10" class="inputs" placeholder="0" size="2"> hr
                                    <input type="number" id="minutes" name="minutes" min="0" max="60" class="inputs" placeholder="50" size="2"> min
                                 </td>
                              </tr>
                           </table>


                           <div id="optionButton">
                              <table id="optionButtonTable">
                                 <tr>
                                    <td><button type="submit" value="publish" id="publish" name="publish" onclick="publish_test()"></button></td>
                                    <td><button type="submit" value="save"    id="save"    name="save"    formaction="create_test.php"></button></td>
                                    <td><button type="submit" value="preview" id="preview" name="preview" onclick="preview_test()"></button></td>
                                    <td><button type="submit" value="cancel"  id="cancel"  name="cancel"  onclick="cancel_test()"> </button></td>
                                 </tr>
                                 <tr>
                                    <td>Publish</td>
                                    <td>Save</td>
                                    <td>Preview</td>
                                    <td>Cancel</td>
                                 </tr>
                              </table>
                           </div>
                        </div>

                        <form id="buttonArea">
                           <div id="form_question"> <!-- Question Types (YC) -->
                              <ul id="sortable1" class="connectedSortable">

                              </ul>
                           </div>
                        </form>
                     </td>
                     <td id="middle">
                        <div class="scroll">
                           Test Name:  &nbsp;<input type="text" id="testName" name="testName" class="inputs" placeholder="Test #1" size="50">

                           <div>
                              <div id="text_instruc_heading">CS 414 Test Instruction</div>
                              <textarea id="test_inst_text" name="test_instruc_text" rows="4" placeholder="Enter Test Instructions . . ."></textarea>
                           </div>

                           <hr align="left"> 

                           <!-- Where Questions Will Be Placed (YC) -->
                           Questions: <br />
                           <div id="field_question">
                              <ul id="sortable2" class="connectedSortableF">
                              
                              </ul>
                           </div>
                           <div>
                           PLEDGE:<br />
                           <textarea id="pledge_text" type="text" name="pledge" class="inputs"
                                     rows="3" style="width: 98%; height: auto;"></textarea> <!-- width:600px; -->
                           </div>
                        </div>
                     </td>
                  </tr>
               </table>
            </form>
         </div>
   </div>

    </div>
        <div class="footer">
            &copy; MegaMonkeys, Inc. <img src="images/monkeyhead.png" class="monkeyheadfooter"/> Pensacola Christian College 2015
        </div>
	</div>

   </BODY>
</HTML>

<script type="text/javascript">
   $(document).ready(function() { $.ajaxSetup({ cache: false }); });

   get_sections();

   function get_test(t_no)
   {
      $("#content").fadeOut(1);
      $(".loader").fadeIn("slow");
      var data = 'testMakingPage_control.php?action=load&test_no=' + t_no;
      $('#sortable2').load(data);
   }
   $(document).ajaxComplete(function() {
      $(".loader").fadeOut(1);
      $("#content").fadeIn("slow");
   });

   function publish_test() {
      alert("Not Yet !!");
   }
   function preview_test() {
      alert("Under Construction");
   }
   function cancel_test() {
      if( confirm("Are You Sure ?") ) {
         window.location.assign("./teacherHomePage.php");
      }
      else
         alert("OK");
   }

   /*function get_section() {
    var data = 'testMakingPage_control.php?action=' + <?php //echo $_SESSION['user_id']; ?> + '&course_no=' + $('#courseNo').val();
    $('#sectionNo').load(data);
    }*/


</script>

<?php
   if( isset( $_GET['test_no'] ) ) {
      if( test_no_check($_GET['test_no']) ) {
         echo "<script type='text/javascript'>get_test(" . $_GET['test_no'] . ");</script>";
         echo "<script type='text/javascript'>$('#save').attr('value'," . $_GET['test_no'] . ");</script>";
      }
      else {
         echo "<script type='text/javascript'>window.location.assign('./teacherHomePage.php');</script>";
      }
   }
   else
      echo "<script type='text/javascript'>$('.loader').fadeOut(1);</script>";
?>