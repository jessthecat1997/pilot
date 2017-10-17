@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="col-md-3">
		<h2>&nbsp;Billing Reports</h2>
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
						<input type = "radio" name = "status_filter" value = "P" checked> <label class = "control-label">Paid</label>
					</div>
					<div class="row">
						<input type = "radio" name = "status_filter" value = "U"> <label class = "control-label">Unpaid</label>
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
		<iframe src="/reports/billing/bill_pdf/1" id = "iframe" style="width: 100%; height: 680px;">
			adsjasdj
		</iframe>
	</div>
</div>
@endsection

@push('scripts')

<script src="/js/dateRangePicker/moment.min.js"></script>         
<script src="/js/dateRangePicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="/js/dateRangePicker/daterangepicker.css" />

<script type="text/javascript">
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
				$('#iframe').attr('src', "/reports/billing/bill_pdf/0/"+ status + "/" +frequency +"/{{ Carbon\Carbon::now('Asia/Hong_Kong')->format('Y-m-d') }}/{{ Carbon\Carbon::now('Asia/Hong_Kong')->format('Y-m-d') }}");
			}
			else
			{

			}
			frequency = $('#frequency').val();
			status = $('input[name=status_filter]:checked').val();
			
			$('#iframe').attr('src', "/reports/billing/bill_pdf/0/"+ status + "/" +frequency + "/" + startDate.format("YYYY-MM-D") + "/" + endDate.format("YYYY-MM-D"));
		})


	})
</script>
@endpush