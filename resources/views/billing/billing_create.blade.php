@extends('layouts.app')
@section('content')
<h2>&nbsp;Billing</h2>
<div class="pull-left">
	<a href="/billing/{{ $so_head_id }}" class="btn but">Back</a>
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
						<td class = "success" id="so_head_id"><strong>{{ $bill->id }}</strong></td>
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
	<button type="button" class="btn but pull-right" data-toggle="modal" data-target="#revModal">New Bill</button>
	<br/>
	<br/>
	<br/>
	<div class="row collapse in" id="bill_collapse">
		<div class="panel-default col-sm-6">
			<div class="panel-heading" id="heading">List of Revenues</div>
			<div class="panel-body">
				<table class = "table-responsive table" id = "revTable">
					<thead>
						<tr>
							<td>
								Name
							</td>
							<td>
								Description
							</td>
							<td>
								Amount
							</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
		<div class="panel-default col-sm-6">
			<div class="panel-heading" id="heading">List of Expenses</div>
			<div class="panel-body">
				<table class = "table-responsive table" id = "expTable">
					<thead>
						<tr>
							<td>
								Name
							</td>
							<td>
								Description
							</td>
							<td>
								Amount
							</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<div id="revModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">New Revenue</h4>
				</div>
				<div class="modal-body">
					<div class="col-sm-12">
						<div class="col-sm-3">
							<div class="form-group">
								<label for="vat">Vat Rate:</label>
								<input type="text" class="form-control" id="vat" value="{{ $vat[0]->rates }}">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label for="date_billed">Date Billed:</label>
								<input type="date" class="form-control" id="date_billed">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label for="due_date">Due Date:</label>
								<input type="date" class="form-control" id="due_date">
							</div>
						</div>
					</div>
					<table class = "table-responsive table" id = "rev_table">
						<thead>
							<tr>
								<td colspan="5">
									<button class = "btn but btn-md new-rev-row pull-right">Add Bill</button>
								</td>
							</tr>
							<tr>
								<td>
									Name *
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
							<tr id = "revenue-row" name="revenue-row">
								<form class="form-horizontal">
									{{ csrf_field() }}
									<td>
										<select id = "rev_bill_id" name="rev_bill_id" class = "form-control select2-allow-clear select2">
											<option value = "0">Select Charges</option>
											@forelse($bill_revs as $rev)
											<option value = "{{ $rev->id }}">{{ $rev->name }}</option>

											@empty

											@endforelse
										</select>
									</td>
									<td>
										<input type = "text" name = "rev_amount" id="rev_amount" class = "form-control" style="text-align: right">
									</td>
									<td>
										<input type = "text" name = "rev_tax" class = "form-control" style="text-align: right">
									</td>
									<td>
										<button class = "btn btn-danger btn-md delete-billing-row">Remove</button>
									</td>
									<tr id="desc_rev_row">
										<td colspan="4">
											<div class="form-group">
												<label for="rev_description">Description:</label>
												<textarea class="form-control" rows="3" id="rev_description" name="rev_description"></textarea>
											</div>
										</td>
									</tr>
								</form>
							</tr>
						</tbody>
					</table>
					<strong>Note:</strong> All fields with * are required.
				</div>
				<div class="modal-footer">
					<a class="btn but finalize-rev">Save</a>
				</div>
			</div>
		</div>
	</div>
	<br>
