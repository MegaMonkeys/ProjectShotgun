<?php
   session_start();
   include_once 'sessionCheck.php';
   user_type_check('Student');
?>

<!DOCTYPE html>
<HTML>
<link rel="stylesheet" type="text/css" href="testTakingPage.css">
<link rel="stylesheet" type="text/css" href="stylesheet.css">
<link rel="stylesheet" href="./jquery_api/jquery-ui.css">
<script src="tabcontent.js" type="text/javascript"></script>
<script src="jquery-1.11.2.js"></script>
<script src="./jquery_api/jquery-1.10.2.js"></script>
<script src="./jquery_api/jquery.min.js"></script>
<script src="./jquery_api/jquery-ui.js"></script>
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
        $current_datetime = date_create($row[0]);
        
        // Delete old test if this test is a retake
        $existingTest = mysqli_query($connection, 'select test_id from student_test where test_id = '.$testID.' and student_id = '.$studentID);
        if($testID != '-1' && mysqli_num_rows($existingTest) == 0)
        {
            $sqlComm = "insert into student_test (student_id, test_id, date_time) values (".$studentID.", ".$testID.", NOW())";
            mysqli_query($connection, $sqlComm);
        }

        // Get the test information
        $sqlComm = 'select course_no, section_no, test_name, time_limit, date_time
                    from test join section using (section_id) left outer join student_test using (test_id) where test_id = '.$testID.' and student_id = '.$studentID;
        $testInfo = mysqli_query($connection, $sqlComm);
        $infoRow = mysqli_fetch_row($testInfo);
        
        // Add time limit to start time, to determine if there is still time left in the test.
        $timeStarted = date_create($infoRow[4]);
        $timeLimit = date_create($infoRow[3]);
        $hoursLeft = date_format($timeLimit, "G"). " hours";
        $minutesLeft = date_format($timeLimit, "i"). " minutes";
        $studentEndTime = date_add(date_create($infoRow[4]), date_interval_create_from_date_string($hoursLeft));
        $studentEndTime = date_add($studentEndTime, date_interval_create_from_date_string($minutesLeft));
        
        $timeLeft = date_diff($current_datetime, $studentEndTime);
        $strTimeLeft = date_interval_format($timeLeft, "%H:%I:%S:%r");
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
		
		<!-- INSERTED BY G3 FOR POPUPS!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->		
	$(function() {
		$( "#dialog-confirm-submit" ).dialog({
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
			"Submit!!!": function() {
			$( this ).dialog( "close" );
				submitTest();
				//document.form.submit();
			},
			Cancel: function() {
			$( this ).dialog( "close" );
			}
		}
	});

    $( "#submit" ).click(function() {
      $( "#dialog-confirm-submit" ).dialog( "open" );
    });
  });  
<!-- INSERTED BY G3 FOR POPUPS!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->

		
        
        // Countdown timer
        var interval;
        
        var duration = "<?php echo $strTimeLeft; ?>";
        var time = duration.split(":");
        var hours = parseInt(time[0]);
        var minutes = parseInt(time[1]);
        var seconds = parseInt(time[2]);
        
        if(time[3] == "-")
            hours = minutes = seconds = 0;
        
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
                    // Display pop-up here
                   // alert("time up");
	$( "#dialog-confirm-submit" ).dialog({
		autoOpen: true,
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
			"Submit!!!": function() {
			$( this ).dialog( "close" );
				submitTest();
			}
		}
	});

                    clearInterval(interval);
                }
            }
            document.getElementById("timer").innerHTML = (hours < 10 ? "0" : "") + hours + ":" +
                                                     (minutes < 10 ? "0" : "") + minutes + ":" +
                                                     (seconds < 10 ? "0" : "") + seconds;
		}
    </script>
    <TITLE>
       INGENIOUS
    </TITLE>

</HEAD>

<BODY style="font-family:Calibri;" class="cbp-spmenu-push" onload="interval = setInterval('timer()', 1000)">
<div id="load_screen"><img src="images/megamonkeysloading.png" /></div>
	<div id="dialog-confirm-submit" title="Pledge" style="background-color: #ADD6FF; ">
		<p>
			<div style="font-size: 20px;">Please
			</div>
			<input type="textbox" value="My Name" onclick="this.select()" style="width:350px;">
		</p>
	</div>
	<div class="header">
		<img src="images/logo.png" alt="Ingenious logo" style="width:250px;">
      <!--<span id="menu"><img src="images/menu.png" alt="Ingenious logo" style="width:70px;"> </span>-->
	</div>
		
		<div class="container">
        
        <div class="sticky-navigation">
        </div>
        <div class="contents">


<div class="content">
	<button type="submit" id="submit" name="submit" class="submit-button" value="submit">Submit</button>
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
				<td id="timer" name="timer">-- : -- : --</td>
			</tr>
		</table>
    </div>

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
                        else if($row[2] === "Matching")
                        {
                           $sqlComm = 'select ans_text from answer where ques_id = '.$row[0];
                           $answers = mysqli_query($connection, $sqlComm);
                           $numAns = mysqli_num_rows($answers);

                           $ansArray = array();
                           for($index = 0; $index < $numAns; $index++)
                           {
                              $ansRow = mysqli_fetch_row($answers);
                              $ansArray[$index] = $ansRow[0];
                           }

                           echo '<tr><td id="matching">';
                           echo '<table>';
                           for($i = 1; $i <= $numAns; $i++)
                           {
                              if($i != 1)
                              {
                                 $row = mysqli_fetch_row($result);
                              }
                              echo '<tr>';
                              echo    '<td width="50px">'.$qNum.'.<input type="text" name="Q'.$x.'ID" value="'.$row[0].',Matching" style="display:none;"/></td>';
                              echo    '<td width="400"><span id="theQuestion">'.$row[3].'</span> ('.$row[4].')</td>';
                              echo    '<td width="400"><select name="Q'.$x.'A">';
                              for($theAns = 0; $theAns < sizeof($ansArray); $theAns++)
                              {
                                 echo '<option value="'.$ansArray[$theAns].'">'.$ansArray[$theAns].'</option>';
                              }
                              echo    '</select></td>';
                              echo '</tr>';

                              $x++;
                              $qNum++;
                           }
                           $x--;
                           echo '</table>';
                           echo '</td></tr>';
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
         &copy; MegaMonkeys, Inc.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/monkeyhead2.png" class="monkeyheadfooter"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pensacola Christian College 2015
      </div>
</div>
</BODY>
</HTML>

<?php
    $result = mysqli_query($connection, 'SELECT section_id FROM test WHERE test_id = '.$testID);
    $row = mysqli_fetch_row($result);
    $_SESSION['section_id'] = $row[0];

    mysqli_close($connection);
?>

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
