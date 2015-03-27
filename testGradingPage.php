<!DOCTYPE html>
<HTML>
<link rel="stylesheet" type="text/css" href="testGradingPage.css">
<script src="tabcontent.js" type="text/javascript"></script>
<script src="./ProjectShotgun/jquery-1.11.2.js"></script>
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
		$( window ).resize(function() {
			page_resize();
		});
		$(function() {
			page_resize();
		});
		function page_resize() {
			//alert( $(window).height() + " " + $(document).height());
			$("#studentInformation").css("height", $(window).height() - 300);
		}
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
<div id="wrapper">
	<div class="content">
		<div id="studentList">Student List:</div>
	   <div id="studentInformation">
	   <table id="studentTable">
	   <tr><td id="studentTD">Jordan Brown</td></tr>
	   <tr><td id="studentTD">Glenn Stegal</td></tr>
	   <tr><td id="studentTD">Youngchan Youn</td></tr>
	   <tr><td id="studentTD">Jon Massie</td></tr>
	   <tr><td id="studentTD">Ethan McGuire</td></tr>
	   <tr><td id="studentTD">Bernike T</td></tr>
	   	   <tr><td id="studentTD">Jordan Brown</td></tr>
	   <tr><td id="studentTD">Glenn Stegal</td></tr>
	   <tr><td id="studentTD">Youngchan Youn</td></tr>
	   <tr><td id="studentTD">Jon Massie</td></tr>
	   <tr><td id="studentTD">Ethan McGuire</td></tr>
	   <tr><td id="studentTD">Bernike T</td></tr>
	   	   <tr><td id="studentTD">Jordan Brown</td></tr>
	   <tr><td id="studentTD">Glenn Stegal</td></tr>
	   <tr><td id="studentTD">Youngchan Youn</td></tr>
	   <tr><td id="studentTD">Jon Massie</td></tr>
	   <tr><td id="studentTD">Ethan McGuire</td></tr>
	   <tr><td id="studentTD">Bernike T</td></tr>
	   </table>
	   </div>

	   <span id='classTitle'></span><br />

	   <div class="testQuestions"><!--style="border:1px solid #66CCFF"-->
	   <table class="table_border_style">
		<tr><td id="trueFalse">
			<table>
			<tr>
				<td width="50px">
					1.
				</td>
				<td colspan="2" width="750px">
					<span id="theQuestion">Dr. Geary teaches .NET programming class</span> (5)
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="radio" name="trueFalseAns" value="true">True
				</td>
				<td>
					<input type="radio" name="trueFalseAns" value="false">False
				</td>
			</tr>
			</table>
		</td>
		<td id="pointBox">
		<input type="text" value="" id="points">/10
		</td>
		</tr>
			
		<tr><td id="multipleChoice">
			<table>
			<tr>
				<td width="50px">
					2.
				</td>
				<td colspan="2" width="750px">
					<span id="theQuestion">What is the first letter of an alphabet</span>(5)
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="radio" name="multipleChoiceAns" value="a">a
				</td>
				<td>
					<input type="radio" name="multipleChoiceAns" value="c">c
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="radio" name="multipleChoiceAns" value="b">b
				</td>
				<td>
					<input type="radio" name="multipleChoiceAns" value="d">d
				</td>
			</tr>
			</table>
			</td>
		<td id="pointBox">
		<input type="text" value="" id="points">/10
		</td>
		</tr>
		  
		<tr><td id="manyChoice">
			<table>
			<tr>
				<td width="50px">
					3.
				</td>
				<td colspan="2" width="750px">
					<span id="theQuestion">Choose all that apply</span>(5)
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="checkbox" name="manyChoiceAns" value="house"> I have a house
				</td>
				<td>
					<input type="checkbox" name="manyChoiceAns" value="phone"> I have a phone
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="checkbox" name="manyChoiceAns" value="Bike"> I have a bike
				</td>
				<td>
					<input type="checkbox" name="manyChoiceAns" value="Car"> I have a car
				</td>
			</tr>
			</table>
		</td>
		<td id="pointBox">
		<input type="text" value="" id="points">/10
		</td>
		</tr>
			
		<tr><td id="shortAnswer">
			<table>
			<tr>
				<td width="50px">
					4.
				</td>
				<td width="750px">
					<span id="theQuestion">Who invented facebook?</span>(5)
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="text" name="shortAns" value="">
				</td>
			</tr>
			</table>
			</td>
			<td id="pointBox">
				<input type="text" value="" id="points">/10
			</td>
		</tr>	
		
		<tr><td id="essay">
			<table>
			<tr>
				<td width="50px">
					5.
				</td>
				<td width="750px">
					<span id="theQuestion">What is DBMS(explain)?</span>(5)
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="text" name="essayAns" value="" class="essayText">
				</td>
			</tr>
			</table>
		</td>
		<td id="pointBox">
		<input type="text" value="" id="points">/10
		</td>
		</tr>
		
			 <!-- Table Elements Generated By AJAX Script -->
	   </table>
	   </div>
	</div>


	<div class="footer"></br>
	   <img src="images/footerblue.png" class="footerblue"/>
	   <div>&copy; MegaMonkeys, Inc. - Pensacola Christian College 2015</div>
	</div>
</div>

</BODY>
</HTML>