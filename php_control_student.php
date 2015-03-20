<?php
   if( isset( $_GET['section_no'] ) )
   {
      get_test_list($_GET['section_no']);
   }


   //TestMakingPage.php
   function get_course_section()
   {
      include 'db_connection.php';
      $sql_command = "SELECT distinct(`course`.`COURSE_NO`)\n"
         . "FROM `section`\n"
         . " LEFT JOIN `cs414_team2`.`course` ON `section`.`COURSE_NO` = `course`.`COURSE_NO` \n"
         . "\n"
         . "";

      $sql_result = mysqli_query($connection, $sql_command);
      mysqli_close($connection);

      for ($i = 0; $i < @mysqli_num_rows($sql_result); $i++) {
         $row = mysqli_fetch_row($sql_result);
         echo '<option value="' . $row[0] . '">' . $row[0] . '</option>';
      }
   }

   //TestMakingPage.php
   function get_course_sections()
   {
      include 'db_connection.php';
      $sql_command = "SELECT `course`.`COURSE_NO`, `section`.`SECTION_NO`, `section`.`SECTION_ID`\n"
         . "FROM `section`\n"
         . " LEFT JOIN `cs414_team2`.`course` ON `section`.`COURSE_NO` = `course`.`COURSE_NO` \n"
         . "\n"
         . "";

      $sql_result = mysqli_query($connection, $sql_command);
      mysqli_close($connection);
      $course = "";

      for ($i = 0; $i < @mysqli_num_rows($sql_result); $i++) {
         $row = mysqli_fetch_row($sql_result);
         //$item = ($row[0] . ' - ' . $row[1]);
         if($course == "")
            $course = $row[0];

         if( $course == $row[0] )
            echo '<option class="section_op ' . preg_replace('/\s+/', '', $row[0]) . '" value="' . $row[2] . '"style="display: block;">' . $row[1] . '</option>';
         else
            echo '<option class="section_op ' . preg_replace('/\s+/', '', $row[0]) . '" value="' . $row[2] . '"style="display: none;">' . $row[1] . '</option>';
      }
   }

   //StudentHomePage.php
   function get_class_list()
   {
      include 'db_connection.php';
      $sql_command = "SELECT `course`.`COURSE_NO`, `section`.`SECTION_NO`, `section`.`SECTION_ID`, `course`.`DESCRIPTION`\n"
         . "FROM `section`\n"
         . " LEFT JOIN `cs414_team2`.`course` ON `section`.`COURSE_NO` = `course`.`COURSE_NO` \n"
         . "\n"
         . "";

      $sql_result = mysqli_query($connection, $sql_command);
      mysqli_close($connection);

      $class_list = array();

      for($i = 1; $i <= @mysqli_num_rows($sql_result); $i++)
      {  //[0]-COURSE_NO [1]-SECTION_NO [2]-SECTION_ID [3]-COURSE_DESCRIPTION
         $row = mysqli_fetch_row($sql_result);
         echo '<tr>';
            echo '<td id="courseTD"type="submit" onclick="get_class_test(' . $row[2] . ')">';
               echo ($row[0] . ' - ' . $row[1]);
            echo '</td>';
         echo '</tr>';
         $class_list += array($row[2] => ($row[0]."-".$row[1]." ".$row[3]));
      }

      return $class_list;
   }

   //StudentHomePage.php
   function get_test_list($section_no)
   {
      include 'db_connection.php';
      $sql_command = "SELECT SECTION_ID, TEST_NAME, PUBLISHED, START_DATE, END_DATE, FINAL_GRADE
                        FROM test LEFT OUTER JOIN student_test using (test_id)
                       WHERE SECTION_ID = " . $section_no;

      $sql_result = mysqli_query($connection, $sql_command);


      if( @mysqli_num_rows($sql_result) != 0)
      {
         for($i=1; $i<=mysqli_num_rows($sql_result); $i++)
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
                     $status = "Available to Take";
                     $gradeStatus = '';
                     $takeTestButton = "<span id='button'>".
                                       "<button type='submit' value='Take Test' id='takeTestButton' name='takeTestButton'></button>".
                                       "</span>";
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
                  $gradeStatus = $row[5];
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
         echo "no data";

      mysqli_close($connection);
   }



?>