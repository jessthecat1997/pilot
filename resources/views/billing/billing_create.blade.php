@extends('layouts.app')
@section('content')
<h2>&nbsp;Billing</h2>
<div class="pull-left">
	<a href="/billing/{{ $so_head_id }}" class="btn but">Back</a>
</div>
<br/>
<hr>
<div class="row col-md-5">
	<label>Invoice No.:</label>
	<input type="text" class="det" value="{{ $so_head_id }}" id="so_head_id">
</div>
<div class="row col-md-7">
	<div class="panel-default panel">
		<div class="panel-heading" id="heading">List of Revenues</div>
		<div class = "panel-body">
			<form class="form-inline">
				{{ csrf_field() }}
				<table class="table" id="revenue_table">
					<thead>
						<tr>
							<td colspan="2">
								<button type="button" class="btn but pull-right" data-toggle="modal" data-target="#revModal">Add Revenue</button>
							</td>
						</tr>
						<tr>
							<td style="text-align: center;">
								NAME
							</td>
							<td style="text-align: center;">
								AMOUNT
							</td>
						</tr>
					</thead>
					<tbody>
						@forelse($rev_bill as $bill)
						<tr>
							<td style="text-align: center;">{{ $bill->name }}</td>
							<td style="text-align: center;">Php&nbsp;{{ $bill->amount }}</td>
						</tr>
						@empty
						<tr>
							<td colspan="2" style="text-align: center;"><strong>No records available.</strong></td>
						</tr>
						@endforelse
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						@forelse($rev_vat as $vr)
						<tr>
							<td style="text-align: center;"><strong>{{ $vr->rates }}% VAT</strong></td>
							<td style="text-align: center;">Php&nbsp;{{ $vr->Total }}</td>
						</tr>
						@empty
						<tr>
							<td colspan="2">No records available.</td>
						</tr>
						@endforelse
						@forelse($rev_total as $rt)
						<tr>
							<td style="text-align: right;">
								<label for="bal"><strong>TOTAL: &nbsp;</strong></label>
							</td>
							<td style="text-align: center;">
								<h3>Php&nbsp;&nbsp;{{ $rt->Total }}</h3>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="2">No records available.</td>
						</tr>
						@endforelse
					</tbody>
				</table>
			</form>
		</div>
	</div>
</div>
<div class="row col-md-5">
</div>
<div class="row col-md-7">
	<div class="panel-default panel">
		<div class="panel-heading" id="heading">List of Expenses</div>
		<div class = "panel-body">
			<form class="form-inline">
				{{ csrf_field() }}
				<table class="table" id="expense_table">
					<thead>
						<tr>
							<td colspan="2">
								<button type="button" class="btn but pull-right" data-toggle="modal" data-target="#expModal">Add Expense</button>
							</td>
						</tr>
						<tr>
							<td style="text-align: center;">
								NAME
							</td>
							<td style="text-align: center;">
								AMOUNT
							</td>
						</tr>
					</thead>
					<tbody>
						@forelse($exp_bill as $bill)
						<tr>
							<td style="text-align: center;">{{ $bill->name }}</td>
							<td style="text-align: center;">Php&nbsp;{{ $bill->amount }}</td>
						</tr>
						@empty
						<tr>
							<td colspan="2" style="text-align: center;"><strong>No records available.</strong></td>
						</tr>
						@endforelse
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						@forelse($exp_vat as $vr)
						<tr>
							<td style="text-align: center;"><strong>{{ $vr->rates }}% VAT</strong></td>
							<td style="text-align: center;">Php&nbsp;{{ $vr->Total }}</td>
						</tr>
						@empty
						<tr>
							<td colspan="2">No records available.</td>
						</tr>
						@endforelse
						@forelse($exp_total as $rt)
						<tr>
							<td style="text-align: right;">
								<label for="bal"><strong>TOTAL: &nbsp;</strong></label>
							</td>
							<td style="text-align: center;">
								<h3>Php&nbsp;&nbsp;{{ $rt->Total }}</h3>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="2">No records available.</td>
						</tr>
						@endforelse
					</tbody>
				</table>
			</form>
		</div>
	</div>
