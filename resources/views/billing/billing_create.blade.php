@extends('layouts.app')
@section('content')
<h2>&nbsp;Billing</h2>
<div class="pull-left">
	<a href="/billing" class="btn but">Back</a>
</div>
<br/>
<hr>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">Consignee Details</div>
				<div class="panel-body">
					<div class="form-group">
						<h5 id="consignee"><strong>Company Name:</strong> {{ $bills[0]->companyName }}</h5>
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
						<label class="label label-success" id="status">Posted</label>
						@else
						<label class="label label-warning" id="status">Pending</label>
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
						</thead>
						<tbody>
							<tr>
								<td colspan="2" style="text-align: center;">
									<label id="parts">Particulars</label>
								</td>
							</tr>
							@forelse($rev_bill as $bill)
							<tr>
								@if($bill->name == "Others (please specify)")
								<td style="text-align: center;"><h5>Others <i>({{ $bill->description }})</i></h5></td>
								@else
								<td style="text-align: center;"><h5>{{ $bill->name }}</h5></td>
								@endif
								<td style="text-align: center;"><h5><strong>Php&nbsp;{{ $bill->amount }}</strong></h5></td>
							</tr>
							@empty
							<tr>
								<td colspan="2" style="text-align: center;">
									<label class="label label-warning" id="parts">No Records</label>
								</td>
							</tr>
							@endforelse
							<tr>
								<td style="text-align: right;">
									<h5>Subtotal</h5>
								</td>
								<td style="text-align: right;">
									<h5><strong>Php {{ $rev_sub[0]->Total }}</strong></h5>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">
									<h5>{{ $vat[0]->rates }}% VAT</h5>
								</td>
								<td style="text-align: right;">
									<h5><strong>Php {{ $rev_vat[0]->Total }}</strong></h5>
								</td>
							</tr>
							<tr>
								<td style="text-align: right;">
									<h5>Total</h5>
								</td>
								<td style="text-align: right;">
									<h4><strong><u>Php {{ $rev_total[0]->Total }}</u></strong></h4>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<button class="btn but pull-right finalize-bill col-sm-4">Finalize</button>
								</td>
							</tr>
							<tr>
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
						<form class="form-horizontal" id="bill_form">
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
									<div class="input-group">
										<span class="input-group-addon">Php</span>
										<input type="number" class="form-control money" id="rev_amount" name="rev_amount" style = "text-align: right" value = "0.00">
									</div>
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
				var stat = null;
				var st = null;
				stat = document.getElementById("parts").innerText;
				st = document.getElementById("status").innerText;
				console.log(stat);
				console.log(st);
				if(stat == "No Records")
				{
					$('.finalize-bill').attr('disabled','disabled');
				}
				if(st == "Posted" && stat == "Particulars")
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
			$("#bill_form").validate({
				rules: 
				{
					rev_bill_id:
					{
						required: true,
					},

					rev_amount:
					{
						required: true,
					},
				},
				onkeyup: false, 
				submitHandler: function (form) {
					return false;
				}
			});
			$(document).on('keyup keydown keypress', '.money', function (event) {
				var len = $('.money').val();
				var value = $('.money').inputmask('unmaskedvalue');
				if (event.keyCode == 8) {
					if(parseFloat(value) == 0 || value == ""){
						$('.money').val("0.00");
					}
				}
				else
				{
					if(value == ""){
						$('.money').val("0.00");
					}
					if(parseFloat(value) <= 9999999999999999.99){

					}
					else{
						if(event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 116){

						}
						else{
							return false;
						}
					}
				}
				if(event.keyCode == 189)
				{
					return false;
				}			
			});
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
					if($('#rev_bill_id').valid() && $('#rev_amount').valid()){
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