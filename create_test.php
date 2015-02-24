<?php
   // Cancel button not handled on this page.




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
	if (!@mysqli_real_connect($conn,'CSWEB.studentnet.int', 'team2_cs414', 't2CS414', 'cs414_team2'))
	{
		die("<br>Connect Error : " . mysqli_connect_error());
	}
	else
	{
		echo "Connected successfully<br>";
	}
	
   // Get the section id associated with the course and section numbers the user put in
	$cNo = isset($_POST['courseNo']) == true ? $_POST['courseNo'] : '';
	$sNo = isset($_POST['sectionNo']) == true ? $_POST['sectionNo'] : '';
   $sqlComm = "select section_id from section where course_no = '".$cNo."' and section_no = ".$sNo;
   $row = mysqli_fetch_row(mysqli_query($conn, $sqlComm));
   
   // Get form information. Format the timeLimit, startDate, and endDate to be compatible with the DB
	$sectionId   = $row[0];
	$testName    = strlen($_POST['testName']) != 0     ? $_POST['testName']  : "Test";
   $published   = ($_POST['submitTest'] == "publish") ? "1"                 : "0";
	$hourLimit   = strlen($_POST['hours']) != 0        ? $_POST['hours']     : "1";
	$minuteLimit = strlen($_POST['minutes']) != 0      ? $_POST['minutes']   : "0";
   $timeLimit   = ($hourLimit < 10 ? "0" : "") . $hourLimit . ":" . ($minuteLimit < 10 ? "0" : "") . $minuteLimit . ":00" ;
	$startDate   = strlen($_POST['startDate']) != 0    ? $_POST['startDate'] : date("Y-m-d");
	$startTime   = strlen($_POST['startTime']) != 0    ? $_POST['startTime'] : "07:30";
   $startDate   = $startDate . " " . $startTime;
	$endDate     = strlen($_POST['endDate']) != 0      ? $_POST['endDate']   : date("y-m-d");
	$endTime     = strlen($_POST['endTime']) != 0      ? $_POST['endTime']   : "22:00";
   $endDate     = $endDate . " " . $endTime;
   
   // Add the test to the database
	$sqlComm = "insert into test (section_id, test_name, published, time_limit, start_date, end_date, created_date)".
               " values (".$sectionId.", '".$testName."', ".$published.", '".$timeLimit."', '".$startDate."', '".$endDate."', '".date("Y-m-d")."')";

// Uncomment this line to add tests to the database
//   mysqli_query($conn, $sqlComm);
   
   echo "<hr>";
   echo "<br> Success!";
   echo "<br> Test not created. mysqli_query() command commented out for testing purposes.";
   echo "<br> SQL Command generated: <br>";        
   echo "<br> $sqlComm <br>";
   echo "<hr>";
    
   mysqli_close($conn);
   
   header("Location: teacherHomePage.php");
?>