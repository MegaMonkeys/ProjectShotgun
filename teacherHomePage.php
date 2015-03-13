<!DOCTYPE html>
<HTML>
<link rel="stylesheet" type="text/css" href="teacherHomePage.css">
<script src="tabcontent.js" type="text/javascript"></script>
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

</HEAD>

<BODY style="background:#F6F9FC; font-family:Arial;">
<div id="load_screen"><img src="images/megamonkeysloading.png" />loading document</div>
<div class="header">
    <img src="images/header.png" class="header"/>
    <img src="images/logo.png" class="testLogo"/>
    <form action="logout.php"><input type="submit" value="Sign out" class="logout-button"></form>
</div>

<div id='cssmenu'>
    <ul>
        <li class='loginPage.html'><a href='#'><span>Home</span></a></li>
        <li><a href='#'><span>About</span></a></li>
        <li><a href='#'><span>Team</span></a></li>
        <li class='last'><a href='#'><span>Contact</span></a></li>
    </ul>
</div>

<script src="jquery-1.11.2.js"></script>

<div class="content">
    <form action="testMakingPage.php"><input type="submit" value="+ Create Test" class="create-button"></form>

    <div class="courses">
    <?php
    $numCourses = 5; // change the number 5 to the database total courses
        echo 'Courses :'.' <br />';
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
    echo "<span id='classTitle'>Courses: CS 404</span><br />";
    ?>
    <div class="testEachCourse">
        <?php
        $numTests = 5; // change the number 5 to the database total tests
        echo '<table id="testTable">';
        for($i = 1; $i <= $numTests; $i++)
        {
            echo '<tr><td id="testTD">';
            echo "<span id='testTitle'>Test #".$i.'</span>'.
                 "<span id='button'>".
                 "<button type='submit' value='Edit' id='editButton' name='editButton'></button>".
                "<button type='submit' value='deleteButton' id='deleteButton' name='deleteButton'></button>".
                "<button type='submit' value='gradeButton' id='gradeButton' name='gradeButton'></button>".'</span><br />';
            echo 'Date Available: '.'2/13/15 at 8:00am - 3/15/15 at 10:00pm'.'<br />';// change the date
            echo 'Status: '.'Publish'.'<br />'; // change the status
            echo 'Class Average: '.'85%'; // change class average
            echo '</td></tr>';
        }
        echo '</table>';
        ?>
    </div>
</div>


<div class="footer"></br>
   <img src="images/footerblue.png" class="footerblue"/>
   <ft>&copy; MegaMonkeys, Inc. - Pensacola Christian College 2015</ft>
</div>
</BODY>
</HTML>