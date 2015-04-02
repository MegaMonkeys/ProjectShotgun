<?php
   if( isset( $_GET['section_no'] ) )
   {
      get_test_list($_GET['section_no'], $_GET['student_id'] );
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
			. "WHERE student_id = " . $_SESSION['user_id'];

      $sql_result = mysqli_query($connection, $sql_command);
      mysqli_close($connection);
	  

      $class_list = array();

      for($i = 1; $i <= @mysqli_num_rows($sql_result); $i++)
      {  //[0]-COURSE_NO [1]-SECTION_NO [2]-SECTION_ID [3]-COURSE_DESCRIPTION
         $row = mysqli_fetch_row($sql_result);
         echo '<tr>';
            echo '<td id="courseTD"type="submit" onclick="get_class_test(' . $row[2] . ', ' . $row[4] . ')">';
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
      $sql_command = "SELECT SECTION_ID, TEST_NAME, PUBLISHED, START_DATE, END_DATE, FINAL_GRADE, TEST_ID, objective_grade
                        FROM enrollment e join test using (section_id)
						 left outer join student_test using (test_id, student_id)
						where e.student_id = " . $student_id . " and section_id = " . $section_no . " and published = 1";

      $sql_result = mysqli_query($connection, $sql_command);
      $numRows = mysqli_num_rows($sql_result);


      if( @mysqli_num_rows($sql_result) != 0)
      {
         for($i = 1; $i <= $numRows; $i++)
         {
            $row = mysqli_fetch_row($sql_result);
            $startDateTime = date_create($row[3]);
            $endDateTime = date_create($row[4]);
            
            if(date("Y-m-d H:i:s") >= date_format($startDateTime, "Y-m-d H:i:s"))
            {
               if(empty($row[5]))
               {
                  if(date("Y-m-d H:i:s") <= date_format($endDateTime, "Y-m-d H:i:s"))
                  {
                     if(empty($row[7]))
                     {
                        $status = "Available to Take";
                        $gradeStatus = '';
                        $takeTestButton = "<span id='button'>".
                                          "<input type='submit' id='takeTestButton' name='takeTestButton' value='".$row[6]."'/>".
                                          "</span>";
                     }
                     else
                     {
                        $status = "Taken";
                        $gradeStatus = 'Pending';
                        $takeTestButton = '';
                     }
                  }
                  else
                  {
                     $status = "Past Due";
                     $gradeStatus = '';
                     $takeTestButton = '';
                  }
               }
               else
               {
                  $status = "Taken";
                  $gradeStatus = $row[5] . '%';
                  $takeTestButton = '';
               }
            }
            else
            {
               $status = 'Unavailable';
               $gradeStatus = '';
               $takeTestButton = '';
            }
            
            echo '<tr><td id="testTD">';
            echo     "<span id='testTitle'>" . $row[1] . "</span>";
            echo     $takeTestButton . "<br />";
            echo     "Available: " . date_format($startDateTime, "Y-m-d H:i:s");
            echo     "&nbsp;&nbsp;&nbsp;&nbsp;until&nbsp;&nbsp;&nbsp;&nbsp;" . date_format($endDateTime, "Y-m-d H:i:s") . "<br />";
            echo     'Status: '.$status.'<br />';
            echo     'Grade: ' . $gradeStatus;
            echo '</td></tr>';
         }
      }
      else
         echo "Umm... looks like there aren't any tests for this course. Check back later.";

      mysqli_close($connection);
   }
?>
