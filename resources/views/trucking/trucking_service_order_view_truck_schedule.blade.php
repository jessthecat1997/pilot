@extends('layouts.app')
@section('content')
<div class="col-md-12">
	<h2>&nbsp;Company Vehicles</h2>
	<div class = "col-md-6">
		@forelse($vehicle_type_with_vehicles as $vt)
		<div class = "col-md-12">
			<div class = "panel panel-default">
				<div class = "panel-heading">
					{{ $vt['vehicle_type']->name }}
				</div>
				<div class = "panel-body">
					<table class="table table-responsive table-striped" id = "{{ $vt['vehicle_type']->name }}_table" />
						<thead>
							<tr>
								<td style="">
									Plate Number
								</td>
								<td>
									Action
								</td>
							</tr>
						</thead>
						<tbody>
							@forelse($vt['vehicles'] as $vehicle)
							<tr>
								<td>
									{{ $vehicle->plateNumber }}
								</td>
								<td>
									<button class="btn btn-md btn-info view-schedule" value = "{{ $vehicle->plateNumber }}" >View Schedule</button>
								</td>
							</tr>
							@empty

							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
		@empty

		@endforelse
	</div>
	<div class = "col-md-6">
		<div class="col-md-12">
			<div class = "collapse in" id = "schedule_collapse">
				<table class="table table-responsive table-striped">
					<thead>
						<tr>
							<td>
								
							</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
		<div class="col-md-12">
			<div class = "collapse in">
				<div class= "panel panel-default">
					<div class = "panel-heading">

					</div>
					<div class="panel-body">
						<div id="calendar">

						</div>
					</div>
				</div>
			</div>
		</div>
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

<script type="text/javascript">
	var calendar_data;
	$(document).ready(function(){
		@forelse($vehicle_type_with_vehicles as $vt)
		$('#{{ $vt['vehicle_type']->name }}_table').DataTable({
			serverSide: false,
			deferRender: true,
		});
		@empty
		@endforelse

		$(document).on('click', '.view-schedule', function(e){
			e.preventDefault();
			$.ajax({
				method: "GET",
				url: "{{ route('get_truck_schedule') }}",
				data: {
					'plateNumber': $(this).val(),
				},
				success: function (data){
					calendar_data = data;
				}
			})
			var calendar = $('#calendar').fullCalendar({
				header: { center: 'month,agendaWeek' },
				events: 
				
				[

				{

					title: 'aw',
					start: '2017-02-02',
					end: '2018-01-02',
					url: '/aw'
				},
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
		})
	})
</script>
@endpush