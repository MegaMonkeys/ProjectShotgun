<!DOCTYPE html>
<HTML>
   <?php
      session_start();
      $u_id = $u_pw = $u_type = $result = $session_id = "";

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
         $u_id  = html_input($_POST["user"]);
         $u_pw  = html_input($_POST["password"]);
         $result = check_account($u_id, $u_pw);

         if( !$result )
            $_SESSION["session"] = "live";
      }

      //Redirect user based on their user type (teacher/instructor or student
      if( isset($_SESSION["session"] )){
         if($_SESSION["user_type"] == "Teacher"){
            header('Location: ./teacherHomePage.php');
         }
         else if($_SESSION["user_type"] == "Student") {
            header('Location: ./studentHomePage2.php');
         }
         else {
            $result = '<p>I am so sorry, but an error occurred! :( </p>';
         }
      }
   ?>
   <link rel="stylesheet" href="font-awesome-4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="loginStyle.css">
   <HEAD>
      <style>
         div#load_screen{
            opacity:0.7;
            position:fixed;
            z-index:10;
            top: 30%;
            width:100%;
            height:100%;
         }
		 #imageLoad{
		 display: block;
    margin-left: auto;
    margin-right: auto ;
		 }
      </style>
      <script>
         window.addEventListener("load", function(){
            var load_screen = document.getElementById("load_screen");
            document.body.removeChild(load_screen);
         });
      </script>
      
      <TITLE>
          INGENIOUS
      </TITLE>
       <link rel="icon" type="logo/png" href="images/monkeyhead2.png">
	   <div id="load_screen"><img src="images/monkeyload.gif" id="imageLoad"/></div>
   </HEAD>
