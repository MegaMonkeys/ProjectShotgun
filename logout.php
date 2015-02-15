<?php
	session_start();
	
	$old_session = @$_SESSION['session'];
	unset($_SESSION['session']);
	session_destroy();
	
	if(!empty($old_session)) {
		header('Location: ./index.php');
		exit;
	}
	else {
		echo "Invalid Access";
	}
?>

<!DOCTYPE html>
<HTML>
	<link rel="stylesheet" type="text/css" href="loginStyle.css">
	<HEAD>
		<TITLE>MegaTest - Online Testing Application</TITLE>
	</HEAD>
	<BODY>
	
	</BODY>
</HTML>