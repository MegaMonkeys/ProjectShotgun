<!DOCTYPE html>
<HTML>
   <link rel="stylesheet" type="text/css" href="templateStyle.css">
   <script src="tabcontent.js" type="text/javascript"></script>
   <link href="template2/templateStyle.css" rel="stylesheet" type="text/css" />
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
	<div class="title">Teacher Home</div>

	<input type="submit" value="Sign out" class="logout-button">
</div>

<script src="jquery-1.11.2.js"></script>
<script>
    $(document).ready(function() {
        function close_accordion_section() {
            $('.accordion .accordion-section-title').removeClass('active');
            $('.accordion .accordion-section-content').slideUp(300).removeClass('open');
        }

        $('.accordion-section-title').click(function(e) {
            // Grab current anchor value
            var currentAttrValue = $(this).attr('href');

            if($(e.target).is('.active')) {
                close_accordion_section();
            }else {
                close_accordion_section();

                // Add active class to section title
                $(this).addClass('active');
                // Open up the hidden content panel
                $('.accordion ' + currentAttrValue).slideDown(300).addClass('open');
            }

            e.preventDefault();
        });
    });
</script>

<div class="content"></div>

    <div style="width: 500px; margin: auto;">
        <ul class="tabs" data-persist="true">
            <li><a href="#view1">Courses</a></li>
            <li><a href="#view2">Grades</a></li>
        </ul>
        <div class="tabcontents">
            <div id="view1">
				<div class="accordion">
                    <div class="accordion-section">
                        <a class="accordion-section-title" href="#accordion-1">CS 414</a>
                        <div id="accordion-1" class="accordion-section-content">
                            <p>Test 1</p>
                            <p>Test 2</p>
                            <p>Test 3</p>
                        </div><!--end .accordion-section-content-->
                    </div><!--end .accordion-section-->
                    <div class="accordion-section">
                        <a class="accordion-section-title" href="#accordion-2">CS 346</a>
                        <div id="accordion-2" class="accordion-section-content">
                            <p>Test 1</p>
                            <p>Test 2</p>
                        </div><!--end .accordion-section-content-->
                    </div><!--end .accordion-section-->
                    <div class="accordion-section">
                        <a class="accordion-section-title" href="#accordion-3">CS 368</a>
                        <div id="accordion-3" class="accordion-section-content">
                            <p>Test 1</p>
                            <p>Test 2</p>
                        </div><!--end .accordion-section-content-->
                    </div><!--end .accordion-section-->
                    <div class="accordion-section">
                        <a class="accordion-section-title" href="#accordion-4">CS 306</a>
                        <div id="accordion-4" class="accordion-section-content">
                            <p>Test 1</p>
                            <p>Test 2</p>
                            <p>Test 3</p>
                            <p>Test 4</p>
                        </div><!--end .accordion-section-content-->
                    </div><!--end .accordion-section-->
                </div><!--end .accordion-->
            </div>
            <div id="view2">
                <p>Grades</p>
            </div>
        </div>
    </div>

<div class="footer"></br>
<img src="images/footerblue.png" class="footerblue"/>
&copy; MegaMonkey Group - Pensacola Christian College 2015

</div>
</BODY>
</HTML>