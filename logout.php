<?php
	session_set_cookie_params(0);
	session_start();
?>

<?php
	$_SESSION["session"] = "";
	header('Location: ./index.php');
	exit;
?>