<?php
	//Check MySQL initialisation check
	$conn=mysqli_init();
	if (!$conn)
	{
		die("mysqli_init failed");
	}
	
	//Set connection time out
	mysqli_options($conn,MYSQLI_OPT_CONNECT_TIMEOUT,"10");
	
	//Connect to the MySQL Server
	//Warning Disabled
   if (!@mysqli_real_connect($conn,'CSWEB.studentnet.int', 'team2_cs414', 't2CS414', 'cs414_team2')) {
      if (!@mysqli_real_connect($conn,'localost', 'team2', 'team2', 'cs414_team2')) {
         die("<br>Connect Error : " . mysqli_connect_error()); }}
      else
         echo "MySQL DB - Connected Successfully<br>";
   echo "<hr>";
   
   // Get question info
	$test_name = strlen($_POST['test_name']) != 0   ? $_POST['test_name'] : '';
   $ques_no   = strlen($_POST['ques_no']) != 0     ? $_POST['ques_no']   : '';
   $ques_type = strlen($_POST['ques_type']) != 0   ? $_POST['ques_type'] : '';
   $points    = strlen($_POST['points']) != 0      ? $_POST['points']    : '';
   $question  = strlen($_POST['question']) != 0    ? $_POST['question']  : '';
   
   // Get the test_id for a given test name.
   // (We won't necessarily be able to do this in the future because tests names aren't necessarily unique.)
   $sql_comm = "select test_id from test where test_name = '$test_name'";
   $row      = mysqli_fetch_row(mysqli_query($conn, $sql_comm));
	$test_id  = $row[0];
   
   // Add the question to the database
   $sql_comm = "insert into question (test_id, ques_no, ques_type, ques_text, points)".
               "values ($test_id,$ques_no,'$ques_type','$question',$points)";
   mysqli_query($conn, $sql_comm);
               
   // Get the question id for the question that was just created
	$ques_id  = mysqli_insert_id($conn);
   
   // Add the choices to the database
   if($ques_id != 0)
   {
      for($x = 1; $x <= 5; $x++)
      {
         if(strlen($_POST['choice'.$x]) != 0)
         {
            $choice = $_POST['choice'.$x];
            $correct = isset($_POST['correct'.$x]) == true ? $_POST['correct'.$x] : '0';
            $sql_comm = "insert into answer (ques_id, ans_text, correct)".
                        "values ($ques_id,'$choice',$correct)";
            mysqli_query($conn, $sql_comm);
         }
      }
   
      // Update the number-of-questions field in the TEST table
      $sql_comm = "select count(test_id) from question where test_id = ".
                  "(select test_id from test where test_name = '$test_name')";
      $row = mysqli_fetch_row(mysqli_query($conn, $sql_comm));
      $no_of_q = $row[0];
      $sql_comm = "update test set no_of_q = $no_of_q where test_id = $test_id";
      mysqli_query($conn, $sql_comm);
   }

   echo "Test named \"$test_name\" now has $no_of_q questions";

   mysqli_close($conn);
?>