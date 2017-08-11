@extends('layouts.app')
@section('content')
<h3><img src="/images/bar.png"> Billing</h3>
<div class="pull-left">
	<a href="/billing/{{ $so_head_id }}" class="btn btn-info">Back</a>
</div>
<br/>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel">
			<div class="panel-heading" id="heading">Consignee Details</div>
			<table class="table">
				<tbody>
					<tr>
						<td class="active"><strong>No.: </strong></td>
						@forelse($bills as $bill)
						<td class = "success" id="consignee"><strong>{{ $bill->id }}</strong></td>
						@empty
						@endforelse
					</tr>
					<tr>
						<td class="active"><strong>Consignee: </strong></td>
						@forelse($bills as $bill)
						<td class = "success" id="consignee"><strong>{{ $bill->companyName }}</strong></td>
						@empty
						@endforelse
					</tr>
					<tr>
						<td class="active"><strong>Address: </strong></td>
						@forelse($bills as $bill)
						<td class="success" id="address"><strong>{{ $bill->address }}</strong></td>
						@empty
						@endforelse
					</tr>
					<tr>
						<td class="active"><strong>Service Order: </strong></td>
						@forelse($bills as $bill)
						<td class="success" id="sotype"><strong>{{ $bill->name }}</strong></td>
						@empty
						@endforelse
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<hr>
	<div class="row">
		<table class="table">
			<tbody>
				<tr>
					<td style="width: 20%">
						<strong>Vat Rate:</strong>
					</td>
					<td style="width: 30%">
						<input type="text" class="form-control" name="vat" id="vat" required>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="row collapse in" id="bill_collapse">
		<div class="panel-default col-sm-6">
			<div class="panel-heading" id="heading">Add Revenues</div>
			<div class="panel-body">
				<table class = "table-responsive table" id = "rev_table">
					<thead>
						<tr>
							<td colspan="5">
								<button class = "btn btn-info btn-md new-billing-row pull-right">New Revenue</button>
							</td>
						</tr>
						<tr>
							<td>
								Name *
							</td>
							<td>
								Description *
							</td>
							<td>
								Amount *
							</td>
							<td>
								Tax *
							</td>
							<td>
								Action
							</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
		<div class="panel-default col-sm-6">
			<div class="panel-heading" id="heading">Add Expenses</div>
			<div class="panel-body">
				<table class = "table-responsive table" id = "exp_table">
					<thead>
						<tr>
							<td colspan="5">
								<button class = "btn btn-info btn-md new-billing-row pull-right">New Expense</button>
							</td>
						</tr>
						<tr>
							<td>
								Name *
							</td>
							<td>
								Description *
							</td>
							<td>
								Amount *
							</td>
							<td>
								Tax *
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
	<div class="row">
		<div class = "panel-default panel">
			<div class="panel-heading" id="heading">Add Revenue</div>
			<div class="panel-body">
				<table class="table responsive table-hover" width="100%" id="billing_parent_table" style = "overflow-x: scroll;">
					<thead>
						<tr>
							<td>
								Name *
							</td>
							<td>
								Description *
							</td>
							<td>
								Amount *
							</td>
							<td>
								Tax *
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
									<button class = "btn btn-danger btn-md delete-billing-row">Remove</button>
								</td>
							</form>
						</tr>
					</tbody>
				</table>
				<div class="form-group col-sm-6">
					<a class="btn btn-info finalize-billing col-sm-6">Save</a>
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