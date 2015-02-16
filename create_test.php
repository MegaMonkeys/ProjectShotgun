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
	if (!@mysqli_real_connect($conn,'CSWEB.studentnet.int', 'team2_cs414', 't2CS414', 'cs414_team2'))
	{
		die("<br>Connect Error : " . mysqli_connect_error());
	}
	else
	{
		echo "Connected successfully<br>";
	}
	echo "<hr>";
	echo "<br> Database list <br>";
	$result=mysqli_query($conn, "show databases");
	$count=mysqli_num_rows($result);
	for($i=0; $i<$count; $i++)
    {
        $row=mysqli_fetch_assoc($result);
        echo $row['Database']."<br>";
    }
	
	$c_no = isset($_POST['course_no']) == true ? $_POST['course_no'] : '';
	$s_no = isset($_POST['section_no']) == true ? $_POST['section_no'] : '';
   $sql_comm = "select section_id from section where course_no = '".$c_no."' and section_no = ".$s_no;
   $row = mysqli_fetch_row(mysqli_query($conn, $sql_comm));
   
	$section_id = $row[0];
	$test_name  = strlen($_POST['test_name']) != 0    ? $_POST['test_name']  : "Test";
   $published  = isset ($_POST['published']) == true ? $_POST['published']  : "0";
	$time_limit = strlen($_POST['time_limit']) != 0   ? $_POST['time_limit'] : "01:00";
	$start_date = strlen($_POST['start_date']) != 0   ? $_POST['start_date'] : date("Y-m-d");
	$start_time = strlen($_POST['start_time']) != 0   ? $_POST['start_time'] : "07:30";
   $start_date = $start_date . " " . $start_time;
	$end_date   = strlen($_POST['end_date']) != 0     ? $_POST['end_date']   : date("y-m-d");
	$end_time   = strlen($_POST['end_time']) != 0     ? $_POST['end_time']   : "22:00";
   $end_date   = $end_date . " " . $end_time;
   
   // Add the test to the database
	$sql_comm = "insert into test (section_id, test_name, published, time_limit, start_date, end_date, created_date)".
               " values (".$section_id.", '".$test_name."', ".$published.", '".$time_limit."', '".$start_date."', '".$end_date."', '".date("Y-m-d")."')";

   mysqli_query($conn, $sql_comm);
   
   echo "<hr>";
   echo "<br> SQL Command to create this test: <br>";        
   echo "<br> $sql_comm <br>";
   echo "<hr>";
   
   $sql_comm = isset($_POST['sql_c']) == true ? $_POST['sql_c'] : '';
	echo "<br><br> !! SQL COMMAND RESULT !! - ";
	echo "SQL Command : $sql_comm <br><br>";
	
	$result=mysqli_query($conn, $sql_comm);
	$count=mysqli_num_rows($result);
	$column=mysqli_num_fields($result);
	
	echo "<TABLE BORDER='0' CELLPADDING='3' CELLSPACING='3'>";
	for($i=0; $i<$count; $i++)
    {
		echo "<TR>";
        $row=mysqli_fetch_row($result);
        for ($c=0; $c<$column; $c++)
		{
			echo "<TD>". $row[$c] . "<TD>";
		}
		echo "</TR>";
    }
	echo "</TABLE>";
    
    
    
   mysqli_close($conn);
?>