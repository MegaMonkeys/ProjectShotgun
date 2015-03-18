<!DOCTYPE html>
<HTML>
<HEAD>

   <link rel="stylesheet" type="text/css" href="studentHomePage2.css">
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

   <div class="courses">
      <?php
      $numCourses = 5; // change the number 5 to the database total courses
      echo 'Select a course below:';
      echo '<table id="courseTable">';

      for($i = 1; $i <= $numCourses; $i++)
      {
         echo '<tr>';
         echo '<td id="courseTD">'."CS 404".'</td>';
         echo '</tr>';
      }

      echo '</table>';
      ?>
   </div>
   <?php
   // Do we want to implement order by date?? we can remove the select statement
   echo "<span id='classTitle'>Courses: CS 404</span>".
       "<span id='orderBy'>Order by:
       <select name='order' class='inputs'>
       <option value='orderByClass'>class</option>
       <option value='orderByDate'>date</option>
       </select></span>"."<br />"; // Change this to the selected class type
   ?>
   <div class="testEachCourse">
      <form action="testTakingPage.php">
      <?php
      $numTests = 7; // change the number 5 to the database total tests
      echo '<table id="testTable">';
      echo "<tr id='testTH'>";
      echo "<td width='130px'>Test Name</td>";
      echo "<td width='400px'>Date Available</td>";
      echo "<td width='160px'>Status</td>";
      echo "<td width='100px'></td>";
      echo '</tr>';
      for($i = 1; $i <= $numTests; $i++)
      {
         echo '<tr>';
         echo '<td>Test #'.$i.'</td>';
         echo '<td>3/13/2015 at 4:50am to 4/12/2015 at 8:00am</td>';
         echo '<td>Available to take</td>'; // this status can be available, not available, or has been taken

         // if the status is available it will show a START button,
         // but if student took the test already, it will show their grade instead
         // if the grade is not available yet, it will show nothing
         echo "<td><button type='submit' id='takeTestButton' name='takeTestButton'>START</button></td>";
         echo '</tr>';
      }
      echo '</table>';
      ?>
      </form>
   </div>

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