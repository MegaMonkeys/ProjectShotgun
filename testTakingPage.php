<?php
   session_start();
   include_once 'sessionCheck.php';
   user_type_check('Student');
?>

<!DOCTYPE html>
<HTML>
<link rel="stylesheet" type="text/css" href="testTakingPage.css">
<script src="tabcontent.js" type="text/javascript"></script>
<script src="jquery-1.11.2.js"></script>
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
    <script type="text/javascript">
        function submitTest()
        {
            document.forms['testForm'].submit();
        }
    </script>
    <TITLE>
        MegaTest - Online Testing Application
    </TITLE>
    <?php
        $testID = isset($_POST['takeTestButton']) ? $_POST['takeTestButton'] : '-1';
        $studentID = $_SESSION['user_id'];
        $startTime = date("Y-m-d H:i:s");
		
        include 'db_connection.php';
        if($testID != '-1')
        {
            $sqlComm = "insert into student_test (student_id, test_id, date_time)
                        values (".$studentID.", ".$testID.", '".$startTime."')";
            mysqli_query($connection, $sqlComm);
        }
        else
            echo "Test ID = -1";
    ?>
</HEAD>

<BODY style="background:#F6F9FC; font-family:Arial;">
<div id="load_screen"><img src="images/megamonkeysloading.png" />loading document</div>
<div class="header">
    <img src="images/header.png" class="header"/>
    <img src="images/logo.png" class="testLogo"/>
    <form action="logout.php"><input type="submit" value="Sign out" class="logout-button"></form>
</div>

<div id='cssmenu'>
    <ul>
        <li class='loginPage.html'><a href='#'><span>Home</span></a></li>
        <li><a href='#'><span>About</span></a></li>
        <li><a href='#'><span>Team</span></a></li>
        <li class='last'><a href='#'><span>Contact</span></a></li>
    </ul>
</div>

<?php
    $sqlComm = 'select course_no, section_no, test_name, time_limit from test join section using (section_id) where test_id = '.$testID;
    $testInfo = mysqli_query($connection, $sqlComm);
    $infoRow = mysqli_fetch_row($testInfo);
?>

