@extends('layouts.app')
@section('content')
<h2>&nbsp;Billing</h2>
<hr>
<div class="container-fluid">
	<div class="row">
		<div class = "panel-default panel" id="so_collapse">
			<div>
				<div class="panel-heading" id="heading">Select Brokerage Service Order</div>
				<div class="panel-body">
					<table class = "table-responsive table" id = "brso_head_table">
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
	<div class="row">
		<div class = "panel-default panel" id="so_collapse">
			<div>
				<div class="panel-heading" id="heading">Select Trucking Service Order</div>
				<div class="panel-body">
					<table class = "table-responsive table" id = "trso_head_table">
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
		border-left: 10px solid #8ddfcc;
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
		var vtable = $('#brso_head_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{ route("brso_head.data") }}',
			columns: [
			{ data: 'id' },
			{ data: 'companyName' },
			{ data: 'name' },
			{ data: 'created_at'},
			{ data: 'action', orderable: false, searchable: false, processing:false }
			]
		})
		var trtable = $('#trso_head_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{ route("trso_head.data") }}',
			columns: [
			{ data: 'id' },
			{ data: 'companyName' },
			{ data: 'name' },
			{ data: 'created_at'},
			{ data: 'action', orderable: false, searchable: false, processing:false }
			]
		})
	})
</script>
@endpush
