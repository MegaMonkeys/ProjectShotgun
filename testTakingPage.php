<?php
   session_start();
   include_once 'sessionCheck.php';
   user_type_check('Student');
?>

<!DOCTYPE html>
<HTML>
<link rel="stylesheet" type="text/css" href="testTakingPage.css">
<link rel="stylesheet" type="text/css" href="stylesheet.css">
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
    <?php
        $testID = isset($_POST['takeTestButton']) ? $_POST['takeTestButton'] : '-1';
        $studentID = $_SESSION['user_id'];
        
        include 'db_connection.php';
        
        //Gets DB Current Time
        $sql_now = "SELECT NOW()";
        $sql_now_result = mysqli_query($connection, $sql_now);
        $row = mysqli_fetch_row($sql_now_result);
        $current_datetime = $row[0];

        $sqlComm = 'select course_no, section_no, test_name, time_limit from test join section using (section_id) where test_id = '.$testID;
        $testInfo = mysqli_query($connection, $sqlComm);
        $infoRow = mysqli_fetch_row($testInfo);
    ?>
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
        
        // Countdown timer
        var interval;
        
        var duration = "00:01:04<?php // echo $infoRow[3]; ?>";
        var time = duration.split(":");
        var hours = parseInt(time[0]);
        var minutes = parseInt(time[1]);
        var seconds = parseInt(time[2]);
        
		function timer()
		{
            seconds -= 1;
            if(seconds < 0)
            {
                if(minutes > 0)
                {
                    minutes -= 1;
                    seconds = 59;
                }
                else if(hours > 0)
                {
                    hours -= 1;
                    minutes = 59;
                    seconds = 59;
                }
                else
                {
                    seconds = 0;
                    alert("time up");
                    clearInterval(interval);
                }
            }
            document.getElementById("timer").innerHTML = (hours < 10 ? "0" : "") + hours + ":" +
                                                     (minutes < 10 ? "0" : "") + minutes + ":" +
                                                     (seconds < 10 ? "0" : "") + seconds;
		}
    </script>
    <TITLE>
        MegaTest - Online Testing Application
    </TITLE>

</HEAD>

<BODY  onload="interval = setInterval('timer()', 1000)">
<div id="load_screen"><img src="images/megamonkeysloading.png" /></div>
	<div class="header">
		<img src="images/logo.png" alt="Ingenious logo" style="width:250px;">
		<span id="menu"><img src="images/menu.png" alt="Ingenious logo" style="width:70px;"> </span>
	</div>
		
		<div class="container">
        
        <div class="sticky-navigation">
        </div>
        <div class="contents">


<div class="content">
	<button type="submit" class="submit-button" onclick="submitTest()">Submit</button>
    <div id="testInformation">
		<table class="informationTable">
			<tr>
				<td>Class:</td>
				<td><?php echo $infoRow[0].' - '.$infoRow[1]; ?></td>
			</tr>
			<tr>
				<td>Test:</td>
				<td><?php echo $infoRow[2]; ?></td>
			</tr>
			<tr>
				<td>Time:</td>
				<td id="timer" name="timer">--:--:--</td>
			</tr>
		</table>
    </div>

    <div class="testQuestions">
        <form name="testForm" action="submit_test.php" method="post">
            <?php
                echo '<input type="text" name="startTime" value="'.$current_datetime.'" style="display:none;"/>';
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

</div>
        <div class="footer">
            &copy; MegaMonkeys, Inc. - Pensacola Christian College 2015
        </div>
</div>
</BODY>
</HTML>



<script type="text/javascript">
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
      $('.contents').css("min-height", $(window).height() - 185 );
   }

</script>