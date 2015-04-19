<?php
   $matching_count = 0;
	//$_POST['gradeButton'] => TEST_ID
   if( isset( $_GET['action'] ) ) {
      if( $_GET['action'] == 'get' )
         get_test($_GET['test_id'], $_GET['student_id']);
      if( $_GET['action'] == 'save' )
         save_test();
   }

   function save_test() {
      //echo $_GET['count'];
      include 'db_connection.php';
      $sql_command = "SELECT ques_id, points\n"
         . "FROM question\n"
         . "WHERE test_id = " . $_GET['t_id'] . "\n"
         . "AND ques_type != \"Instruction\"\n"
         . "ORDER BY ques_no";
      $sql_result = mysqli_query($connection, $sql_command);

      $test_total = 0;
      $q_id_array = array();
      for($i = 0; $i < @mysqli_num_rows($sql_result); $i++) {
         $data = mysqli_fetch_row($sql_result);
         array_push($q_id_array, $data[0]);
         $test_total = $test_total + $data[1];
      }

      $student_total = 0;
      for($i = 0; $i < sizeof($q_id_array); $i++) {
         $sql_command = "UPDATE student_answer\n"
         ."SET stu_points = ".$_GET['n'.($i+1)]."\n"
         ."WHERE ques_id = ".$q_id_array[$i]."\n"
         ."AND student_id = ".$_GET['s_id']."\n";
         mysqli_query($connection, $sql_command);
         $student_total = $student_total + $_GET['n'.($i+1)];
      }

      $sql_command = "UPDATE student_test\n"
         . "SET final_grade = " . round($student_total/$test_total,2)*100 . "\n"
         . "WHERE student_id = " . $_GET['s_id'] . "\n"
         . "AND test_id = " . $_GET['t_id'];
      mysqli_query($connection, $sql_command);



      mysqli_close($connection);
   }

   function testing() {
      include 'db_connection.php';
      $sql_command = "select q.ques_id, ques_no, ques_type, ques_text, stu_ans_text, points, stu_points\n"
         . "from question q\n"
         . "join student_answer a\n"
         . "where q.ques_id = a.ques_id\n"
         . "and student_id = \'112233\'\n"
         . "and test_id = \'4\'\n"
         . "order by ques_no";
      $sql_result = mysqli_query($connection, $sql_command);
      mysqli_close($connection);
   }

   function get_student_list() {
      include 'db_connection.php';
      $sql_command = "SELECT s.student_id, first_name, last_name from test t\n"
				. "join enrollment e\n"
				. "join student s\n"
				. "on t.section_id = e.section_id\n"
				. "and e.student_id = s.student_id\n"
				. "where test_id = " . $_POST['gradeButton']
                . " order by last_name, first_name";
	  
	  
	  $test = "SELECT s.student_id, first_name, last_name\n"
         . "FROM student s\n"
         . "LEFT OUTER JOIN student_test t\n"
         . "ON s.student_id = t.student_id\n"
         . "WHERE test_id = " . $_POST['gradeButton'] . "\n"
         . "OR test_id IS NULL\n"
         . "ORDER BY LAST_NAME";
      $sql_result = mysqli_query($connection, $sql_command);
      mysqli_close($connection);

      for($i = 1; $i <= @mysqli_num_rows($sql_result); $i++) {
         //[0]-STUDENT_ID [1]-FIRST_NAME [2]-LAST_NAME
         $row = mysqli_fetch_row($sql_result);
         $s_name = $row[2] . ', ' . $row[1];
         echo '<tr>';
            echo '<td id="studentTD" type="submit" onclick="get_student_test('.$_POST['gradeButton'].','.$row[0].','."'".$s_name."'".' )">';
                  echo($s_name);
            echo '</td>';
         echo '</tr>';
		 if($i == 1) {
			global $st_id, $st_name;
			$st_id = $row[0];
			$st_name = $row[1] . ' ' . $row[2];
		 }
      }
   }

   function get_test_info($test_id) {
      include 'db_connection.php';
      $sql_command = "SELECT test_name FROM test WHERE test_id = ".$test_id;
      $sql_result = mysqli_query($connection, $sql_command);
      mysqli_close($connection);
      return mysqli_fetch_row($sql_result);
   }

   function get_test($test_id, $student_id) {
      include 'db_connection.php';
      $sql_command = "SELECT test_id, q.ques_id, ques_type, ques_text, points, ans_id, ans_text, correct\n"
         . "FROM question q\n"
         . "LEFT OUTER JOIN answer a\n"
         . "ON q.ques_id = a.ques_id\n"
         . "WHERE test_id = " . $test_id . "\n"
         . "ORDER BY q.ques_id";
         /*"SELECT s.ques_id, ans_id, ques_no, ques_type, ques_text, ans_text, stu_ans_text, points, stu_points\n"
         . "FROM\n"
         . "(SELECT q.ques_id, q.ques_no, ques_type, ques_text, stu_ans_text, points, stu_points\n"
         . "FROM question q\n"
         . "LEFT OUTER JOIN student_answer s\n"
         . "ON q.ques_id = s.ques_id\n"
         . "WHERE test_id = " . $test_id . "\n"
         . "AND student_id = " . $student_id ."\n"
         . "OR student_id IS NULL) s\n"
         . "LEFT OUTER JOIN answer a\n"
         . "on s.ques_id = a.ques_id\n"
         . "WHERE correct IS NULL\n"
         . "OR correct = 1\n"
         . "ORDER BY ques_no";*/
      $sql_result = mysqli_query($connection, $sql_command);


      $ques_id = "";
      $count_matching = 0;
      $array_matching = array();

      for($i = 1, $q=0; $i <= @mysqli_num_rows($sql_result); $i++) {
         $row = mysqli_fetch_row($sql_result);
         if( $row[1] != $ques_id ) {

            if( $row[2] == "Matching" ) {
               $count_matching = get_matching_count($connection, $row, $student_id);
               array_push($array_matching, $row);
               for($z=1; $z<$count_matching*$count_matching; $z++, $i++) {
                  $row = mysqli_fetch_row($sql_result);
                  array_push($array_matching, $row);
               }
               echo get_test_type_matching($array_matching, ++$q, $student_id, $count_matching, $connection, $row[4]);
               $q = $q + $count_matching - 1;
               $ques_id = $row[1];
            }
            else {
               echo get_test_type($row, (($row[2] != "Instruction") ? ++$q : $q), $student_id, $sql_result);
               $ques_id = $row[1];
            }
         }
      }
      mysqli_close($connection);
   }

   function get_matching_count($temp_connection, $row, $student_id) {
      $sql_command_ex = "SELECT q.ques_id, stu_ans_text, stu_points\n"
         . "FROM question q\n"
         . "LEFT OUTER JOIN student_answer a\n"
         . "ON q.ques_id = a.ques_id\n"
         . "WHERE test_id = ".$row[0]."\n"
         . "AND student_id = ".$student_id."\n"
         . "AND q.ques_id = ".$row[1]."\n"
         . "ORDER BY q.ques_id";
      $sql_result_ex = mysqli_query($temp_connection, $sql_command_ex);
      $ex = mysqli_fetch_row($sql_result_ex);

      $sql_command_m = "SELECT COUNT(*) FROM answer WHERE ques_id = " . $ex[0];
      $sql_result_m = mysqli_query($temp_connection, $sql_command_m);
      $matching_form_count = mysqli_fetch_row($sql_result_m);
      $matching_form_count = $matching_form_count[0];
      return $matching_form_count;
   }

   function get_test_type_matching($row, $q, $student_id, $count_matching, $connections, $point) {
		include 'db_connection.php';
      $array_students_ans = array();
      $array_students_points = array();
      for($i=0; $i<$count_matching; $i++) {
         $sql_command = "SELECT * FROM student_answer WHERE ques_id = ".$row[$i*$count_matching][1]." AND student_id = ".$student_id;
         $sql_result = mysqli_query($connection, $sql_command);
         $result_data = mysqli_fetch_row($sql_result);
         array_push($array_students_ans, $result_data[2]);
         array_push($array_students_points, $result_data[3]);
      }

      $array_ans_list_form = array();
      $array_ans_list = array();
      $sql_result = mysqli_query($connection, 'SELECT ans_text, correct FROM answer WHERE ques_id = '.$row[0][1]);
      for($i=1,$ascii=65;$i<=$count_matching;$i++,$ascii++) {
         $tep = mysqli_fetch_row($sql_result);
         $array_ans_list_form += array($tep[0] => $ascii);
         array_push($array_ans_list, $tep[0]);
      }

      $array_test_ans = array();
      for($i=0;$i<$count_matching;$i++) {
         $sql_result = mysqli_query($connection, 'SELECT ans_text FROM answer WHERE ques_id = ' . $row[$i*$count_matching][1]. ' AND correct = 1');
         $tep = mysqli_fetch_row($sql_result);
         array_push($array_test_ans, $tep[0]);
      }

      $data =
         '<tr>'.
            '<td id="Matching">'.
               '<table>'.
                  '<tr>'.
                     '<td width="50%">Matching</td>'.
                     '<td colspan="1" width="750px">'.
                        //'<span id="theQuestion">'.$row[3].'</span> ('.$row[4].') - Ans: '.$row[6].
                     '</td>'.
                     '<td width="50px">'.'Stu.'.'</td>'.
                     '<td width="50px">'.'Ans.'.'</td>'.
                  '</tr>';

      for($i=0,$ascii=65;$i<$count_matching; $i++, $ascii++, $q++) {
         $temp =
                  '<tr>' .
                     '<td><span style="padding-left:10px;">Q.' . $q . " " . $row[$i*$count_matching][3] . '</span></td>' .
                     '<td>&#'.$ascii.';. '.$array_ans_list[$i] .'</td>' .
                     '<td>&#' . $array_ans_list_form[$array_students_ans[$i]] . ';</td>' .
                     '<td>&#' . $array_ans_list_form[$array_test_ans[$i]] . ';</td>' .
                  '</tr>';
         $data = $data . $temp;
      }

      $data = $data .
               '</table>'.
            '</td>'.
            '<td class="pointBox">'.
               '<table id="test_table2" style="border-color:transparent;">'.
                  '<tr><td>&nbsp;</td></tr>';

      $q = $q - $count_matching;
      for($i=0;$i<$count_matching; $i++, $q++) {
         $temp =
               '<tr><td id="pointBox'.$q .'"><input type="text" value="'.$array_students_points[$i].'" onkeydown="return isNumberKey(event)" onkeyup="calculate_total()" maxlength="3" style="width:40px;" class="points" id="p' . $q . '">/' .$point.'</tr></td>';
         $data = $data . $temp;
      }

      $data = $data .
               '</table>'.
            '</td>' .
         '</tr>';

      return $data;
   }

   function get_test_type($row, $q, $student_id, $main_result) {
      include 'db_connection.php';
      $sql_command_ex = "SELECT q.ques_id, stu_ans_text, stu_points\n"
         . "FROM question q\n"
         . "LEFT OUTER JOIN student_answer a\n"
         . "ON q.ques_id = a.ques_id\n"
         . "WHERE test_id = ".$row[0]."\n"
         . "AND student_id = ".$student_id."\n"
         . "AND q.ques_id = ".$row[1]."\n"
         . "ORDER BY q.ques_id";
      $sql_result_ex = mysqli_query($connection, $sql_command_ex);
      //mysqli_close($connection);

      /*if( $row[2] == "Matching" ) {
         $ex = mysqli_fetch_row($sql_result_ex);

         $sql_command_m = "SELECT COUNT(*) FROM student_answer WHERE ques_id = " . $ex[0];
         $sql_result_m = mysqli_query($connection, $sql_command_m);
         $matching_form_count = mysqli_fetch_row($sql_result_m);
         $matching_form_count = $matching_form_count[0];
         $GLOBALS['matching_count'] = $matching_form_count;

         $sql_command = "SELECT ans_text, correct\n"
            . "FROM answer\n"
            . "WHERE ques_id = " . $row[1];
         $sql_result = mysqli_query($connection, $sql_command);
         $ans_data = array();
         for($i=1;$i<=$matching_form_count;$i++) {
            $tep = mysqli_fetch_row($sql_result);
            $ans_data += array($tep[0] => 65);
         }
         $sql_result = mysqli_query($connection, $sql_command);

         $data =
            '<tr>'.
               '<td id="Matching">'.
                  '<table>'.
                     '<tr>'.
                        '<td width="50px">'.
                           'Ans.'. //$q.'.'.
                        '</td>'.
                        '<td colspan="2" width="750px">'.
                           //'<span id="theQuestion">'.$row[3].'</span> ('.$row[4].') - Ans: '.$row[6].
                        '</td>'.
                     '</tr>';




for($x=1,$ascii=65;$x<=$matching_form_count; $x++, $ascii++, $q++) {
   $ans_datas = mysqli_fetch_row($sql_result);
   $temp =
      '<tr>' .
         '<td>&#' . $ans_data[$ex[1]] . ';</td>' .
         '<td>' .
            '<span>Q.' . $q . " " . $row[3] . '</span>'.
         '</td>' .
         '<td>' .
            '&#'.$ascii.';. '.$ans_datas[0] .
         '</td>' .
      '</tr>';
   $data = $data . $temp;

   for($z=0;$z<$matching_form_count;$z++)
      $row = mysqli_fetch_row($main_result);
}

         $data = $data .
                  '</table>'.
               '</td>'.
               '<td class="pointBox" id="pointBox'.$q.'">'.
                  '<input type="text" value="'.((is_null($ex[2]))?0:$ex[2]).'" onchange="calculate_total()" class="points" id="p'.$q.'">/'.$row[4].
               '</td>'.
            '</tr>';


         return $data;
      }*/


      if( $row[2] == "True/False" ) {
         $ex = mysqli_fetch_row($sql_result_ex);
         mysqli_close($connection);
         $data =
            '<tr><td id="trueFalse" class="questionTD">'.
            '<table>'.
            '<tr>'.
            '<td width="50px">'.
            $q.'.'.
            '</td>'.
            '<td colspan="2" width="750px">'.
            '<span id="theQuestion">'.$row[3].'</span> ('.$row[4].') - Ans: '.$row[6].
            '</td>'.
            '</tr>'.
            '<tr>'.
            '<td></td>'.
            '<td>'.
            '<input disabled type="radio" name="trueFalseAns'.$q.'" value="true"' . (($ex[1]=="True")? 'checked':'') . '>True'.
            '</td>'.
            '<td>'.
            '<input disabled type="radio" name="trueFalseAns'.$q.'" value="false"' . (($ex[1]=="False")? 'checked':'') . '>False'.
            '</td>'.
            '</tr>'.
            '</table>'.
            '</td>'.
            '<td class="pointBox" id="pointBox'.$q.'">'.
            '<input type="text" value="'.((is_null($ex[2]))?0:$ex[2]).'" onkeydown="return isNumberKey(event)" onkeyup="calculate_total()" maxlength="3" style="width:40px;" class="points" id="p'.$q.'">/'.$row[4].
            '</td>'.
            '</tr>';
         return $data;
      }
      else if( $row[2] == "Multiple Choice" ) {
         $ex = mysqli_fetch_row($sql_result_ex);
         $sql_command = "SELECT ans_text, correct\n"
            . "FROM answer\n"
            . "WHERE ques_id = " . $row[1];
         $sql_result = mysqli_query($connection, $sql_command);

         $t_ans_array = array();
            for($i = 1; $i <= @mysqli_num_rows($sql_result); $i++) {
               $data = mysqli_fetch_row($sql_result);
               array_push($t_ans_array, $data[0]);
            }
         mysqli_close($connection);

         $data =
            '<tr><td id="multipleChoice" class="questionTD">'.
            '<table>'.
            '<tr>'.
            '<td width="50px">'.
            $q.'.'.
            '</td>'.
            '<td colspan="2" width="750px">'.
            '<span id="theQuestion">'.$row[3].'</span> ('.$row[4].') - Ans: '.$row[6].
            '</td>'.
            '</tr>'.
            '<tr>'.
            '<td></td>'.
            '<td style="width:45%">'.
            '<input disabled type="radio" name="multipleChoiceAns'.$q.'"'.(($ex[1]==$t_ans_array[0])?'checked':'').' value="a">'.$t_ans_array[0].
            '</td>'.
            '<td>'.
            '<input disabled type="radio" name="multipleChoiceAns'.$q.'"'.(($ex[1]==$t_ans_array[1])?'checked':'').' value="c">'.$t_ans_array[1].
            '</tr>'.
            '<tr>'.
            '<td></td>'.
            '<td>'.
            '<input disabled type="radio" name="multipleChoiceAns'.$q.'"'.(($ex[1]==$t_ans_array[2])?'checked':'').' value="b">'.$t_ans_array[2].
            '</td>'.
            '<td>'.
            '<input disabled type="radio" name="multipleChoiceAns'.$q.'"'.(($ex[1]==$t_ans_array[3])?'checked':'').' value="d">'.$t_ans_array[3].
            '</td>'.
            '</tr>'.
            '</table>'.
            '</td>'.
            '<td class="pointBox" id="pointBox'.$q.'">'.
            '<input type="text" value="'.((is_null($ex[2]))?0:$ex[2]).'" onkeydown="return isNumberKey(event)" onkeyup="calculate_total()" maxlength="3" style="width:40px;" class="points" id="p'.$q.'">/'.$row[4].
            '</td>'.
            '</tr>';
         return $data;
      }
      else if( $row[2] == "Many Choice" ) {

            $sql_command = "SELECT ans_text, correct\n"
               . "FROM answer\n"
               . "WHERE ques_id = " . $row[1];
            $sql_result = mysqli_query($connection, $sql_command);

            $ans_text = "";
            $t_ans_array = array();
            for($i = 1; $i <= @mysqli_num_rows($sql_result); $i++) {
               $data = mysqli_fetch_row($sql_result);
               if( $data[1]==1 )
                  $ans_text .= ((!$ans_text=="")?", ":""). $data[0];
               array_push($t_ans_array, $data[0]);
            }

            $s_ans_array = array();
            for($i = 1; $i <= @mysqli_num_rows($sql_result_ex); $i++) {
               $ex = mysqli_fetch_row($sql_result_ex);
               array_push($s_ans_array, $ex[1]);
            }

         mysqli_close($connection);

         $data =
            '<tr><td id="manyChoice" class="questionTD">'.
            '<table>'.
            '<tr>'.
            '<td width="50px">'.
            $q.'.'.
            '</td>'.
            '<td colspan="2" width="750px">'.
            '<span id="theQuestion">'.$row[3].'</span> ('.$row[4].') - Ans: '.$ans_text.
            '</td>'.
            '</tr>'.
            '<tr>'.
            '<td></td>'.
            '<td style="width:45%">'.
            '<input disabled type="checkbox" name="manyChoiceAns'.$q.'"'.((in_array($t_ans_array[0], $s_ans_array))?'checked':'').' value="a">'.$t_ans_array[0].
            '</td>'.
            '<td>'.
            '<input disabled type="checkbox" name="manyChoiceAns'.$q.'"'.((in_array($t_ans_array[1], $s_ans_array))?'checked':'').' value="c">'.$t_ans_array[1].
            '</tr>'.
            '<tr>'.
            '<td></td>'.
            '<td>'.
            '<input disabled type="checkbox" name="manyChoiceAns'.$q.'"'.((in_array($t_ans_array[2], $s_ans_array))?'checked':'').' value="b">'.$t_ans_array[2].
            '</td>'.
            '<td>'.
            '<input disabled type="checkbox" name="manyChoiceAns'.$q.'"'.((in_array($t_ans_array[3], $s_ans_array))?'checked':'').' value="d">'.$t_ans_array[3].
            '</td>'.
            '</tr>'.
            '</table>'.
            '</td>'.
            '<td class="pointBox" id="pointBox'.$q.'">'.
            '<input type="text" value="'.((is_null($ex[2]))?0:$ex[2]).'" onkeydown="return isNumberKey(event)" onkeyup="calculate_total()" maxlength="3" style="width:40px;" class="points" id="p'.$q.'">/'.$row[4].
            '</td>'.
            '</tr>';
         return $data;
      }
      else if( $row[2] == "Short Answer" ) {
         $ex = mysqli_fetch_row($sql_result_ex);
         mysqli_close($connection);
         $data =
            '<tr><td id="shortAnswer" class="questionTD">'.
            '<table>'.
            '<tr>'.
            '<td width="50px">'.
            $q.'.'.
            '</td>'.
            '<td width="750px">'.
            '<span id="theQuestion">'.$row[3].'</span> ('.$row[4].') - Ans: '.$row[6].
            '</td>'.
            '</tr>'.
            '<tr>'.
            '<td></td>'.
            '<td>'.
            '<input disabled type="text" name="shortAns" style="width:95%; height:25px;" value="'.$ex[1].'">'.
            '</td>'.
            '</tr>'.
            '</table>'.
            '</td>'.
            '<td class="pointBox" id="pointBox'.$q.'">'.
            '<input type="text" value="'.((is_null($ex[2]))?0:$ex[2]).'" onkeydown="return isNumberKey(event)" onkeyup="calculate_total()" maxlength="3" style="width:40px;" class="points" id="p'.$q.'">/'.$row[4].
            '</td>'.
            '</tr>';
         return $data;
      }
      else if( $row[2] == "Essay" ) {
         $ex = mysqli_fetch_row($sql_result_ex);
         mysqli_close($connection);
         $data =
            '<tr><td id="essay" class="questionTD">'.
            '<table>'.
            '<tr>'.
            '<td width="50px">'.
            $q.'.'.
            '</td>'.
            '<td width="750px">'.
            '<span id="theQuestion">'.$row[3].'</span> ('.$row[4].')'.
            '</td>'.
            '</tr>'.
            '<tr>'.
            '<td></td>'.
            '<td>'.
            '<textarea disabled type="text" name="essayAns" value="" class="essayText">'.$ex[1].'</textarea>'.
            '</td>'.
            '</tr>'.
            '</table>'.
            '</td>'.
            '<td class="pointBox" id="pointBox'.$q.'">'.
            '<input type="text" value="'.((is_null($ex[2]))?0:$ex[2]).'" onkeydown="return isNumberKey(event)" onkeyup="calculate_total()" maxlength="3" style="width:40px;" class="points" id="p'.$q.'">/'.$row[4].
            '</td>'.
            '</tr>';
         return $data;
      }
      mysqli_close($connection);
   }
?>