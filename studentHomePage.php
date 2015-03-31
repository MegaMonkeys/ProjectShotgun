<!DOCTYPE html>
<HTML>
<HEAD>

   <link rel="stylesheet" type="text/css" href="studentHomePage.css">
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
      if (!@mysqli_real_connect($conn,'localhost', 'team2', 'team2', 'cs414_team2')) {
         die("<br>Connect Error : " . mysqli_connect_error()); }}
      
      
   ?>
   <TITLE>
      MegaTest - Online Testing Application
   </TITLE>
</HEAD>

<BODY>

<div id="load_screen"><img src="images/megamonkeysloading.png" />loading document</div>
<div class="header">
   <img src="images/header.png" class="header"/>
   <div class="title"><img src="images/logo.png" class="logo"/></div>
   <form action="logout.php" method="post">
      <input type="submit" value="Sign out" class="logout-button">
   </form>
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

   <?php
      $courses = mysqli_query($conn, "select course_no, section_id from section where instructor_id = 123456");
      $numCourses = mysqli_num_rows($courses);
      for($i = 1; $i <= $numCourses; $i++)
      {
         $courseRow = mysqli_fetch_assoc($courses);
            
         $tests = mysqli_query($conn, "select test_name, published, test_avg from test where section_id = ".$courseRow['section_id']);
         $numTests = mysqli_num_rows($tests);
         echo '<p style="position:relative; left:5in;"><b>'.$courseRow['course_no'].'</b></p>';
         echo '<table style="border:solid; position:relative; left:5in;">';
         echo '<tr><th>Test</th><th>Average</th></tr>';
         
         // Loop creating table rows.
         for($i = 1; $i <= $numTests; $i++)
         {
            $testRow = mysqli_fetch_assoc($tests);
            echo '<tr>';
            echo '<td>'.$testRow['test_name'].'</td>';
            echo '<td>'.$testRow['test_avg'].'Sample</td>';
            echo '</tr>';
         }
         echo '</table>';
      }
    ?>



</div>
<div class="footer"></br>
   <img src="images/footerblue.png" class="footerblue"/>
   <ft>&copy; MegaMonkeys, Inc. - Pensacola Christian College 2015</ft>
</div>

</BODY>
<?php
    mysqli_close($conn);
?>
</HTML>