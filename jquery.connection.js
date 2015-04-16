//Question Form Script - Caution !!

//Question Form
var form_array = ['True/False Question', 'Multiple Choice Question', 'Many Choices', 'Short Answer Question', 'Essay', 'Instruction'];
var form_text_array =
	[
		' Point - <input type="text" name="f_point" maxlength="3" size="3">' +
		'<br><textarea required name="ques_head" rows="3" placeholder="True/False Question"></textarea>',

		' Point - <input type="text" name="f_point" maxlength="3" size="3">' +
		'<input type="button" value="Option" onclick="add_option(this);">' +
		'<br><textarea required name="ques_head" rows="3" placeholder="Multiple Choice Question"></textarea>',

		' Point - <input type="text" name="f_point" maxlength="3" size="3">' +
		'<input type="button" value="Option" onclick="add_option(this);">' +
		'<br><textarea required name="ques_head" rows="3" placeholder="Many Choices Question"></textarea>',

		' Point - <input type="text" name="f_point" maxlength="3" size="3">' +
		'<br><textarea required name="ques_head" rows="2" placeholder="Short Answer Question"></textarea>',

		' Point - <input type="text" name="f_point" maxlength="3" size="3">' +
		'<br><textarea required name="ques_head" rows="2" placeholder="Essay Question"></textarea>',

		'<hr align="left" width="100%" />' +
		'<textarea required name="ques_instruc" rows="4" placeholder="Type Instruction"></textarea>',

		'<textarea required name="ques_random" rows="4" placeholder="Nothing Nothing"></textarea>'
	];


	function add_option(current) { //Add Choice Option
		var opt_num = ($(current).parent('li')).children('div').length + 1;
		if(opt_num > 4) {

		}
		else {
			var newQ =
				'<div class="choices">' +
				'Option <span>' + opt_num + '</span>: <input type="text" name="text_Q">' +
				'<input type="button" value="Remove" onclick="removeOpt(this);"></div>';
			$(current).parent('li').append(newQ);
		}
	}

	function removeOpt(current) { //Remove Choice Option
		//alert( $(current).parent('div').children('span').text() );
		var form_element = $(current).parent('div').parent('li');
		$(current).parent('div').remove();
		for(x=0; x<form_element.children('div').length; x++) {
			$(form_element).children('div').eq(x).children('span').text(x+1);
		}
	}

$(function() {
	//jQuery Connection - Do not touch !!
	$( "#sortable1" ).sortable({
		connectWith: ".connectedSortableF"
	}).disableSelection();
	$( "#sortable2, #sortable4" ).sortable({
		connectWith: ".connectedSortableF, .connectedSortableT"
	}).disableSelection();

	//Default Question Type Load
	for(i=0; i<form_array.length; i++) {
		var form_element =
			'<li class="ui-state-default tess">' +
			'<span>::</span> ' + form_array[i] +
			'</li>';
		$('#sortable1').append(form_element);
	}

	//Set Question Area height
	$("#sortable1").css({'height': (($("#sortable1").height()))+'px'});
	$("#sortable2").css({'height': (($("#field_question").height() - 25))+'px'});

	//Reset Question Type
	var default_T = jQuery("#sortable1").html();
	$("#sortable1").sortable({
		update: function(event, ui) {
			$( default_T ).appendTo( $( "#sortable1" ).empty() );
		}
	});

	/*$('#field_question').bind('scroll', function()
	{
		if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight)
		{
			alert('end reached');
		}
	});*/

	//Update Question Number
	$("#sortable2").sortable({
		update: function(event, ui) { //When Question Order Changed
			if( $("#sortable2 li").length == 0 ) {
				$('#sortable2').css('background-color', 'orange');
			}
			else {
				$('#sortable2').css('background-color', 'transparent');

				for(i=0,count=1; i<$("#sortable2 li").length; i++,count++) {
					var current_element = jQuery('#sortable2 li').eq(i);

					if( current_element.text().search(form_array[2]) == 3 ) {
						current_element.children('span').text('Q.' + (count) + ' ');
					}
					else if( current_element.text().search(form_array[5]) == 3 ) {
						--count;
					}
					else {
						current_element.children('span').text('Q.' + (count) + ' ');
					}
				}
			}
		},
		receive: function(event, ui) { //When Question Form is Dropped
			//$(this).sortable( "refreshPositions" );
			//$(this).sortable( "refresh" );

			//$('#sortable2').scrollBottom(1000);
			if( $("#sortable2 li").length == ui.item.index()+1 ) {
				$("#field_question").scrollTop(5000);
			}

			var index = ui.item.index();
			for(x=0; x<form_array.length; x++) {
				if( $('#sortable2 li').eq(index).text().search(form_array[x]) == 3 ) {
					$('#sortable2 li').eq(index).append(form_text_array[x]);
					break;
				}
			}

			//alert( $('#sortable2').height() + " " + $('#field_question').height() );
			$(this).css({'height': "auto"});
			if( $('#sortable2').height() < $('#field_question').height() ) {
				$("#sortable2").css({'height': (($("#field_question").height() - 25))+'px'});
			}
		}
	});

	//Destroy Question Form
	$("#sortable4").sortable({
		change: function(event, ui) { //Hover
			$("#sortable4").css('background-image', 'url("./images/recycle_open.jpeg")');
		},
		out: function(event, ui) { //Moved Out
			$("#sortable4").css('background-image', 'url("./images/recycle_close.jpeg")');
		},
		update: function(event, ui) { //When Dropped
			if( $("#sortable4 li").length != 0 ) {
				$( "#sortable4" ).empty();
			}
			$("#sortable4").css('background-image', 'url("./images/recycle_close.jpeg")');
		}
	});
});