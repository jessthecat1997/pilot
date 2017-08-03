@extends('layouts.app')
@section('content')
<h3><img src="/images/bar.png"> Billing</h3>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<div class="col-sm-12">
					<form class="form-horizontal col-sm-12">
						{{ csrf_field() }}
						<div class="form-group">
							<label class="control-label col-sm-2">ID: </label> 
							@forelse($bills as $bill)
							<label class="control-label col-sm-3" id="so_head_id"><strong>{{ $bill->id }}</strong></label>
							@empty
							@endforelse
						</div>
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
						<div class="form-group">
							<label class="control-label col-sm-2">Payment Allowance (day/s): </label>
							<div class="col-sm-3"> 
								<input type="text" class="form-control" name="paymentAllowance" id="paymentAllowance" required>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>