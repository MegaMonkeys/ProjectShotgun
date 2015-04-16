<?php
   session_start();
   include_once 'sessionCheck.php';
   user_type_check('Student');
?>

<!DOCTYPE html>
<HTML>
<link rel="stylesheet" type="text/css" href="studentHomePage2.css">
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
<?php include_once 'php_control_student.php'; ?>

<?php include_once 'php_control_student.php'; ?>

<HEAD>
    <script>
        $(function() {
	        var winWidth = $(window).width();
	        var winHeight = $(window).height();
	        var dialogWidth = winWidth * 0.9;
	        var dialogHeight = winHeight * 0.9;
            $( "#openDialog").on("click", function(){
                $( "#dialog-modal" ).dialog({
	                height: dialogHeight,
                    width: dialogWidth,
                    modal: true
                });
                $( "#dialog-modal" ).show();
            });
        });
    </script>
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
	<link rel="icon" type="logo/png" href="images/monkeyhead.png">
</HEAD>

<a href="#" id="openDialog" class="stats" style="...">Statistics</a>
<div id="dialog-modal" title="Student Statistics" style="display:none">
    <html>
    <div>
        <?php
        include_once 'db_connection.php';

        $student_id = $_SESSION["user_id"];

        $overall_grade = mysqli_fetch_array(mysqli_query($connection, "select FORMAT(AVG(final_grade), 2) from student join enrollment using(student_id) join student_test using(student_id) join test using (section_id) where student_test.test_id = test.test_id AND student_id = ".$student_id));

        echo "<p>OVERALL GRADE: ";
        if (is_numeric($overall_grade[0]))
        	echo "$overall_grade[0]%";
        if (!is_numeric($overall_grade[0]))
        	echo "No Grade Yet";
        echo "<br></p>";

		$classAndInstructorResult = mysqli_query($connection, "select course_no, '-', section_no, description, instructor_title, first_name, last_name, section_id from section join course using(course_no) join instructor using(instructor_id) join enrollment using(section_id) where student_id = ".$student_id." order by course_no, section_no");

        echo "<table style='border: solid 1px black' id='statsTable'>";
        echo "<tr><th>CLASS</th><th>INSTRUCTOR</th><th>YOUR CLASS GRADE</th></tr>";
        
        while ($row1 = mysqli_fetch_array($classAndInstructorResult)){
	        echo "<tr>";
	        echo "<td>$row1[0]$row1[1]$row1[2] ".$row1[3]."</td>";
	        echo "<td>$row1[4] $row1[5] $row1[6]</td>";
	        
	        $section_id = $row1[7];
	        $classGradeResult = mysqli_fetch_array(mysqli_query($connection, "select FORMAT(AVG(final_grade), 2) from student join enrollment using(student_id) join student_test using(student_id) join test using (section_id) where student_test.test_id = test.test_id AND section_id = ".$section_id." AND student_id = ".$student_id));
	        if (is_numeric($classGradeResult[0]))
	        	echo "<td>$classGradeResult[0]%</td>";
	        if (!is_numeric($classGradeResult[0]))
	        	echo "<td>No Grade Yet</td>";
	        
	        echo "</tr>";
        }
        
        echo "</table>";
        ?>
        <?php
        mysqli_close($connection);
        ?>
    </div>
    </html>
</div>

<BODY style="background:#F6F9FC; font-family:Calibri;" class="cbp-spmenu-push">

<div id="load_screen"><img src="images/monkeyload.gif" />loading document</div>


<!-- body has the class "cbp-spmenu-push" -->
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
<a href='studentHomePage2.php'><i class="fa fa-home"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Home</span></a>
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



	<div class="container">
		<div class="header">
			<img src="images/logo.png" alt="Ingenious logo" style="width:250px;">
			<!-- <span id="menu"><img src="images/menu.png" alt="Ingenious logo" style="width:70px;"> </span>-->
		</div>
		
		<div class="sticky-navigation"></div>
		<div class="contents">
			<div class="content">
				<div class="courses"> <h2>Courses</h2>
					<table id="courseTable">
						<?php $class_list = get_class_list(); ?>
					</table>
				</div>

				<span id='classTitle'></span><br />

				<div class="testEachCourse">
					<div class="loader"></div>
					<form id="form_table" name="testListForm" action="testTakingPage.php" method="post">
						<table id="testTable">
							<!-- Table Elements Generated By AJAX Script -->
						</table>
					</form>
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

   var class_list = <?php echo json_encode($class_list) ?>;
      //[0]-COURSE_NO [1]-SECTION_NO [2]-SECTION_ID [3]-COURSE_DESCRIPTION
   //get_class_test(Object.keys(class_list)[0], <?php //echo $first_user; ?>);
   get_class_test(<?php echo key($class_list); ?>, <?php echo $first_user; ?>);
   

   function get_class_test(section_no, student_id) {
      //$("#testTable").attr("display", "none");
      $("#testTable").fadeOut(1);
      $(".loader").fadeIn("slow");
      document.getElementById("classTitle").innerHTML = class_list[section_no];
      var data = 'php_control_student.php?section_no=' + section_no + '&student_id=' + student_id;
      $('#testTable').load(data, function (responseText, textStatus, XMLHttpRequest) {
         if (textStatus == "success") {
            //alert("donw");
         }
         if (textStatus == "error") {
            //alert(responseText);
         }
      });
   }
   $(document).ajaxComplete(function() {
      $(".loader").fadeOut(1);
      $("#testTable").fadeIn("slow");
   });

   //When Page Loads
   $(function() {
      page_resize();
   });
   //When Page Size Changes
   $( window ).resize(function() {
      page_resize();
   });
   function page_resize() {
      //alert($(window).height() + " " + $(document).height());
      $('#classTitle').css("left", 180 + ($(window).width() - 1100) / 2);
      $('.courses').css("max-height", $(window).height() - 250);
      $('.testEachCourse').css("left", 180 + ($(window).width() - 1100) / 2);
      $('.testEachCourse').css("min-height", $(window).height() - 280 );
	  $('.contents').css("min-height", $(window).height() - 150 );
   }

</script>

<?php
if( isset( $_SESSION['section_id'] ) ) {
   echo '<script type="text/javascript"> get_class_test('.$_SESSION['section_id'].','.$first_user.'); </script>';
   unset($_SESSION['section_id']);
}
?>
