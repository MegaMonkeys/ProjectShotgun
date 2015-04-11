<?php
   include_once 'db_connection.php';

   $section_id = $_GET['section'];

   $class = "test";//$_GET['class'];

   //Test Names
   $result1 = mysqli_query($connection, "select test_name from test where section_id = ".$section_id);
   //Student names
   $result2 = mysqli_query($connection, "select distinct student_id, first_name, last_name from student join enrollment using(student_id) join student_test using (student_id) join test using (section_id) where student_test.test_id = test.test_id AND section_id = ".$section_id);
   //Test averages
   $result4 = mysqli_query($connection, "select FORMAT(test_avg, 2) from test where section_id = ".$section_id);
   //Total class average
   $result5 = mysqli_query($connection, "select FORMAT(AVG(test_avg), 2) from test where section_id = ".$section_id);

   echo "<p>$class</p>";
   $count = mysqli_num_rows($result1);
   $row1 = mysqli_fetch_array($result1);

   $countNo = 0;

   if ($count==0) {
      echo "<th> No test information to show :( </th>";
   }
   else {
      echo "<table style='border: solid 1px black' id='statsTable'>";

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
         $result3 = mysqli_query($connection, "select FORMAT(final_grade, 2) from student join enrollment using(student_id) join student_test using(student_id) join test using (section_id) where student_test.test_id = test.test_id AND section_id = " . $section_id . " AND student_id = $student_id;");
         //Each student's class average
         $result6 = mysqli_query($connection, "select FORMAT(AVG(final_grade), 2) from student join enrollment using(student_id) join student_test using(student_id) join test using (section_id) where student_test.test_id = test.test_id AND section_id = " . $section_id . " AND student_id = $student_id;");

         while ($row3 = mysqli_fetch_array($result3)) {
            echo "<td>$row3[0]"."%"."</td>";
         }
         $row6 = mysqli_fetch_array($result6);
         echo "<th>$row6[0]%</th>";
         echo "</tr>";
      }

      echo "<tr><th>AVG</th>";
      while ($row4 = mysqli_fetch_array($result4)) {
         echo "<th>$row4[0]%";
         if (!is_numeric($row4[0]))
            echo "--";
         echo "</th>";
      }
      $row5 = mysqli_fetch_array($result5);
      echo "<th>Total class avg: $row5[0]%</th>";

      echo "</tr>";
      echo "</table>";
   }
   mysqli_close($connection);
?>