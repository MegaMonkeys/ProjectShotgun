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
               $("p:first").replaceWith("Hello world!");
            });
         });
      </script>

      <TITLE>
         MegaTest - Online Testing Application
      </TITLE>

   </HEAD>
   <BODY><!-- oncontextmenu="return false" onselectstart="return false" ondragstart="return false">-->
      <div id="load_screen"><img src="images/megamonkeysloading.png" />loading document</div>

      <div id="header">
         <img src="images/header.png" class="header"/>
         <img src="images/logo.png" class="testLogo"/>
         <div class="title"></div>
         <form action="logout.php" method="post">
            <input type="submit" value="Sign out" class="logout-button">
         </form>
      </div>

   <div id="wrap">
         <div id="content">
            <table>
               <tr>

                  <td id="left">
                     <br />
                     You are login as <span> </span> <br />
                     <div class="informationForm">
                        Class : &nbsp;
                        <select class="inputs">
                           <option value="CS214">CS 214</option>
                           <option value="CS306">CS 306</option>
                           <option value="CS414">CS 414</option>
                           <option value="BA303">BA 303</option>
                        </select>
                        Section : &nbsp;&nbsp;<select class="inputs">
                           <option value="1">1</option>
                           <option value="2">2</option>
                           <option value="3">3</option>
                        </select><br />
                        Start : &nbsp;&nbsp;<input type="date" name="startDate" class="inputs"> <input type="time" class="inputs" name="startTime"><br />
                        End  : &nbsp;&nbsp;<input type="date" id="endDate" class="inputs"> <input type="time" class="inputs" name="endTime"><br />
                        Time limit : &nbsp;<input type="number" name="hours" min="0" max="10" class="inputs" placeholder="1"> &nbsp; hr &nbsp;
                        <input type="number" name="minute" min="0" max="60" class="inputs" placeholder="45"> &nbsp; min
                     </div>
                     <form id="buttonArea" >
                        <div id="form_question"> <!-- Question Types (YC) -->
                           Question Form : - <br>
                           <ul id="sortable1" class="connectedSortable">

                           </ul>
                        </div>
                     </form>
                  </td>

                  <td id="middle">
                     <div class="scroll">
                        Test Name:  &nbsp;<input type="text" name="testName" class="inputs" placeholder="Test #1">

                        <div>
                           <div id="text_instruc_heading">CS 414 Test Instruction</div>
                           <textarea id="test_inst_text" name="test_instruc_text" rows="4">Enter Test Instructions . . .</textarea>
                        </div>

                        <hr align="left"> 

                        <!-- Where Questions Will Be Placed (YC) -->
                        Questions : - <br>
                        <div id="field_question">
                           <ul id="sortable2" class="connectedSortableF">
                           
                           </ul>
                        </div>
                        <div>
                        PLEDGE:<br />
                        <input id="pledge_text" type="text" name="pledge" class="inputs"
                           value="This is a pledge. This is a pledge. This is a pledge. This is a pledge. This is a pledge. This is a pledge. "
                           style="width: 98%; height:100px;"> <!-- width:600px; -->
                        </div>
                     </div>
                  </td>
                  </td>

               </tr>
            </table>
         </div>
   </div>

      <div id="footer">
         <img src="images/footerblue.png" class="footerblue"/>
         &copy; MegaMonkey Group - Pensacola Christian College 2015
      </div>

   </BODY>
</HTML>
