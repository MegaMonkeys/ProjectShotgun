<!DOCTYPE html>
<HTML>
   <link rel="stylesheet" type="text/css" href="loginStyle.css">
   <HEAD>
   <style>
   div#load_screen{
	background:#FFF;
	opacity:0.7;
	position:fixed;
	z-index:10;
	top: 0px;
	width:100%;
	height:100%;
   }
   </style>
   <script>
   window.addEventListener("load", function(){
   
	var load_screen = document.getElementById("load_screen");
	document.body.removeChild(load_screen);
   });
      </script>
      <TITLE>
	  MegaTest - Online Testing Application
      </TITLE>
	  <script type="text/javascript">
   
   var image1 = new Image();
   image1.src="images/verses/verse1.png";
   var image2=new Image();
   image2.src="images/verses/verse2.png";
   var image3=new Image();
   image3.src="images/verses/verse3.png";
   var image4=new Image();
   image4.src="images/verses/verse4.png"
   var image5=new Image();
   image5.src="images/verses/verse5.png"
   </script>
   </HEAD>
<BODY>

<?php //Main PHP Functions
$u_id = $u_pw = $u_type = $result = $session_id = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u_id  = html_input($_POST["user"]);
    $u_pw  = html_input($_POST["password"]);
    $result = check_account($u_id, $u_pw);

    if($result != "INVALID LOGIN")
        $_SESSION["session"] = "session_on";
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
            $_SESSION["user_id"] = $u_id; //Store user id, but only if user id is valid

            if ($row[0] == "I") {//If Instructor
                $sql_command = "SELECT FIRST_NAME, LAST_NAME FROM INSTRUCTOR WHERE INSTRUCTOR_ID = " . $u_id . ";";
                $_SESSION["user_type"] = "Teacher"; //Store user type
            }
            elseif ($row[0] == "S") {//If Student
                $sql_command = "SELECT FIRST_NAME, LAST_NAME FROM STUDENT WHERE STUDENT_ID = " . $u_id . ";";
                $_SESSION["user_type"] = "Student"; //Store user type
            }
        }
        else { //If Length Check fails
            mysqli_close($connection);
            return "INVALID LOGIN";
        }

        $sql_result  = mysqli_query($connection, $sql_command);
        $_SESSION["user_name"] = $sql_result; //Store the user name (FirstName LastName)
        $row         = mysqli_fetch_row($sql_result);
        mysqli_close($connection);
        return $row[0] . " " . $row[1];
    }
    else {
        mysqli_close($connection);
        return "Error :- Duplicate Account Exist";
    }
}
//End of Main PHP Functions
?>
<?php //Body PHP
//Redirect user based on their user type (teacher/instructor or student
if(@$_SESSION["session"] != ""){
    if(@$_SESSION["user_type"] == "Teacher"){
        header('Location: ./teacherHomePage.php');
    }
    else if(@$_SESSION["user_type"] == "Student") {
        header('Location: ./studentHomePageEthan.php');
    }
    else {
        echo '<p>I am so sorry, but an error occurred! :( </p>';
    }
}

//End of Body PHP
?>

<div id="load_screen"><img src="images/megamonkeysloading.png" />loading document</div>
<img src="verses/verse5.png" name="slide"  height="600" class="slideshow">
	  <script type="text/javascript">
<!--
var step=1
function slideit(){
document.images.slide.src=eval("image"+step+".src");
if(step<5)
step++;
else
step=1;
setTimeout("slideit()",5500);
}
slideit();
-->
</script>
<div class="header">
<img src="images/header.png" class="header"/>
<div class="title"><img src="images/logo.png" class="logo"/></div>
</div>
<div id='cssmenu'>
<ul>
   <li class='loginPage.html'><a href='#'><span>Home</span></a></li>
   <li><a href='#'><span>About</span></a></li>
   <li><a href='#'><span>Team</span></a></li>
   <li class='last'><a href='#'><span>Contact</span></a></li>
</ul>
</div>

<div class="content">
<div class="login">
Log in below &#9660;
<form action="#" method="post">
	<input type="text" placeholder="username" name="user" required><br>
	<input type="password" placeholder="password" name="password" required><br>
	<input type="submit" class="myButton" value="Login">
<span>
 <?php if(isset($_GET['msg']))
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
<div class="footer"></br>
<img src="images/footerblue.png" class="footerblue"/>
&copy; MegaMonkey Group - Pensacola Christian College 2015

</div>
</BODY>
</HTML>