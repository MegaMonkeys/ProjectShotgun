//Question Form Script - Caution !!

//Question Form
var form_array =
   [
      'True/False Question',
      'Multiple Choice Question',
      'Many Choice Question',
      'Short Answer Question',
      'Essay Question',
      'Instruction'
   ];
var form_text_array =
	[
   //Index:0 - True/False Question
		'<input type="text" maxlength="3" size="4" style="float: right;"><qp style="float:right;"> Point-&nbsp;</qp>' +
		'<textarea required rows="3" placeholder="True/False Question"></textarea>' +
      '<input type="radio" checked style="margin-left: 23%;"> True' +
		'<input type="radio"         style="margin-left: 23%;"> False',

   //Index:1 - Multiple Choice Question
      '<input type="text" maxlength="3" size="4" style="float: right;"><qp style="float:right;"> Point-&nbsp;</qp>' +
		'<textarea required rows="3" placeholder="Multiple Choice Question"></textarea>',

   //Index:2 - Many Choices
      '<input type="text" maxlength="3" size="4" style="float: right;"><qp style="float:right;"> Point-&nbsp;</qp>' +
		'<textarea required rows="3" placeholder="Many Choice Question"></textarea>',

   //Index:3 - Short Answer Question
      '<input type="text" maxlength="3" size="4" style="float: right;"><qp style="float:right;"> Point-&nbsp;</qp>' +
		'<textarea required rows="3" placeholder="Short Answer Question"></textarea>' +
      'Answer: <input type="text"  maxlength="50" size="55">',

   //Index:4 - Essay
      '<input type="text" maxlength="3" size="4" style="float: right;"><qp style="float:right;"> Point-&nbsp;</qp>' +
		'<textarea required rows="4" placeholder="Essay Question"></textarea><br>',

   //Index:5 - Instruction
      '<button class="bin_button" type="button" onmouseover="recy_onHover(this);" onmouseout="recy_offHover(this);" onclick="removeQ(this);">'+
      '<input type="image" width="100%" height="100%" src="./images/recycle_close.jpeg">' +
      '</button><br>' +
		'<textarea required rows="2" placeholder="Type Instruction"></textarea>' +
      '<input type="hidden">'
	];
   var default_pledge =
      'This test is completely my own work.' +
      'I have not had anyone or anything aid me in answering the questions, ' +
      'including Internet search engines, such as Google, Bing, ect. ' +
      'I have not received, nor will I give any information regarding this test.';
