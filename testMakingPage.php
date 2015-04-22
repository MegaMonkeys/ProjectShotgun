<?php
   session_start();
   include_once 'sessionCheck.php';
   user_type_check('Teacher');
?>

<!DOCTYPE html>
<HTML>
   <HEAD>
      <link rel="stylesheet" type="text/css" href="tooltip.css">
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
      <link rel="stylesheet" href="font-awesome-4.3.0/css/font-awesome.min.css">
      <?php include_once 'testMakingPage_control.php'; ?>

      <!-- DatePicker API (YoungChan) -->
      <link rel="stylesheet" type="text/css" href="./jquery_api/jquery.datepick.css">
      <script type="text/javascript" src="./jquery_api/jquery.plugin.js"></script>
      <script type="text/javascript" src="./jquery_api/jquery.datepick.js"></script>

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

            $(document).ready(function(){
               $("button").click(function(){
               //$("p:first").replaceWith("Hello world!");
            });
         });
		 
<!-- INSERTED BY G3 FOR POPUPS!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->		
// Publish Dialog Box 
	$(function() {
		$( "#dialog-confirm-publish" ).dialog({
		autoOpen: false,
		resizable: false,
		height: 250,
		width:  400,
		modal: true,
		show: {
			effect: "blind",
			duration: 1000
		},
		hide: {
			effect: "explode",
			duration: 1000
		},
		buttons: {
			"Publish!!!": function() {
			$( this ).dialog( "close" );
				document.form.action="create_test.php";
					document.form.submit();
			},
			Cancel: function() {
			$( this ).dialog( "close" );
			}
		}
	});

    $( "#publish" ).click(function() {
       if(validateForm('publish'))
         if(publish_check())
            $( "#dialog-confirm-publish" ).dialog( "open" );
    });
  });  
// Save Dialog Box
	$(function() {
		$( "#dialog-confirm-save" ).dialog({
		autoOpen: false,
		resizable: false,
		height: 250,
		width:  400,
		modal: true,
		show: {
			effect: "blind",
			duration: 1000
		},
		hide: {
			effect: "explode",
			duration: 1000
		},
		buttons: {
			"Save for Later...": function() {
			$( this ).dialog( "close" );
				document.form.action="create_test.php";
				document.form.submit();
			},
			Cancel: function() {
			$( this ).dialog( "close" );
			}
		}
	});
	
    $( "#save" ).click(function() { //alert($('#startTime').val() > $('#endTime').val());
       if(validateForm('save'))
            $( "#dialog-confirm-save" ).dialog( "open" );
    });
  });
// Cancel Dialog Box
	$(function() {
		$( "#dialog-confirm-cancel" ).dialog({
		autoOpen: false,
		resizable: false,
		height: 250,
		width:  700,
		modal: true,
		show: {
			effect: "blind",
			duration: 1000
		},
		hide: {
			effect: "explode",
			duration: 1000
		},
		buttons: {
			"Return to Test Creation": function() {
			$( this ).dialog( "close" );
				$( this ).dialog( "close" );
			},
			"Leave And Return to Home Page": function() {
				window.location.assign("./teacherHomePage.php");
			}
		}
	});
	
    $( "#cancel" ).click(function() {
      $( "#dialog-confirm-cancel" ).dialog( "open" );
    });
  });
<!-- INSERTED BY G3 FOR POPUPS!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->

      </script>

      <TITLE>
         INGENIOUS
      </TITLE>
      <link rel="icon" type="logo/png" href="images/monkeyhead.png">
   </HEAD>

   <BODY  style="font-family:Calibri;" class="cbp-spmenu-push"><!-- oncontextmenu="return false" onselectstart="return false" ondragstart="return false">-->

