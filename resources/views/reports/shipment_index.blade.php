@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="col-md-3">
		<h2>&nbsp;Shipment Reports</h2>
		<hr />
		<div class="row">
			<div class="form-group">
				<label class="control-label">Range</label>
				<input type="text" id = "daterange" class="form-control" required/>
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<label class="control-label" >Frequency</label>
				<select class="form-control" id = "frequency">
					<option value="0">Daily</option>
					<option value="1">Weekly</option>
					<option value="2">Monthly</option>
					<option value="3">Yearly</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<label class="control-label">Filter by Status</label>
				<div class="col-md-8 col-md-offset-2">
					<div class="row">
						<input type = "radio" name = "status_filter" value = "0" checked> <label class = "control-label">All</label>
					</div>
					<div class="row">
						<input type = "radio" name = "status_filter" value = "1"> <label class = "control-label">Pending</label>
					</div>
					<div class="row">
						<input type = "radio" name = "status_filter" value = "2"> <label class = "control-label">Finished</label>
					</div>
					<div class="row">
						<input type = "radio" name = "status_filter" value = "3"> <label class = "control-label">Cancelled</label>
					</div>
				</div>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-md but generate" style="width: 100%;">Generate Report</button>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<iframe src="{{route('shipment.index')}}/print/Daily" id = "iframe" style="width: 100%; height: 680px;">

		</iframe>
	</div>
</div>
@endsection
@push('styles')
<style>
	.class-shipment
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
	.table td.fit,
	.table th.fit {
			overflow: scroll; /* Scrollbar are always visible */
			overflow: auto;   /* Scrollbar is displayed as it's needed */
			white-space: nowrap;
			width: 1%;
	}
</style>
@endpush

@push('scripts')

<script src="/js/dateRangePicker/moment.min.js"></script>
<script src="/js/dateRangePicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="/js/dateRangePicker/daterangepicker.css" />

<script type="text/javascript">

	$('#collapse3').addClass('in');
	var data;
	var frequency;
	$(document).on('click', '.print-report', function(e){
		e.preventDefault();
		window.open("http://localhost:8000/reports/shipments/print/"+frequency);
	})

	$(document).on('change', '#frequency_select', function(e){
		e.preventDefault();
		var selected = $(this).val();

		switch (selected) {
			case "4" :
			$('#custom_collapse').addClass('in');
			$('#shipment_table').removeClass('in');
			$('.print-report').removeClass('in');
			break;
			case "1" :
			$('#shipment_table').removeClass('in');
			$('#custom_collapse').removeClass('in');
			$('#shipment_table').addClass('in');
			$('.print-report').addClass('in');
			frequency = "Daily Report: 10-14-2017";
			break;
			case "2" :
			$('#custom_collapse').removeClass('in');

			$('#shipment_table').removeClass('in');
			$('#custom_collapse').removeClass('in');
			$('#shipment_table').addClass('in');
			$('.print-report').addClass('in');
			frequency = "Monthly Report: October"
			break;
			case "3" :
			$('#custom_collapse').removeClass('in');

			$('#shipment_table').removeClass('in');
			$('#custom_collapse').removeClass('in');
			$('#shipment_table').addClass('in');
			$('.print-report').addClass('in');
			frequency = "Yearly Report: 2017"
			break;
		}
	});

	$(document).on('click', '.custom_date', function(e){
		$('#shipment_table').addClass('in');
		$('.print-report').addClass('in');
		if($('#from_date').val() != "" && $('#to_date').val() != ""){
			frequency = "Report: "+$('#from_date').val()+" to "+$('#to_date').val();
		}
	});

	var startDate = null;
	var endDate = null;
	$(document).ready(function(){
		$('#daterange').daterangepicker({
			"showDropdowns": true,
			"applyClass" : "select_date_range btn-success",
			"showWeekNumbers": true,
			"ranges": {
				"Today": [
				"{{ Carbon\Carbon::now('Asia/Hong_Kong')->format('m/d/Y') }}",
				"{{ Carbon\Carbon::now('Asia/Hong_Kong')->format('m/d/Y') }}",
				],
				"Yesterday": [
				"{{ Carbon\Carbon::now('Asia/Hong_Kong')->addDays(-1)->format('m/d/Y') }}",
				"{{ Carbon\Carbon::now('Asia/Hong_Kong')->format('m/d/Y') }}"
				],
				"Last 7 Days": [
				"{{ Carbon\Carbon::now('Asia/Hong_Kong')->addDays(-7)->format('m/d/Y') }}",
				"{{ Carbon\Carbon::now('Asia/Hong_Kong')->format('m/d/Y') }}"
				],
				"Last 30 Days": [
				"{{ Carbon\Carbon::now('Asia/Hong_Kong')->addDays(-30)->format('m/d/Y') }}",
				"{{ Carbon\Carbon::now('Asia/Hong_Kong')->format('m/d/Y') }}"
				],
				"This Month": [
				"{{ Carbon\Carbon::now('Asia/Hong_Kong')->startOfMonth()->format('m/d/Y') }}",
				"{{ Carbon\Carbon::now('Asia/Hong_Kong')->endOfMonth()->format('m/d/Y') }}"
				],
				"Last Month": [
				"{{ Carbon\Carbon::now('Asia/Hong_Kong')->addMonths(-1)->startOfMonth()->format('m/d/Y') }}",
				"{{ Carbon\Carbon::now('Asia/Hong_Kong')->addMonths(-1)->endOfMonth()->format('m/d/Y') }}"
				]
			},
			"alwaysShowCalendars": true,
			"startDate": "{{ $now }}",
			"endDate": "{{ $now }}",
			"drops": "down"
		}, function(start, end, label) {
			startDate = start;
			endDate = end;
		});

		$(document).on('click', '.select_date_range', function(e)
		{
			e.preventDefault();
			console.log(startDate.format('D MMMM YYYY') + ' - ' + endDate.format('D MMMM YYYY'));
		})

		$(document).on('click', '.generate', function(e){
			e.preventDefault();
			if(startDate == null)
			{
				frequency = $('#frequency').val();
				status = $('input[name=status_filter]:checked').val();
				$('#iframe').attr('src', "");
			}
			else
			{

			}
			frequency = $('#frequency').val();
			status = $('input[name=status_filter]:checked').val();

			//console.log("{{ route('delivery.index') }}/del_pdf/0/"+ status + "/" +frequency + "/" + startDate.format("Y-M-D") + "/" + endDate.format("Y-M-D"));
			$('#iframe').attr('src', "{{route('shipment.index')}}/print/"+ startDate.format("Y-M-D") + " to " + endDate.format("Y-M-D") + " ");
		})


	})
		//->brokerage_service_order_details.created_at','consignee_service_order_header.id',DB::raw('CONCAT(employees.firstName, employees.lastName) as Employee'), 'companyName', 'supplier', DB::raw('CONCAT(container_types.description,  containerNumber) as CONTRS'), 'docking', 'awb', 'deposit')
</script>
@endpush
