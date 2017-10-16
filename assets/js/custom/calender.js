function custom_calender(id)
{
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	var link = $(id).attr('data-source');
	// $.get(link, {param:'03'},function( data ) {
		$(id).fullCalendar({
		header: {
			left: 'title',
			center: '',
			right: 'prev,next,today month,agendaWeek,agendaDay'
		},
		buttonText: {
			prev: '<i class="icon-chevron-left cal_prev" />',
			next: '<i class="icon-chevron-right cal_next" />'
		},
		lazyFetching: true,
		allDaySlot: false,
		aspectRatio: 1.5,
		selectHelper: true,
		theme: false,
		viewRender: function(view,element){alert("aha");},
		eventSources:[
			{
				url: '/framework/mom/meeting_management/kalender/load?param=03',
				color: '#FAF29B',
				textColor: 'black',
				allDayDefault: false
			}
		],
		// events: xhr_result(),
		// events: getEventSource(link),
		eventClick: function(calEvent, jsEvent, view) {
			bootbox.alert('Detail', function() {
				
			});
			// change the border color just for fun
			$(this).css('border-color', 'red');
		},
		viewRender: function (view, element) {
			// Function Untuk mendapatkan value agenda perbulan
        },
		eventColor: '#5db2ff'
		
	  });
	// },
	// 'script');
	
}

