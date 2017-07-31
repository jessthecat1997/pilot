@extends('layouts.app')
@section('content')
<h3><img src="/images/bar.png"> Billing</h3>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel collapse in" id="so_collapse">
			<div class = "panel-body">
				<div>
					<h3>Select Service Order</h3>
					<table class = "table-responsive table" id = "so_head_table">
						<thead>
							<tr>
								<td>
									ID
								</td>
								<td>
									Consignee
								</td>
								<td>
									Status
								</td>
								<td>
									Date Created
								</td>
								<td>
									Actions
								</td>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div id="bill_collapse" class="collapse">
		<div class="row">
			<div class = "panel-default panel">
				<div class = "panel-body">
					<form class="form-horizontal">
						{{ csrf_field() }}
						<div class="form-group">
							<label class="control-label col-sm-2">Consignee: </label>
							<div class="col-sm-10"> 
								<input type="text" class="form-control" name="consigneeName" id="consigneeName" required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">Payment Allowance (day/s): </label>
							<div class="col-sm-10"> 
								<input type="text" class="form-control" name="paymentAllowance" id="paymentAllowance" required>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="row">
			<div class = "panel-default panel">
				<div class = "panel-body">
					<h3>Bills</h3>
					<table class="table responsive table-hover" width="100%" id= "billing_parent_table" style = "overflow-x: scroll;">
						<thead>
							<tr>
								<td>
									Description
								</td>
								<td>
									Amount
								</td>
								<td>
									Discount
								</td>
								<td>
									Action
								</td>
							</tr>
						</thead>
						<tr id = "billing-row" name="billing-row">
							<form class="form-horizontal">
								{{ csrf_field() }}
								<td>
									<select name = "bill_id" class = "form-control ">
										<option>

										</option>
										@forelse($billings as $bill)
										<option value = "{{ $bill->id }}">
											{{ $bill->description }}
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
									<button class = "btn btn-success btn-md new-billing-row">New Bill</button>
									<button class = "btn btn-danger btn-md delete-billing-row">Remove</button>
								</td>
							</form>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12"> 
				<button class="btn btn-info form-control finalize-billing" id="btnSave">Generate Billing Invoice</button>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style>
	.class-billing
	{
		border-left: 10px solid #2ad4a5;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
$('#collapse1').addClass('in');

	var data;
	var so_head_id;
	var bill_id = [];
	var	amount_value = [];
	var	discount_value = [];

	var billing_row = "<tr>" + $('#billing-row').html() + "</tr>";


	$(document).ready(function(){
		var vtable = $('#so_head_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{ route("so_head.data") }}',
			columns: [
			{ data: 'id' },
			{ data: 'companyName' },
			{ data: 'paymentStatus' },
			{ data: 'created_at'},
			{ data: 'action', orderable: false, searchable: false }
			]
		})

		$(document).on('click', '.selectConsignee' ,function(e){
			$('#so_collapse').removeClass('in');
			$('#bill_collapse').addClass('in');
			data = vtable.row($(this).parents()).data();
			so_head_id = $(this).val();
			$('#consigneeName').val(data.companyName);
			$('#companyName').val(data.companyName);
		})


		$(document).on('click', '.new-billing-row', function(e){
			e.preventDefault();
			$('#billing_parent_table:last-child').append(billing_row);
		})


		$(document).on('click', '.finalize-billing', function(e){
			if(validateContractRows() === true){
				console.log(bill_id);
				console.log(amount_value);
				console.log(discount_value);
				$.ajax({
					method: 'POST',
					url: '{{ route("billingdetails.store") }}',
					data: {
						'_token' : $('input[name=_token]').val(),
						'so_head_id' : so_head_id,
						'paymentAllowance' : $('#paymentAllowance').val(),
						'billings_id' : bill_id,
						'amount' : amount_value,
						'discount' : discount_value,
						'bi_head_id' : $('#soHead_id').val(),
					},

					success: function (data){

					}
				})
			}
			
		})
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

	function resetErrors() {
		$('form input, form select').removeClass('inputTxtError');
		$('label.error').remove();
	}
</script>
@endpush