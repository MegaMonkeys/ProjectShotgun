<?php
	//session_start();
	
	$old_session = @$_SESSION['session'];

	if(empty($old_session)) {
		unset($_SESSION['session']);
		session_destroy();
		header('Location: ./index.php');
		exit;
	}
	else {
		//echo "Invalid Access";
	}
?>

<!--
session   = '' / session_on
user_type = Teacher / Student
user_id   = $u_id
user_name = array(first_name, last_name)







-->