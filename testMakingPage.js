//Question Form Script - Caution !!

//Question Form
var form_array = ['True/False Question', 'Multiple Choice Question', 'Many Choices', 'Short Answer Question', 'Essay'];
var form_text_array =
	[
		' Point - <input type="text" name="f_point" maxlength="3" size="3">' +
		'<br><textarea required name="ques_head" rows="3" placeholder="True/False Question"></textarea>' +
        '<input type="radio" > True <input type="radio" > False',

		' Point - <input type="text" name="f_point" maxlength="3" size="3">' +
		'<input type="button" value="Option" onclick="add_option(this);">' +
		'<br><textarea required name="ques_head" rows="3" placeholder="Multiple Choice Question"></textarea>',

		' Point - <input type="text" name="f_point" maxlength="3" size="3">' +
		'<input type="button" value="Option" onclick="add_option(this);">' +
		'<br><textarea required name="ques_head" rows="3" placeholder="Many Choices Question"></textarea>',

		' Point - <input type="text" name="f_point" maxlength="3" size="3">' +
		'<br><textarea required name="ques_head" rows="3" placeholder="Short Answer Question"></textarea>' +
        'Answer: <input type="text" name="f_ans" maxlength="50" size="60">',

		' Point - <input type="text" name="f_point" maxlength="3" size="3">' +
		'<br><textarea required name="ques_head" rows="4" placeholder="Essay Question"></textarea>',

		'<hr align="left" width="100%" />' +
		'<textarea required name="ques_instruc" rows="4" placeholder="Type Instruction"></textarea>'

		//'<textarea required name="ques_random" rows="4" placeholder="Nothing Nothing"></textarea>'
	];

    function pop_option(current, qnum, qtype) { //Add Choice Option
        for(x=1; x<=4; x++) {
            var newQ =
                '<div class="choices">' +
                    '<input type=' + qtype + ' name=' + qnum + ' value=' + x+1 + '>' +
                    'Option <span>' + x + '</span>: <input type="text" name="text_Q">' +
                '</div>';
            $(current).append(newQ);
        }
    }

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


	function page_resize() {
		if( $(window).width() <= 1100 ) {
			$(".logout-button").css("left", 1000);
			$(".header").css("width", 1250);
			$("#wrap").css("padding-left", 0);
		}
		else {
			$("#wrap").css("padding-left", ($(document).width() - 1200) / 2);
			$(".logout-button").css("left", $(document).width() - 300 );
			$(".header").css("width", "100%");
		}
	}

	$( window ).resize(function() {
		page_resize();
	});

    function getQNum() {
        return ($("#sortable2 li").length);
    }

    function getQuestion(qNumber) {
        var current = $('#sortable2 li').eq(qNumber-1);
        var type;
        var question;
        var point;
        var answer = "";

        for(x=0; x<form_array.length; x++) {
            if (current.text().search(form_array[x]) != -1) {
                type = '' + (x+1) + '';
                break;
            }
        }

        question = current.children('textarea').val();
        point    = current.children('input').val();

        if(type == "1") {
            answer +=  (current.children('input').eq(0).is(':checked')) ? 't' : 'f';
            return [ type, question, point, answer ];
        }
        else if (type == "2" || type == "3") {
            for(x=0; x<4; x++) {
                var cur_opt = current.children('div').eq(x).children('input').eq(0);
                if( cur_opt.is(':checked') ) {
                    answer += '' + (x + 1);
                }
            }
            return [ type, question, point, answer,
             current.children('div').eq(0).children('input').eq(1).val(),
             current.children('div').eq(1).children('input').eq(1).val(),
             current.children('div').eq(2).children('input').eq(1).val(),
             current.children('div').eq(3).children('input').eq(1).val() ];
        }
        else if (type == "4") {
            answer += current.children('input').eq(1).val();
            return [ type, question, point, answer ];
        }
        else if (type == "5") {
            return [ type, question, point ];
        }
        else {
            return [ type ];
        }
    }

$(function() {
	//Page Resize Elements
	page_resize();
	$("#footer").css("min-width", $(document).width());

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

	$(document).bind('scroll', function() {
		//alert($(document).height() + " " + $(window).height());
		//document.getElementById("tester").innerText =
		//	$(document).width() + " " + $(window).width() + " " + $(document).scrollTop() + " " + $(document).innerHeight();
		var val;
		if( ($(document).height() - $(window).height()) > $(document).scrollTop() ) {
			val = $(document).scrollTop();
		}
		else {
			val = $(document).height() - $(window).height();
		}
		$(".logout-button").css("top", 10 + val);
		$("#left").css("padding-top", 60 + val);
		$("#right").css("padding-top", 100 + val);

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
            var index = ui.item.index();
			if( $("#sortable2 li").length == ui.item.index()+1 ) {
				$("#field_question").scrollTop(5000);
			}

            //Store Current User View Position
            var cur_po = $(document).scrollTop() / ($(document).height() - $(window).height());

            var current = $('#sortable2 li').eq(index);
            for(x=0; x<form_array.length; x++) {
				if( current.text().search(form_array[x]) == 3 ) {
                    current.append(form_text_array[x]);

                    //Set New User View Position
                    cur_po = ($(document).height() - $(window).height()) * cur_po;
                    $(document).scrollTop(cur_po);

                    if( x == 1 || x == 2) {
                        pop_option(current, index, (x==1) ? "radio" : "checkbox" );
                    }
                    else if ( x == 0 ) {
                        current.children('input').eq(1).attr("name", index);
                        current.children('input').eq(1).attr("value", 1);
                        current.children('input').eq(2).attr("name", index);
                        current.children('input').eq(1).attr("value", 0);
                    }
					break;
				}
			}

            //Adjust the Question Area Size - Min / Dynamic
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



