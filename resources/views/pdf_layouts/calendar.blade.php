@extends('layouts.app')
@section('content')

<h2>Scheduled deliveries</h2>
<div class = "col-md-10 col-md-offset-1">
	<div id = "calendar">

	</div>
</div>

@endsection

@push('styles')
<style type="text/css">
	#calendar h2:first-child{
		border-left: none;
	}
</style>
<link href="/js/fullCalendar/fullcalendar.min.css" rel="stylesheet">
@endpush

@push('scripts')

<script type="text/javascript" charset="utf8" src="/js/fullCalendar/moment.min.js"></script>
<script type="text/javascript" charset="utf8" src="/js/fullCalendar/fullcalendar.min.js"></script>
<script>


	$(document).ready(function() {
		$('#calendar').fullCalendar({
			header: { center: 'month,agendaWeek' },
			events: [
			@forelse($deliveries as $delivery)
			{
				title: '{{ $delivery->plateNumber }}',
				start: '{{ $delivery->pickupDateTime }}',
				end: '{{ $delivery->deliveryDateTime }}',
				url: '{{ route("trucking.index" ) }}/{{ $delivery->tr_so_id }}/delivery/{{ $delivery->del_head_id }}/view'
			},
			@empty

			@endforelse
			],
			eventRender: function (event, element, view) { 

				var dateString = moment(event.start).format('YYYY-MM-DD');
				$('#calendar').find('.fc-day-number[data-date="' + dateString + '"]').css('background-color', '#0AA722');
			},
			eventClick: function(event) {
				if (event.url) {
					window.open(event.url);
					return false;
				}
			},
		})
	});
</script>

@endpush