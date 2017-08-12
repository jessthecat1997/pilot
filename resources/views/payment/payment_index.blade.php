@extends('layouts.app')
@section('content')
<h2>&nbsp;Payment</h2>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel">
			<div class="panel-heading" id="heading">Consignee Details</div>
			<table class="table">
				<tbody>
					<tr>
						<td class="active"><strong>No.: </strong></td>
						@forelse($pays as $pay)
						<td class = "success" id="so_head_id"><strong>{{ $pay->id }}</strong></td>
						@empty
						@endforelse
					</tr>
					<tr>
						<td class="active"><strong>Consignee: </strong></td>
						@forelse($pays as $pay)
						<td class = "success" id="consignee"><strong>{{ $pay->companyName }}</strong></td>
						@empty
						@endforelse
					</tr>
					<tr>
						<td class="active"><strong>Address: </strong></td>
						@forelse($pays as $pay)
						<td class="success" id="address"><strong>{{ $pay->address }}</strong></td>
						@empty
						@endforelse
					</tr>
					<tr>
						<td class="active"><strong>Service Order: </strong></td>
						@forelse($pays as $pay)
						<td class="success" id="sotype"><strong>{{ $pay->name }}</strong></td>
						@empty
						@endforelse
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="panel-default col-sm-8">
			<div class="panel-heading" id="heading">List of Unpaid Bills</div>
			<div class = "panel-body">
				<table class = "table-responsive table" id = "bill_table">
					<thead>
						<tr>
							<td>
								Name
							</td>
							<td>
								Amount
							</td>
						</tr>
					</thead>
				</table>
				<br>
				<div class="form-group">
					<a class="btn but finalize-payment col-sm-6">Save</a>
					<a href="/payment/{{ $pay->id }}/show_pdf" class="btn but  col-sm-6">Generate Receipt</a>
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
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	$('#collapse1').addClass('in');
	var so_head_id = $('#so_head_id').text();
	var bfee = $('#bfee');
	var bfee_val = bfee.text();
	var totalbills = $('#totalbills');
	var bills = totalbills.text();
	var totrc = $('#totrc');
	var rc_val = totrc.text();
	var delfees = $('#delfee');
	var del_val = delfees.text();
	var totalamt = $('#totalamt');
	var total_val = totalamt.text();
	var pmid = document.getElementsByName('pm_id');

	$(document).ready(function(){
		var totals = 0;
		totals = +bfee_val + +bills + +rc_val + +del_val;
		totalamt.text(totals);
		console.log(so_head_id);
		console.log(totals);
	})

	$(document).on('click', '.finalize-payment', function(e){
		var totals = 0;
		totals = +bfee_val + +bills + +rc_val + +del_val;
		totalamt.text(totals);
		console.log(so_head_id);
		console.log(totals);
		var pm_val = document.getElementsByName('pm_id');
		console.log(pm_val);
		$.ajax({
			method: 'POST',
			url: '{{ route("payment.store") }}',
			data: {
				'_token' : $('input[name=_token]').val(),
				'so_head_id' : so_head_id,
				'amount' : totals,
				'payment_mode_id' : '1',
			},
			success: function (data){
				toastr.options = {
					"closeButton": false,
					"debug": false,
					"newestOnTop": false,
					"progressBar": false,
					"rtl": false,
					"positionClass": "toast-bottom-right",
					"preventDuplicates": false,
					"onclick": null,
					"showDuration": 300,
					"hideDuration": 1000,
					"timeOut": 2000,
					"extendedTimeOut": 1000,
					"showEasing": "swing",
					"hideEasing": "linear",
					"showMethod": "fadeIn",
					"hideMethod": "fadeOut"
				}
				toastr["success"]("Payment Added successfully")
				location.reload();
			}
		})
	})
</script>
@endpush