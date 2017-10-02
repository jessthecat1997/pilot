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
					<tbody>
						@forelse($contract_headers as $con_head)
						<tr>
							<td>
								{{ $con_head->id }}
							</td>
							<td>
								{{ $con_head->companyName }}
							</td>
							<td>
								{{ $con_head->dateEffective ? with(new Carbon\Carbon ($con_head->dateEffective))->format("F d, Y") : 'Pending' }}
							</td>
							<td>
								{{ $con_head->dateExpiration ? with(new Carbon\Carbon ($con_head->dateExpiration))->format("F d, Y")  : 'Pending' }}
							</td>
							<td>
								@if($con_head->isFinalize == 1)

								@if(Carbon\Carbon::now()->between(Carbon\Carbon::parse($con_head->dateEffective), Carbon\Carbon::parse($con_head->dateExpiration)))
								Active

								@elseif(Carbon\Carbon::parse($con_head->dateEffective)->isPast())
								Expire
								@elseif(Carbon\Carbon::parse($con_head->dateEffective)->isFuture())
								Inactive
								@else
								Expire
								@endif

								@else
								
								Draft
								
								@endif
							</td>
							<td>
								{{ Carbon\Carbon::parse($con_head->created_at)->format("F d, Y") }}
							</td>
							<td>
								@if($con_head->isFinalize == 1)

								<button value = "{{ $con_head->id }}" class = "btn btn-md but view-contract-details">View</button>
								<button value = "{{ $con_head->id }}" class = "btn btn-md btn-primary amend-contract">Amend</button>
								<button value = "{{ $con_head->id }}" class = "btn btn-md btn-success print-contract-details">Print</button>

								@else
								<button value = "{{ $con_head->id }}" class = "btn btn-md btn-primary update-draft">Update</button>
								@endif
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
			//ajax: "{{ route('contract.data') }}",
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