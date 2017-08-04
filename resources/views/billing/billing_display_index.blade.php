@extends('layouts.app')
@section('content')
<h3><img src="/images/bar.png"> Billing</h3>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel">
			<div class="panel-heading" id="heading"><h4>Billing Details</h4></div>
			<div class = "panel-body">
				<div class="col-sm-12">
					<form class="form-horizontal col-sm-6">
						{{ csrf_field() }}
						<div class="form-group">
							<label class="control-label col-sm-2">Consignee: </label>
							@forelse($bills as $bill)
							<label class="control-label col-sm-3" id="consignee"><strong>{{ $bill->companyName }}</strong></label>
							@empty
							@endforelse
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">Address: </label>
							@forelse($bills as $bill)
							<label class="control-label col-sm-3" id="address"><strong>{{ $bill->address }}</strong></label>
							@empty
							@endforelse
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">Service: </label>
							@forelse($bills as $bill)
							<label class="control-label col-sm-3" id="sotype"><strong>{{ $bill->description }}</strong></label>
							@empty
							@endforelse
						</div>
					</form>
					<div class=" form-group col-sm-6">
						<h4 class="control-label col-sm-4">Billing Invoice: </h4>
						@forelse($bill_counts as $b_count)
						<h4 class="control-label col-sm-3"><strong>{{ $b_count->count }}</strong></h4>
						@empty
						@endforelse
					</div>
					<div class="form-group col-sm-3">
						<a href='/bill_invoice/bill/{{ $bill->id }}' class="btn btn-info form-control col-sm-3 add_bill">New Bill</a>
					</div>
					<div class="form-group col-sm-3">
						<a href="/billing/{{ $bill->id }}/show_pdf" class="btn btn-info form-control col-sm-3">Generate Invoice</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<hr>
@endsection