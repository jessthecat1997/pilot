@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="col-md-12">
		<h2>&nbsp;Audit Trail</h2>
		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						Settings
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label">Date From:</label>
							<input type="text" name="date_from" id = "date_from"  class="form-control" />
						</div>
						<div class="form-group">
							<label class="control-label">Date To:</label>
							<input type="text" name="date_from" id = "date_to"  class="form-control" />
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading">
						Results
					</div>
					<div class="panel-body">
						<p>
							<pre class = "form-control">ASSJAPOSJOJ	</pre>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="/js/jqueryDateTimePicker/jquery.datetimepicker.css">
@endpush

@push('scripts')
<script type="text/javascript" src = "/js/jqueryDateTimePicker/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript">
	$(document).ready(function()
	{
		$.datetimepicker.setLocale('en');
		$('#date_from').datetimepicker({
			mask:'9999/19/39',
			dayOfWeekStart : 1,
			lang:'en',
			step: 5,
			format:'Y/m/d H:i',
			formatDate:'Y/m/d H:i',
			value: "{{ Carbon\Carbon::now('Asia/Hong_Kong')->format('Y/m/d H:i') }}",
			startDate:	"{{ Carbon\Carbon::now('Asia/Hong_Kong')->format('Y/m/d H:i') }}",
		});
		$('#date_to').datetimepicker({
			mask:'9999/19/39',
			dayOfWeekStart : 1,
			lang:'en',
			step: 5,
			format:'Y/m/d H:i',
			formatDate:'Y/m/d H:i',
			value: "{{ Carbon\Carbon::now('Asia/Hong_Kong')->format('Y/m/d H:i') }}",
			startDate:	"{{ Carbon\Carbon::now('Asia/Hong_Kong')->format('Y/m/d H:i') }}",
		});
	})
</script>
@endpush