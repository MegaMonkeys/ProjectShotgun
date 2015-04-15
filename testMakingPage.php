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
      <link rel="stylesheet" type="text/css" href="testMakingPage.css">
      <link rel="stylesheet" type="text/css" href="stylesheet.css">
      <?php include_once 'testMakingPage_control.php'; ?>

      <style>
         div#load_screen{
            background:#FFF;
            opacity:0.7;
            position:absolute;
            z-index:10;
            top: 0px;
            width:100%;
            height:100%;
         }
		 #loadingImage{
		 position: absolute;
    margin: auto;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
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
         INGENIOUS
      </TITLE>
      <link rel="icon" type="logo/png" href="images/monkeyhead2.png">
   </HEAD>

   <BODY  style="font-family:Calibri;" class="cbp-spmenu-push"><!-- oncontextmenu="return false" onselectstart="return false" ondragstart="return false">-->
   <div id="load_screen"><img src="images/monkeyload.gif" id="loadingImage" /></div>
   
   <div id="undo"><a href='teacherHomePage.php'><span><i class="fa fa-hand-o-left"></i></span></a></div>
<!-- body has the class "cbp-spmenu-push" -->
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
<a href='teacherHomePage.php'><i class="fa fa-home"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Home</span></a>
<a href='aboutUs.php'><i class="fa fa-info"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;About Us</span></a>
<a href='teampage.php'><i class="fa fa-user"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Developers</span></a>
<a href='#'><i class="fa fa-question"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Need Help?</span></a>
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
	  
	  
	  // YOUNG CHAN START
	  var position_value = true;
	  
	  function tessss() {
		
		if (position_value) {
			$('#middle').css('position', 'fixed');
			$('.footer').css('position', 'fixed');
			position_value = false;
		}
		else {
			$('#middle').css('position', 'relative');
			$('.footer').css('position', 'relative');
			position_value = true;
		}
	}
	// YOUNG CHAN END

      var menuRight = document.getElementById( 'cbp-spmenu-s2' ),
          showRightPush = document.getElementById( 'showRightPush' ),
          body = document.body;

      showRightPush.onclick = function() {
		 tessss(); // YOUNG FUNCTOIN CALL
         classie.toggle( this, 'active' );
         classie.toggle( body, 'cbp-spmenu-push-toleft' );
         classie.toggle( menuRight, 'cbp-spmenu-open' );
      };
	  
	  
	  
	  
   </script>
   <!-- END of JavaScript to make Hidden Side Menu Work
	<div class="loader" align="center"></div> -->
	
	<div class="container" >
      <div class="header">
         <img src="images/logo.png" alt="Ingenious logo" class="logo" style="width:250px;">
         <!-- <span id="menu"><img src="images/menu.png" alt="Ingenious logo" style="width:70px;"> </span>-->
      </div>

      <div class="sticky-navigation"></div>
		<div class="contents" >
            <form method="post" action="javascript:void(0);">
                     <div id="left">
                         
                        <div class="informationForm">
                           <!--Start : &nbsp;&nbsp;&nbsp;&nbsp;<input type="date" id="startDate"  name="startDate" class="inputs"> <input type="time" class="inputs" id="startTime" name="startTime"><br />
                           End : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" id="endDate" name="endDate" class="inputs"> <input type="time" class="inputs" id="endTime" name="endTime"><br />
                           Time limit : &nbsp;<input type="number" id="hours" name="hours" min="0" max="10" class="inputs" placeholder="0" size="2"> hr &nbsp;
                           &nbsp;&nbsp;&nbsp;
                           <input type="number" id="minutes" name="minutes" min="0" max="60" class="inputs" placeholder="50" size="2"> min-->
                           <table>
							  <tr>
								<td style="width:110px">Class:</td>
								<td>
									<select id="courseNo" name="courseNo" class="inputs" style="width:80px;" onchange="get_sections()">
										<?php get_course_list(); get_section_list(); ?>
									</select>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Section:&nbsp;&nbsp;
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
								</td>
							  </tr>
                              <tr>
                                 <td style="width:110px">Start:</td>
                                 <td>
                                    <input type="date" class="inputs" id="startDate" name="startDate" style="width:135px;">
                                    <input type="time" class="inputs" id="startTime" name="startTime" style="width:90px;">
                                 </td>
                              </tr>
                              <tr>
                                 <td>End:</td>
                                 <td>
                                    <input type="date" class="inputs" id="endDate" name="endDate" style="width:135px;">
                                    <input type="time" class="inputs" id="endTime" name="endTime" style="width:90px;">
                                 </td>
                              </tr>
                              <tr>
                                 <td>Time limit:</td>
                                 <td>
                                    <input type="number" id="hours" name="hours" min="0" max="10" class="inputs" onkeydown="return isNumberKey(event)" placeholder="0" value="1" size="2"> hr
                                    <input type="number" id="minutes" name="minutes" min="0" max="60" class="inputs" onkeydown="return isNumberKey(event)" placeholder="50" value="0" size="2"> min
                                 </td>
                              </tr>
                           </table>

                           <div id="optionButton">
                              <table id="optionButtonTable">
                                 <tr>
                                    <td><button type="submit" value="publish" id="publish" name="publish" formaction="create_test.php"></button></td> <!--onclick="publish_test()"-->
                                    <td><button type="submit" value="save"    id="save"    name="save"    formaction="create_test.php"></button></td>
                                    <td><button type="submit" value="cancel"  id="cancel"  name="cancel"  onclick="cancel_test()"> </button></td>
                                 </tr>
                                 <tr>
                                    <td>Publish</td>
                                    <td>Save</td>
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
                     </div>
                     <div id="middle">
                           Test Name:  &nbsp;<input type="text" id="testName" name="testName" class="inputs" placeholder="Test #1" size="50">

                           <!-- Where Questions Will Be Placed (YC) -->
                           <br />Questions: <br />
                           <div id="field_question">
                              <ul id="sortable2" class="connectedSortableF">
                              
                              </ul>
                           </div>
                           
                           PLEDGE:<br />
                           <textarea id="pledge_text" type="text" name="pledge" class="inputs"
                                     rows="3" style="width: 98%; height: auto;"></textarea> <!-- width:600px; -->
                          
                     </div>
            </form>
		<div id="info_loading"></div>

		</div>

	</div>

        <div class="footer">
            &copy; MegaMonkeys, Inc.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/monkeyhead2.png" class="monkeyheadfooter"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pensacola Christian College 2015
        </div>		

   </BODY>
