@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="col-md-12">
		<br />
		<div class="col-md-6">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Deliveries Today<span class="pull-right">{{ Carbon\Carbon::now('Asia/Hong_Kong')->format('F d, Y H:i A') }}</span></h4>
					</div>
					<div class="panel-body">
						<table class="table table-responsive table-striped table-bordered">
							<thead>
								<tr>
									<td>
										<label class = "control-label">ID</label>
									</td>
									<td>
										<label class = "control-label">Name</label>
									</td>
									<td>
										<label class = "control-label">Pickup Location</label>
									</td>
									<td>
										<label class = "control-label">Vehicle</label>
									</td>
								</tr>
							</thead>
							<tbody>
								@forelse($today_deliveries as $td)
								<tr>
									<td>
										{{ $td->del_id }}
									</td>
									<td>
										{{ $td->name }}
									</td>
									<td>
										{{ $td->address }} {{ $td->city_name }}, {{ $td->province_name }}, {{ Carbon\Carbon::parse($td->pickupDateTime)->format('H:i A') }}
									</td>
									<td>
										{{ $td->plateNumber }}
									</td>
								</tr>
								@empty
								<tr>
									<td colspan="4" style="text-align: center;">
										No deliveries today.
									</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Containers</h4>
					</div>
					<div class="panel-body">
						<table class="table table-striped table-bordered table-responsive">
							<thead>
								<tr>
									<td>
										<label class= "control-label">Container No</label>
									</td>
									<td>
										<label class = "control-label">Return Address</label>
									</td>
									<td>
										<label class = "control-label">Return Before</label>
									</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									@forelse($unreturned_containers as $uc)
									<td>
										{{ $uc->containerNumber }}
									</td>
									<td>
										{{ $uc->containerReturnAddress }}
									</td>
									<td>
										{{ Carbon\Carbon::parse($uc->containerReturnDate)->format('F d, Y') }}
									</td>
								</tr>
								@empty
								<tr>
									<td colspan="3" style="text-align: center;">
										No unreturned containers.
									</td>
								</tr>
								@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3>Delivery Schedule</h3>
			</div>
			<div class="panel-body">
				<div class = "col-md-12">
					<div id = "calendar">

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