</div>
<div id="revModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Revenue</h4>
			</div>
			<div class="modal-body">
				<table class = "table-responsive table" id = "rev_table">
					<thead>
						<tr>
							<td>
								Name *
							</td>
							<td>
								Amount *
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
					<!-- 				<td>
										<input type = "text" name = "rev_tax" class = "form-control" style="text-align: right">
									</td> -->
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
	<div id="expModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Revenue</h4>
				</div>
				<div class="modal-body">
					<table class = "table-responsive table" id = "rev_table">
						<thead>
							<tr>
								<td>
									Name *
								</td>
								<td>
									Amount *
								</td>
							</tr>
						</thead>
						<tbody>
							<tr id = "revenue-row" name="revenue-row">
								<form class="form-horizontal">
									{{ csrf_field() }}
									<td>
										<select id = "exp_bill_id" name="exp_bill_id" class="form-control">
											<option value = "0">Select Charges</option>
											@forelse($bill_exps as $exp)
											<option value = "{{ $exp->id }}">{{ $exp->name }}</option>

											@empty

											@endforelse
										</select>
									</td>
									<td>
										<input type = "text" name = "exp_amount" id="exp_amount" class = "form-control" style="text-align: right">
									</td>
					<!-- 				<td>
										<input type = "text" name = "rev_tax" class = "form-control" style="text-align: right">
									</td> -->
									<tr id="desc_rev_row">
										<td colspan="4">
											<div class="form-group">
												<label for="exp_description">Description:</label>
												<textarea class="form-control" rows="3" id="exp_description" name="exp_description"></textarea>
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
					<a class="btn but finalize-exp">Save</a>
				</div>
			</div>
		</div>
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
			var bi_id = document.getElementById("so_head_id").value;
			console.log(bi_id);

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

			var rc_table = $('#revTable').DataTable({
				processing: false,
				serverSide: true,
				ajax: "{{ route('revenue.data',$so_head_id) }}",
				columns: [
				{ data: 'name' },
				{ data: 'description' },
				{ data: 'Total' }
				]
			})
			var br_table = $('#expTable').DataTable({
				processing: false,
				serverSide: true,
				ajax: "{{ route('expenses.data', $so_head_id) }}",
				columns: [
				{ data: 'name' },
				{ data: 'description' },
				{ data: 'Total' }
				]
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
				var bi_id = document.getElementById("so_head_id").value;
				console.log(rev_bill_id);
				console.log(rev_amount_value);
				console.log(rev_description_value);
				console.log(rev_tax_value);
				console.log({{ $so_head_id }});
				$.ajax({
					method: 'POST',
					url: '{{ route("billing.store") }}',
					data: {
						'_token' : $('input[name=_token]').val(),
						'charge_id' : rev_bill_id,
						'description' : rev_description_value,
						'amount' : rev_amount_value,
						'tax' : 0,
						'bi_head_id' : bi_id,
					},
					success: function (data){
						location.reload();
					}
				})
			}
		})
		$(document).on('click', '.finalize-exp', function(e){
			if(validateExpenseRows() === true){
				var bi_id = document.getElementById("so_head_id").value;
				console.log(exp_bill_id);
				console.log(exp_amount_value);
				console.log(exp_description_value);
				console.log(exp_tax_value);
				console.log({{ $so_head_id }});
				$.ajax({
					method: 'POST',
					url: '{{ route("billing.store") }}',
					data: {
						'_token' : $('input[name=_token]').val(),
						'charge_id' : exp_bill_id,
						'description' : exp_description_value,
						'amount' : exp_amount_value,
						'tax' : 0,
						'bi_head_id' : bi_id,
					},
					success: function (data){
						location.reload();
					}
				})
			}
		})
		function validateRevenueRows()
		{
			rev_bill_id = [];
			rev_description_value = [];
			rev_amount_value = [];
		// rev_tax_value = [];

		rev_billID = document.getElementsByName('rev_bill_id');
		rev_description = document.getElementsByName('rev_description');
		rev_amount = document.getElementsByName('rev_amount');
		// rev_tax = document.getElementsByName('rev_tax');


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
			// if(rev_tax[i].value === "")
			// {
			// 	rev_tax[i].style.color = 'red';
			// 	error += "Tax Required.";
			// }

			// else
			// {
			// 	rev_tax_value.push(rev_tax[i].value);
			// }

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
			// if(exp_tax[i].value === "")
			// {
			// 	exp_tax[i].style.color = 'red';
			// 	error += "Tax Required.";
			// }

			// else
			// {
			// 	exp_tax_value.push(exp_tax[i].value);
			// }

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