</div>
@endsection
@push('styles')
<style>
	.class-billing
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
<link href= "/js/select2/select2.css" rel = "stylesheet">
@push('scripts')
<script  type = "text/javascript" charset = "utf8" src="/js/select2/select2.full.js"></script>
<script type="text/javascript">
	$('#collapse1').addClass('in');
	var so_head_id = document.getElementById ( "so_head_id" ).innerText
	var rev_bill_id = [];
	var rev_description_value = [];
	var	rev_amount_value = [];
	var	rev_tax_value = [];

	var exp_bill_id = [];
	var	exp_description_value = [];
	var	exp_amount_value = [];
	var	exp_tax_value = [];


	var rev_row = "<tr>" + $('#revenue-row').html() + "</tr>";
	var exp_row = "<tr>" + $('#expense-row').html() + "</tr>";
	var desc_rev_row =  "<tr>" + $('#desc_rev_row').html() + "</tr>";
	var desc_exp_row =  "<tr>" + $('#desc_exp_row').html() + "</tr>";

	var so_type = $('#so_type').text();


	$(document).ready(function(){
		$('#rev_bill_id').select2(); 
		$(document).on('change', '#rev_bill_id', function(e){
			revID = $('#rev_bill_id').val();
			if($('#rev_bill_id').val() != 0){
				$.ajax({
					type: 'GET',
					url: "/charge/"+ $('#rev_bill_id').val() + "/getCharge",
					data: {
						'_token' : $('input[name=_token]').val(),
					},
					success: function(data){
						if(typeof(data) == "object"){
							console.log(data[0].amount);
							$('#rev_amount').val(data[0].amount);
						}
					},
					error: function(data) {
						if(data.status == 400){
							alert("Nothing found");
						}
					}
				})
			}
			else
			{
				$('amount').val("");
			}
		})
	})
	$(document).on('click', '.new-rev-row', function(e){
		e.preventDefault();
		$('#rev_table > tbody').append(rev_row);
		$('#rev_table > tbody').append(desc_rev_row);
	})

	$(document).on('click', '.new-exp-row', function(e){
		e.preventDefault();
		$('#exp_table > tbody').append(exp_row);
		$('#exp_table > tbody').append(desc_exp_row);
	})

	$(document).on('click', '.finalize-rev', function(e){
		if(validateRevenueRows() === true){
			console.log(rev_bill_id);
			console.log(rev_amount_value);
			console.log(rev_description_value);
			console.log(rev_tax_value);
			$.ajax({
				method: 'POST',
				url: '{{ route("billing.store") }}',
				data: {
					'_token' : $('input[name=_token]').val(),
					'so_head_id' : {{ $bills[0]->id }},
					'vatRate' : $('#vat').val(),
					'status' : 'U',
					'date_billed' : $('#date_billed').val(),
					'override_date' : $('#override_date').val(),
					'due_date' : $('#due_date').val(),
					'charge_id' : rev_bill_id,
					'description' : rev_description_value,
					'amount' : rev_amount_value,
					'tax' : rev_tax_value,
					'bi_head_id' : {{ $bills[0]->id }},
				},
				success: function (data){
					location.reload();
					var rc_table = $('#revTable').DataTable({
						processing: false,
						serverSide: true,
						ajax: "{{ route('revenue.data',$so_head_id) }}",
						columns: [
						{ data: 'name' },
						{ data: 'description' },
						{ data: 'amount' }
						]
					})
					var br_table = $('#expTable').DataTable({
						processing: false,
						serverSide: true,
						ajax: "{{ route('expenses.data', $so_head_id) }}",
						columns: [
						{ data: 'name' },
						{ data: 'description' },
						{ data: 'amount' }
						]
					})
				}
			})
		}
	})
	function validateRevenueRows()
	{
		rev_bill_id = [];
		rev_description_value = [];
		rev_amount_value = [];
		rev_tax_value = [];

		rev_billID = document.getElementsByName('rev_bill_id');
		rev_description = document.getElementsByName('rev_description');
		rev_amount = document.getElementsByName('rev_amount');
		rev_tax = document.getElementsByName('rev_tax');


		error = "";

		for(var i = 0; i < rev_billID.length; i++){

			if(rev_billID[i].value === "")
			{
				rev_billID[i].style.color = 'red';	
				error += "Bill ID is required.";
			}

			else
			{
				rev_bill_id.push(rev_billID[i].value);
			}
			rev_description_value.push(rev_description[i].value);
			if(rev_amount[i].value === "")
			{
				rev_amount[i].style.color = 'red';
				error += "Amount Required.";
			}

			else
			{
				rev_amount_value.push(rev_amount[i].value);
			}
			if(rev_tax[i].value === "")
			{
				rev_tax[i].style.color = 'red';
				error += "Tax Required.";
			}

			else
			{
				rev_tax_value.push(rev_tax[i].value);
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
	function validateExpenseRows()
	{
		exp_bill_id = [];
		exp_description_value = [];
		exp_amount_value = [];
		exp_tax_value = [];

		exp_billID = document.getElementsByName('exp_bill_id');
		exp_description = document.getElementsByName('exp_description');
		exp_amount = document.getElementsByName('exp_amount');
		exp_tax = document.getElementsByName('exp_tax');


		error = "";

		for(var i = 0; i < exp_billID.length; i++){

			if(exp_billID[i].value === "")
			{
				exp_billID[i].style.color = 'red';	
				error += "Bill ID is required.";
			}

			else
			{
				exp_bill_id.push(exp_billID[i].value);
			}
			exp_description_value.push(exp_description[i].value);
			if(exp_amount[i].value === "")
			{
				exp_amount[i].style.color = 'red';
				error += "Amount Required.";
			}

			else
			{
				exp_amount_value.push(exp_amount[i].value);
			}
			if(exp_tax[i].value === "")
			{
				exp_tax[i].style.color = 'red';
				error += "Tax Required.";
			}

			else
			{
				exp_tax_value.push(exp_tax[i].value);
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