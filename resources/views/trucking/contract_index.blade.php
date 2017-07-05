@extends('layouts.app')
@section('content')
<div class = "container-fluid">
	<div  class = "row">
		<div class = "col-md-10 col-md-offset-1">
			<div class = "panel default-panel">
				<div class  = "panel-heading">
					<h3>Active Contracts<a href="{{route('contracts.create')}}" role = "button" class = "btn btn-success pull-right">Create New Contract</a></h3>
					<hr />
				</div>
				<div class = "panel-body">
					<table class = "table table-responsive" id = "contracts_table">
						<thead>
							<tr>
								<td>
									Contract Number
								</td>
								<td>
									Consignee
								</td>
								<td>
									Date Effective
								</td>
								<td>
									Termination Date
								</td>
								<td>
									Created At
								</td>
								<td>
									Action
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
.contracts
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
	$(document).ready(function(){
		var chtable = $('#contracts_table').DataTable({
			processing: true,
			scrollX: true,
			serverSide: true,
			ajax: "{{ route('contract.data') }}",
			columns: [
			{ data: 'id' },
			{ data: 'companyName' },
			{ data: 'dateEffective' },
			{ data: 'dateExpiration' },
			{ data: 'created_at' },
			{ data: 'action', orderable: false, searchable: false }
			]
		});

		$(document).on('click', '.view-contract-details', function(e){
			var contract_id = $(this).val();
			window.location.replace("{{route('contracts.index') }}/" + contract_id + "/view"); 
		})
	})
</script>
@endpush