@extends('layouts.app')
@section('content')
<h2>&nbsp;Reports | Delivery</h2>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<h3>Delivery Report</h3>
				<table class = "table-responsive table" id = "delivery_table">
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
								Date
							</td>
							<td>
								Weight
							</td>
							<td>
								Date of Delivery
							</td>
							<td>
								Remarks
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
	.class-del_rep
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
		var shiptable = $('#delivery_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: '{{ route("delivery.data") }}',
			columns: [
			{ data: 'name' },
			{ data: 'shippingLine'},
			{ data: 'portOfCfsLocation' },
			{ data: 'containerVolume' },
			{ data: 'containerNumber'},
			{ data: 'created_at'},
			{ data: 'deliveryDateTime' },
			{ data: 'remarks', processing:false },
			]
		})
	})
	// ->select('companyName', 'shippingLine', 'portOfCfsLocation', 'containerVolume', 'containerNumber', 'delivery_receipt_headers.created_at', 'delivery_non_container_details.grossWeight', 'delivery_receipt_headers.deliveryDateTime', 'delivery_containers.remarks')
</script>
@endpush