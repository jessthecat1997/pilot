@extends('layouts.app')
@section('content')
<h2>&nbsp;Delivery</h2>
<hr>
<div class="pull-right">
	<a href = "{{ route('trucking.create') }}" class = "btn btn-primary btn-md pull-right">Create Trucking Service Order</a>
</div>
<br/>
<br/>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				List of Trucking Service Orders
			</div>
			<div class="panel-body">
				<table class = "table table-responsive table-striped cell-border table-bordered" id = "pending_trucking_so_table">
					<thead>
						<tr>
							<th>
								Consignee
							</th>
							<th>
								Company Name
							</th>
							<th>
								Status
							</th>
							<th>
								Action
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse($truckings as $trucking)
						<tr>
							<td>
								{{ $trucking->name }}
							</td>
							<td>
								{{ $trucking->companyName }}
							</td>
							<td>
								@if($trucking->status == 'F')
								Finished
								@elseif($trucking->status == 'P')
								Pending
								@elseif($trucking->status == 'C')
								Cancelled

								@else
								Unknown

								@endif
							</td>
							<td>
								<a href = "{{ route('trucking.index') }}/{{ $trucking->id }}/view" class = "btn btn-md but view-service-order">Manage</a>
							</td>
						</tr>
						@empty

						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style>
	.delivery
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
	var route = '{{ route("tr_so.data") }}';
	var current_route = "";
	$(document).ready(function(){
		current_route = route.replace('//view', '/1/view');

		var emtable = $('#pending_trucking_so_table').DataTable({
			processing: false,
			deferRender: true,
			serverSide: false,
			
			columns: [
			{ data: 'name'},
			{ data: 'companyName'},
			{ data: 'status' },
			{ data: 'action', orderable: false, searchable: false }

			],
			"order": [[ 0, "desc" ]],
		});
	})
</script>
@endpush