<div id="load_screen"><img src="images/monkeyload.gif" id="imageLoad"/></div>  

  <div class="container">
        <div class="header">
            <a href="./teacherHomePage.php" id="logo"><img src="images/logo.png" alt="Ingenious logo" style="width:250px;"></a>
        </div>
			<div class="main">
			 <section class="buttonset">
				<!-- Class "cbp-spmenu-open" gets applied to menu and "cbp-spmenu-push-toleft" or "cbp-spmenu-push-toright" to the body -->
				<a href="#" id="showRightPush" class="button tooltip-bottom" data-tooltip='Menu' style="margin-top:-5px"><!--<img src="images/menu.png" class="menuImage" />--></a>
			 </section>
			</div>

        <div class="sticky-navigation">
        </div>
        <div class="contents">
   <!-- body has the class "cbp-spmenu-push" -->
  <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
     <span id="name_tab"><?php echo $_SESSION['user_name'][0].' '.$_SESSION['user_name'][1]; ?></span>
     <a href='teacherHomePage.php'><i class="fa fa-home"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Home</span></a>
     <a href='aboutUs.php'><i class="fa fa-info"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;About Us</span></a>
     <a href='teampage.php'><i class="fa fa-user"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Developers</span></a>
     <a href='helpPage.php'><i class="fa fa-question"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Need Help?</span></a>
     <a href='logout.php' class="last"><i class="fa fa-sign-out"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sign Out</span></a>
  </nav>
  <!--<form action="logout.php"><input type="submit" value="Sign out" class="logout-button"></form>-->
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


      var menuRight = document.getElementById( 'cbp-spmenu-s2' ),
          showRightPush = document.getElementById( 'showRightPush' ),
          body = document.body;

      showRightPush.onclick = function() {tessss();
         classie.toggle( this, 'active' );
         classie.toggle( body, 'cbp-spmenu-push-toleft' );
         classie.toggle( menuRight, 'cbp-spmenu-open' );
      };
   </script>
   <!-- END of JavaScript to make Hidden Side Menu Work -->

   <div id="wrap">
      <!--<div class="loader" align="center"></div>-->
         <div id="content">
            <form name="form" method="post" action="javascript:void(0);">
				<input type="text" class="button_type" id="button_type" name="button_type" style="display:none;">
				<input type="text" class="button_id" id="button_id" name="button_id" style="display:none;">
<!-- INSERTED BY G3 FOR POPUPS!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
				<div id="dialog-confirm-publish" title="Are you sure about this?" style="background-color: #ADD6FF; ">
					<p>
						<div style="font-size: 20px;">Are you sure you wish to publish this test? Not only will it be saved, students will then be able to view and take this test.
						</div>
					</p>
				</div>
				<div id="dialog-confirm-save" title="Is this your intended action?" style="background-color: #ADD6FF; ">
					<p>
						<div style="font-size: 20px;">Are you sure you wish to save this test? Students will NOT be able to view or take it; however, you will be able to edit it later.
						</div>
					</p>
				</div>
				<div id="dialog-confirm-cancel" title="Did you mean to do this?" style="background-color: #ADD6FF; ">
					<p>
						<div style="font-size: 20px;">Are you sure you want to stop creating this test? Keep in mind that this test is not saved unless you explicitly save it, and any progress made on the creation of this test WILL BE LOST!!!
						</div>
					</p>
				</div>
