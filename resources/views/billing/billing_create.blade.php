@extends('layouts.app')
@section('content')
<h2>&nbsp;Billing</h2>
<hr>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">Consignee Details</div>
				<div class="panel-body">
					<div class="form-group">
						<label>Consignee:</label>
						<input type="text" class="det" value="{{ $bills[0]->companyName }}" id="companyName" disabled>
					</div>
					<div class="form-group">
						<h5 id="address"><strong>Address:</strong> {{ $bills[0]->address }}</h5>
					</div>
					<div class="form-group">
						<label>Service Order:</label>
						<input type="text" class="det" value="{{ $bills[0]->name }}" id="sotype" disabled>
					</div>
					<div class="form-group">
						<label>Status:</label>
						@if($bills[0]->isFinalize == 1)
						<label class="label label-success" id="status">Finalized</label>
						@else
						<label class="label label-danger" id="status">Not Finalize</label>
						@endif
					</div>
					<div class="form-group">
						<label>Invoice No.:</label>
						<input type="text" class="det" value="{{ $so_head_id }}" id="so_head_id" disabled>
					</div>
					<div class="form-group">
						<label>Due Date:</label>
						<input type="text" class="det" value="{{ Carbon\Carbon::parse($bills[0]->due_date)->toFormattedDateString() }}" id="due_date" disabled>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">New Bills</div>
				<div class = "panel-body">
					<table class="table table-hover" id="revenue_table">
						<thead>
							<tr>
								<td colspan="2">
									<button type="button" class="btn but pull-right addBill" data-toggle="modal" data-target="#revModal">Add Bills</button>
								</td>
							</tr>
							<tr>
								<th>Name</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
							@forelse($rev_bill as $bill)
							<tr>
								@if($bill->name == "Others")
								<td style="text-align: center;">{{ $bill->name }} ({{ $bill->description }})</td>
								@else
								<td style="text-align: center;">{{ $bill->name }}</td>
								@endif
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
									<button class="btn but pull-right finalize-bill col-sm-4">Finalize</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div id="revModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Bills</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
						{{ csrf_field() }}
						<div class="form-group">
							<label class="control-label col-sm-2" for="rev_bill_id">*Select Charge:</label>
							<div class="col-sm-10">
								<select class="form-control" id="rev_bill_id" name="rev_bill_id">
									<option></option>
									@forelse($bill_revs as $rev)
									<option value = "{{ $rev->id }}">{{ $rev->name }}</option>
									@empty
									<option>No records available.</option>
									@endforelse
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="rev_amount">*Amount:</label>
							<div class="col-sm-10"> 
								<input type="number" class="form-control" name="rev_amount" id="rev_amount" style="text-align: right;">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="rev_description">Description:</label>
							<div class="col-sm-10"> 
								<textarea class="form-control" rows="3" id="rev_description" name="rev_description"></textarea>
							</div>
						</div>
					</form>
					<strong>Note:</strong> All fields with * are required.
				</div>
				<div class="modal-footer">
					<a class="btn but finalize-rev">Save</a>
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
	@push('scripts')
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
				$('.addBill').attr('disabled','disabled');
				$('.finalize-bill').attr('disabled','disabled');
			}
			var bi_id = document.getElementById("so_head_id").value;
			console.log(bi_id);

			var rc_table = $('#revTable').DataTable({
				processing: false,
				serverSide: false,
				deferRender: true,
				ajax: "{{ route('revenue.data',$so_head_id) }}",
				columns: [
				{ data: 'name' },
				{ data: 'description' },
				{ data: 'Total' }
				]
			})
			var br_table = $('#expTable').DataTable({
				processing: false,
				serverSide: false,
				deferRender: true,
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
				method: 'PUT',
				url: '/billing/{{ $so_head_id }}/finalize',
				data: {
					'_token' : $('input[name=_token]').val(),
					'isFinalize' : 1
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