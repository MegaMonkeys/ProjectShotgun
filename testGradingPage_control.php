<?php
   if( isset( $_GET['action'] ) ) {
      if( $_GET['action'] == 'get' )
         get_test($_GET['test_id'], $_GET['student_id']);
      if( $_GET['action'] == 'save' )
         save_test();
   }

   function save_test() {
      //echo $_GET['count'];
      include 'db_connection.php';
      $sql_command = "SELECT ques_id\n"
         . "FROM question\n"
         . "WHERE test_id = 4\n"
         . "AND ques_type != \"Instruction\"\n"
         . "ORDER BY ques_no";
      $sql_result = mysqli_query($connection, $sql_command);

      $q_id_array = array();
      for($i = 0; $i < @mysqli_num_rows($sql_result); $i++) {
         $data = mysqli_fetch_row($sql_result);
         array_push($q_id_array, $data[0]);
      }

      for($i = 0; $i < sizeof($q_id_array); $i++) {
         $sql_command = "UPDATE student_answer\n"
         ."SET stu_points = ".$_GET['n'.($i+1)]."\n"
         ."WHERE ques_id = ".$q_id_array[$i]."\n"
         ."AND student_id = ".$_GET['s_id']."\n";
         $sql_result = mysqli_query($connection, $sql_command);
      }
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
      $sql_command = "SELECT s.student_id, first_name, last_name\n"
         . "FROM student s\n"
         . "LEFT OUTER JOIN student_test t\n"
         . "ON s.student_id = t.student_id\n"
         . "WHERE test_id = 4\n"
         . "OR test_id IS NULL\n"
         . "ORDER BY LAST_NAME";
      $sql_result = mysqli_query($connection, $sql_command);
      mysqli_close($connection);

      for($i = 1; $i <= @mysqli_num_rows($sql_result); $i++) {
         //[0]-STUDENT_ID [1]-FIRST_NAME [2]-LAST_NAME
         $row = mysqli_fetch_row($sql_result);
         $s_name = $row[1] . ', ' . $row[2];
         echo '<tr>';
            echo '<td id="studentTD" type="submit" onclick="get_student_test(4,'.$row[0].','."'".$s_name."'".' )">';
                  echo($s_name);
            echo '</td>';
         echo '</tr>';
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
      $sql_command = "SELECT s.ques_id, ans_id, ques_no, ques_type, ques_text, ans_text, stu_ans_text, points, stu_points\n"
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
         . "ORDER BY ques_no";
      $sql_result = mysqli_query($connection, $sql_command);
      mysqli_close($connection);

      $ques_id = "";
      for($i = 1, $q=0; $i <= @mysqli_num_rows($sql_result); $i++) {
         $row = mysqli_fetch_row($sql_result);
         if( $row[0] != $ques_id ) {
            echo get_test_type($row, (($row[3] != "Instruction") ? ++$q : $q));
            $ques_id = $row[0];
         }
         else {

         }
      }
   }

   function get_test_type($row, $q) {
      if( $row[3] == "True/False" ) {
         $data =
            '<tr><td id="trueFalse">'.
            '<table>'.
            '<tr>'.
            '<td width="50px">'.
            $q.'.'.
            '</td>'.
            '<td colspan="2" width="750px">'.
            '<span id="theQuestion">'.$row[4].'</span> ('.$row[7].') - Ans: '.$row[5].
            '</td>'.
            '</tr>'.
            '<tr>'.
            '<td></td>'.
            '<td>'.
            '<input disabled type="radio" name="trueFalseAns'.$q.'" value="true"' . (($row[6]=="True")? 'checked':'') . '>True'.
            '</td>'.
            '<td>'.
            '<input disabled type="radio" name="trueFalseAns'.$q.'" value="false"' . (($row[6]=="False")? 'checked':'') . '>False'.
            '</td>'.
            '</tr>'.
            '</table>'.
            '</td>'.
            '<td class="pointBox" id="pointBox'.$q.'">'.
            '<input type="text" value="'.((is_null($row[8]))?0:$row[8]).'" onchange="calculate_total()" class="points" id="p'.$q.'">/'.$row[7].
            '</td>'.
            '</tr>';
         return $data;
      }
      else if( $row[3] == "Multiple Choice" ) {
         include 'db_connection.php';
         $sql_command = "SELECT ans_text, correct\n"
            . "FROM answer\n"
            . "WHERE ques_id = " . $row[0];
         $sql_result = mysqli_query($connection, $sql_command);

            $t_ans_array = array();
            for($i = 1; $i <= @mysqli_num_rows($sql_result); $i++) {
               $data = mysqli_fetch_row($sql_result);
               array_push($t_ans_array, $data[0]);
            }
         mysqli_close($connection);

         $data =
            '<tr><td id="multipleChoice">'.
            '<table>'.
            '<tr>'.
            '<td width="50px">'.
            $q.'.'.
            '</td>'.
            '<td colspan="2" width="750px">'.
            '<span id="theQuestion">'.$row[4].'</span> ('.$row[7].') - Ans: '.$row[5].
            '</td>'.
            '</tr>'.
            '<tr>'.
            '<td></td>'.
            '<td style="width:45%">'.
            '<input disabled type="radio" name="multipleChoiceAns'.$q.'"'.(($row[6]==$t_ans_array[0])?'checked':'').' value="a">'.$t_ans_array[0].
            //'<input disabled type="radio" name="multipleChoiceAns'.$q.'"'.(($q_info[1]=="1")?0checked':'').' value="a">'.$q_info[0].
            '</td>'.
            '<td>'.
            '<input disabled type="radio" name="multipleChoiceAns'.$q.'"'.(($row[6]==$t_ans_array[1])?'checked':'').' value="c">'.$t_ans_array[1].
            '</tr>'.
            '<tr>'.
            '<td></td>'.
            '<td>'.
            '<input disabled type="radio" name="multipleChoiceAns'.$q.'"'.(($row[6]==$t_ans_array[2])?'checked':'').' value="b">'.$t_ans_array[2].
            '</td>'.
            '<td>'.
            '<input disabled type="radio" name="multipleChoiceAns'.$q.'"'.(($row[6]==$t_ans_array[3])?'checked':'').' value="d">'.$t_ans_array[3].
            '</td>'.
            '</tr>'.
            '</table>'.
            '</td>'.
            '<td class="pointBox" id="pointBox'.$q.'">'.
            '<input type="text" value="'.((is_null($row[8]))?0:$row[8]).'" onchange="calculate_total()" class="points" id="p'.$q.'">/'.$row[7].
            '</td>'.
            '</tr>';
         return $data;
      }
      else if( $row[3] == "Many Choice" ) {
         include 'db_connection.php';
            $sql_command = "SELECT ans_text, correct\n"
               . "FROM answer\n"
               . "WHERE ques_id = " . $row[0];
            $sql_result = mysqli_query($connection, $sql_command);

            $ans_text = "";
            $t_ans_array = array();
            for($i = 1; $i <= @mysqli_num_rows($sql_result); $i++) {
               $data = mysqli_fetch_row($sql_result);
               if( $data[1]==1 )
                  $ans_text .= ((!$ans_text=="")?", ":""). $data[0];
               array_push($t_ans_array, $data[0]);
            }

            $sql_command = "SELECT stu_ans_text\n"
               . "FROM student_answer\n"
               . "WHERE ques_id = " . $row[0];
            $sql_result = mysqli_query($connection, $sql_command);

            $s_ans_array = array();
            for($i = 1; $i <= @mysqli_num_rows($sql_result); $i++) {
               $data = mysqli_fetch_row($sql_result);
               array_push($s_ans_array, $data[0]);
            }

         mysqli_close($connection);

         $data =
            '<tr><td id="manyChoice">'.
            '<table>'.
            '<tr>'.
            '<td width="50px">'.
            $q.'.'.
            '</td>'.
            '<td colspan="2" width="750px">'.
            '<span id="theQuestion">'.$row[4].'</span> ('.$row[7].') - Ans: '.$ans_text.
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
            '<input type="text" value="'.((is_null($row[8]))?0:$row[8]).'" onchange="calculate_total()" class="points" id="p'.$q.'">/'.$row[7].
            '</td>'.
            '</tr>';
         return $data;
      }
      else if( $row[3] == "Short Answer" ) {
         $data =
            '<tr><td id="shortAnswer">'.
            '<table>'.
            '<tr>'.
            '<td width="50px">'.
            $q.'.'.
            '</td>'.
            '<td width="750px">'.
            '<span id="theQuestion">'.$row[4].'</span> ('.$row[7].') - Ans: '.$row[5].
            '</td>'.
            '</tr>'.
            '<tr>'.
            '<td></td>'.
            '<td>'.
            '<input disabled type="text" name="shortAns" style="width:95%; height:25px;" value="'.$row[6].'">'.
            '</td>'.
            '</tr>'.
            '</table>'.
            '</td>'.
            '<td class="pointBox" id="pointBox'.$q.'">'.
            '<input type="text" value="'.((is_null($row[8]))?0:$row[8]).'" onchange="calculate_total()" class="points" id="p'.$q.'">/'.$row[7].
            '</td>'.
            '</tr>';
         return $data;
      }
      else if( $row[3] == "Essay" ) {
         $data =
            '<tr><td id="essay">'.
            '<table>'.
            '<tr>'.
            '<td width="50px">'.
            $q.'.'.
            '</td>'.
            '<td width="750px">'.
            '<span id="theQuestion">'.$row[4].'</span> ('.$row[7].')'.
            '</td>'.
            '</tr>'.
            '<tr>'.
            '<td></td>'.
            '<td>'.
            '<textarea disabled type="text" name="essayAns" value="" class="essayText"></textarea>'.
            '</td>'.
            '</tr>'.
            '</table>'.
            '</td>'.
            '<td class="pointBox" id="pointBox'.$q.'">'.
            '<input type="text" value="'.((is_null($row[8]))?0:$row[8]).'" onchange="calculate_total()" class="points" id="p'.$q.'">/'.$row[7].
            '</td>'.
            '</tr>';
         return $data;
      }
   }
?>