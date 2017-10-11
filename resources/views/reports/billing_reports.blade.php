@extends('layouts.reports')
@section('content')
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<h3>Unpaid Billing Report</h3>
				
				<div class = "form-horizontal">
					<div class = "form-group">
						<label class = "control-label col-md-3">Select Frequency: </label>
						<div class = "col-md-6 col-md-offset-1">
							<select class = "form-control" id = "frequency_select">
								<option value = "0"></option>
								<option value = "1">Daily</option>
								<option value = "2">Monthly</option>
								<option value = "3">Yearly</option>
								<option value = "4">Custom</option>
							</select>
						</div>
					</div>
					<div class = "collapse" id = "custom_collapse">
						<div class = "form-group">
							<div class = "col-md-2">
							</div>
							<div class = "col-md-8">
								<div class = "col-md-5">
									<label class = "control-label col-md-2">From: </label>
									<div class = "col-md-9 col-md-offset-1">
										<input type = "date"  class = "form-control" id = "from_date" style="width: 100%;" />
									</div>
								</div>
								<div class = "col-md-5">
									<label class = "control-label col-md-2">To: </label>
									<div class = "col-md-9 col-md-offset-1">
										<input type = "date"  class = "form-control" id = "to_date" sstyle="width: 100%;" />
									</div>
								</div>
								<div class = "col-md-2">
									<button class = "btn but custom_date">Go</button>
								</div>
							</div>
							<div class = "col-md-2">
							</div>
						</div>
					</div>
				</div>
				<div class = "collapse" id = "daily_collapse">
					<br />
					<table class = "table-responsive table" id = "daily_table">
						<thead>
							<tr>
								<td>
									Consignee
								</td>
								<td>
									Particulars
								</td>
								<td>
									Amount
								</td>
								<td>
									Date
								</td>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
				<div id = "monthly_collapse">
					<br />
					<table class = "table-responsive table" id = "monthly_table">
						<thead>
							<tr>
								<td>
									Consignee
								</td>
								<td>
									Particulars
								</td>
								<td>
									Amount
								</td>
								<td>
									Date
								</td>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
				<div class = "collapse" id = "yearly_collapse">
					<br />
					<table class = "table-responsive table" id = "yearly_table">
						<thead>
							<tr>
								<td>
									Consignee
								</td>
								<td>
									Particulars
								</td>
								<td>
									Amount
								</td>
								<td>
									Date
								</td>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
				<div class = "collapse" id = "customed_collapse">
					<br />
					<table class = "table-responsive table" id = "customed_table">
						<thead>
							<tr>
								<td>
									Client
								</td>
								<td>
									Shipping Line
								</td>
								<td>
									Port of CFS Location
								</td>
								<td>
									Container
								</td>
								<td>
									Container Number
								</td>
								<td>
									Pickup Date
								</td>
								<td>
									Date of Delivery
								</td>
								<td>
									Remarks
								</td>
								<td>
									Delivery Year
								</td>	
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style>
	.class-bill_rep
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	$('#collapse3').addClass('in');
	var data;
	$(document).ready(function(){
		var btable = $('#monthly_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: "{{ route('billRep.data') }}",
			columns: [
			{ data: 'companyName' },
			{ data: 'part',
			"render": function(data, type, row){
				return data.split("\n").join("<br/>");}
			},
			{ data: 'amount',
			"render": function(data, type, row){
				return data.split("\n").join("<br/>");}
			},
			{ data: 'date_billed' },
			]
		})
	})
</script>
@endpush