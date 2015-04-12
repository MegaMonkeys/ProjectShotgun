<?php
   session_start();
   include_once 'sessionCheck.php';
   user_type_check('Teacher');
?>

<!DOCTYPE html>
<HTML>
   <link rel="stylesheet" type="text/css" href="teacherHomePage.css">
   <link rel="stylesheet" type="text/css" href="stylesheet.css">
   <link rel="stylesheet" href="font-awesome-4.3.0/css/font-awesome.min.css">
   <!--Ethan--><link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.css">
   <script src="tabcontent.js" type="text/javascript"></script>
   <script src="jquery-1.11.2.js"></script>
   <script src="jquery_api/jquery.min.js"></script>
   <!--Ethan--><script src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
	<script src="waypoints.js"></script>
    <script src="waypoints-sticky.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.sticky-navigation').waypoint('sticky');
        });
    </script>
   <?php include_once 'teacherHomePage_control.php'; ?>

<HEAD>
    <!--Ethan begin-->
    <script>
        $(function() {
            $( "#openDialog").on("click", function(){
                $( "#dialog-modal" ).dialog({
                    height:'auto',
                    width:'auto',
                    modal: true
                });
                $( "#dialog-modal" ).show();
            });
        });
    </script>
    <!--Ethan end-->
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
        INGENIOUS - Online Testing Center
    </TITLE>
    <link rel="icon" type="logo/png" href="images/monkeyhead2.png">
</HEAD>

   <!--Ethan begin-->
   <a href="#" id="openDialog" class="stats" style="display: none;">Statistics</a>
   <div id="dialog-modal" title="Class Statistics" style="display:none">
       <html>
       <div>

           <?php
           include_once 'db_connection.php';

           $section_id = 1;
           $class = 'CS 130-1';

           $result1 = mysqli_query($connection, "select test_name from test where section_id = $section_id");
           $result2 = mysqli_query($connection, "select distinct student_id, first_name, last_name from student join enrollment using(student_id) join student_test using (student_id) join test using (section_id) where student_test.test_id = test.test_id AND section_id = $section_id;");
           $result4 = mysqli_query($connection, "select FORMAT(((test_avg/total_points)*100), 2) from test where section_id = $section_id");

           echo "<p>$class</p>";

           echo "<table style='border: solid 1px black' id='statsTable'>";

           echo "<tr><th>STUDENTS</th>";
           while ($row1 = mysqli_fetch_array($result1)) {
               echo "<th>$row1[0]</th>";
           }
           echo "</tr>";
           echo "<tr>";
           while ($row2 = mysqli_fetch_array($result2)) {
               echo "<td>$row2[1]"." "."$row2[2]</td>";
               $student_id = $row2[0];
               $result3 = mysqli_query($connection, "select FORMAT(((final_grade/total_points)*100), 2) from student join enrollment using(student_id) join student_test using(student_id) join test using (section_id) where student_test.test_id = test.test_id AND section_id = $section_id AND student_id = $student_id;");
               while ($row3 = mysqli_fetch_array($result3)) {
                   echo "<td>$row3[0]"."%"."</td>";
               }
           }
           echo "<tr><th>AVG</th>";
           while ($row4 = mysqli_fetch_array($result4)) {
               echo "<th>$row4[0]%</th>";
           }
           echo "</tr>";
           echo "</table>";
           ?>
           <?php
           mysqli_close($connection);
           ?>
       </div>
       </html>
   </div>
   <!--Ethan end-->

<BODY style="background:#F6F9FC; font-family:Calabri;" class="cbp-spmenu-push">
 <div id="load_screen"><img src="images/monkeyload.gif" />loading document</div>
