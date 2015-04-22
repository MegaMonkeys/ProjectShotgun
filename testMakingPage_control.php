<?php
   if( isset( $_GET['test_no'] ) && isset( $_GET['action'] ) ) {
      load_test( $_GET['test_no'] );
   }
   else if( isset( $_GET['course_no'] ) && isset( $_GET['action'] ) ) {
      load_section( $_GET['course_no'], $_GET['action'] );
   }
   else if( isset( $_GET['test_no'] ) && isset( $_GET['load'] ) ) {
      load_info( $_GET['test_no'] );
   }


   //TestMakingPage.php
   function get_course_list($connection) {
      //include 'db_connection.php';
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
   function get_section_list($connection) {
      //include 'db_connection.php';
      $sql_command = "SELECT `course`.`COURSE_NO`, `section`.`SECTION_NO`, `section`.`SECTION_ID`\n"
         . "FROM `section`\n"
         . " LEFT JOIN `cs414_team2`.`course` ON `section`.`COURSE_NO` = `course`.`COURSE_NO` \n"
         . " WHERE INSTRUCTOR_ID = " . $_SESSION['user_id'];

      $sql_result = mysqli_query($connection, $sql_command);
                    //mysqli_close($connection);

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
               if( $row[3] == "Matching" ) {
                  $array_matching = array();

                  $sql_command_1 = 'SELECT * FROM answer WHERE ques_id = ' . $row[0];
                  $sql_result_1  = mysqli_query($connection, $sql_command_1);
                  $matching_size = mysqli_num_rows($sql_result_1);

                  $sql_command_2 = 'SELECT * FROM question join answer on question.ques_id = answer.ques_id WHERE question.ques_id = '.$row[0];
                  $sql_result_2  = mysqli_query($connection, $sql_command_2);
                  for($b=0;$b<$matching_size;$b++) {
                     array_push($array_matching, mysqli_fetch_row($sql_result_2));
                  }

                  for($a=1;$a<$matching_size;$a++, $i++) {
                     $row = mysqli_fetch_row($sql_result);
                     $sql_command_2 = 'SELECT * FROM question join answer on question.ques_id = answer.ques_id WHERE question.ques_id = '.$row[0];
                     $sql_result_2  = mysqli_query($connection, $sql_command_2);
                     for($b=0;$b<$matching_size;$b++) {
                        array_push($array_matching, mysqli_fetch_row($sql_result_2));
                     }
                  }
                  load_question_matching($matching_size, $array_matching);
               }
               else
                  load_question_form($row,$connection);
               $question_data += array($row[0], $row[4], $row[5]); //Q_ID, Que, Pt
            }
            //echo load_question_refresh();
         }
      }
      //echo  load_question_info($info);
      mysqli_close($connection);
   }

   function load_question_matching($matching_size, $array_matching) {

      echo '<li class="ui-state-default tess">';
      echo '<span>::</span>Matching';
      echo '<input type="text" class="required_field" maxlength="3" size="3" style="float: right;" onkeydown="return isNumberKey(event)" onkeyup="isNum(this)" onblur="numCheck(this)" value="'.$array_matching[0][5].'"><qp style="float:right;"> Point-&nbsp;</qp><br />';
      echo '<table style="border:1px solid #ccc; width: 100%; position:relative;">';
      echo '<tr><td>';

      for($i=0; $i<$matching_size; $i++) {
         echo '<div>';
         echo '<span style="margin-right: 2%;">::</span>(Match: ';
               echo '<select>';
            for($y=0,$ascii_code=65; $y<$matching_size; $y++,$ascii_code++) {
               //(($array_matching[$i*$matching_size+$y][9]==1)? 'selected':'')
               echo '<option value="'.($y+1).'"'.(($array_matching[$i*$matching_size+$y][9]==1)? 'selected':'').'>&#'.$ascii_code.';</option>';
            }
               echo '</select>';
         echo ')';
         echo '<label style="position:absolute; left: 50%;">Choice:</label>';
         echo '<button type="button" style="float:right; margin-right: 5px;" onclick="removeMatchQ(this);">Remove Option</button><br/>';
         echo '<input required class="required_field" type="text"  maxlength="50" style="width:45%; margin-left: 3%;" value="'.$array_matching[$i*$matching_size][4].'">';
         echo '<input required class="required_field" type="text"  maxlength="50" style="width:45%; margin-left: 3%;" value="'.$array_matching[$i][8].'">';
         echo '</div>';
      }

      echo '</td></tr></table>';
      echo '<button type="button" style="margin-right: 5px;" onclick="addMatchQ(this);">Add New Option</button>';
      echo '<button class="bin_button" type="button" onmouseover="recy_onHover(this);" onmouseout="recy_offHover(this);" onclick="removeQ(this);">';
      echo '<input type="image" width="100%" height="100%" src="./images/recycle_close.jpeg">';
      echo '</button><br>';
      echo '</li>';


   }

      function load_info($test_no)
      {
         include 'db_connection.php';
         $sql_command =
            "SELECT TEST_NAME, START_DATE, END_DATE, TIME_LIMIT, PLEDGE, SECTION.SECTION_ID, COURSE_NO, SECTION_NO\n"
            . "FROM TEST, SECTION\n"
            . "WHERE TEST.SECTION_ID = SECTION.SECTION_ID\n"
            . "AND TEST_ID = " . $test_no . ";";

         $sql_result = mysqli_query($connection, $sql_command);
         $info = mysqli_fetch_row($sql_result);

         echo  load_question_info($info);
         mysqli_close($connection);
      }

   function load_question_info($data) {
      return
         '<script type="text/javascript">'.
            '$("#testName").val("' . $data[0] . '");' .
            '$("#test_inst_text").val("' . $data[0] . '");' .
            '$("#pledge_text").val("' . $data[4] . '");' .
            '$("#startDate").val("' . substr($data[1], 0, 10) . '");' .
            '$("#endDate").val("' . substr($data[2], 0, 10) . '");' .
            '$("#startTime").val("' . substr($data[1], 11, 18) . '");' .
            'set_time("'.substr($data[1], 11, 18).'", "start");' .
            '$("#endTime").val("' . substr($data[2], 11, 18) . '");' .
            'set_time("'.substr($data[2], 11, 18).'", "end");' .
            '$("#hours").val("' . intval(substr($data[3], 0, 2)) . '");' .
            '$("#minutes").val("' . intval(substr($data[3], 3, 5)) . '");' .
            '$("#courseNo").val("' . preg_replace('/\s+/', '', $data[6]) . '");' .
            'get_sections(); $("#sectionNo").val("' . $data[5] . '");' .
         '</script>';
      //echo '<option class="section_op ' . preg_replace('/\s+/', '', $row[0]) . '" value="' . $row[2] . '">' . $row[1] . '</option>';
   }

   function load_question_form($data, $connection)
   {
      $q_types = array('Instruction', 'True/False', 'Multiple Choice', 'Many Choice', 'Short Answer', 'Essay');
      $q_type = array_search($data[3], $q_types);
      echo '<li class="ui-state-default tess">';
      echo '<span>::</span> ';
      echo     load_question_type($q_type, $data[4], $data[5], $data[0], $connection);
      echo     ($q_type == 2 || $q_type == 3 ? load_question_option( ($q_type == 2 ? "radio" : "checkbox"), $data[0], $connection) : "");
      echo     ($q_type == 1 || $q_type == 4 || $q_type == 5 ? load_question_extra() : "");
      echo '</li>';
   }

   function load_question_type($q_type, $q_text, $q_pt, $q_id, $connection)
   {
      if($q_type == 1 || $q_type == 4)
      {
         //include 'db_connection.php';
         $sql_command = "SELECT * FROM `answer` WHERE QUES_ID = " . $q_id . ";";
         $sql_result = mysqli_query($connection, $sql_command);
         $row = mysqli_fetch_row($sql_result);
         //mysqli_close($connection);
      }

      $form_array = array('Instruction', 'True/False Question', 'Multiple Choice Question', 'Many Choice Question', 'Short Answer Question', 'Essay Question');
      $form_text_array =
         array(
            //Index:0 - Instruction
            $form_array[$q_type] .
            '<button class="bin_button" type="button" onmouseover="recy_onHover(this);" onmouseout="recy_offHover(this);" onclick="removeQ(this);">' .
            '<input type="image" width="100%" height="100%" src="./images/recycle_close.jpeg">' .
            '</button><br>' .
            '<textarea required class="required_field" rows="2" placeholder="Type Instruction" maxlength="200">'.$q_text.'</textarea>' .
            '<input type="hidden">',

            //Index:1 - True/False Question
            $form_array[$q_type] .
            '<input class="required_field" type="text" maxlength="3" size="3" style="float: right;" onkeydown="return isNumberKey(event)" onkeyup="isNum(this)" onblur="numCheck(this)" value="'.$q_pt.'"><qp style="float:right;"> Point-&nbsp;</qp>'.
            '<textarea required class="required_field" rows="3" placeholder="True/False Question" maxlength="200">'.$q_text.'</textarea>'.
            '<input type="radio" style="margin-left: 23%;"' . (@$row[2]=='True'? 'checked': '') . '> True'.
            '<input type="radio" style="margin-left: 23%;"' . (@$row[2]=='False'? 'checked': '') . '> False',

            //Index:2 - Multiple Choice Question
            $form_array[$q_type] .
            '<input class="required_field" type="text" maxlength="3" size="3" style="float: right;" onkeydown="return isNumberKey(event)" onkeyup="isNum(this)" onblur="numCheck(this)" value="'.$q_pt.'"><qp style="float:right;"> Point-&nbsp;</qp>'.
            //'<input type="button" value="Option" onclick="add_option(this);"><br>'.
            '<textarea equired class="required_field" rows="3" placeholder="Multiple Choice Question" maxlength="200">'.$q_text.'</textarea>' ,

            //Index:3 - Many Choices
            $form_array[$q_type] .
            '<input type="text" maxlength="3" size="3" style="float: right;" onkeydown="return isNumberKey(event)" onkeyup="isNum(this)" onblur="numCheck(this)" value="'.$q_pt.'"><qp style="float:right;"> Point-&nbsp;</qp>'.
            //'<input type="button" value="Option" onclick="add_option(this);"><br>'.
            '<textarea required class="required_field" rows="3" placeholder="Many Choice Question" maxlength="200">'.$q_text.'</textarea>',

            //Index:4 - Short Answer Question
            $form_array[$q_type] .
            '<input type="text" class="required_field" maxlength="3" size="3" style="float: right;" onkeydown="return isNumberKey(event)" onkeyup="isNum(this)" onblur="numCheck(this)" value="'.$q_pt.'"><qp style="float:right;"> Point-&nbsp;</qp>'.
            '<textarea required class="required_field" rows="3" placeholder="Short Answer Question" maxlength="200">'.$q_text.'</textarea>'.
            'Answer: <input required class="required_field" type="text" maxlength="50" size="55" value="' . @$row[2] . '">',

            //Index:5 - Essay
            $form_array[$q_type] .
            '<input type="text" class="required_field" maxlength="3" size="3" style="float: right;" onkeydown="return isNumberKey(event)" onkeyup="isNum(this)" onblur="numCheck(this)" value="'.$q_pt.'"><qp style="float:right;"> Point-&nbsp;</qp>'.
            '<textarea required class="required_field" rows="4" placeholder="Essay Question" maxlength="250">'.$q_text.'</textarea><br>'

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

   function load_question_option($o_type, $q_id, $connection)
   {
      //include 'db_connection.php';
      $sql_command = "SELECT * FROM `answer` WHERE QUES_ID = " . $q_id . ";";
      $sql_result = mysqli_query($connection, $sql_command);
      //mysqli_close($connection);
      $row = array();
      for ($i = 0; $i < mysqli_num_rows($sql_result); $i++) {
         $row[$i] = mysqli_fetch_row($sql_result);
      }

      $mul_op =
         '<table class="q_options">' .
         '<tr>' .
         '<td>' .
         '<input type="' . $o_type . '" value="A"' . ($row[0][3]? "checked": "") . '>' .
         '<span>A</span> <input required class="required_field" type="text" value="' . $row[0][2] . '" maxlength="20">' .
         '</td>' .
         '<td>' .
         '<input type="' . $o_type . '" value="B"' . ($row[1][3]? "checked": "") . '>' .
         '<span>B</span> <input required class="required_field" type="text" value="' . $row[1][2] . '" maxlength="20">' .
         '</td>' .
         '</tr>' .
         '<tr>' .
         '<td>' .
         '<input type="' . $o_type . '" value="C"' . ($row[2][3]? "checked": "") . '>' .
         '<span>C</span> <input required class="required_field" type="text" value="' . $row[2][2] . '" maxlength="20">' .
         '</td>' .
         '<td>' .
         '<input type="' . $o_type . '" value="D"' . ($row[3][3]? "checked": "") . '>' .
         '<span>D</span> <input required class="required_field" type="text" value="' . $row[3][2] . '" maxlength="20">' .
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
