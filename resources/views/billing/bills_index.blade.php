@extends('layouts.app')
@section('content')
<h3><img src="/images/bar.png"> Billing</h3>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel">
			<div class="panel-heading" id="heading">Consignee Details</div>
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
					</form>
				</div>
			</div>
		</div>
		<hr>
		<div class="panel-default panel collapse" id="del_collapse">
			<div class="panel-heading" id="heading">Delivery Bill</div>
			<div class="panel-body">
				<table class="table-responsive table-hover">
					<thead>
						<tr>
							<td>
								Charges
							</td>
							<td>
								Amount
							</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							@forelse($delivery as $del)
							<td>
								{{ $del->description }}
							</td>
							@empty
							@endforelse
							@forelse($delivery as $del)
							<td>
								{{ $del->amount }}
							</td>
							@empty
							@endforelse
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="panel-default panel">
			<div class="panel-heading" id="heading">New Bill</div>
			<div class="panel-body">
				<div class="collapse in" id="new_bill_collapse">
					<div class="form-group col-sm-12">
						<label class="control-label col-sm-3">Payment Allowance (day/s): </label>
						<div class="col-sm-6"> 
							<input type="text" class="form-control" name="paymentAllowance" id="paymentAllowance" required>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<label class="control-label col-sm-3">Vat Rate (%): </label>
						<div class="col-sm-6"> 
							<input type="text" class="form-control" name="vat" id="vat" required>
						</div>
					</div>
					<table class="table responsive table-hover" width="100%" id="billing_parent_table" style = "overflow-x: scroll;">
						<thead>
							<tr>
								<td>
									Description *
								</td>
								<td>
									Amount *
								</td>
								<td>
									Discount *
								</td>
								<td>
									Action
								</td>
							</tr>
						</thead>
						<tbody>
							<tr id = "billing-row" name="billing-row">
								<form class="form-horizontal">
									{{ csrf_field() }}
									<td>
										<select name = "bill_id" class = "form-control ">
											<option>

											</option>
											@forelse($billings as $billing)
											<option value = "{{ $bill->id }}">
												{{ $billing->name }}
											</option>
											@empty

											@endforelse
										</select>
									</td>

									<td>
										<input type = "text" name = "amount" class = "form-control" style="text-align: right">

									</td>
									<td>
										<input type = "text" name = "discount" class = "form-control" style="text-align: right">

									</td>
									<td>
										<button class = "btn btn-info btn-md new-billing-row">Add Row</button>
										<button class = "btn btn-danger btn-md delete-billing-row">Remove</button>
									</td>
								</form>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="form-group col-sm-6">
					<a class="btn btn-info finalize-billing col-sm-6">Save</a>
				</div>
				<!-- <div class="row collapse" id="billings_collapse">
					<table class = "table-responsive table" id="bill_table">
						<thead>
							<tr>
								<td>
									<strong>Description</strong>
								</td>
								<td>
									<strong>Amount</strong>
								</td>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<div class="form-group">
						<label class="control-label col-sm-2">Total: </label>
						<div class="col-sm-3"> 
							
						</div>
					</div>
					<div class="form-group col-sm-12">
						<a href="{{ route('payment.index') }}" class="btn btn-info col-sm-6">Proceed to Payment</a>
					</div>
				</div> -->
				<!-- end ng payment allowance -->
			</div>
		</div>
		<hr>
		<div class="panel-default panel">
			<div class="panel-heading" id="heading">New Refundable Charges</div>
			<div class="panel-body">
				<table class="table responsive table-hover" width="100%" id="charge_parent_table" style = "overflow-x: scroll;">
					<thead>
						<tr>
							<td>
								Charges *
							</td>
							<td>
								Description *
							</td>
							<td>
								Amount *
							</td>
							<td>
								Action
							</td>
						</tr>
					</thead>
					<tbody>
						<tr id = "charge-row" name="charge-row">
							<form class="form-horizontal">
								{{ csrf_field() }}
								<td>
									<select name = "charge_id" class = "form-control ">
										<option>

										</option>
										@forelse($charges as $ch)
										<option value = "{{ $ch->id }}">
											{{ $ch->description }}
										</option>
										@empty

										@endforelse
									</select>
								</td>

								<td>
									<input type = "text" name = "rc_description" class = "form-control" style="text-align: right">

								</td>
								<td>
									<input type = "text" name = "rc_amount" class = "form-control" style="text-align: right">

								</td>
								<td>
									<button class = "btn btn-info btn-md new-billing-row">Add Row</button>
									<button class = "btn btn-danger btn-md delete-billing-row">Remove</button>
								</td>
							</form>
						</tr>
					</tbody>
				</table>
				<div class="form-group col-sm-6">
					<a class="btn btn-info finalize-ref col-sm-6">Save</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style>
	.class-billing
	{
		border-left: 10px solid #3ce28e;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	$('#collapse1').addClass('in');
	var so_head_id = $('#so_head_id').text();
	var bill_id = [];
	var	amount_value = [];
	var	discount_value = [];

	var charge_id = [];
	var	rc_amount_value = [];
	var	rc_description_value = []


	var billing_row = "<tr>" + $('#billing-row').html() + "</tr>";
	var charge_row = "<tr>" + $('#charge-row').html() + "</tr>";

	var so_type = $('#so_type').text();
	$(document).ready(function(){
		if(so_type === 'Trucking')
		{
			$('#del_collapse').addClass('in');
		}
	})

	$(document).on('click', '.new-billing-row', function(e){
		e.preventDefault();
		$('#billing_parent_table > tbody').append(billing_row);
	})

	$(document).on('click', '.new-charge-row', function(e){
		e.preventDefault();
		$('#charge_parent_table > tbody').append(charge_row);
	})

	$(document).on('click', '.finalize-billing', function(e){
		if(validateContractRows() === true){
			console.log(bill_id);
			console.log(amount_value);
			console.log(discount_value);
			$.ajax({
				method: 'POST',
				url: '{{ route("billing.store") }}',
				data: {
					'_token' : $('input[name=_token]').val(),
					'so_head_id' : so_head_id,
					'paymentAllowance' : $('#paymentAllowance').val(),
					'vatRate' : $('#vat').val(),
					'billings_id' : bill_id,
					'amount' : amount_value,
					'discount' : discount_value,
					'bi_head_id' : $('#soHead_id').val(),
				},
				success: function (data){
					$('#billings_collapse').addClass('in');
					window.location.href = '{{ route("view.index") }}/{{ $bill->id }}/show_pdf';
				}
			})
		}
	})
	$(document).on('click', '.finalize-ref', function(e){
		if(validateContractRows() === true){
			console.log(bill_id);
			console.log(amount_value);
			console.log(discount_value);
			$.ajax({
				method: 'POST',
				url: '{{ route("billing.store") }}',
				data: {
					'_token' : $('input[name=_token]').val(),
					'so_head_id' : so_head_id,
					'paymentAllowance' : $('#paymentAllowance').val(),
					'vatRate' : $('#vat').val(),
					'billings_id' : bill_id,
					'amount' : amount_value,
					'discount' : discount_value,
					'bi_head_id' : $('#soHead_id').val(),
				},
				success: function (data){
					$('#billings_collapse').addClass('in');
					window.location.href = "/billing/{billing_id}/show_pdf";
				}
			})
		}
	})
	function validateContractRows()
	{
		bill_id = [];
		amount_value = [];
		discount_value = [];

		billID = document.getElementsByName('bill_id');
		discount = document.getElementsByName('discount');
		amount = document.getElementsByName('amount');
		

		error = "";

		for(var i = 0; i < billID.length; i++){

			if(billID[i].value === "")
			{
				billID[i].style.color = 'red';	
				error += "Bill ID Required.";
			}

			else
			{
				bill_id.push(billID[i].value);
			}
			if(discount[i].value === "")
			{
				discount[i].style.color = 'red';
				error += "Discount Required.";
			}

			else
			{
				discount_value.push(discount[i].value);
			}
			if(amount[i].value === "")
			{
				amount[i].style.color = 'red';
				error += "Amount Required.";
			}

			else
			{
				amount_value.push(amount[i].value);
			}

		}

		if(error.length == 0){
			return true;
		}

		else
		{
			return false;
		}

	}
</script>
@endpush