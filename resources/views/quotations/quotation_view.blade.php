@extends('layouts.app')

@section('content')
<div class = "row">
	<div class  = "col-md-10 col-md-offset-1">
		<div class = "panel default-panel">
			<div class = "panel-heading">
				<h2>&nbsp;View Quotation <button class="btn btn-md btn-primary pull-right generate_pdf print-quotation-details">Print Quotation</button></h2>
				<hr />
			</div>
			<div class = "panel-body">
				<div class = "col-md-6">
					<h3>Quotation Information</h3>
					<hr />
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label class="control-label col-sm-5" for="contactNumber">Contract #:</label>
							<label class="control-label col-sm-7" for="address" style = "text-align: left;">{{ $quotation[0]->id }}</label>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-5" for="contactNumber">Consignee:</label>
							<label class="control-label col-sm-7" for="address" style = "text-align: left;">{{ $quotation[0]->name }}</label>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-5" for="contactNumber">Company Name:</label>
							<label class="control-label col-sm-7" for="address" style = "text-align: left;">{{ $quotation[0]->companyName }}</label>
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
				<h3>Area Rates</h3> 
				<table class = "table table-striped table-responsive"> 
					<thead> 
						<tr> 
							<td> 
								<h4>Origin</h4> 
							</td> 
							<td> 
								<h4>Destination</h4> 
							</td> 
							<td> 
								<h4>Size</h4> 
							</td>
							<td> 
								<h4>Amount</h4> 
							</td> 
						</tr> 
					</thead> 
					@forelse($quotation_details as $quotation_detail) 
					<tr> 
						<td> 
							{{ $quotation_detail->from }} 
						</td> 
						<td> 
							{{ $quotation_detail->to }} 
						</td>
						<td> 
							{{ $quotation_detail->name }} 
						</td> 
						<td> 
							Php {{ $quotation_detail->amount }} 
						</td> 
						
					</tr> 
					@empty 
					<tr> 
						<td colspan="3"> 
							<h5 style="text-align: center;">No records available.</h5> 
						</td> 
					</tr> 
					@endforelse 
				</table> 
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
					@if($quotation[0]->specificDetails == null)
					<h5 style="text-align: center;">No specified details</h5>
					@else
					<p><pre class = "">{!! $quotation[0]->specificDetails !!}</pre></p>

					@endif	
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style>
	.quotation
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
	$(document).on('click', '.print-quotation-details', function(e){
		e.preventDefault();
		window.open("{{ route('quotation.index') }}/" + {{ $quotation[0]->id }} + "/print");
	})
</script>
@endpush