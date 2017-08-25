@extends('layouts.app')

@section('content')
<div class = "row">
	<div class  = "col-md-10 col-md-offset-1">
		<div class = "panel default-panel">
			<div class = "panel-heading">
				<h2>&nbsp;View Contract<button class="btn btn-md btn-primary pull-right generate_pdf print-contract-details">Print Contract</button></h2>
				<hr />
			</div>
			<div class = "panel-body">
				<div class = "col-md-6">
					<h3>Contract Information</h3>
					<hr />
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label class="control-label col-sm-5" for="contactNumber">Contract #:</label>
							<label class="control-label col-sm-7" for="address" style = "text-align: left;">{{ $contract[0]->id }}</label>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-5" for="contactNumber">Consignee:</label>
							<label class="control-label col-sm-7" for="address" style = "text-align: left;">{{ $contract[0]->name }}</label>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-5" for="contactNumber">Company Name:</label>
							<label class="control-label col-sm-7" for="address" style = "text-align: left;">{{ $contract[0]->companyName }}</label>
						</div>
						<div class="form-group">        
							<label class="control-label col-sm-5" for="contactNumber">Date Effective:</label>
							<label class="control-label col-sm-7" for="address" style = "text-align: left;">{{ Carbon\Carbon::parse($contract[0]->dateEffective)->toFormattedDateString() }}</label>
						</div>
						<div class="form-group">        
							<label class="control-label col-sm-5" for="contactNumber">Date Expiration:</label>
							<label class="control-label col-sm-7" for="address" style = "text-align: left;">{{ Carbon\Carbon::parse($contract[0]->dateExpiration)->toFormattedDateString() }}, ({{ Carbon\Carbon::parse($contract[0]->dateExpiration)->diffForHumans() }})</label>
						</div>
					</form>
				</div>
				
			</div>
		</div>
	</div>
</div>
<div class = "row">
	<div class  = "col-md-10 col-md-offset-1">
		<div class = "panel default-panel">
			<div class = "panel-body">
				<h3>Terms &amp; Conditions</h3>
				<hr />
				<div style = "overflow-y: scroll; overflow-wrap: none; height: 300px;" class="panel-default panel">
					@if($contract[0]->specificDetails == null)
					<h5 style="text-align: center;">No specified details</h5>
					@else
					<p><pre class = "">{!! $contract[0]->specificDetails !!}</pre></p>

					@endif
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
		pre {border: 0; background-color: transparent;}
	</style>
	@endpush

	@push('scripts')
	<script type="text/javascript">
		$(document).on('click', '.print-contract-details', function(e){
			e.preventDefault();
			window.open("{{ route('trucking.index') }}/contracts/" + {{ $contract[0]->id }} + "/agreement_pdf");
		})
	</script>
	@endpush