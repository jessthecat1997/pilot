@extends('layouts.app')
@section('content')
<h3><img src="/images/bar.png"> Billing</h3>
<hr>
<div class="container-fluid">
	<div class="row">
		<div class = "panel-default panel" id="so_collapse">
				<div>
					<div class="panel-heading" id="heading">Select Service Order</div>
					<div class="panel-body">
						<table class = "table-responsive table" id = "so_head_table">
							<thead>
								<tr>
									<td>
										ID
									</td>
									<td>
										Consignee
									</td>
									<td>
										Service Order Type
									</td>
									<td>
										Status
									</td>
									<td>
										Date Created
									</td>
									<td>
										Actions
									</td>
								</tr>
							</thead>
						</table>
					</div>
				</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style>
	.class-billing
	{
		border-left: 10px solid #3ce28e;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	$('#collapse1').addClass('in');
	var data;
	var so_head_id;


	$(document).ready(function(){
		var vtable = $('#so_head_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{ route("so_head.data") }}',
			columns: [
			{ data: 'id' },
			{ data: 'companyName' },
			{ data: 'description' },
			{ data: 'paymentStatus' },
			{ data: 'created_at'},
			{ data: 'action', orderable: false, searchable: false }
			]
		})
	})
</script>
@endpush
