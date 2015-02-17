<?php include 'sessionCheck.php'; ?>
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

<div class="header">
<img src="images/header.png" class="header"/>
<div class="title">Online Test</div>
</div>
<table>
<tr>
<td style="vertical-align: top">
<div class="content">
<form action="./logout.php" method="post">
You are login as <span> </span>
<input type="submit" value="Sign out" class="logout-button"></br>
<div class="informationForm">
<table>
<tr>
<td>
Class: &nbsp;
<select class="inputs">
  <option value="CS214">CS 214</option>
  <option value="CS306">CS 306</option>
  <option value="CS414">CS 414</option>
  <option value="BA303">BA 303</option>
</select> </br>
Start: &nbsp;<input type="date" name="startDate" class="inputs"> &nbsp;&nbsp;&nbsp; <input type="time" class="inputs" name="startTime"></br>
End  : &nbsp;<input type="date" id="endDate" class="inputs">  &nbsp;&nbsp;&nbsp; <input type="time" class="inputs" name="endTime"></br>
</td>
<td>
Test Name:  &nbsp;<input type="text" name="testName" class="inputs" placeholder="Test #1"> </br></br>
Time limit : &nbsp;<input type="number" name="hours" min="0" max="10" class="inputs" placeholder="1"> &nbsp; hr &nbsp;
<input type="number" name="minute" min="0" max="60" class="inputs" placeholder="45"> &nbsp; min
</td>
</tr>
<tr>
<td colspan="2">
<input type="submit" value="publish" class="publish-Button">
<input type="submit" value="save" class="save-Button">
<input type="submit" value="cancel" class="cancel-Button">
</td>
</tr>
</table>
</div>
<div class ="questionTable">
<table>
<tr>
	<td>Question Type</td>
</tr>
<tr>
	<td height="50"><button>Multiple Choice</button></td>
</tr>
<tr>
	<td height="50"><button>True / False</button></td>
</tr>
<tr>
	<td height="50"><button>Short Answer</button></td>
</tr>
<tr>
	<td height="50"><button>Essay</button></td>
</tr>

</table></div>
<table>
<tr>
<td width="500">
PLEDGE:</br>
<input type="text" name="pledge" class="inputs"
 value="This is a pledge. This is a pledge. This is a pledge. This is a pledge. This is a pledge. This is a pledge. "
 style="width:100%; height:100px">
</br>
</td>
<td>&nbsp;&nbsp;
<input type="submit" value="preview" class="preview-Button">
</td>
</tr>
</table>
</form>
</div>
</td>
<td style="vertical-align: top">


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



<form method="post">
    Ctrl + C / Ctrl + V / Ctrl + F / Mouse Right Click Disabled
    
    <form id="buttonArea">
        <fieldset style="width:600px;">
            <legend>New Question</legend>
            <input onclick="add_Instruc(this.form);" type="button" value="Instruction" />
            <input onclick="add_Q_Multi(this.form);" type="button" value="Multiple Choice" />
            <input onclick="add_Q_TF(this.form);"    type="button" value="True/False" />
            <input onclick="add_Q_Short(this.form);" type="button" value="Short Answer" />
        </fieldset>
    </form>

    <p>
        <div id="text_instruc_heading">CS 414 Test Instruction</div>
        <textarea name="test_instruc_text" rows="4" cols="100">Enter Test Instructions . . .</textarea>
    </p>

    <hr align="left" width="650px">

    <p id="mainArea">


    </p>




    <div id="questionArea">
        <br/><br/>
        <div id="itemRows">
            Item quantity: <input type="text" name="add_qty" size="4" />
            Item name:     <input type="text" name="add_name" />
            <input onclick="addRow(this.form);" type="button" value="Add row" />
        </div>

    <div/>

</form>


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
</td>
</tr>
</table>
<div class="footer"></br>
&copy; MegaMonkey Group - Pensacola Christian College 2015
<img src="images/footerblue.png" class="footerblue"/>
</div>
</BODY>
</HTML>