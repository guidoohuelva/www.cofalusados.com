window.jQuery(document).ready(function($){
	var toggl = false;
	$('#external_link').on('click', function(){
		if( $('.external-links a.active')[0] ){
			$('.external-links a.active').click();
		}
		if(toggl){
			$(this).find('span').html('Abrir');
			$(this).find('i').attr('class', '').addClass('icon-plus-sign');
		} else {
			$(this).find('span').html('Cerrar');
			$(this).find('i').attr('class', '').addClass('icon-minus-sign');
		}
		toggl = toggl ? false : true;
	});

	// menu links

	$('.external-links a.open-form').on('click', function(){
		if( $(this).hasClass('active') ){
			$(this).removeClass('active');
			a = true;
			b = true;
		} else {
			$(this).addClass('active');
		}
	});

	// form

	var popshow = false,
		mouseOverActiveElement = false;
	$('#cita').popover({
		// selector: "#support",
		html: true,
		placement: 'right',
		content: function(){
			var html = $(this).attr('href').substring(1);
			// console.log( $('#' + html) );
			return $('#' + html).html();
		},
		container : '#get_form_container'
	});

	// date pickers
	var a = true, b = true, minfecha, date_1, date_2,
		dayNamesMin = [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
		monthNamesShort = [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ];
	$('#get_form_container').delegate( '.availabledate', 'focus', function(event){
		// event.preventDefault();
		if(a){
			// console.log('se aplicara el datepicker a: ', this);
			$(this).datepicker({
				defaultDate: "+2d",
				beforeShowDay: $.datepicker.noWeekends,
				changeMonth: true,
				numberOfMonths: 1,
				minDate: "+2d",
				dateFormat : 'dd/mm/yy',
				dayNamesMin: dayNamesMin,
				monthNamesShort: monthNamesShort,
				onClose: function( selectedDate ) {
					date_1 = $(this);
					date_2 = $( "#get_form_container .availabledate_2" );
					// console.log( 'detectar si el segundo campo ya tiene datepicker: ', date_2.hasClass('has_datepicker') );
					if( !date_2.hasClass('has_datepicker') ) {
						// console.log('asignar datepicker al segundo campo');
						date_2.removeAttr('disabled').addClass('has_datepicker').datepicker({
							defaultDate: "+2d",
							beforeShowDay: $.datepicker.noWeekends,
							changeMonth: true,
							numberOfMonths: 1,
							minDate: selectedDate,
							dateFormat : 'dd/mm/yy',
							dayNamesMin: dayNamesMin,
							monthNamesShort: monthNamesShort,
							onClose: function( selectedDate ) {
								date_1.datepicker( "option", "maxDate", selectedDate );
							}
						});
					};
				}
			});
			a = false;
		}
		// console.log('se abre el datepicker: ');
	});

	// activate form

	$('#get_form_container').delegate( '.get_date_form', 'submit', function(event){
		event.preventDefault();
		$(this).find("[name='sent_from']").val(window.document.URL);
		// console.log( $(this).serialize() );
		$(".ajax-loader").css("display", "inline");
		var jqxhr = $.ajax( {
				url : $(this).attr("action"),
				type : $(this).attr("method"),
				dataType : 'JSON',
				data : $(this).serialize()
			})
		    .done(function(a, b, c) {
				$(".ajax-loader").css("display", "none");
		    	// console.log("success", a, b, c);
		    	// console.log('data devuelta', a);
		    	alert(a.msg);
		    	if(a.sent){
		    		$('#cita').click();
		    	}
			})
		    .fail(function(a, b, c) {
		    	// console.log("error", a, b, c);
		    })
		    .always(function(a, b, c) {
		    	// console.log("complete", a, b, c);
		    });
	});

});
