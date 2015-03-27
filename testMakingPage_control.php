<?php
   if( isset( $_GET['test_no'] ) && isset( $_GET['action'] ) ) {
      load_test( $_GET['test_no'] );
   }
   else if( isset( $_GET['course_no'] ) && isset( $_GET['action'] ) ) {
      load_section( $_GET['course_no'], $_GET['action'] );
   }


   //TestMakingPage.php
   function get_course_list() {
      include 'db_connection.php';
      $sql_command = "SELECT distinct(`course`.`COURSE_NO`)\n"
         . "FROM `section`\n"
         . " LEFT JOIN `cs414_team2`.`course` ON `section`.`COURSE_NO` = `course`.`COURSE_NO` \n"
         . " WHERE INSTRUCTOR_ID = " . $_SESSION['user_id'] . "\n"
         . " ORDER BY `section`.`COURSE_NO`";

      $sql_result = mysqli_query($connection, $sql_command);
                    //mysqli_close($connection);

      for ($i = 0; $i < @mysqli_num_rows($sql_result); $i++) {
         $row = mysqli_fetch_row($sql_result);
         echo '<option value="' . preg_replace('/\s+/', '', $row[0]) . '">' . $row[0] . '</option>';
      }
   }

   //TestMakingPage.php
   function get_section_list() {
      include 'db_connection.php';
      $sql_command = "SELECT `course`.`COURSE_NO`, `section`.`SECTION_NO`, `section`.`SECTION_ID`\n"
         . "FROM `section`\n"
         . " LEFT JOIN `cs414_team2`.`course` ON `section`.`COURSE_NO` = `course`.`COURSE_NO` \n"
         . " WHERE INSTRUCTOR_ID = " . $_SESSION['user_id'];

      $sql_result = mysqli_query($connection, $sql_command);
                    mysqli_close($connection);

      $GLOBALS['section_list'] = '';
      for ($i = 0; $i < @mysqli_num_rows($sql_result); $i++) {
         $row = mysqli_fetch_row($sql_result);
         //echo '<option class="section_op ' . preg_replace('/\s+/', '', $row[0]) . '" value="' . $row[2] . '">' . $row[1] . '</option>';
         $GLOBALS['section_list'] = $GLOBALS['section_list'] . '<option class="' . preg_replace('/\s+/', '', $row[0]) . '" value="' . $row[2] . '">' . $row[1] . '</option>';
      }
      //echo '<script type="text/javascript">'. 'get_section();' .  '</script>';
   }

   function load_section($course_no, $user_id) {
      $course_no = substr($course_no, 0, 2) . " " . substr($course_no, 2, 3);
      include 'db_connection.php';
      $sql_command = "SELECT `course`.`COURSE_NO`, `section`.`SECTION_NO`, `section`.`SECTION_ID`\n"
         . "FROM `section`\n"
         . " LEFT JOIN `cs414_team2`.`course` ON `section`.`COURSE_NO` = `course`.`COURSE_NO` \n"
         . " WHERE INSTRUCTOR_ID = " . $user_id . "\n"
         . " AND section.COURSE_NO = '" . $course_no . "'";

      $sql_result = mysqli_query($connection, $sql_command);
      mysqli_close($connection);

      for ($i = 0; $i < @mysqli_num_rows($sql_result); $i++) {
         $row = mysqli_fetch_row($sql_result);
         echo '<option value="' . $row[2] . '">' . $row[1] . '</option>';
      }
   }

   function test_no_check($test_no) {
      include 'db_connection.php';
      $sql_command = "select * from section join test\n"
         . "on section.section_id = test.section_id\n"
         . "where instructor_id = " . $_SESSION['user_id'] . "\n"
         . "and test_id = " . $test_no;

      $sql_result = mysqli_query($connection, $sql_command);
      mysqli_close($connection);

      return ((mysqli_num_rows($sql_result) == 1)? true : false);
   }


   // ======================================================================================== //
   //                                                                                          //
   // ======================================================================================== //


   //TestMakingPage.php
   function load_test($test_no)
   {
      include 'db_connection.php';
      $sql_command =
         "SELECT TEST_NAME, START_DATE, END_DATE, TIME_LIMIT, PLEDGE, SECTION.SECTION_ID, COURSE_NO, SECTION_NO\n"
         . "FROM TEST, SECTION\n"
         . "WHERE TEST.SECTION_ID = SECTION.SECTION_ID\n"
         . "AND TEST_ID = " . $test_no . ";";

      $sql_result = mysqli_query($connection, $sql_command);
      $info = mysqli_fetch_row($sql_result);



      if( @mysqli_num_rows($sql_result) != 0 ) {
         $sql_command = "select * from question where test_id = " . $test_no . ";";
         $sql_result  = mysqli_query($connection, $sql_command);
         $question_data = array();

         if (@mysqli_num_rows($sql_result) != 0) {
            for ($i = 1; $i <= mysqli_num_rows($sql_result); $i++) {
               $row = mysqli_fetch_row($sql_result);
               load_question_form($row);
               $question_data += array($row[0], $row[4], $row[5]); //Q_ID, Que, Pt
            }
            echo load_question_refresh();
         }
      }
      echo  load_question_info($info);
      mysqli_close($connection);
   }

   function load_question_info($data)
   {
      return
         '<script type="text/javascript">'.
            '$("#testName").val("' . $data[0] . '");' .
            '$("#test_inst_text").val("' . $data[0] . '");' .
            '$("#pledge_text").val("' . $data[4] . '");' .
            '$("#startDate").val("' . substr($data[1], 0, 10) . '");' .
            '$("#endDate").val("' . substr($data[2], 0, 10) . '");' .
            '$("#startTime").val("' . substr($data[1], 11, 18) . '");' .
            '$("#endTime").val("' . substr($data[2], 11, 18) . '");' .
            '$("#hours").val("' . intval(substr($data[3], 0, 2)) . '");' .
            '$("#minutes").val("' . intval(substr($data[3], 3, 5)) . '");' .
            '$("#courseNo").val("' . preg_replace('/\s+/', '', $data[6]) . '");' .
            'get_sections(); $("#sectionNo").val("' . $data[5] . '");' .
         '</script>';
      //echo '<option class="section_op ' . preg_replace('/\s+/', '', $row[0]) . '" value="' . $row[2] . '">' . $row[1] . '</option>';
   }

   function load_question_form($data)
   {
      $q_types = array('True/False', 'Multiple Choice', 'Many Choice', 'Short Answer', 'Essay', 'Instruction');
      $q_type = array_search($data[3], $q_types);
      echo '<li class="ui-state-default tess">';
      echo '<span>::</span> ';
      echo     load_question_type($q_type, $data[4], $data[5], $data[0]);
      echo     ($q_type == 1 || $q_type == 2 ? load_question_option(($q_type == 1 ? "radio" : "checkbox"), $data[0]) : "");
      echo     ($q_type == 0 || $q_type == 3 || $q_type == 4 ? load_question_extra() : "");
      echo '</li>';
   }

   function load_question_type($q_type, $q_text, $q_pt, $q_id)
   {
      if($q_type == 1 || $q_type == 3)
      {
         include 'db_connection.php';
         $sql_command = "SELECT * FROM `answer` WHERE QUES_ID = " . $q_id . ";";
         $sql_result = mysqli_query($connection, $sql_command);
         $row = mysqli_fetch_row($sql_result);
         mysqli_close($connection);
      }

      $form_array = array('True/False Question', 'Multiple Choice Question', 'Many Choice Question', 'Short Answer Question', 'Essay Question', 'Instruction');
      $form_text_array =
         array(
            //Index:0 - True/False Question
            $form_array[$q_type] .
            '<input type="text" maxlength="3" size="4" style="float: right;" value="'.$q_pt.'"><qp style="float:right;"> Point-&nbsp;</qp>'.
            '<textarea required rows="3" placeholder="True/False Question">'.$q_text.'</textarea>'.
            '<input type="radio" style="margin-left: 23%;"' . ($q_type==1||@$row[2]? 'checked': '') . '> True'.
            '<input type="radio" style="margin-left: 23%;"' . ($q_type==1||@!$row[2]? 'checked': '') . '> False',

            //Index:1 - Multiple Choice Question
            $form_array[$q_type] .
            '<input type="text" maxlength="3" size="4" style="float: right;" value="'.$q_pt.'"><qp style="float:right;"> Point-&nbsp;</qp>'.
            //'<input type="button" value="Option" onclick="add_option(this);"><br>'.
            '<textarea required rows="3" placeholder="Multiple Choice Question">'.$q_text.'</textarea>' ,

            //Index:2 - Many Choices
            $form_array[$q_type] .
            '<input type="text" maxlength="3" size="4" style="float: right;" value="'.$q_pt.'"><qp style="float:right;"> Point-&nbsp;</qp>'.
            //'<input type="button" value="Option" onclick="add_option(this);"><br>'.
            '<textarea required rows="3" placeholder="Many Choice Question">'.$q_text.'</textarea>',

            //Index:3 - Short Answer Question
            $form_array[$q_type] .
            '<input type="text" maxlength="3" size="4" style="float: right;" value="'.$q_pt.'"><qp style="float:right;"> Point-&nbsp;</qp>'.
            '<textarea required rows="3" placeholder="Short Answer Question">'.$q_text.'</textarea>'.
            'Answer: <input type="text"  maxlength="50" size="55" value="' . @$row[2] . '">',

            //Index:4 - Essay
            $form_array[$q_type] .
            '<input type="text" maxlength="3" size="4" style="float: right;" value="'.$q_pt.'"><qp style="float:right;"> Point-&nbsp;</qp>'.
            '<textarea required rows="4" placeholder="Essay Question">'.$q_text.'</textarea><br>',

            //Disabled
            $form_array[$q_type] .
            '<button class="bin_button" type="button" onmouseover="recy_onHover(this);" onmouseout="recy_offHover(this);" onclick="removeQ(this);">' .
            '<input type="image" width="100%" height="100%" src="./images/recycle_close.jpeg">' .
            '</button><br>' .
            '<textarea required rows="2" placeholder="Type Instruction">'.$q_text.'</textarea>' .
            '<input type="hidden">'

            //'<textarea required name="ques_random" rows="4" placeholder="Nothing Nothing"></textarea>'
         );
      return $form_text_array[$q_type];
   }

   function load_question_refresh()
   {
      return   '<script type="text/javascript">'.
      'resetQnum();'.
      '$("#sortable2").css({"height": "auto"});'.
      '$("#sortable2").css("background-image", "none");'.
      '</script>';
   }

   function load_question_extra()
   {
      $del_button =
         '<button class="bin_button" type="button" onmouseover="recy_onHover(this);" onmouseout="recy_offHover(this);" onclick="removeQ(this);">' .
         '<input type="image" width="100%" height="100%" src="./images/recycle_close.jpeg">'  .
         '</button><br>';

      return $del_button;
   }

   function load_question_option($o_type, $q_id)
   {
      include 'db_connection.php';
      $sql_command = "SELECT * FROM `answer` WHERE QUES_ID = " . $q_id . ";";
      $sql_result = mysqli_query($connection, $sql_command);
      mysqli_close($connection);
      $row = array();
      for ($i = 0; $i < mysqli_num_rows($sql_result); $i++) {
         $row[$i] = mysqli_fetch_row($sql_result);
      }

      $mul_op =
         '<table class="q_options">' .
         '<tr>' .
         '<td>' .
         '<input type="' . $o_type . '" value="A"' . ($row[0][3]? "checked": "") . '>' .
         '<span>A</span> <input type="text" value="' . $row[0][2] . '">' .
         '</td>' .
         '<td>' .
         '<input type="' . $o_type . '" value="B"' . ($row[1][3]? "checked": "") . '>' .
         '<span>B</span> <input type="text" value="' . $row[1][2] . '">' .
         '</td>' .
         '</tr>' .
         '<tr>' .
         '<td>' .
         '<input type="' . $o_type . '" value="C"' . ($row[2][3]? "checked": "") . '>' .
         '<span>C</span> <input type="text" value="' . $row[2][2] . '">' .
         '</td>' .
         '<td>' .
         '<input type="' . $o_type . '" value="D"' . ($row[3][3]? "checked": "") . '>' .
         '<span>D</span> <input type="text" value="' . $row[3][2] . '">' .
         '</td>' .
         '<td>' .
         '<button class="bin_button" type="button"' .
         'onmouseover="recy_onHover(this);" onmouseout="recy_offHover(this);"' .
         'onclick="removeQ(this.parentNode.parentNode.parentNode.parentNode);">' .
         '<input type="image" width="100%" height="100%" src="./images/recycle_close.jpeg">' .
         '</button><br>' .
         '</td>' .
         '</tr>' .
         '</table>';

      return $mul_op;
   }





?>
