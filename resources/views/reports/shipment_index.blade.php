@extends('layouts.app')
@section('content')
<h2>&nbsp;Reports | Shipment</h2>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<h3>Shipment Report</h3>
				<table class = "table-responsive table" id = "shipment_table">
					<thead>
						<tr>
							<td>
								Date
							</td>
							<td>
								File Number
							</td>
							<td>
								Processor
							</td>
							<td>
								Consignee
							</td>
							<td>
								Port
							</td>
							<td>
								Shipping Line
							</td>
							<td>
								Deposit
							</td>
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
	.class-shipment
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
		var shiptable = $('#shipment_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{ route("shipment.data") }}',
			columns: [
			{ data: 'created_at' },
			{ data: 'id'},
			{ data: 'Employee' },
			{ data: 'companyName' },
			{ data: 'arrivalArea'},
			{ data: 'shipper'},
			{ data: 'deposit' },
			]
		})
	})
	//->select('brokerage_service_order_details.created_at','consignee_service_order_header.id',DB::raw('CONCAT(employees.firstName, employees.lastName) as Employee'), 'companyName', 'supplier', DB::raw('CONCAT(container_types.description,  containerNumber) as CONTRS'), 'docking', 'awb', 'deposit')
</script>
@endpush