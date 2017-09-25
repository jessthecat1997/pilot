@extends('layouts.app')
@section('content')
<h2>&nbsp;Contracts</h2>
<hr>
<div class="pull-right">
	<a href="{{route('contracts.create')}}" role = "button" class = "btn but pull-right">Create New Contract</a>
</div>
<br/>
<br/>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				List of Contracts
			</div>
			<div class="panel-body">
				<table class = "table-responsive table" id="contracts_table">
					<thead>
						<tr>
							<th>
								Contract No.
							</th>
							<th>
								Consignee
							</th>
							<th>
								Date Effective
							</th>
							<th>
								Termination Date
							</th>
							<th>
								Status
							</th>
							<th>
								Created At
							</th>
							<th>
								Action
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
	.contracts
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
	$(document).ready(function(){
		var chtable = $('#contracts_table').DataTable({
			processing: false,
			deferRender: true,
			serverSide: false,
			ajax: "{{ route('contract.data') }}",
			columns: [
			{ data: 'id' },
			{ data: 'companyName' },
			{ data: 'dateEffective' },
			{ data: 'dateExpiration' },
			{ data: 'status' },
			{ data: 'created_at' },
			{ data: 'action', orderable: false, searchable: false }
			]
		});

		$(document).on('click', '.update-draft', function(e){
			var contract_id = $(this).val();
			window.location.replace("{{ route('contracts.index')}}/" + $(this).val() + "/draft");
		})

		$(document).on('click', '.view-contract-details', function(e){
			var contract_id = $(this).val();
			window.location.replace("{{route('contracts.index') }}/" + contract_id + "/view"); 
		})

		$(document).on('click', '.amend-contract', function(e){
			e.preventDefault();
			window.location.replace("{{ route('contracts.index')}}/" + $(this).val() + "/amend");
		})

		$(document).on('click', '.print-contract-details', function(e){
			e.preventDefault();
			window.open("{{ route('trucking.index') }}/contracts/" + $(this).val() + "/agreement_pdf");
		})
	})
</script>
@endpush