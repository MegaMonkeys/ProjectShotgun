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
      <div id="load_screen"><img src="images/megamonkeysloading.png" /> </div>

      <div id="header">
         <img src="images/header.png" class="header"/>
         <img src="images/logo.png" class="testLogo"/>

         <form action="logout.php" method="post">
            <input type="submit" value="Sign out" class="logout-button">
         </form>
      </div>
   <div id="wrap">
         <div id="content">
            <table>
               <tr>

                  <td id="left">
                      <form action="#.php" method="post">

                     <div class="informationForm">
                        Class : &nbsp;
                        <select name="courseNo" class="inputs">
                           <option value="CS214">CS 214</option>
                           <option value="CS306">CS 306</option>
                           <option value="CS414">CS 414</option>
                           <option value="BA303">BA 303</option>
                        </select>
                        &nbsp;
                        Section : <select name="sectionNo" class="inputs">
                           <option value="1">1</option>
                           <option value="2">2</option>
                           <option value="3">3</option>
                        </select><br />
                        Start : &nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name="startDate" class="inputs"> <input type="time" class="inputs" name="startTime"><br />
                        End : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" id="endDate" class="inputs"> <input type="time" class="inputs" name="endTime"><br />
                        Time limit : &nbsp;<input type="number" name="hours" min="0" max="10" class="inputs" placeholder="0"> hr &nbsp;
                        &nbsp;&nbsp;&nbsp;
                        <input type="number" name="minutes" min="0" max="60" class="inputs" placeholder="50"> min

                     <div id="optionButton">
                     <button type="submit" value="publish" id="publish" name="publish"></button>&nbsp;&nbsp;&nbsp;
                      <button type="submit" value="save" id="save" name="save"></button>&nbsp;&nbsp;&nbsp;
                      <button type="submit" value="preview" id="preview" name="preview"></button>&nbsp;&nbsp;&nbsp;
                      <button type="submit" value="cancel" id="cancel" name="cancel"></button>
                     </div>
                     </div>
                      <div id="optionName">Publish&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Save&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Preview&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Cancel
                     </div>

                      </form>
                     <form id="buttonArea" >
                        <div id="form_question"> <!-- Question Types (YC) -->
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
                                  style="width: 98%; height:100px;">
                           This test is completely my own work.
                           I have not had anyone or anything aid me in answering the questions,
                           including Internet search engines, such as Google, Bing, ect.
                           I have not received, nor will I give any information regarding this test.
                           </textarea> <!-- width:600px; -->
                        </div>
                     </div>
                  </td>
               </tr>
            </table>
         </div>
   </div>

      <div id="footer">
         &copy; MegaMonkey Group - Pensacola Christian College 2015
      </div>
   <img src="images/footerblue.png" class="footerblue"/>
   </BODY>
</HTML>