</HTML>

<script type="text/javascript">
   $(document).ready(function() { $.ajaxSetup({ cache: false }); });
   function get_today() {
      var now = new Date();
      var day = ("0" + now.getDate()).slice(-2);
      var month = ("0" + (now.getMonth() + 1)).slice(-2);
      var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
      return today;
   }

   $(document).ready(function(){
      var today = get_today();

      $("#startDate").val(today);
      $("#endDate").val(today);

      $("#startTime").val('00:00:00');
      $("#endTime").val('23:59:00');


      if( <?php echo $_POST['creat_section']; ?> != -1 ) {
         //DEFAULT COURSE_SECTION SELECTION
         document.getElementById('sectionNo').innerHTML = <?php echo json_encode($GLOBALS['section_list']) ?>;
         document.getElementById("sectionNo").value = <?php echo $_POST['creat_section']; ?>;

         var e = document.getElementById("sectionNo");
         var strUser = e.options[e.selectedIndex].className;

         document.getElementById("courseNo").value = strUser;
         get_sections();
         document.getElementById("sectionNo").value = <?php echo $_POST['creat_section']; ?>;
      }
   });

   get_sections();

   function get_test(t_no)
   {
      $("#content").fadeOut(1);
      $(".loader").fadeIn("slow");
      var data = 'testMakingPage_control.php?load=1&test_no=' + t_no;
      $('#info_loading').load(data);
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
      publish_check();
      if( confirm("Are You Sure ?") ) {
         window.location.assign("./teacherHomePage.php");
      }
      else
         alert("OK");
   }
   /////////////////////////////////////
   function publish_check() {
      var today = get_today();
      if($('#startDate').val() > $('#endDate').val())
         alert('NO');
      if($('#startDate').val() < today)
         alert('NO PAST');
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
         echo "<script type='text/javascript'>$('#publish').attr('value'," . $_GET['test_no'] . ");</script>";
      }
      else {
         echo "<script type='text/javascript'>window.location.assign('./teacherHomePage.php');</script>";
      }
   }
   else
      echo "<script type='text/javascript'>$('.loader').fadeOut(1);</script>";
?>