<BODY  style="font-family:Calibri;">

    <div class="container">
        <div class="header">
            <img src="images/logo.png" alt="Ingenious logo" style="width:250px;">
        </div>
        <div class="sticky-navigation">
        </div>
        <div class="contents">
		
   <!-- START SLIDER -->

   <div id='slides'>
    <!-- use jssor.slider.min.js for release -->
    <!-- jssor.slider.min.js = (jssor.js + jssor.slider.js) -->
    <script type="text/javascript" src="Jssor.Slider.FullPack/js/jssor.js"></script>
    <script type="text/javascript" src="Jssor.Slider.FullPack/js/jssor.slider.js"></script>
    <script>
        jssor_slider1_starter = function (containerId) {
            var _CaptionTransitions = [];
            _CaptionTransitions["L"] = { $Duration: 900, x: 0.6, $Easing: { $Left: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
            _CaptionTransitions["R"] = { $Duration: 900, x: -0.6, $Easing: { $Left: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
            _CaptionTransitions["T"] = { $Duration: 900, y: 0.6, $Easing: { $Top: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
            _CaptionTransitions["B"] = { $Duration: 900, y: -0.6, $Easing: { $Top: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
            _CaptionTransitions["ZMF|10"] = { $Duration: 900, $Zoom: 11, $Easing: { $Zoom: $JssorEasing$.$EaseOutQuad, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 };
            _CaptionTransitions["RTT|10"] = { $Duration: 900, $Zoom: 11, $Rotate: 1, $Easing: { $Zoom: $JssorEasing$.$EaseOutQuad, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInExpo }, $Opacity: 2, $Round: { $Rotate: 0.8} };
            _CaptionTransitions["RTT|2"] = { $Duration: 900, $Zoom: 3, $Rotate: 1, $Easing: { $Zoom: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $Opacity: 2, $Round: { $Rotate: 0.5} };
            _CaptionTransitions["RTTL|BR"] = { $Duration: 900, x: -0.6, y: -0.6, $Zoom: 11, $Rotate: 1, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInCubic }, $Opacity: 2, $Round: { $Rotate: 0.8} };
            _CaptionTransitions["CLIP|LR"] = { $Duration: 900, $Clip: 15, $Easing: { $Clip: $JssorEasing$.$EaseInOutCubic }, $Opacity: 2 };
            _CaptionTransitions["MCLIP|L"] = { $Duration: 900, $Clip: 1, $Move: true, $Easing: { $Clip: $JssorEasing$.$EaseInOutCubic} };
            _CaptionTransitions["MCLIP|R"] = { $Duration: 900, $Clip: 2, $Move: true, $Easing: { $Clip: $JssorEasing$.$EaseInOutCubic} };

            var options = {
                $FillMode: 2,                                       //[Optional] The way to fill image in slide, 0 stretch, 1 contain (keep aspect ratio and put all inside slide), 2 cover (keep aspect ratio and cover whole slide), 4 actual size, 5 contain for large image, actual size for small image, default value is 0
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                                   //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: false,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideEasing: $JssorEasing$.$EaseOutQuint,          //[Optional] Specifies easing for right to left animation, default value is $JssorEasing$.$EaseOutQuad
                $SlideDuration: 800,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $CaptionSliderOptions: {                            //[Optional] Options which specifies how to animate caption
                    $Class: $JssorCaptionSlider$,                   //[Required] Class to create instance to animate caption
                    $CaptionTransitions: _CaptionTransitions,       //[Required] An array of caption transitions to play caption, see caption transition section at jssor slideshow transition builder
                    $PlayInMode: 1,                                 //[Optional] 0 None (no play), 1 Chain (goes after main slide), 3 Chain Flatten (goes after main slide and flatten all caption animations), default value is 1
                    $PlayOutMode: 3                                 //[Optional] 0 None (no play), 1 Chain (goes before main slide), 3 Chain Flatten (goes before main slide and flatten all caption animations), default value is 1
                },

                $BulletNavigatorOptions: {                          //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                 //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 8,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 8,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },

                $ArrowNavigatorOptions: {                       //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 1,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };

            var jssor_slider1 = new $JssorSlider$(containerId, options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var bodyWidth = document.body.clientWidth;
                if (bodyWidth)
                    jssor_slider1.$ScaleWidth(Math.min(bodyWidth, 1920));
                else
                    $Jssor$.$Delay(ScaleSlider, 30);
            }

            ScaleSlider();
            $Jssor$.$AddEvent(window, "load", ScaleSlider);

            $Jssor$.$AddEvent(window, "resize", $Jssor$.$WindowResizeFilter(window, ScaleSlider));
            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            //responsive code end
        };
    </script>
    <!-- Jssor Slider Begin -->
    <!-- You can move inline styles to css file or css block. -->
    <div id="slider1_container" style="position: relative; margin: 0 auto;
        top: 0px; left: 0px; width: 1200px; height: 600px; overflow: hidden;">
        <!-- Loading Screen -->
      <!--<div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;
                top: 0px; left: 0px; width: 100%; height: 100%;">
            </div>
            <div style="position: absolute; display: block; background: url(images/monkeyload.gif) no-repeat center center;
                top: 0px; left: 0px; width: 100%; height: 100%;">
            </div>
        </div>-->
        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1300px; height: 500px;
             overflow: hidden;">
            <div>
                <img u="image" src="images/academic/slide1.png" />
                <!-- Image from: www.huffingtonpost.com/2013/09/20/paying-for-college-prep_n_3963035.html -->
            </div>
            <div>
                <img u="image" src="images/academic/slide2.png" />
                <!-- Image from: http://www.supportingeducation.org/2013/06/17/high-speed-internet-for-schools/ -->
            </div>
            <div>
                <img u="image" src="images/academic/slide3.png" />
				<!-- Image from: eluniversitario.net -->
            </div>
            <div>
                <img u="image" src="images/academic/slide4.png" />
                <!-- Image from: https://www.thebureauinvestigates.com/2010/09/20/top-10-teacher-salaries/ -->
            </div>
        </div>

        <!-- Bullet Navigator Skin Begin -->
        <style>
            /* jssor slider bullet navigator skin 21 css */
            /*
            .jssorb05 div           (normal)
            .jssorb05 div:hover     (normal mouseover)
            .jssorb05 .av           (active)
            .jssorb05 .av:hover     (active mouseover)
            .jssorb05 .dn           (mousedown)
            */
            .jssorb05 div, .jssorb05 div:hover, .jssorb05 .av
            {
                background: url(Jssor.Slider.FullPack/img/b05.png) no-repeat;
                overflow:hidden;
                cursor: pointer;
            }
            .jssorb05 div { background-position: -5px -5px; }
            .jssorb05 div:hover, .jssorb05 .av:hover { background-position: -35px -5px; }
            .jssorb05 .av { background-position: -65px -5px; }
            .jssorb05 .dn, .jssorb05 .dn:hover { background-position: -95px -5px; }
        </style>
        <!-- bullet navigator container -->
        <div u="navigator" class="jssorb05" style="position: absolute; bottom: 26px; left: 6px;">
            <!-- bullet navigator item prototype -->
            <div u="prototype" style="POSITION: absolute; WIDTH: 19px; HEIGHT: 19px; text-align:center; line-height:19px; color:White; font-size:12px;"></div>
        </div>
        <!-- Bullet Navigator Skin End -->

        <!-- Arrow Navigator Skin Begin -->
        <style>
            /* jssor slider arrow navigator skin 21 css */
            /*
            .jssora15l              (normal)
            .jssora15r              (normal)
            .jssora15l:hover        (normal mouseover)
            .jssora15r:hover        (normal mouseover)
            .jssora15ldn            (mousedown)
            .jssora15rdn            (mousedown)
            */
            .jssora15l, .jssora15r, .jssora15ldn, .jssora15rdn
            {
                position: absolute;
                cursor: pointer;
                display: block;
                background: url(Jssor.Slider.FullPack/img/a15.png) center center no-repeat;
                overflow: hidden;
            }
            .jssora15l { background-position: -3px -33px; }
            .jssora15r { background-position: -63px -33px; }
            .jssora15l:hover { background-position: -123px -33px; }
            .jssora15r:hover { background-position: -183px -33px; }
            .jssora15ldn { background-position: -243px -33px; }
            .jssora15rdn { background-position: -303px -33px; }
        </style>
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssora15l" style="width: 55px; height: 55px; top: 123px; left: 8px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora15r" style="width: 55px; height: 55px; top: 123px; right: 8px">
        </span>
        <!-- Arrow Navigator Skin End -->
        <a style="display: none" href="http://www.jssor.com">jQuery Carousel</a>
    </div>
    <!-- Trigger -->
    <script>
        jssor_slider1_starter('slider1_container');
    </script>
    <!-- Jssor Slider End -->
</div>

   <!-- END SLIDER -->


   <div class="content">
      <div class="login">
         Log In
         <form action="#" method="post">
            <input type="text"     placeholder="username" name="user" required><br>
            <input type="password" placeholder="password" name="password" required><br>
            <input type="submit"   class="myButton"       value="Login">
            <span>  <?php echo $result; ?>  </span>
         </form>
      </div>
   </div>
   
   
 </div>
        <div class="footer">
            &copy; MegaMonkeys, Inc.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/monkeyhead2.png" class="monkeyheadfooter"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pensacola Christian College 2015
        </div>
</div>
</BODY>
</HTML>



<!-- PHP FUNCTIONS FOR LOGIN PAGE -->
<?php
   function html_input($data) {
      //$data = trim($data);
      //$data = intval($data); //In DB, ID & PW is stored as Integer
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
   }

   function check_account($u_id, $u_pw) {
      include_once 'db_connection.php';

      //Check ID and PW
      $sql_command = "SELECT USER_TYPE, LENGTH(USER_ID), LENGTH(PASSWORD) FROM account WHERE USER_ID = " . $u_id . " and PASSWORD = " . $u_pw . ";";
      $sql_result  = mysqli_query($connection, $sql_command);
      $count       = @mysqli_num_rows($sql_result);
      $row         = @mysqli_fetch_row($sql_result);

      if($count == 0) {
         mysqli_close($connection);
         return "<div class='invalid'><i class='fa fa-exclamation-triangle'></i> INVALID LOGIN</div>";
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
            return "<div class='invalid'><i class='fa fa-exclamation-triangle'></i> INVALID LOGIN</div>";
         }

         $sql_result  = mysqli_query($connection, $sql_command);
         $row         = mysqli_fetch_row($sql_result);
         $_SESSION["user_name"] = $row; //Store the user name (FirstName LastName)
         mysqli_close($connection);
         return 0;
      }
      else {
         mysqli_close($connection);
         return "Error :- Duplicate Account Exist";
      }
   }
?>