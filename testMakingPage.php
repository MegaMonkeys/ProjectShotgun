<!DOCTYPE html>
<HTML>
   <link rel="stylesheet" type="text/css" href="testMakingPage.css">
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
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
   <script>
   window.addEventListener("load", function(){
   
	var load_screen = document.getElementById("load_screen");
	document.body.removeChild(load_screen);
   });
   
   $(document).ready(function(){
    $("button").click(function(){
        $("p:first").replaceWith("Hello world!");
    });
});
   
   
   </script>
      <TITLE>
	  MegaTest - Online Testing Application
      </TITLE>
   </HEAD>
<BODY oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
<div id="load_screen"><img src="images/megamonkeysloading.png" />loading document</div>
<form action="#.php" method="post">
<div class="header">
	<img src="images/header.png" class="header"/>
	<img src="images/wikitest.png" class="testLogo"/>
	<div class="title"></div>

	<input type="submit" value="Sign out" class="logout-button">
</div>

<div class="content">
<table>
<tr>
<td style="vertical-align: top">
<br />
	You are login as <span> </span> <br />
	<div class="informationForm">
	Class : &nbsp;
	<select class="inputs">
	  <option value="CS214">CS 214</option>
	  <option value="CS306">CS 306</option>
	  <option value="CS414">CS 414</option>
	  <option value="BA303">BA 303</option>
	</select>
	Section : &nbsp;&nbsp;<select class="inputs">
	  <option value="1">1</option>
	  <option value="2">2</option>
	  <option value="3">3</option>
	</select><br />
	Start : &nbsp;&nbsp;<input type="date" name="startDate" class="inputs"> <input type="time" class="inputs" name="startTime"><br />
	End  : &nbsp;&nbsp;<input type="date" id="endDate" class="inputs"> <input type="time" class="inputs" name="endTime"><br />
	Time limit : &nbsp;<input type="number" name="hours" min="0" max="10" class="inputs" placeholder="1"> &nbsp; hr &nbsp;
	<input type="number" name="minute" min="0" max="60" class="inputs" placeholder="45"> &nbsp; min
	
	
	</div>
	<form id="buttonArea" >
		<div class="questionType-button">
            <legend>Question's type:</legend>
            <input onclick="add_Instruc(this.form);" type="button" value="Instruction" id="instruction"/>
            <input onclick="add_Q_Multi(this.form);" type="button" value="Multiple Choice" /><br />
            <input onclick="add_Q_TF(this.form);"    type="button" value="True/False" />
            <input onclick="add_Q_Short(this.form);" type="button" value="Short Answer" /><br />
			<input onclick="#" type="button" value="Essay" />
			<input onclick="#" type="button" value="Matching" />
		</div>
    </form>
	</td>
<td width="80">
</td>
<td style="vertical-align: top">
<div class="scroll">

        <script>
            var isNS = (navigator.appName == "Netscape") ? 1 : 0;

            if(navigator.appName == "Netscape") document.captureEvents(Event.MOUSEDOWN||Event.MOUSEUP);

            function mischandler() {
                return false;
            }

            function mousehandler(e) {
                var myevent = (isNS) ? e : event;
                var eventbutton = (isNS) ? myevent.which : myevent.button;
                if((eventbutton==2)||(eventbutton==3)) return false;
            }

            /*function keyhandler(e) {
                if ( event.keyCode==17 || event.keyCode==18 || event.keyCode==91) //17 is ascii code for ctrl
                {
                    event.keyCode = 0;
                    event.cancelBubble = true;
                    return false;
                }
            }*/

            function onKeyDown() {
                var pressedKey = String.fromCharCode(event.keyCode).toLowerCase();

                if ( (event.ctrlKey || event.shiftKey || event.altKey || event.metaKey) && (pressedKey == "c" || pressedKey == "v" || pressedKey == "f")) {
                    event.returnValue = false;
                }
            }

            document.oncontextmenu = mischandler;
            document.onmousedown   = mousehandler;
            document.onmouseup     = mousehandler;
            document.onkeydown     = onKeyDown;
            //document.onkeypress    = onKeyDown;
        </script>

  <!-- Ctrl + C / Ctrl + V / Ctrl + F / Mouse Right Click Disabled-->
    
    Test Name:  &nbsp;<input type="text" name="testName" class="inputs" placeholder="Test #1">

    <p>
        <div id="text_instruc_heading">CS 414 Test Instruction</div>
        <textarea name="test_instruc_text" rows="4" cols="100">Enter Test Instructions . . .</textarea>
    </p>

    <hr align="left" width="650px">

    <p id="mainArea">


    </p>