<!-- INSERTED BY G3 FOR POPUPS!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
               <table>
                  <tr>
                     <td id="left">
                         
                        <div class="informationForm">
                           
                           
                           <!--Start : &nbsp;&nbsp;&nbsp;&nbsp;<input type="date" id="startDate"  name="startDate" class="inputs"> <input type="time" class="inputs" id="startTime" name="startTime"><br />
                           End : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" id="endDate" name="endDate" class="inputs"> <input type="time" class="inputs" id="endTime" name="endTime"><br />
                           Time limit : &nbsp;<input type="number" id="hours" name="hours" min="0" max="10" class="inputs" placeholder="0" size="2"> hr &nbsp;
                           &nbsp;&nbsp;&nbsp;
                           <input type="number" id="minutes" name="minutes" min="0" max="60" class="inputs" placeholder="50" size="2"> min-->
                           <table>
                              <tr>
                                 <td style="width:auto">Class </td>
                                 <td>
                                    <select id="courseNo" name="courseNo" class="inputs" style="width:80px; margin-right:20px;" onchange="get_sections()"><?php include 'db_connection.php'; get_course_list($connection); get_section_list($connection); mysqli_close($connection) ?></select>
                                    Section <select id="sectionNo" name="sectionNo" class="inputs" style="width:50px;"></select>
                                 </td>
                              </tr>
                              <tr>
                                 <td>Start</td>
                                 <td>
                                    <!--<input type="date" class="inputs" id="startDate" name="startDate" style="width:135px;">-->
                                       <input type="time" class="inputs" id="startTime" name="startTime" style="width:90px; display: none;">
                                    <input type="text" class="inputs" id="startDate" name="startDate" placeholder="yyyy-mm-dd" style="width:100px;">
                                    <select id="start_time_hour" class="inputsTime start_time_change">
                                       <?php get_time_hour_list(); ?>
                                    </select>
                                    <select id="start_time_min" class="inputsTime start_time_change">
                                       <?php get_time_min_list(); ?>
                                    </select>
                                    <select id="start_time_ampm" class="inputsTime start_time_change">
                                       <option value="AM">AM</option>
                                       <option value="PM">PM</option>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td>End</td>
                                 <td>
                                    <!--<input type="date" class="inputs" id="endDate" name="endDate" style="width:135px;">-->
                                       <input type="time" class="inputs" id="endTime" name="endTime" style="width:90px; display: none;">
                                    <input type="text" class="inputs" id="endDate" name="endDate" placeholder="yyyy-mm-dd" style="width:100px;">
                                    <select id="end_time_hour" class="inputsTime end_time_change">
                                       <?php get_time_hour_list(); ?>
                                    </select>
                                    <select id="end_time_min" class="inputsTime end_time_change">
                                       <?php get_time_min_list(); ?>
                                    </select>
                                    <select id="end_time_ampm" class="inputsTime end_time_change">
                                       <option value="AM">AM</option>
                                       <option value="PM">PM</option>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td>Time Limit</td>
                                 <td>
                                    <input type="number" id="hours" style="text-align: center;" name="hours" min="0" max="23" class="inputs" onkeydown="return isNumberKey(event)" onkeyup="isNum(this)" onblur="numCheck(this)" placeholder="1" value="1" size="2" > hr
                                    <input type="number" id="minutes" style="margin-left:20px; text-align: center;" name="minutes" min="0" max="59" class="inputs" onkeydown="return isNumberKey(event)" onkeyup="isNum(this)" onblur="numCheck(this)" placeholder="0" value="0" size="3" > min
                                 </td>
                              </tr>
                           </table>

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

                           <div id="optionButton">
                              <table id="optionButtonTable">
                                 <tr>
                                    <td><button type="submit" id="publish" name="publish" value ="publish" onclick="$('#button_type').attr('value','publish');" ></button></td> <!--onclick="publish_test()"-->
                                    <td><button type="submit" id="save"    name="save"    value="save"     onclick="$('#button_type').attr('value','save');"></button></td>
                                    <!--<td><button type="submit" value="preview" id="preview" name="preview" onclick="preview_test()"></button></td>-->
                                    <td><button type="submit" id="cancel"  name="cancel"  value="cancel" > </button></td>
                                 </tr>
                                 <tr>
                                    <td>Publish</td>
                                    <td>Save</td>
                                    <!--<td>Preview</td>-->
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
                           Test Name:  &nbsp;<input required class="required_field inputs" type="text" id="testName" name="testName" placeholder="Test Name" size="45" style="font-size:18px; width:80%;"> <!--class="inputs"-->

                           <!--<div>
                              <div id="text_instruc_heading">CS 414 Test Instruction</div>
                              <textarea id="test_inst_text" name="test_instruc_text" rows="4" placeholder="Enter Test Instructions . . ."></textarea>
                           </div>-->

                           <hr align="left" style="margin-top: 5px">

                           <!-- Where Questions Will Be Placed (YC) -->
                           Questions: <br />
                           <div id="field_question">
                              <ul id="sortable2" class="connectedSortableF">
                              
                              </ul>
                           </div>
                           <div>
                           PLEDGE:<br />
                           <textarea required class="required_field inputs" id="pledge_text" type="text" name="pledge"
                                     rows="3" style="width: 98%; height: auto;"></textarea> <!-- width:600px; --> <!--class="inputs"-->
                           </div>
                        </div>
                     </td>
                  </tr>
               </table>
            </form>
         </div>
   </div>
     <div id="info_loading"></div>

    </div>
      <div class="footer">
         &copy; MegaMonkeys, Inc.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/monkeyhead2.png" class="monkeyheadfooter"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pensacola Christian College 2015
      </div>
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
   function get_time() {
      var now = new Date();
      var time = now.getHours()+":"+now.getMinutes()+":"+now.getSeconds();
      return time;
   }
   function get_time_ampm() {
      var now = new Date();
      var hour = now.getHours();
      var ampm = (hour>=12)? "PM" : "AM";
      var min  = now.getMinutes();

      var hour = (hour>12)? hour-12 : ((hour==0)? 12:hour);

      var time = ((hour < 10)? "0"+hour: hour) + ":" + ((min < 10)? "0"+min: min) +" "+ampm;
      return time;

   }

   $(document).ready(function(){
      var today = get_today();

      $("#startDate").val(today);
      $("#startTime").val('00:00:00');
      $("#start_time_hour").val('12');
      $("#start_time_min").val('0');
      $("#start_time_ampm").val('AM');

      $("#endDate").val(today);
      $("#endTime").val('23:55:00');
      $("#end_time_hour").val('12');
      $("#end_time_min").val('55');
      $("#end_time_ampm").val('PM');

		var post_section = <?php echo (isset($_POST['creat_section'])? $_POST['creat_section']: -1); ?>;
		//alert(post_section);
      if( post_section != -1 ) {
         //DEFAULT COURSE_SECTION SELECTION
         document.getElementById('sectionNo').innerHTML = <?php echo json_encode($GLOBALS['section_list']) ?>;
         document.getElementById("sectionNo").value = post_section;

         var e = document.getElementById("sectionNo");
         var strUser = e.options[e.selectedIndex].className;

         document.getElementById("courseNo").value = strUser;
         get_sections();
         document.getElementById("sectionNo").value = post_section;
      }
   });

   get_sections();

   function set_time(time_data,start_end)
   {
      //alert(time_data);
      //alert(time_data.split(":"));
      var hour = parseInt(time_data.split(":")[0]);
      var min  = parseInt(time_data.split(":")[1]);
      var ampm = "AM";
      if(hour>=12) {
         ampm = "PM";
         hour = hour - 12;
      }
      if(hour==0)
        hour = 12;
      if(min%5!=0)
         min = min - min%5;
      $("#"+start_end+"_time_hour").val(hour);
      $("#"+start_end+"_time_min").val(min);
      $("#"+start_end+"_time_ampm").val(ampm);
   }

   function get_test(t_no)
   {
      $("#content").fadeOut(1);
      $("#load_screen").fadeIn("slow");//$(".loader").fadeIn("slow");
      var data = 'testMakingPage_control.php?load=1&test_no=' + t_no;
      $('#info_loading').load(data);
      var data = 'testMakingPage_control.php?action=load&test_no=' + t_no;
      $('#sortable2').load(data, function (responseText, textStatus, XMLHttpRequest) {
         if (textStatus == "success") {
            resetQnum();
            $("#sortable2").css({"height": "auto"});
            $("#sortable2").css("background-image", "none");
         }
         if (textStatus == "error") {
         }
      });
   }
   $(document).ajaxComplete(function() {
      $("#load_screen").fadeOut(1);//$(".loader").fadeOut(1);
      $("#content").fadeIn("slow");
   });

   function publish_test() {
      alert("Not Yet !!");
   }
   function preview_test() {
      alert("Under Construction");
   }
