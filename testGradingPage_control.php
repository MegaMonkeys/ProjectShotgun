<?php
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
      $sql_command = "SELECT stu_ans_id, ques_type, points\n"
            . "FROM student_answer s\n"
            . "JOIN question q \n"
            . "ON s.ques_id = q.ques_id\n"
            . "WHERE student_id = " . $_GET['s_id'] . "\n"
            . "AND test_id = " . $_GET['t_id'] . "\n";

         /*"SELECT stu_ans_id, ques_type\n"
         . "FROM student_answer\n"
         . "WHERE student_id = " . $_GET['s_id'] . "\n"
         . "AND ques_id\n"
         . "IN (\n"
         . "SELECT ques_id\n"
         . "FROM question\n"
         . "WHERE test_id = " . $_GET['t_id'] . "\n"
         . "AND ques_type != \"Instruction\"\n"
         . "ORDER BY ques_no)\n"
         . "GROUP BY ques_id";*/

         /*"SELECT ques_id\n"
         . "FROM question\n"
         . "WHERE test_id = 4\n"
         . "AND ques_type != \"Instruction\"\n"
         . "ORDER BY ques_no";*/
      $sql_result = mysqli_query($connection, $sql_command);

      if( $_GET['count'] != 0 && mysqli_num_rows($sql_result) == 0 )
	  {
		  $q_id_array = array();
		  $q_type_array = array();
		  $q_total_p     = 0;
		  $q_objective_p = 0;
		  $q_essay_p     = 0;
		  $q_total_s     = 0;
		  for($i = 0; $i < @mysqli_num_rows($sql_result); $i++) {
			 $data = mysqli_fetch_row($sql_result);
			 array_push($q_id_array,   $data[0]);
			 array_push($q_type_array, $data[1]);
			 $q_total_p += $data[2];
		  }

		  for($i = 0; $i < sizeof($q_id_array); $i++) {
			 $sql_command = "UPDATE student_answer\n"
			 ."SET stu_points   = ".$_GET['n'.($i+1)]."\n"
			 ."WHERE stu_ans_id = ".$q_id_array[$i]."\n"
			 ."AND student_id   = ".$_GET['s_id']."\n";
			 mysqli_query($connection, $sql_command);
			 echo $q_type_array[$i];
			 
			 if( $q_type_array[$i] != "Instruction" )
				$q_objective_p += $_GET['n'.($i+1)];
			 else
				$q_essay_p += $_GET['n'.($i+1)];
		  }
		  
		  $q_total_s = ($q_objective_p+$q_essay_p)*100/(($q_total_p!=0)?$q_total_p:1);
		  
		  $sql_command = "UPDATE student_test\n"
			 . "SET objective_grade = " . $q_objective_p . "\n"
			 . ", essay_grade = " . $q_essay_p . "\n"
			 . ", final_grade = " . $q_total_s . "\n"
			 . "WHERE student_id   = ".$_GET['s_id']."\n"
			 . "AND test_id = " . $_GET['t_id'];
		  mysqli_query($connection, $sql_command);
      }
	  else {
	     
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
      $sql_command = "SELECT s.student_id, first_name, last_name from test t\n"
				. "join enrollment e\n"
				. "join student s\n"
				. "on t.section_id = e.section_id\n"
				. "and e.student_id = s.student_id\n"
				. "where test_id = " . $_POST['gradeButton'];
	  
	  
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
         $s_name = $row[1] . ', ' . $row[2];
         echo '<tr>';
            echo '<td id="studentTD" type="submit" onclick="get_student_test('.$_POST['gradeButton'].','.$row[0].','."'".$s_name."'".' )">';
                  echo($s_name);
            echo '</td>';
         echo '</tr>';
		 if($i == 1) {
			global $f_id, $f_name;
			$f_id = $row[0];
			$f_name = $s_name;
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
	  $sql_command = "SELECT * FROM student_test WHERE student_id = ".$student_id." AND test_id = ".$test_id;
	  $sql_result = mysqli_query($connection, $sql_command);
	  
	  if(mysqli_num_rows($sql_result) == 0)
	  {
         echo '<script type="text/javascript">alert("This Student did not take the tset.");</script>';
	  }
	  else {
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
      mysqli_close($connection);

      $ques_id = "";

      for($i = 1, $q=0; $i <= @mysqli_num_rows($sql_result); $i++) {
         $row = mysqli_fetch_row($sql_result);
         if( $row[1] != $ques_id ) {
            echo get_test_type($row, (($row[2] != "Instruction") ? ++$q : $q), $student_id);
            $ques_id = $row[1];
         }
      }
	  }
   }

   function get_test_type($row, $q, $student_id) {
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


      if( $row[2] == "True/False" ) {
         $ex = mysqli_fetch_row($sql_result_ex);
         mysqli_close($connection);
         $data =
            '<tr><td id="trueFalse">'.
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
            '<input type="text" value="'.((is_null($ex[2]))?0:$ex[2]).'" onchange="calculate_total()" class="points" id="p'.$q.'">/'.$row[4].
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
            '<tr><td id="multipleChoice">'.
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
            '<input type="text" value="'.((is_null($ex[2]))?0:$ex[2]).'" onchange="calculate_total()" class="points" id="p'.$q.'">/'.$row[4].
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

            $s_point = 0;
            $s_ans_array = array();
            for($i = 1; $i <= @mysqli_num_rows($sql_result_ex); $i++) {
               $ex = mysqli_fetch_row($sql_result_ex);
               array_push($s_ans_array, $ex[1]);
               if( $i == 1) {
                  $s_point = $ex[2];
               }
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
            '<input type="text" value="'.((is_null($s_point))?0:$s_point).'" onchange="calculate_total()" class="points" id="p'.$q.'">/'.$row[4].
            '</td>'.
            '</tr>';
         return $data;
      }
      else if( $row[2] == "Short Answer" ) {
         $ex = mysqli_fetch_row($sql_result_ex);
         mysqli_close($connection);
         $data =
            '<tr><td id="shortAnswer">'.
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
            '<input type="text" value="'.((is_null($ex[2]))?0:$ex[2]).'" onchange="calculate_total()" class="points" id="p'.$q.'">/'.$row[4].
            '</td>'.
            '</tr>';
         return $data;
      }
      else if( $row[2] == "Essay" ) {
         $ex = mysqli_fetch_row($sql_result_ex);
         mysqli_close($connection);
         $data =
            '<tr><td id="essay">'.
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
            '<input type="text" value="'.((is_null($ex[2]))?0:$ex[2]).'" onchange="calculate_total()" class="points" id="p'.$q.'">/'.$row[4].
            '</td>'.
            '</tr>';
         return $data;
      }
      mysqli_close($connection);
   }
?>