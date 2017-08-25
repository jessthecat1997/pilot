@extends('layouts.app')
@section('content')
<h2>&nbsp;Billing</h2>
<hr>
<div class="row col-md-5">
	<div class="panel-default panel">
		<div class="panel-heading" id="heading">Consignee Details</div>
		<div class="panel-body">
			<form class="inline">
				<div class="form-group">
					<label>Invoice No.:</label>
					<input type="text" class="det" value="{{ $so_head_id }}" id="so_head_id">
				</div>
				<div class="form-group">
					<label>Due Date:</label>
					<input type="text" class="det" value="{{ Carbon\Carbon::parse($bills[0]->due_date)->toFormattedDateString() }}" id="due_date">
				</div>
				<hr>
				<div class="form-group">
					<label>Consignee:</label>
					<h5>{{ $bills[0]->companyName }}</h5>
				</div>
				<div class="form-group">
					<label>Address:</label>
					<h5>{{ $bills[0]->address }}</h5>
				</div>
				<div class="form-group">
					<label>Service Order:</label>
					<h5>{{ $bills[0]->name }}</h5>
				</div>
				<div class="form-group">
					<label>Status:</label>
					@if($bills[0]->isFinalize == 1)
					<label class="label label-success" id="status">Finalized</label>
					@else
					<label class="label label-warning" id="status">Not Finalize</label>
					@endif
				</div>
			</form>
		</div>
	</div>
</div>
<div class="row col-md-7">
	<div class="panel-default panel">
		<div class="panel-heading" id="heading">List of Bills</div>
		<div class = "panel-body">
			<form class="form-inline">
				{{ csrf_field() }}
				<table class="table" id="revenue_table">
					<thead>
						<tr>
							<td colspan="2">
								<button type="button" class="btn but pull-right collapse in addBill" data-toggle="modal" data-target="#revModal">Add Bills</button>
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
						<tr>
							<td colspan="2">
								<a class="btn but pull-right finalize-bill col-sm-6">Finalize</a>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
</div>
<div class="row col-md-5">
</div>
<div id="revModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Bills</h4>
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
<div id="updateModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">New Billing Invoice</h4>
			</div>
			<div class="modal-body">
				<div class="col-sm-12">
					<form class="form-inline">
						{{ csrf_field() }}
						<div class="col-sm-3">
							<div class="form-group">
								<label for="vat">Vat Rate:*</label>
								<input type="text" class="form-control" id="vat" value="{{ $vat[0]->rates }}">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label for="date_billed">Date Billed:*</label>
								<input type="date" class="form-control" id="date_billed">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label for="due_date">Due Date:*</label>
								<input type="date" class="form-control" id="due_date">
							</div>
						</div>
					</form>
				</div>
				<strong>Note:</strong> All fields with * are required.
			</div>
			<div class="modal-footer">
				<a class="btn but save-header">Save</a>
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
		var stat = document.getElementById("status").innerText;
		console.log(stat);
		if(stat == "Finalized")
		{
			$('.addBill').removeClass('in');
		}
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
	$(document).on('click', '.finalize-bill', function(e){
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