//--------------------------------------------------------------------------------------------------------------------//


    function removeQ (para) {
		$(para).parent('li').remove();
		resetQnum();
    }

    function pop_option(current, qnum, qtype) { //Add Choice Option
		var mul_op =
            '<table class="q_options">' +
                '<tr>' +
                    '<td>' +
                        '<input type=' + qtype + ' value="A"' +((qtype=="radio")? "checked" : "") + '>' +
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



	function resetQnum() {
      //Remove Background(Guide Line) When Question Exist
		if( $("#sortable2 li").length == 0 ) {
			$('#sortable2').css('background-image', 'url("./images/q_background.png")');
		}


      //Loop Through All Question Form Types
		for(index=0,q_count=0; index<$("#sortable2 li").length; index++) {
			var current = jQuery('#sortable2 li').eq(index);
			var q_type;

         //Check Question Form Type
			for(x=0; x<form_array.length; x++)
				if( current.text().search(form_array[x]) != -1 )
					q_type = x;

			//Update Question Number
         if( q_type != 5)
			   current.children('span').text('Q.' + (++q_count) + ' ');

		 /* Reset ID Attribute */
			//Set ID for Question
			   current.attr("name", "Q"+(index+1));
			//Set ID for Question Text
			   current.children('textarea').eq(0).attr("name", "Q"+(index+1)+"T");
			//Set ID for Question Point
            if( q_type != 5)
               current.children('input').eq(0).attr("name", "Q"+(index+1)+"P");
            else {
               current.children('input').eq(0).attr("name", "Q" + (index + 1) + "I");
               current.children('input').eq(0).attr("value", "0");
            }


			// True / False Question
			if ( q_type == 0 ) {
				current.children('input').eq(1).attr("name", "Q"+(index+1)+"O");
            current.children('input').eq(2).attr("name", "Q"+(index+1)+"O");
            current.children('input').eq(1).attr("value", "True");
            current.children('input').eq(2).attr("value", "False");
			}
         //Multiple Choice Question
         else if( q_type == 1 ) {
            var o_table = current.children('table').children('tbody');
            //Radio - Multiple Choice
            //ID is setted in the function
            o_table.children('tr').eq(0).children('td').eq(0).children('input').eq(1).attr("name", "Q"+(index+1)+"C1T");
            o_table.children('tr').eq(0).children('td').eq(0).children('input').eq(0).attr("name", "Q"+(index+1)+"C");
            o_table.children('tr').eq(0).children('td').eq(0).children('input').eq(0).attr("value", "1");

            o_table.children('tr').eq(0).children('td').eq(1).children('input').eq(1).attr("name", "Q"+(index+1)+"C2T");
            o_table.children('tr').eq(0).children('td').eq(1).children('input').eq(0).attr("name", "Q"+(index+1)+"C");
            o_table.children('tr').eq(0).children('td').eq(1).children('input').eq(0).attr("value", "2");

            o_table.children('tr').eq(1).children('td').eq(0).children('input').eq(1).attr("name", "Q"+(index+1)+"C3T");
            o_table.children('tr').eq(1).children('td').eq(0).children('input').eq(0).attr("name", "Q"+(index+1)+"C");
            o_table.children('tr').eq(1).children('td').eq(0).children('input').eq(0).attr("value", "3");

            o_table.children('tr').eq(1).children('td').eq(1).children('input').eq(1).attr("name", "Q"+(index+1)+"C4T");
            o_table.children('tr').eq(1).children('td').eq(1).children('input').eq(0).attr("name", "Q"+(index+1)+"C");
            o_table.children('tr').eq(1).children('td').eq(1).children('input').eq(0).attr("value", "4");
         }
         //Many Choice Question
         else if( q_type == 2) {
            var o_table = current.children('table').children('tbody');
            //Checkbox - Many Choice
            //ID is setted in the function
            //o_table.children('tr').eq(0).children('td').eq(0).children('input').eq(0).attr("id", "Q"+(index+1)+"O1");
            o_table.children('tr').eq(0).children('td').eq(0).children('input').eq(1).attr("name", "Q"+(index+1)+"C1T");
            o_table.children('tr').eq(0).children('td').eq(0).children('input').eq(0).attr("name", "Q"+(index+1)+"C1");
            o_table.children('tr').eq(0).children('td').eq(0).children('input').eq(0).attr("value", "1");

            //o_table.children('tr').eq(0).children('td').eq(1).children('input').eq(0).attr("id", "Q"+(index+1)+"O2");
            o_table.children('tr').eq(0).children('td').eq(1).children('input').eq(1).attr("name", "Q"+(index+1)+"C2T");
            o_table.children('tr').eq(0).children('td').eq(1).children('input').eq(0).attr("name", "Q"+(index+1)+"C2");
            o_table.children('tr').eq(0).children('td').eq(1).children('input').eq(0).attr("value", "1");

            //o_table.children('tr').eq(1).children('td').eq(0).children('input').eq(0).attr("id", "Q"+(index+1)+"O3");
            o_table.children('tr').eq(1).children('td').eq(0).children('input').eq(1).attr("name", "Q"+(index+1)+"C3T");
            o_table.children('tr').eq(1).children('td').eq(0).children('input').eq(0).attr("name", "Q"+(index+1)+"C3");
            o_table.children('tr').eq(1).children('td').eq(0).children('input').eq(0).attr("value", "1");

            //o_table.children('tr').eq(1).children('td').eq(1).children('input').eq(0).attr("id", "Q"+(index+1)+"O4");
            o_table.children('tr').eq(1).children('td').eq(1).children('input').eq(1).attr("name", "Q"+(index+1)+"C4T");
            o_table.children('tr').eq(1).children('td').eq(1).children('input').eq(0).attr("name", "Q"+(index+1)+"C4");
            o_table.children('tr').eq(1).children('td').eq(1).children('input').eq(0).attr("value", "1");
         }
         //Short Answer Question
			else if( q_type == 3 ) {
				current.children('input').eq(1).attr("name", "Q"+(index+1)+"A");
			}
         //Essay Question
         else if( q_type == 4) {

         }
         //Instruction
         else if( q_type == 5) {
            current.children('input').eq(0).attr("value", "0");

         }
		}
	}


//Pre-run JavaScript Codes
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

   document.getElementById('pledge_text').value = default_pledge;

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

	});

	//Update Question Number
	$("#sortable2").sortable({
		update: function(event, ui) { //When Question Order Changed
			resetQnum();
		},
		over: function(event, ui) {
			$('#sortable2').css('background-image', 'none');
		},
		receive: function(event, ui) { //When Question Form is Dropped
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

					if( x==0 || x== 3 || x==4) {
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

});


// Extra Functions

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
   }

   $( window ).resize(function() {
      page_resize();
   });

   function recy_onHover(item) {
      $(item).children('input').attr('src', './images/recycle_open.jpeg');
   }

   function recy_offHover(item) {
      $(item).children('input').attr('src', './images/recycle_close.jpeg');
   }


