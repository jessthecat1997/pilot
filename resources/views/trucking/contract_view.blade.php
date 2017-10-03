@extends('layouts.app')
@section('content')
<h2>&nbsp;Contract</h2>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">Contract Information</div>
				<div class="panel-body">
					<div class="form-group">
						<label>Contract #:</label>
						<input type="text" class="det" value="{{ $contract[0]->id }}" id="companyName" disabled>
					</div>
					<div class="form-group">
						<label>Consignee:</label>
						<input type="text" class="det" value="{{ $contract[0]->name }}" id="consignee" disabled>
					</div>
					<div class="form-group">
						<label>Company Name:</label>
						<input type="text" class="det" value="{{ $contract[0]->companyName }}" id="sotype" disabled>
					</div>
					<div class="form-group">
						<label>Date Effective:</label>
						<input type="text" class="det" value="{{ Carbon\Carbon::parse($contract[0]->dateEffective)->toFormattedDateString() }}" id="sotype" disabled>
					</div>
					<div class="form-group">
						<h5 id="address"><strong>Date Expiration:</strong> {{ Carbon\Carbon::parse($contract[0]->dateExpiration)->toFormattedDateString() }}, ({{ Carbon\Carbon::parse($contract[0]->dateExpiration)->diffForHumans() }})</h5>
					</div>
					<hr>
					<button class="btn btn-md btn-primary pull-right generate_pdf print-contract-details">Print Contract</button>
				</div>
			</div>
		</div>
	</div>
	@if($contract[0]->quot_head_id != null && count($quotation_details)> 0)
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">Contract Quotation</div>
				<div class="panel-body">
					<table class="table table-responsive table-bordered table-striped" id = "quot_table">
						<thead> 
							<tr> 
								<th> 
									Origin
								</th> 
								<th> 
									Destination
								</th> 
								<th> 
									Size 
								</th>
								<th> 
									Amount
								</th> 
							</tr> 
						</thead>
						<tbody>
							@forelse($quotation_details as $quotation_detail) 
							<tr> 
								<td> 
									{{ $quotation_detail->_from }} 
								</td> 
								<td> 
									{{ $quotation_detail->_to }} 
								</td>
								<td> 
									{{ $quotation_detail->sizes }} 
								</td> 
								<td style="text-align: right;"> 
									Php {{ $quotation_detail->amount }} 
								</td> 
							</tr> 
							@empty 
							<tr> 
								<td colspan="4"> 
									<h5 style="text-align: center;">No records available.</h5> 
								</td> 
							</tr> 
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@endif
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">Terms &amp; Conditions</div>
				<div class="panel-body">
					@if($contract[0]->specificDetails == null)
					<h5 style="text-align: center;">No specified details</h5>
					@else
					<p><pre class = "">{!! $contract[0]->specificDetails !!}</pre></p>
					@endif
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
	border-left: 10px solid #8ddfcc;
	background-color:rgba(128,128,128,0.1);
	color: #fff;
}
</style>
@endpush

@push('scripts')
<script type="text/javascript">
	$('#collapse1').addClass('in');
	$(document).on('click', '.print-contract-details', function(e){
		e.preventDefault();
		window.open("{{ route('trucking.index') }}/contracts/" + {{ $contract[0]->id }} + "/agreement_pdf");
	})

	@if($contract[0]->quot_head_id != null)
	$('#quot_table').DataTable();
	@endif
</script>
@endpush