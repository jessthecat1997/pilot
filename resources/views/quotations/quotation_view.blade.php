@extends('layouts.app')
@section('content')
<h2>&nbsp;Quotations</h2>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class="col-lg-5">
			<div class="panel panel-primary">
				<div class="panel-heading">Quotation Information</div>
				<div class="panel-body">
					<div class="form-group">
						<label>Contract #:</label>
						<input type="text" class="det" value="{{ $quotation[0]->id }}" id="companyName" disabled>
					</div>
					<div class="form-group">
						<label>Consignee:</label>
						<input type="text" class="det" value="{{ $quotation[0]->name }}" id="consignee" disabled>
					</div>
					<div class="form-group">
						<label>Company Name:</label>
						<input type="text" class="det" value="{{ $quotation[0]->companyName }}" id="sotype" disabled>
					</div>
					<hr>
					<button class="btn btn-md btn-primary pull-left generate_pdf print-quotation-details">Print Quotation</button></h2>
				</div>
			</div>
		</div>
		<div class="col-lg-7">
			<div class="panel panel-primary">
				<div class="panel-heading">Area Rates</div>
				<div class="panel-body">
					<table class = "table table-striped table-responsive" id = "area_rate_table"> 
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
							<td> 
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
					</table> 
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">Terms & Conditions</div>
				<div class="panel-body">
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
		$(document).on('click', '.print-quotation-details', function(e){
			e.preventDefault();
			window.open("{{ route('quotation.index') }}/" + {{ $quotation[0]->id }} + "/print");
		})

		$('#area_rate_table').DataTable({
			processing: false,
			deferRender: true,
			serverSide: false,
		});
	})
</script>
@endpush