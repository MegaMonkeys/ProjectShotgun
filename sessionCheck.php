<?php
	//session_start();
	$old_session = @$_SESSION['session'];

	if(empty($old_session)) {
		unset($_SESSION['session']);
		session_destroy();
		header('Location: ./index.php');
		exit;
	}

   //Illegal Page Access Checker
   function user_type_check($user_type) {
      if( $_SESSION['user_type'] != $user_type ) {
         if( $_SESSION['user_type'] == 'Teacher' ) {
            header('Location: ./teacherHomePage.php');
            exit;
         }
         else if ( $_SESSION['user_type'] == 'Student' ) {
            header('Location: ./studentHomePage2.php');
            exit;
         }
      }
   }


//$_SESSION[] VARIABLE
   //session    = '' / session_on
   //user_type  = Teacher / Student
   //user_id    = $u_id
   //user_name  = array(first_name, last_name)
   //section_id = only to teacherPage yet. it gets unset after used.
?>