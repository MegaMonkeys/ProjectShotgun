<?php
   if( isset( $_GET['section_no'] ) )
   {
      get_test_list($_GET['section_no'], $_GET['student_id']);
   }
   $first_user = 0;
   

   //StudentHomePage.php
   function get_class_list()
   {
      include 'db_connection.php';
      $sql_command = "SELECT c.course_no, s.section_no, s.section_id, c.description, e.student_id\n"
			. "FROM enrollment e\n"
			. "JOIN section s\n"
			. "JOIN course c\n"
			. "ON e.section_id = s.section_id\n"
			. "AND c.course_no = s.course_no\n"
			. "WHERE student_id = " . $_SESSION['user_id'] . "\n"
         . "ORDER BY c.course_no, s.section_no";

      $sql_result = mysqli_query($connection, $sql_command);
      mysqli_close($connection);
	  

      $class_list = array();

      for($i = 1; $i <= @mysqli_num_rows($sql_result); $i++)
      {  //[0]-COURSE_NO [1]-SECTION_NO [2]-SECTION_ID [3]-COURSE_DESCRIPTION
         $row = mysqli_fetch_row($sql_result);
         echo '<tr>';
            echo '<td id="courseTD" type="submit" value="'.$row[2].'" onclick="get_class_test(' . $row[2] . ', ' . $row[4] . ')">';
               echo ($row[0] . ' - ' . $row[1]);
            echo '</td>';
         echo '</tr>';
         $class_list += array($row[2] => ($row[0]."-".$row[1]." ".$row[3]));
         if($i==1)
            global $first_user;
            $first_user = $row[4];
      }
      return $class_list;
   }

   //StudentHomePage.php
   function get_test_list($section_no, $student_id)
   {
      include 'db_connection.php';
      $sql_command = "SELECT SECTION_ID, TEST_NAME, PUBLISHED, START_DATE, END_DATE, FINAL_GRADE, TEST_ID, OBJECTIVE_GRADE, TIME_LIMIT, DATE_TIME, SIGNED_PLEDGE
                        FROM enrollment e join test using (section_id)
						 left outer join student_test using (test_id, student_id)
						where e.student_id = " . $student_id . " and section_id = " . $section_no . " and published = 1 order by START_DATE, END_DATE";

      $sql_result = mysqli_query($connection, $sql_command);
      $numRows = $counter = mysqli_num_rows($sql_result);

      //Gets DB Current Time
      $sql_now = "SELECT NOW()";
      $sql_now_result = mysqli_query($connection, $sql_now);
      $row = mysqli_fetch_row($sql_now_result);
      $current_datetime = $row[0];
      
      if( @mysqli_num_rows($sql_result) != 0)
      {
         for($i = 1; $i <= $numRows; $i++)
         {
            $row = mysqli_fetch_row($sql_result);
            $startDateTime = date_create($row[3]);
            $endDateTime = date_create($row[4]);
            
            // add time limit to start time to determine if there is still time left in the test.
            if(isset($row[9]))
            {
                $timeStarted = date_create($row[9]);
                $timeLimit = date_create($row[8]);
                $hoursLeft = date_format($timeLimit, "G"). " hours";
                $minutesLeft = date_format($timeLimit, "i"). " minutes";
                $studentEndTime = date_add(date_create($row[9]), date_interval_create_from_date_string($hoursLeft));
                $studentEndTime = date_add($studentEndTime, date_interval_create_from_date_string($minutesLeft));
        
            //    $timeLeft = date_diff($current_datetime, $studentEndTime);     // JB - Not working for some reason.
            //    $strTimeLeft = date_interval_format($timeLeft, "%H:%I:%S:%r");
            }
            
            
            if($current_datetime >= date_format($startDateTime, "Y-m-d H:i:s"))
            {
               if(empty($row[5]))
               {
                  if($current_datetime <= date_format($endDateTime, "Y-m-d H:i:s"))
                  {
                     if(empty($row[7]))
                     {
                        if(isset($row[9]))
                        {
                            $status = 'You started, but never submitted this test. The time is still ticking...';
                            $gradeStatus = "You still need to submit this test.";
                        }
                        else
                        {
                            $status = 'Available to Take.';
                            $gradeStatus = "You haven't taken this test yet.";
                        }
                        $takeTestButton = "<span id='button' style='text-align:center;' class='tooltip-bottom' data-tooltip='Take the test'>".
                                          "<input type='submit' id='takeTestButton' name='takeTestButton' value='".$row[6]."'/>".
                                          "</span>";
                     }
                     else
                     {
                        $status = "Test Submitted.";
                        $gradeStatus = 'Waiting for the instructor...';
                        $takeTestButton = '';
                     }
                  }
                  else
                  {
                    $status = "Past Due.";
                    $gradeStatus = '0.00% (You never submitted this test)';
                    $takeTestButton = '';
                  }
               }
               else
               {
                    if($row[10])
                    {
                        $status = "Test Submitted.";
                        $gradeStatus = $row[5] . '%';
                        $takeTestButton = '';
                    }
                    else
                    {
                        $status = "Test Submitted.";
                        $gradeStatus = $row[5] . "% (You didn't sign the pledge)";
                        $takeTestButton = '';
                    }
               }
            }
            else
            {
               $status = 'Will be available at the time shown.';
               $gradeStatus = "You can't take this test yet.";
               $takeTestButton = '';
            }
            
            echo '<tr><td id="testTD">';
            echo     "<span id='testTitle'>" . $row[1] . "</span>";
            echo     $takeTestButton . "<br />";
            echo     "<b>Available Starting:</b> " . date_format($startDateTime, "F j, Y") . " <b>at</b> " . date_format($startDateTime, "g:ia") . "<br />";
            echo     "<b>Available Until:</b> " . date_format($endDateTime, "F j, Y") . " <b>at</b> " . date_format($endDateTime, "g:ia") . "<br />";
            echo     '<b>Status:</b> '.$status.'<br />';
            echo     '<b>Grade:</b> ' . $gradeStatus;
            echo '</td></tr>';
            $counter--;
         }
         if($counter == $numRows)
            //echo "<tr><td>Looks like there aren't any tests for this course. Check back later.</td></tr>";
            echo "<tr><td><img id='welcome_bg' src='./images/no test student.png' style='width:80%; height:80%;margin: 10% 10%;'></td></tr>";
      }
      else
         //echo "<tr><td>Looks like there aren't any tests for this course. Check back later.</td></tr>";
         echo "<tr><td><img id='welcome_bg' src='./images/no test student.png' style='width:80%; height:80%;margin: 10% 10%;'></td></tr>";

      mysqli_close($connection);
   }
?>
