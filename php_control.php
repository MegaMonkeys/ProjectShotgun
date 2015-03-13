<?php
   //Global - Initiate Connection
   //Connection needs to be close !!!
      //Check MySQL initialisation check
      $connection = mysqli_init();
      if (!$connection)
         die("mysqli_init failed");

      //Set connection time out
      mysqli_options($connection, MYSQLI_OPT_CONNECT_TIMEOUT, "5");

      //Connect to the MySQL Server
      //Warning Disabled
      if (!@mysqli_real_connect($connection, 'CSWEB.studentnet.int', 'team2_cs414', 't2CS414', 'cs414_team2')) {
         if (!@mysqli_real_connect($connection, 'localhost', 'team2', 'team2', 'cs414_team2')) {
            die("<br>Connect Error : " . mysqli_connect_error());
         }
      } else
         echo "Connected successfully<br>";


   function get_course_section()
   {
      $sql_command = "SELECT distinct(`course`.`COURSE_NO`)\n"
         . "FROM `section`\n"
         . " LEFT JOIN `cs414_team2`.`course` ON `section`.`COURSE_NO` = `course`.`COURSE_NO` \n"
         . "\n"
         . "";

      $sql_result = mysqli_query($GLOBALS["connection"], $sql_command);

      for ($i = 0; $i < @mysqli_num_rows($sql_result); $i++) {
         $row = mysqli_fetch_row($sql_result);
         echo '<option value="' . $row[0] . '">' . $row[0] . '</option>';
      }

   }

   function get_course_sections()
   {
      $sql_command = "SELECT `course`.`COURSE_NO`, `section`.`SECTION_NO`, `section`.`SECTION_ID`\n"
         . "FROM `section`\n"
         . " LEFT JOIN `cs414_team2`.`course` ON `section`.`COURSE_NO` = `course`.`COURSE_NO` \n"
         . "\n"
         . "";

      $sql_result = mysqli_query($GLOBALS["connection"], $sql_command);
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

?>