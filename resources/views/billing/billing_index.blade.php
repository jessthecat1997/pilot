@extends('layouts.app')
@section('content')

<h2>&nbsp;Billing</h2>
<hr>
<div class="row">
	<div class="col-lg-4">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Select Service Order
			</div>
			<div class="panel-body">
				<table class = "table-responsive table" id = "so_table">
					<thead>
						<tr>
							<th>
								Consignee
							</th>
							<th>
								Actions
							</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="panel panel-primary">
			<div class="panel-heading">
				List of Invoice
			</div>
			<div class="panel-body">
				<table class = "table-responsive table" id = "bill_hist_table">
					<thead>
						<tr>
							<th>
								Consignee
							</th>
							<th>
								Total Amount
							</th>
							<th>
								Status
							</th>
							<th>
								Due Date
							</th>
							<th>
								Actions
							</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style>
.maintenance
{
	border-left: 10px solid #2ad4a5;
	background-color:rgba(128,128,128,0.1);
	color: #fff;
}
.class-billing
{
	border-left: 10px solid #8ddfcc;
	background-color:rgba(128,128,128,0.1);
	color: #fff;
}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	$('#maintenancecollapse').addClass('in');
	$('#billingcollapse').addClass('in');
	var data;
	var so_head_id;


	$(document).ready(function(){

		var vtable = $('#bill_hist_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: "{{ route('invoice.data') }}",
			columns: [
			{ data: 'companyName' },
			{ data: 'totall',
			"render" : function( data, type, full ) {
				return formatNumber(data); } },
				{ data: 'isFinalize',
				"render" : function( data, type, full ) {return formatWithBillType(data); }},
				{ data: 'due_date' },
				{ data: 'action', orderable: false, searchable: false }
				]
			})

		function formatWithBillType(n) {

			if (n == '0'){
				return "Pending";
			}else{
				return "Posted";
			}
		}
		var stable = $('#so_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: '{{ route("brso_head.data") }}',
			columns: [
			{ data: 'companyName' },
			{ data: 'action', orderable: false, searchable: false, processing:false }
			]
		})
	})
</script>
@endpush