<div class="content"><button type="submit" class="submit-button" onclick="submitTest()">Submit</button>
    <div id="testInformation">
    <table>
        <tr>
            <td>Class:</td>
            <td><?php echo $infoRow[0].' - '.$infoRow[1]; ?></td>
        </tr>
        <tr>
            <td>Test:</td>
            <td><?php echo $infoRow[2]; ?></td>
        </tr>
        <tr>
            <td>Time limit:</td>
            <td><?php echo $infoRow[3]; ?></td>
        </tr>
    </table>
    </div>

    <span id='classTitle'></span><br />
    <div class="testQuestions">
        <form name="testForm" action="submit_test.php" method="post">
            <?php
                echo '<input type="text" name="testID" value="'.$testID.'" style="display:none;"/>';
                if($testID != '-1')
                {
                    $sqlComm = 'select ques_id, ques_no, ques_type, ques_text, points from question
                                    where test_id = '.$testID.' order by ques_no;';
                    $result = mysqli_query($connection, $sqlComm);
                    $numEntries = mysqli_num_rows($result);
                    
                    echo '<input type="text" name="numEntries" value="'.$numEntries.'" style="display:none" />';
                    echo '<table>';
                    
                    $qNum = 1;
                    for($x = 1; $x <= $numEntries; $x++)
                    {
                        $row = mysqli_fetch_row($result);
                        
                        if($row[2] === 'True/False')
                        {
                            echo '<tr><td id="trueFalse">';
                            echo '<table>';
                            echo '<tr>';
                            echo    '<td width="50px">'.$qNum.'.<input type="text" name="Q'.$x.'ID" value="'.$row[0].',True/False" style="display:none;"/></td>';
                            echo    '<td colspan="2" width="850"><span id="theQuestion">'.$row[3].'</span> ('.$row[4].')</td>';
                            echo '</tr><tr>';
                            echo     '<td></td>';
                            echo     '<td><input type="radio" name="Q'.$x.'A" value="True"> True</td>';
                            echo     '<td><input type="radio" name="Q'.$x.'A" value="False"> False</td>';
                            echo '</tr>';
                            echo '</table>';
                            echo '</td></tr>';
                            
                            $qNum++;
                        }
                        else if($row[2] === 'Multiple Choice')
                        {
                            $sqlComm = 'select ans_text from answer where ques_id = '.$row[0];
                            $answers = mysqli_query($connection, $sqlComm);
                            
                            echo '<tr><td id="multipleChoice">';
                            echo '<table>';
                            echo '<tr>';
                            echo    '<td width="50px">'.$qNum.'.<input type="text" name="Q'.$x.'ID" value="'.$row[0].',Multiple Choice" style="display:none;"/></td>';
                            echo    '<td colspan="2" width="850"><span id="theQuestion">'.$row[3].'</span> ('.$row[4].')</td>';
                            echo '</tr><tr>';
                            echo    '<td></td>';
                            $ans = mysqli_fetch_row($answers);
                            echo    '<td><input type="radio" name="Q'.$x.'A" value="'.$ans[0].'"> '.$ans[0].'</td>';
                            $ans = mysqli_fetch_row($answers);
                            echo    '<td><input type="radio" name="Q'.$x.'A" value="'.$ans[0].'"> '.$ans[0].'</td>';
                            echo '</tr><tr>';
                            echo    '<td></td>';
                            $ans = mysqli_fetch_row($answers);
                            echo    '<td><input type="radio" name="Q'.$x.'A" value="'.$ans[0].'"> '.$ans[0].'</td>';
                            $ans = mysqli_fetch_row($answers);
                            echo    '<td><input type="radio" name="Q'.$x.'A" value="'.$ans[0].'"> '.$ans[0].'</td>';
                            echo '</tr>';
                            echo '</table>';
                            echo '</td></tr>';
                            
                            $qNum++;
                        }
                        else if($row[2] === 'Many Choice')
                        {
                            $sqlComm = 'select ans_text from answer where ques_id = '.$row[0];
                            $answers = mysqli_query($connection, $sqlComm);
                            
                            echo '<tr><td id="manyChoice">';
                            echo '<table>';
                            echo '<tr>';
                            echo    '<td width="50px">'.$qNum.'.<input type="text" name="Q'.$x.'ID" value="'.$row[0].',Many Choice" style="display:none;"/></td>';
                            echo    '<td colspan="2" width="850"><span id="theQuestion">'.$row[3].'</span> ('.$row[4].')</td>';
                            echo '</tr><tr>';
                            echo    '<td></td>';
                            $ans = mysqli_fetch_row($answers);
                            echo    '<td><input type="checkbox" name="Q'.$x.'A1" value="'.$ans[0].'"> '.$ans[0].'</td>';
                            $ans = mysqli_fetch_row($answers);
                            echo    '<td><input type="checkbox" name="Q'.$x.'A2" value="'.$ans[0].'"> '.$ans[0].'</td>';
                            echo '</tr><tr>';
                            echo    '<td></td>';
                            $ans = mysqli_fetch_row($answers);
                            echo    '<td><input type="checkbox" name="Q'.$x.'A3" value="'.$ans[0].'"> '.$ans[0].'</td>';
                            $ans = mysqli_fetch_row($answers);
                            echo    '<td><input type="checkbox" name="Q'.$x.'A4" value="'.$ans[0].'"> '.$ans[0].'</td>';
                            echo '</tr>';
                            echo '</table>';
                            echo '</td></tr>';
                            
                            $qNum++;
                        }
                        else if($row[2] === 'Short Answer')
                        {
                            echo '<tr><td id="shortAnswer">';
                            echo '<table>';
                            echo '<tr>';
                            echo    '<td width="50px">'.$qNum.'.<input type="text" name="Q'.$x.'ID" value="'.$row[0].',Short Answer" style="display:none;"/></td>';
                            echo    '<td width="850"><span id="theQuestion">'.$row[3].'</span> ('.$row[4].')</td>';
                            echo '</tr><tr>';
                            echo    '<td></td>';
                            echo    '<td><input type="text" name="Q'.$x.'A" value=""></td>';
                            echo '</tr>';
                            echo '</table>';
                            echo '</tr></td>';
                            
                            $qNum++;
                        }
                        else if($row[2] === 'Essay')
                        {
                            echo '<tr><td id="essay">';
                            echo '<table>';
                            echo '<tr>';
                            echo    '<td width="50px">'.$qNum.'.<input type="text" name="Q'.$x.'ID" value="'.$row[0].',Essay" style="display:none;"/></td>';
                            echo    '<td width="850"><span id="theQuestion">'.$row[3].'</span> ('.$row[4].')</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo 	'<td></td>';
                            echo 	'<td><input type="text" name="Q'.$x.'A" value="" class="essayText"></td>';
                            echo '</tr>';
                            echo '</table>';
                            echo '</td></tr>';
                            
                            $qNum++;
                        }
                        else if($row[2] === "Instruction")
                        {
                            echo '<tr><td id="instruction">';
                            echo '<table>';
                            echo '<tr>';
                            echo    '<td width="50px"><input type="text" name="Q'.$x.'ID" value="'.$row[0].',Instruction" style="display:none;"/></td>';
                            echo    '<td width="850"><span id="theQuestion"><b>'.$row[3].'</b></span></td>';
                            echo '</tr>';
                            echo '</table>';
                            echo '</td></tr>';
                        }
                        else
                        {
                            echo '<tr><td>A question didn\'t display correctly.</td></tr>';
                        }
                    }
                    mysqli_close($connection);
                }
                else
                {
                    echo '<tr><td>No Test Selected</td></tr>';
                }
                echo '</table>';
            ?>
       </form>
   </div>
</div>


<div class="footer"></br>
   <img src="images/footerblue.png" class="footerblue"/>
   <ft>&copy; MegaMonkeys, Inc. - Pensacola Christian College 2015</ft>
</div>
</BODY>
</HTML>