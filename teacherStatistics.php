<?php
   include_once 'db_connection.php';

   $section_id = $_GET['section'];

   $class = mysqli_fetch_array(mysqli_query($connection, "select course_no, '-', section_no, description from section join course using(course_no) where section_id = " . $section_id)); 

   //Test Names
   $result1 = mysqli_query($connection, "select test_name from test where section_id = ".$section_id);
   //Student names
   $result2 = mysqli_query($connection, "select distinct student_id, first_name, last_name from student join enrollment using(student_id) join student_test using (student_id) join test using (section_id) where student_test.test_id = test.test_id AND section_id = ".$section_id);
   //Test averages
   $result4 = mysqli_query($connection, "select FORMAT(avg(final_grade), 2) from student_test right outer join (select test_id from test where section_id = " . $section_id . ")new using(test_id) where test_id in (select test_id from test where section_id = " . $section_id . ") group by test_id");
   //Total class average
   $result5 = array();

   echo "<p id='statTitle'><br />".$class[0],$class[1],$class[2]." ".$class[3]."<br /><br /></p>";
   echo "<p></p>";
   
   $count = mysqli_num_rows($result1);
   $row1 = mysqli_fetch_array($result1);

   $countNo = 0;

   if ($count==0) {
      echo "<th> No test information to show :( </th>";
   }
   else {
      echo "<table id='statsTable'>";

      echo "<tr><th>STUDENTS</th>";
      do {
      echo "<th>$row1[0]</th>";
      $countNo += 1;
      }while ($row1 = mysqli_fetch_array($result1));
      echo "<th>CUMULATIVE AVG</th>";
      echo "</tr>";

      while ($row2 = mysqli_fetch_array($result2)) {
         echo "<tr>";
         echo "<td>$row2[1]"." "."$row2[2]</td>";
         $student_id = $row2[0];
         //Student grades
         $result3 = mysqli_query($connection, "select FORMAT(final_grade, 2) from test left outer join (select test_id, final_grade from student_test where student_id = " . $student_id . ")new using(test_id) where section_id = " . $section_id . " order by test_id");
         //Each student's class average
         $result6 = mysqli_query($connection, "select FORMAT(AVG(final_grade), 2) from student join enrollment using(student_id) join student_test using(student_id) join test using (section_id) where student_test.test_id = test.test_id AND section_id = " . $section_id . " AND student_id = $student_id;");
         $thisRowCount = 0;
         while ($thisRowCount < $countNo) {
            $row3 = mysqli_fetch_array($result3);
            if (is_numeric($row3[0]))
	        	echo "<td>$row3[0]%</td>";
            if (!is_numeric($row3[0]))
            	echo "<td>No Data</td>";
            $thisRowCount += 1;
         }
         $row6 = mysqli_fetch_array($result6);
         if (is_numeric($row6[0]))
         	echo "<th>$row6[0]%</th>";
         if (!is_numeric($row6[0]))
         	echo "<th>No Data</th>";
         echo "</tr>";
      }

      echo "<tr><th>AVG</th>";
      while ($row4 = mysqli_fetch_array($result4)) {
	     echo "<th>";
		 if (!is_numeric($row4[0]))
            echo "No Data</th>";
        if (is_numeric($row4[0])){
	     	echo "$row4[0]%";
	     	array_push($result5, $row4[0]);
     	}
        echo "</th>";
      }
      $row4_2 = array_sum($result5) / count($result5);
      echo "<th>Total class avg: ";   
      if (is_numeric($row4_2))
            echo "$row4_2%";
      if (!is_numeric($row4_2))
            echo "No Data";
      echo "</th>";      

      echo "</tr>";
      echo "</table>";
   }
   mysqli_close($connection);
?>