<script>
    var rowNum = 0;
    var queNum = 0;
    var option = 0;

    function add_Instruc() {
        var text_field =
            '<div><hr align="left" width="650px" /><textarea name="ques_instruc" rows="4" cols="100">Type Test Instructions . . .</textarea>' +
            '<input onclick="removeEle(this);" type="button" value="Remove" /></div>';
        jQuery('#mainArea').append(text_field);
    }

        function removeEle(element) {
            jQuery(element).parent('div').remove();
        }



    function add_Q_Multi(data) {
        ++queNum;
        var newQ =
            '<div id="question'+queNum+'" style="padding: 10px 5px 0px 5px;"><fieldset style="width:400px;">' +
            '<legend>Multiple Choice Question - <input type="button" value="Option" onclick="add_Q_Multi_Opt('+queNum+');">' +
            '<input type="button" value="Remove" onclick="remove_Q('+queNum+');">' +
            ' Point - <input type="text" name="f_point" maxlength="3" size="3"></legend>' +
            '<textarea name="ques_head" rows="2" cols="80"></textarea></fieldset></div>';

        jQuery('#mainArea').append(newQ);

    }

        function remove_Q(num) {
            //jQuery(element).parent('p').remove();
            jQuery('#question'+num).remove();

        }

        function add_Q_Multi_Opt(num) {
            ++option;
            var newO = '<div id="multiOption'+option+'">' +
                'Option : <input type="text" name="text_Q">' +
                '<input type="button" value="Remove" onclick="removeOpt('+option+');"></div>';
            jQuery('#question'+num).children('fieldset').append(newO);

        }

        function removeOpt(opte) {
            jQuery('#multiOption'+opte).remove();

        }


    function add_Q_TF(data) {
        ++queNum;
        var newQ =
            '<div id="question'+queNum+'" style="padding: 10px 5px 0px 5px;"><fieldset style="width:400px;">' +
            '<legend>True / False Question - ' +
            '<input type="button" value="Remove" onclick="remove_Q('+queNum+');">' +
            ' Point - <input type="text" name="f_point" maxlength="3" size="3"></legend>' +
            '<textarea name="ques_head" rows="2" cols="80"></textarea></fieldset></div>';

        jQuery('#mainArea').append(newQ);

    }

    function add_Q_Short(data) {
        ++queNum;
        var newQ =
            '<div id="question'+queNum+'" style="padding: 10px 5px 0px 5px;"><fieldset style="width:400px;">' +
            '<legend>Short Answer Question - ' +
            '<input type="button" value="Remove" onclick="remove_Q('+queNum+');">' +
            ' Point - <input type="text" name="f_point" maxlength="3" size="3"></legend>' +
            '<textarea name="ques_head" rows="2" cols="80"></textarea></fieldset></div>';

        jQuery('#mainArea').append(newQ);

    }
    function addRow(frm) {
        rowNum ++;
        var row = '<p id="rowNum'+rowNum+'">Item quantity: <input type="text" name="qty[]" size="4" value="'+frm.add_qty.value+'"> Item name: <input type="text" name="name[]" value="'+frm.add_name.value+'"> <input type="button" value="Remove" onclick="removeRow('+rowNum+');"></p>';
        jQuery('#itemRows').append(row);
        frm.add_qty.value = '';
        frm.add_name.value = '';
    }

    function removeRow(rnum) {
        jQuery('#rowNum'+rnum).remove();
    }

</script>
		PLEDGE:<br />
		<input type="text" name="pledge" class="inputs"
		 value="This is a pledge. This is a pledge. This is a pledge. This is a pledge. This is a pledge. This is a pledge. "
		 style="width:600px; height:100px">
		<br />
		

</div>

</td>
<td>
	<input type="submit" value="Publish" class="buttons"><br />
	<input type="submit" value="Save" class="buttons"><br />
	<input type="submit" value="Cancel" class="buttons"><br />
	<input type="submit" value="Preview" class="buttons">
</td>
</tr>
</table>
</div>
</form>

<div class="footer"><br />
<img src="images/footerblue.png" class="footerblue"/>
&copy; MegaMonkey Group - Pensacola Christian College 2015

</div>
</BODY>
</HTML>