<?php
   //Global - Initiate Connection
      //Connection needs to be close !!!
      //Check MySQL initialisation check
      $connection = mysqli_init();
      if (!$connection)
         die("mysqli_init failed");

      //Set connection time out
      mysqli_options($connection, MYSQLI_OPT_CONNECT_TIMEOUT, "3");

      //Connect to the MySQL Server
      //Warning Disabled
      if (!@mysqli_real_connect($connection, 'CSWEB.studentnet.int', 'team2_cs414', 't2CS414', 'cs414_team2')) {
         if (!@mysqli_real_connect($connection, 'localhost', 'team2', 'team2', 'cs414_team2')) {
            die("<br>Connect Error : " . mysqli_connect_error());
         }
      }
      else
         //echo "Connected successfully<br>";
?>
