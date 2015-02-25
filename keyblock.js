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
