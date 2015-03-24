<?php
	//session_set_cookie_params(0);
	//session_start();
?>

<?php
	if (!empty($_SERVER['HTTP']) && ('on' == $SERVER['HTTPS'])) {
		$uri = 'https://';
	}
	else {
		$uri = 'http://';
	}
	
	$uri .= $_SERVER['HTTP_HOST'];
	//header('Location: '.$uri.'/cs414/youngchan_test/development/loginPage.php');
	header('Location: ./loginPage.php');
	exit;
?>
