<?php
	session_set_cookie_params(0);
	session_start();
?>

<!DOCTYPE html>
<HTML>
<link rel="stylesheet" type="text/css" href="loginStyle.css">
<HEAD>
    <TITLE>
        MegaTest - Online Testing Application
    </TITLE>
</HEAD>
<BODY>
	
	<?php //Main PHP Functions
		$u_id = $u_pw = $u_type = $result = $session_id = "";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$u_id  = html_input($_POST["user"]);
			$u_pw  = html_input($_POST["password"]);
			$result = check_account($u_id, $u_pw);
			if($result != "INVALID LOGIN")
				$session_id = "session_on";
		}

		function html_input($data) {
			//$data = trim($data);
			//$data = intval($data); //In DB, ID & PW is stored as Integer
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		function check_account($u_id, $u_pw) {
			//Check MySQL initialisation check
			$connection = mysqli_init();
			if (!$connection)
				die("mysqli_init failed");

			//Set connection time out
			mysqli_options($connection, MYSQLI_OPT_CONNECT_TIMEOUT, "10");

			//Connect to the MySQL Server
			if (!@mysqli_real_connect($connection,'CSWEB.studentnet.int', 'team2_cs414', 't2CS414', 'cs414_team2'))
				return("Connect Error : " . mysqli_connect_error()); //die->return
			else
				echo "MySQL DB - Connected Successfully<br>";

			//Check ID and PW
			$sql_command = "SELECT USER_TYPE, LENGTH(USER_ID), LENGTH(PASSWORD) FROM account WHERE USER_ID = " . $u_id . " and PASSWORD = " . $u_pw . ";";
			$sql_result  = mysqli_query($connection, $sql_command);
			$count       = @mysqli_num_rows($sql_result);
			$row         = mysqli_fetch_row($sql_result);

			if($count == 0) {
				mysqli_close($connection);
				return "INVALID LOGIN";
			}
			else if($count == 1) {
				//$row = mysqli_fetch_row($sql_result);

				if($row[1] == strlen($u_id) && $row[2] == strlen($u_pw)) { //Length Check for ID & Password
					if ($row[0] == "I") {//If Instructor
						$sql_command = "SELECT FIRST_NAME, LAST_NAME FROM INSTRUCTOR WHERE INSTRUCTOR_ID = " . $u_id . ";";
					}
					elseif ($row[0] == "S") {//If Student
						$sql_command = "SELECT FIRST_NAME, LAST_NAME FROM STUDENT WHERE STUDENT_ID = " . $u_id . ";";
					}
				}
				else { //If Length Check fails
					mysqli_close($connection);
					return "INVALID LOGIN";
				}

				$sql_result  = mysqli_query($connection, $sql_command);
				$row         = mysqli_fetch_row($sql_result);
				mysqli_close($connection);
				return $row[0] . " " . $row[1];
			}
			else {
				return "Error :- Ducplicate Account Exist";
			}
		}
	//End of Main PHP Functions
	?> 
	
	<?php //Body PHP
		$_SESSION["session"] = $session_id;
		if($_SESSION["session"] != "")
			header('Location: ./testMkaingPae/testMakingPage.php');
	
	
	
	//End of Body PHP
	?>


<div class="background">
</div>

<div class="header">
    <div class="title">Online Test</div>
</div>

<div id='cssmenu'>
    <ul>
        <li class='#'><a href='#'><span>Home</span></a></li>
        <li><a href='#'><span>About</span></a></li>
        <li><a href='#'><span>Team</span></a></li>
        <li class='last'><a href='#'><span>Contact</span></a></li>
    </ul>
</div>

<div class="content">
    <div class="inner_content">
        <div id="title">

        </div>

        <div class="login">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="text" placeholder="username" name="user" required><br>
                <input type="password" placeholder="password" name="password" required><br>
                <?php
					if($result)
						echo $result . "<br>";
					else
						echo "";
                ?>
                <input type="submit" class="myButton" value="Login">

					<span>
						<?php
							if(isset($_GET['msg']))
								echo $_GET['msg'];
                        ?>
					</span>
                <!--
                the php
                if(!$_POST["username"] || !$_POST["password"])
                {
                $msg = "You left one or more of the required fields.";
                header("Location:http://localhost/login.php?msg=$msg");
                }
                -->
            </form>

        </div>
    </div>
</div>

<div class="footer">
    </br> ¨Ï MegaMonkey Group - Pensacola Christian College 2015
</div>
</BODY>
</HTML>	