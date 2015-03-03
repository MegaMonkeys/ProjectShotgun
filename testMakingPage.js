//Question Form Script - Caution !!

//Question Form
var form_array = ['True/False Question', 'Multiple Choice Question', 'Many Choices', 'Short Answer Question', 'Essay'];
var form_text_array =
	[
		//Index:0 - True/False Question
		'<input type="text" maxlength="3" size="4" style="float: right;"><qp style="float:right;"> Point-&nbsp;</qp>' +
		'<textarea required rows="3" placeholder="True/False Question"></textarea>' +
        '<input type="radio" style="margin-left: 23%;"> True' +
		'<input type="radio" style="margin-left: 23%;"> False',

		//Index:1 - Multiple Choice Question
      '<input type="text" maxlength="3" size="4" style="float: right;"><qp style="float:right;"> Point-&nbsp;</qp>' +
		//'<input type="button" value="Option" onclick="add_option(this);"><br>' +
		'<textarea required rows="3" placeholder="Multiple Choice Question"></textarea>',

		//Index:2 - Many Choices
      '<input type="text" maxlength="3" size="4" style="float: right;"><qp style="float:right;"> Point-&nbsp;</qp>' +
		//'<input type="button" value="Option" onclick="add_option(this);"><br>' +
		'<textarea required rows="3" placeholder="Many Choices Question"></textarea>',

		//Index:3 - Short Answer Question
      '<input type="text" maxlength="3" size="4" style="float: right;"><qp style="float:right;"> Point-&nbsp;</qp>' +
		'<textarea required rows="3" placeholder="Short Answer Question"></textarea>' +
        'Answer: <input type="text"  maxlength="50" size="55">',

		//Index:4 - Essay
      '<input type="text" maxlength="3" size="4" style="float: right;"><qp style="float:right;"> Point-&nbsp;</qp>' +
		'<textarea required rows="4" placeholder="Essay Question"></textarea><br>',

		//Disabled
		'<hr align="left" width="100%" />' +
		'<textarea required rows="4" placeholder="Type Instruction"></textarea>'

		//'<textarea required name="ques_random" rows="4" placeholder="Nothing Nothing"></textarea>'
	];

    function removeQ (para) {
		$(para).parent('li').remove();
		resetQnum();
    }

    function pop_option(current, qnum, qtype) { //Add Choice Option
		var mul_op =
            '<table class="q_options">' +
                '<tr>' +
                    '<td>' +
                        '<input type=' + qtype + ' value="A">' +
                        '<span>A</span> <input type="text">' +
                    '</td>' +
                    '<td>' +
                        '<input type=' + qtype + ' value="B">' +
                        '<span>B</span> <input type="text">' +
                    '</td>' +
                '</tr>' +
                '<tr>' +
                    '<td>' +
                        '<input type=' + qtype + ' value="C">' +
                        '<span>C</span> <input type="text">' +
                    '</td>' +
                    '<td>' +
                        '<input type=' + qtype + ' value="D">' +
                        '<span>D</span> <input type="text">' +
                    '</td>' +
					'<td>' +
						'<button class="bin_button" type="button"' +
							'onmouseover="recy_onHover(this);" onmouseout="recy_offHover(this);"' +
							'onclick="removeQ(this.parentNode.parentNode.parentNode.parentNode);">' +
							'<input type="image" width="100%" height="100%" src="./images/recycle_close.jpeg">' +
						'</button><br>' +
					'</td>' +
                '</tr>' +

            '</table>';

        $(current).append(mul_op);
    }

	function add_option(current) { //Add Choice Option
		var opt_num = ($(current).parent('li')).children('div').length + 1;
		if(opt_num > 4) {

		}
		else {
			var newQ =
				'<div class="choices">' +
				'Option <span>' + opt_num + '</span>: <input type="text">' +
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
		//alert( $(window).height() + " " + $(document).height());

		if( $(window).width() >= 1050 ) {
			$("#left").css("left", ($(window).width() - 1050) / 2);
			$("#middle").css("left", ($(window).width() - 300) / 2);
			$(".logout-button").css("right", 10);
		}
		else {
			$("#left").css("left", 5);
			$("#middle").css("left", "55%");
			$(".logout-button").css("left", 840);
		}


		/*if( $(window).width() <= 1000 ) {
			$(".logout-button").css("left", 1000);
			$(".header").css("width", 1250);
			$("#wrap").css("padding-left", 0);
		}
		else {
			$("#wrap").css("padding-left", ($(document).width() - 1200) / 2);
			$(".logout-button").css("left", $(document).width() - 300 );
			$(".header").css("width", "100%");
		}
        alert();*/
	}

	$( window ).resize(function() {
		page_resize();
	});

    function getQNum() {
		return ($("#sortable2 li").length);
    }

	function resetQnum() {
		if( $("#sortable2 li").length == 0 ) {
			$('#sortable2').css('background-image', 'url("./images/q_background.png")');
		}



		for(index=0,count=1; index<$("#sortable2 li").length; index++,count++) {
			var current = jQuery('#sortable2 li').eq(index);
			var q_type;

			for(x=0; x<form_array.length; x++) {
				if( current.text().search(form_array[x]) == 3 ) {
					q_type = x;
				}
			}

			//Update Question Number
			current.children('span').text('Q.' + (count) + ' ');

		/* Reset ID Attribute */
			//Set ID for Question
			current.attr("name", "Q"+(index+1));
			//Set ID for Question Text
			current.children('textarea').eq(0).attr("name", "Q"+(index+1)+"T");
			//Set ID for Question Point
			current.children('input').eq(0).attr("name", "Q"+(index+1)+"P");

			//True / False Question
			if ( q_type == 0 ) {
				//current.children('input').eq(1).attr("id", "Q"+(index+1)+"O1");
				//current.children('input').eq(2).attr("id", "Q"+(index+1)+"O2");
				//current.children('input').eq(1).attr("name", "Q"+(index+1)+"O");
				//current.children('input').eq(2).attr("name", "Q"+(index+1)+"O");
            current.children('input').eq(1).attr("name", "Q"+(index+1)+"O");
            current.children('input').eq(2).attr("name", "Q"+(index+1)+"O");
            current.children('input').eq(1).attr("value", "True");
            current.children('input').eq(2).attr("value", "False");
			}
			//Multiple or Many Choice Question ?
			else if( q_type == 1 || q_type == 2) {
				var o_table = current.children('table').children('tbody');
				//Radio - Multiple Choice, Checkbox - Many Choice
				//ID is setted in the function
				//o_table.children('tr').eq(0).children('td').eq(0).children('input').eq(0).attr("id", "Q"+(index+1)+"O1");
				o_table.children('tr').eq(0).children('td').eq(0).children('input').eq(1).attr("name", "Q"+(index+1)+"O1T");
				o_table.children('tr').eq(0).children('td').eq(0).children('input').eq(0).attr("name", "Q"+(index+1)+"O");
            o_table.children('tr').eq(0).children('td').eq(0).children('input').eq(0).attr("value", "A");

				//o_table.children('tr').eq(0).children('td').eq(1).children('input').eq(0).attr("id", "Q"+(index+1)+"O2");
				o_table.children('tr').eq(0).children('td').eq(1).children('input').eq(1).attr("name", "Q"+(index+1)+"O2T");
				o_table.children('tr').eq(0).children('td').eq(1).children('input').eq(0).attr("name", "Q"+(index+1)+"O");
            o_table.children('tr').eq(0).children('td').eq(1).children('input').eq(0).attr("value", "B");

				//o_table.children('tr').eq(1).children('td').eq(0).children('input').eq(0).attr("id", "Q"+(index+1)+"O3");
				o_table.children('tr').eq(1).children('td').eq(0).children('input').eq(1).attr("name", "Q"+(index+1)+"O3T");
				o_table.children('tr').eq(1).children('td').eq(0).children('input').eq(0).attr("name", "Q"+(index+1)+"O");
            o_table.children('tr').eq(1).children('td').eq(0).children('input').eq(0).attr("value", "C");

				//o_table.children('tr').eq(1).children('td').eq(1).children('input').eq(0).attr("id", "Q"+(index+1)+"O4");
				o_table.children('tr').eq(1).children('td').eq(1).children('input').eq(1).attr("name", "Q"+(index+1)+"O4T");
				o_table.children('tr').eq(1).children('td').eq(1).children('input').eq(0).attr("name", "Q"+(index+1)+"O");
            o_table.children('tr').eq(1).children('td').eq(1).children('input').eq(0).attr("value", "D");
			}
			else if( q_type == 3 ) {
				current.children('input').eq(1).attr("name", "Q"+(index+1)+"A");
			}
		}
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
            /*for(x=0; x<4; x++) {
             var cur_opt = current.children('div').eq(x).children('input').eq(0);
             if( cur_opt.is(':checked') ) {
             answer += '' + (x + 1);
             }
             }*/

            for(r=0; r<2; r++) {
                for(c=0; c<2; c++) {
                    if( (current.children('table').children('tbody').children('tr').eq(r).children('td').eq(c).children('input').eq(0).is(':checked')) ) {
                        answer += (current.children('table').children('tbody').children('tr').eq(r).children('td').eq(c).children('input').eq(0).val());
                    }
                }
            }

            return [ type, question, point, answer,
                (current.children('table').children('tbody').children('tr').eq(0).children('td').eq(0).children('input').eq(1).val()),
                (current.children('table').children('tbody').children('tr').eq(0).children('td').eq(1).children('input').eq(1).val()),
                (current.children('table').children('tbody').children('tr').eq(1).children('td').eq(0).children('input').eq(1).val()),
                (current.children('table').children('tbody').children('tr').eq(1).children('td').eq(1).children('input').eq(1).val()) ];
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

	function recy_onHover(item) {
		$(item).children('input').attr('src', './images/recycle_open.jpeg');
	}

	function recy_offHover(item) {
		$(item).children('input').attr('src', './images/recycle_close.jpeg');
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
	var default_sortable1 = jQuery("#sortable1").html();
	$("#sortable1").sortable({
		update: function(event, ui) {
			$( default_sortable1 ).appendTo( $( "#sortable1" ).empty() );
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
		//$(".logout-button").css("top", 10 + val);
		//$("#left").css("padding-top", 60 + val);
		//$("#right").css("padding-top", 100 + val);

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
			resetQnum();
			/*
			if( $("#sortable2 li").length == 0 ) {
				alert();
				$('#sortable2').css('background-color', 'orange');
			}
			else {
				$('#sortable2').css('background-image', 'none');

				resetQnum();

				/*
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
			}*/
		},
		over: function(event, ui) {
			$('#sortable2').css('background-image', 'none');
		},
		receive: function(event, ui) { //When Question Form is Dropped
			/*
			 if( $("#sortable2 li").length == ui.item.index()+1 ) {
			 $("#field_question").scrollTop(5000);
			 }
			 */
			$('#sortable2').css('background-image', 'none');

			var index = ui.item.index();
			var current = $('#sortable2 li').eq(index);

			//Store Current User View Position
            var cur_po = $(document).scrollTop() / ($(document).height() - $(window).height());

			//Check type of Questions and Expand
            for(x=0; x<form_array.length; x++) {
				if( current.text().search(form_array[x]) == 3 ) {
                    current.append(form_text_array[x]);

                    //Set New User View Position
                    $(document).scrollTop( ($(document).height() - $(window).height()) * cur_po );


					if( x == 1 || x == 2) {
						//Radio - Multiple Choice, Checkbox - Many Choice
						//ID is setted in the function
						pop_option(current, index, ((x==1) ? "radio" : "checkbox") );
					}

					if( x==0 || x== 3 || x==4 ) {
						//var del_button = '<input type="button" value="Delete" style="float:right" onclick="sizes(this);"><br>';
						var del_button =
							'<button class="bin_button" type="button" onmouseover="recy_onHover(this);" onmouseout="recy_offHover(this);" onclick="removeQ(this);">'+
								'<input type="image" width="100%" height="100%" src="./images/recycle_close.jpeg">' +
							'</button><br>';
						current.append(del_button);
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
            $("#sortable4").css('width', 400);
            $("#sortable4").css('height', 320);
            $("#sortable4").css('bottom', 0);
		},
		out: function(event, ui) { //Moved Out
			$("#sortable4").css('background-image', 'url("./images/recycle_close.jpeg")');
            $("#sortable4").css('width', 200);
            $("#sortable4").css('height', 160);
		},
		update: function(event, ui) { //When Dropped
			if( $("#sortable4 li").length != 0 ) {
				$( "#sortable4" ).empty();
            }
            $("#sortable4").css('background-image', 'url("./images/recycle_close.jpeg")');
		}
	});
});



