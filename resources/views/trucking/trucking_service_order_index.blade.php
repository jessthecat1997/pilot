@extends('layouts.app')
@section('content')
<div class = "row">
	<div class = "col-md-10 col-md-offset-1">
		<div class = "default panel panel">
			<div class = "panel-heading">
				<h2>&nbsp;Trucking Service Orders</h2>
				<hr />
			</div>
			<a href = "{{ route('trucking.create') }}" class = "btn btn-success btn-md pull-right">New Trucking Service Order </a>
			<div class = "panel-body">
				<h4>Trucking Service Orders</h4>
				<div class = "panel-default panel">
					<div class = "panel-body">
						<table class = "table table-responsive table-striped cell-border table-bordered" width="100%" id = "pending_trucking_so_table">
							<thead>
								<tr>
									<td>
										Consignee
									</td>
									<td>
										Company Name
									</td>
									<td>
										Status
									</td>
									<td>
										Action
									</td>
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
	</div>
</div>
@endsection
@push('styles')
<style>
.delivery
{
	border-left: 10px solid #2ad4a5;
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
