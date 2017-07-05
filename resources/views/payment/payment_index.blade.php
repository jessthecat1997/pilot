@extends('layouts.app')
@section('content')
<h3><img src="/images/bar.png"> Payment</h3>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<div id="con_collapse" class="collapse in">
					<h3>Select Service Order</h3>
					<table class = "table-responsive table" id = "sorder_table">
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
									Actions
								</td>
							</tr>
						</thead>
					</table>
				</div>
				<button class="btn buts" id="btnSO">Change Service Order</button>
				<div id="bill_collapse" class="collapse">
					<h3>Pending Billing</h3>
					<table class = "table-responsive table" id = "pso_head_table">
						<thead>
							<tr>
								<td>
									ID
								</td>
								<td>
									Bill
								</td>
								<td>
									Amount
								</td>
							</tr>
						</thead>
					</table>
				</div>
				<div id="totbill_collapse" class="collapse">
					<h3>Total Billing</h3>
					<table class = "table-responsive table" id = "totbill_table">
						<thead>
							<tr>
								<td>
									ID
								</td>
								<td>
									Total Amount
								</td>
								<td>
									Actions
								</td>
							</tr>
						</thead>
					</table>
				</div>
				<br>
				<br>
				<div id="rc_collapse" class="collapse">
					<h3>Select Pending Refundable Charges</h3>
					<table class = "table-responsive table" id = "rc_head_table">
						<thead>
							<tr>
								<td>
									ID
								</td>
								<td>
									Refundables
								</td>
								<td>
									Amount
								</td>
							</tr>
						</thead>
					</table>
				</div>
				<div id="totrc_collapse" class="collapse">
					<h3>Total Refundables</h3>
					<table class = "table-responsive table" id = "totrc_table">
						<thead>
							<tr>
								<td>
									ID
								</td>
								<td>
									Total Amount
								</td>
								<td>
									Actions
								</td>
							</tr>
						</thead>
					</table>
				</div>
				<br>
				<hr>
				<form class="form-horizontal">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="control-label col-sm-2">Service Order ID: </label>
						<div class="col-sm-10"> 
							<input type="text" class="form-control" name="sorder_id" id="sorder_id" required>
						</div>
					</div>
				</form>
				<form class="form-inline">
					{{ csrf_field() }}
					<div class="form-group">
						<label>Total Billing Amount: </label>
						<input type="text" class="form-control" id="totalBill" name="totalBill"  required>
					</div>
					<div class="form-group">
						<label>Total Refunfable Charges: </label>
						<input type="text" class="form-control" id="totalRC" name="totalRC"  required>
					</div>
					<div class="form-group">
						<input type="button" class="btn btn-info form-control compute_total" id="btnSave" value="Compute"></input>
					</div>
				</form>
				<br>
				<form class="form-horizontal">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="control-label col-sm-2">Payment Mode: </label>
						<div class="col-sm-10">
							<select name = "payment_mode_id" id = "payment_mode_id" class = "form-control ">
								<option>

								</option>
								@forelse($payMode as $pm)
								<option value = "{{ $pm->id }}">
									{{ $pm->description }}
								</option>
								@empty

								@endforelse
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Service Order ID: </label>
						<div class="col-sm-10"> 
							<input type="text" class="form-control" name="so_id" id="so_id" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Total Amount: </label>
						<div class="col-sm-10"> 
							<input type="text" class="form-control" name="totamount" id="totamount" required>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12"> 
							<button class="btn btn-info form-control finalize-payment" id="btnSave">Generate Receipt</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style>
	.class-payment
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
	$(document).ready(function(){
		var sotable = $('#sorder_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{ route("sorder.data") }}',
			columns: [
			{ data: 'id' },
			{ data: 'companyName' },
			{ data: 'paymentStatus'},
			{ data: 'action', orderable: false, searchable: false }
			]
		})
		$(document).on('click', '.selectCon' ,function(e){
			$('#con_collapse').removeClass('in');
			$('#bill_collapse').addClass('in');
			$('#totbill_collapse').addClass('in');
			data = sotable.row($(this).parents()).data();
			$('#sorder_id').val(data.id);

			var vtable = $('#pso_head_table').DataTable({
				processing: true,
				serverSide: true,
				ajax: 'http://localhost:8000/payment/'+data.id+'/so_id_data',
				columns: [
				{ data: 'id' },
				{ data: 'description' },
				{ data: 'Total'},
				]
			})
			var tbill = $('#totbill_table').DataTable({
				processing: true,
				serverSide: true,
				ajax: 'http://localhost:8000/payment/'+data.id+'/totbill_data',
				columns: [
				{ data: 'id' },
				{ data: 'Total' },
				{ data: 'action', orderable: false, searchable: false }
				]
			})
			var rctable = $('#rc_head_table').DataTable({
				processing: true,
				serverSide: true,
				ajax: 'http://localhost:8000/payment/'+data.id+'/rcso_id_data',
				columns: [
				{ data: 'id' },
				{ data: 'description' },
				{ data: 'TotalRC'},
				]
			})
			var trc = $('#totrc_table').DataTable({
				processing: true,
				serverSide: true,
				ajax: 'http://localhost:8000/payment/'+data.id+'/totrc_data',
				columns: [
				{ data: 'id' },
				{ data: 'Total' },
				{ data: 'action', orderable: false, searchable: false }
				]
			})
			$(document).on('click', '.selectTotBill' ,function(e){
				$('#bill_collapse').removeClass('in');
				$('#totbill_collapse').removeClass('in');
				$('#rc_collapse').addClass('in');
				$('#totrc_collapse').addClass('in');
				data = tbill.row($(this).parents()).data();
				$('#totalBill').val(data.Total);


				$(document).on('click', '.selectTotRC' ,function(e){
					$('#rc_collapse').removeClass('in');
					$('#totrc_collapse').removeClass('in');
					data = trc.row($(this).parents()).data();
					$('#totalRC').val(data.Total);
				})
			})
			
			
		})
		

		
	})

	$(document).on('click', '.compute_total' ,function(e){
		tot_amt = (parseInt($('#totalBill').val()) + parseInt($('#totalRC').val()));

		$('#totamount').val(tot_amt);
	})
	$(document).on('click', '.finalize-payment', function(e){


		$.ajax({
			method: 'POST',
			url: '{{ route("payment.store") }}',
			data: {
				'_token' : $('input[name=_token]').val(),
				'amount' : $('#totamount').val(),
				'so_head_id' : $('#so_id').val(),
				'payment_mode_id' : $('#payment_mode_id').val(),
			},

			success: function (data){

			}
		})

	})
	$(document).on('click', '#btnSO' ,function(e){
		$('#con_collapse').addClass('in');
	})
</script>
@endpush