<!-- body has the class "cbp-spmenu-push" -->
<!-- body has the class "cbp-spmenu-push" -->
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
<a href='teacherHomePage.php'><i class="fa fa-home"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Home</span></a>
<a href='#'><i class="fa fa-info"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;About</span></a>
<a href='teampage.php'><i class="fa fa-user"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Developers</span></a>
<a href='#'><i class="fa fa-question"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Help</span></a>
<a href='logout.php' class="last"><i class="fa fa-sign-out"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sign Out</span></a>
</nav>
<div class="container">
    <div class="main">
        <section class="buttonset">
            <!-- Class "cbp-spmenu-open" gets applied to menu and "cbp-spmenu-push-toleft" or "cbp-spmenu-push-toright" to the body -->
            <a href="#" id="showRightPush" class="button"><img src="images/menu.png" class="menuImage" /></a>
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

   <?php include_once 'reload_goback.php'; ?>
  
   
   <div class="container" >
      <div class="header">
         <img src="images/logo.png" alt="Ingenious logo" style="width:250px;">
         <!-- <span id="menu"><img src="images/menu.png" alt="Ingenious logo" style="width:70px;"> </span>-->
      </div>

      <div class="sticky-navigation"></div>
      <div class="contents" >
         <div class="content" >
            <form method="post" action="testMakingPage.php">
               <input type="submit" value="+ Create Test" class="create-button"/>
               <input type="number" id="creat_section" name="creat_section" value="-1" style="display:none;">
            </form>
            <div class="courses">
               <table id="courseTable">
                  <?php $class_list = get_class_list(); ?>
               </table>
            </div>

            <span id='classTitle'></span><br />

            <div class="testEachCourse">
               <div class="loader"></div>
               <div id="form_table">
                  <table id="testTable">
                     <!-- Table Elements Generated By AJAX Script -->
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
	<div class="footer">
	&copy; MegaMonkeys, Inc.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/monkeyhead2.png" class="monkeyheadfooter"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pensacola Christian College 2015
	</div>
</BODY>
</HTML>


<script type="text/javascript">
   $(document).ready(function() { $.ajaxSetup({ cache: false }); });

   var current;
   var class_list = <?php echo json_encode($class_list) ?>;
      //[0]-COURSE_NO [1]-SECTION_NO [2]-SECTION_ID [3]-COURSE_DESCRIPTION
   //get_class_test(Object.keys(class_list)[0]);
   $(".loader").fadeOut(1);

   function get_class_test(section_id) {
      current = section_id;
      $(".welcome").fadeOut(1);
      $("#testTable").fadeOut(1);
      $(".loader").fadeIn("slow");
      document.getElementById("classTitle").innerHTML = class_list[section_id];
      $('.stats').css('display', 'inline');
      var data = 'teacherHomePage_control.php?section_id=' + section_id;
      $('#testTable').load(data, function (responseText, textStatus, XMLHttpRequest) {
         if (textStatus == "success") {
            //alert("donw");
            $('#creat_section').val(section_id);
         }
         if (textStatus == "error") {
            //alert(responseText);
         }
      });
   }

   function delete_test(test_id) {
      $("#testTable").fadeOut(1);
      $(".loader").fadeIn("slow");
      var data = 'teacherHomePage_control.php?action=delete&section_id=' + current + '&test_id=' + test_id;
      $('#testTable').load(data);
   }

   function modify_test(test_id) {
      var data = 'teacherHomePage_control.php?action=modify&section_id=' + current + '&test_id=' + test_id;
      window.location.href = data;
   }

   function grade_test(test_id) {
      alert("Test End Time Not Met Yet");
   }

   $(document).ajaxComplete(function() {
      $(".loader").fadeOut(1);
      $("#testTable").fadeIn("slow");
   });
   
   
   //When Page Loads
   $(function() {
      page_resize();
	  
	  $( "#openDialog").on("click", function(){
	  alert(current);
	    var data = 'teacherStatistics.php?section=' + current;
		$("#dialog-modal").load(data, function (responseText, textStatus, XMLHttpRequest) {
		   if (textStatus == "success") {
			  //alert("donw");
			  //$( "#dialog-modal" ).show();
         $( "#dialog-modal" ).dialog({
            height:'auto',
            width:'auto',
            modal: true
         });
		   }
		   if (textStatus == "error") {
			  alert(responseText);
		   }
		});
	  
		
	});
   });
   //When Page Size Changes
   $( window ).resize(function() {
      page_resize();
   });
      function page_resize() {
         //alert($(window).height() + " " + $(document).height());
         //$('#classTitle').css("left", 300 + ($(window).width() - 1100) / 2);
         $('.courses').css("max-height", $(window).height() - 350);
         //$('.testEachCourse').css("left", 300 + ($(window).width() - 1100) / 2);
         $('.testEachCourse').css("min-height", $(window).height() - 195 );
      }
</script>

<?php
   if( isset( $_SESSION['section_id'] ) ) {
      echo '<script type="text/javascript"> get_class_test('.$_SESSION['section_id'].'); </script>';
      unset($_SESSION['section_id']);
   }
?>