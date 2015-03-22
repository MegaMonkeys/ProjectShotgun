<?php
   session_start();
   include_once 'sessionCheck.php';
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
         MegaTest - Online Testing Application
      </TITLE>

   </HEAD>
   <BODY><!-- oncontextmenu="return false" onselectstart="return false" ondragstart="return false">-->
      <div id="load_screen"><img src="images/megamonkeysloading.png" /> </div>

      <div id="header"> <!-- 100 -->
         <img src="images/header.png" class="header"/> <!-- 100/26 -->
         <img src="images/logo.png" class="testLogo"/> <!-- 50 -->

         <form action="logout.php" method="post">
            <input type="submit" value="Sign out" class="logout-button">
         </form>
      </div>

   <div id='cssmenu'>
      <ul>
         <li class='loginPage.html'><a href='./teacherHomePage.php'><span>Home</span></a></li>
         <li><a href='#'><span>About</span></a></li>
         <li><a href='#'><span>Team</span></a></li>
         <li class='last'><a href='#'><span>Contact</span></a></li>
      </ul>
   </div>
   <div id="wrap">
      <div class="loader" align="center"></div>
         <div id="content">
            <form method="post" action="javascript:void(0);">
               <table>
                  <tr>
                     <td id="left">
                         
                        <div class="informationForm">
                           Class : &nbsp;
                           <select id="courseNo" name="courseNo" class="inputs" onchange="get_section()">
                              <?php get_course_list(); ?>
                           </select>
                           &nbsp;
                           Section :
                           <select id="sectionNo" name="sectionNo" class="inputs">
                              <?php get_section_list(); ?>
                           </select><br />
                           Start : &nbsp;&nbsp;&nbsp;&nbsp;<input type="date" id="startDate"  name="startDate" class="inputs"> <input type="time" class="inputs" id="startTime" name="startTime"><br />
                           End : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" id="endDate" name="endDate" class="inputs"> <input type="time" class="inputs" id="endTime" name="endTime"><br />
                           Time limit : &nbsp;<input type="number" id="hours" name="hours" min="0" max="10" class="inputs" placeholder="0"> hr &nbsp;
                           &nbsp;&nbsp;&nbsp;
                           <input type="number" id="minutes" name="minutes" min="0" max="60" class="inputs" placeholder="50"> min

                           <div id="optionButton">
                              <table>
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

                        <form id="buttonArea" >
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

   <div class="footer"></br>
      <img src="images/footerblue.png" class="footerblue"/>
      <ft>&copy; MegaMonkeys, Inc. - Pensacola Christian College 2015</ft>
   </div>

   </BODY>
</HTML>

<script type="text/javascript">
   $(document).ready(function() {
      $.ajaxSetup({ cache: false });
   });

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
      alert("Are You Sure ?");
   }
</script>

<?php
   if( isset( $_GET['test_no'] ) ) {
      echo "<script type='text/javascript'>get_test(" . $_GET['test_no'] . ");</script>";
      echo "<script type='text/javascript'>$('#save').attr('value'," . $_GET['test_no'] . ");</script>";
   }
   else
      echo "<script type='text/javascript'>$('.loader').fadeOut(1);</script>";
?>