// Commented out by G3!!!!!!!!!!!!!!!!!! This code's function is now handled by a popup!!!!!
//   function cancel_test() {
//      publish_check();
//      if( confirm("Are You Sure ?") ) {
//         window.location.assign("./teacherHomePage.php");
//      }
//      else
//         alert("OK");
//   }
   /////////////////////////////////////


   /*function get_section() {
    var data = 'testMakingPage_control.php?action=' + <?php //echo $_SESSION['user_id']; ?> + '&course_no=' + $('#courseNo').val();
    $('#sectionNo').load(data);
    }*/
</script>

<?php
   if( isset( $_GET['test_no'] ) ) {
      if( test_no_check($_GET['test_no']) ) {
         echo "<script type='text/javascript'>get_test(" . $_GET['test_no'] . ");</script>";
         //echo "<script type='text/javascript'>$('#save').attr('value'," . $_GET['test_no'] . ");</script>";
         //echo "<script type='text/javascript'>$('#publish').attr('value'," . $_GET['test_no'] . ");</script>";
		 echo "<script type='text/javascript'>$('#button_id').attr('value'," . $_GET['test_no'] . ");</script>";
      }
      else {
         echo "<script type='text/javascript'>window.location.assign('./teacherHomePage.php');</script>";
      }
   }
   else
      echo "<script type='text/javascript'>$('#load_screen').fadeOut(1);//$('.loader').fadeOut(1);</script>";
?>

<!-- PHP FUNCTIONS FOR startTime & EndTime -->
<?php
function get_time_hour_list() {
   for($i=1; $i<=12; $i++)
      echo '<option value="'.$i.'">'.$i.'</option>';
}
function get_time_min_list() {
   for($i=0; $i<=55; $i+=5)
      echo '<option value="'.$i.'">'.$i.'</option>';
}
?>