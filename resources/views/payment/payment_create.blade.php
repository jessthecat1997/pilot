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
		<div class="col-sm-12" id="tot">
			<form class="form-inline">
				{{ csrf_field() }}
				<div class="col-sm-8">
					<div class="form-group">
						<label for="bal"><h3>Balance: &nbsp;</h3></label>
						<strong>Php</strong>&nbsp;&nbsp;<input type="text" class="txt" id="bal" disabled>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<input type="text" class="txt" id="total" value="{{ $total[0]->Total }}" disabled hidden>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						@forelse($paid as $pd)
						<input type="text" class="txt" id="paid" value="{{ $pd->total }}" disabled hidden>
						@empty
						<input type="text" class="txt" id="paid" value="0.00" disabled hidden>
						@endforelse
					</div>
				</div>
			</form>
		</div>
	</div>
	<br/>

	<button type="button" class="btn but pull-right" data-toggle="modal" @if($total[0]->totpay == $total[0]->totall) disabled @endif data-target="#revModal">New Payment</button>
	<br/>
	<br/>
	<div class="row">
		<div class="panel-default col-sm-12">
			<div class="panel-heading" id="heading">List of Payable</div>
			<div class="panel-body">
				<table class = "table-responsive table" id = "bills_table">
					<thead>
						<tr>
							<td>
								Name
							</td>
							<td>
								Amount
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
	<br/>
	<div class="row">
		<div class="panel-default col-sm-12">
			<div class="panel-heading" id="heading">Payment History</div>
			<div class="panel-body">
				<table class = "table-responsive table" id = "hist_table">
					<thead>
						<tr>
							<td>
								No.
							</td>
							<td>
								Amount
							</td>
							<td>
								Date of Payment
							</td>
							<td>
								Remarks
							</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
<hr>
<div id="revModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">New Payment</h4>
			</div>
			<div class="modal-body">
				<table class="table">
					{{ csrf_field() }}
					<thead>
						<tr>
							<td>
								Amount *
							</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<form class="form-horizontal">
								<td>
									<input type = "number" name="amount" id="amount" class="form-control col-sm-2" style="text-align: right" required>
								</td>
							</form>
						</tr>
						<tr>
							<td colspan="2">
								<div class="form-group">
									<label for="remarks">Remarks:</label>
									<textarea class="form-control" rows="3" id="remarks" name="remarks"></textarea>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<strong>Note:</strong> All fields with * are required.
			</div>
			<div class="modal-footer">
				<button class="btn but finalize-payment-rev">Save</button>
			</div>
		</div>
	</div>
</div>
<div id="billModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">New Payment</h4>
			</div>
			<div class="modal-body">
				<form class="form-inline">
					{{ csrf_field() }}
					<div class="col-sm-8">
						<div class="form-group">
							<label for="selected_bill"><h4>Amount: &nbsp;</h4></label>
							<strong>Php</strong>&nbsp;&nbsp;<input type="text" class="txt" id="selected_bill" disabled>
						</div>
					</div>
				</form>
				<table class="table">
					{{ csrf_field() }}
					<thead>
						<tr>
							<td>
								Amount *
							</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<form class="form-horizontal">
								<td>
									<input type = "number" name="amount" id="bill_amount" class="form-control col-sm-2" style="text-align: right" required>
								</td>
							</form>
						</tr>
						<tr>
							<td colspan="2">
								<div class="form-group">
									<label for="remarks">Remarks:</label>
									<textarea class="form-control" rows="3" id="b_remarks" name="b_remarks"></textarea>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<strong>Note:</strong> All fields with * are required.
			</div>
			<div class="modal-footer">
				<button  class="btn but finalize-payment">Save</button>
			</div>
		</div>
	</div>
</div>
</div>
@endsection
@push('styles')
<style>
	.class-payment
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
	var totalamt = {{ $total[0]->totall }};
	var balance = @if( $total[0]->balance == null) {{ $total[0]->totall }} @else {{ $total[0]->balance }} @endif ;
	var paid =  @if( $total[0]->totpay == null) 0 @else {{ $total[0]->totpay }} @endif ;
	n = totalamt - paid;
	var bals = n.toFixed(2);
	document.getElementById("bal").value = bals;

	$(document).ready(function(){
		console.log(bals);
		var b_table = $('#hist_table').DataTable({
			processing: false,
			serverSide: true,
			ajax: "{{ route('payments.data', $so_head_id) }}",
			columns: [
			{ data: 'id' },
			{ data: 'amount' },
			{ data: 'created_at'},
			{ data: 'description'}
			]
		})
		var p_table = $('#bills_table').DataTable({
			processing: false,
			serverSide: true,
			ajax: "{{ route('paybills.data', $so_head_id) }}",
			columns: [
			{ data: 'name' },
			{ data: 'amount' },
			{ data: 'action' }
			]
		})
		
	})
	$(document).on('click', '.make_payment', function(e){
		var amount = $(this).val(); 
		console.log(amount); 
		var amt = parseFloat(document.getElementById("selected_bill").value = amount);
	})
	$(document).on('click', '#check', function(e){
		var amt = parseFloat(document.getElementById("amount").value);
		console.log(bals);
		if(amt<bals)
		{
			var n = totalamt - amt;
			alert(n);
		}
		else if(amt>bals)
		{
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
			toastr["warning"]("The amount must not be higher than the total");
			location.reload();
		}
		else if(amt==bals)
		{
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
			toastr["warning"]("Paid");
			location.reload();
		}
	})

	$(document).on('click', '.finalize-payment-rev', function(e){
		e.preventDefault();
		var amt = $('#amount').val();
		var rem = $('#remarks').val();

		console.log(amt);
		if( amt > 0 ){

			if(amt < totalamt)
			{
				if(amt<bals)
				{
					var tot = totalamt - amt;
					$('.finalize-payment-rev').attr('disabled', 'true');
					$.ajax({
						method: 'POST',
						url: '{{ route("payment.store") }}',
						data: {
							'_token' : $('input[name=_token]').val(),
							'bi_head_id' : {{ $so_head_id }},
							'amount' : amt,
							'description' : rem
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
							toastr["success"]('Successfully saved');
							location.reload();
						}
					})
				}
				else if(amt>bals)
				{
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
					toastr["warning"]("The amount must not be higher than the balance");
					$('.finalize-payment-rev').removeAttr('disabled');

	
				}
				else if(amt==bals)
				{
					var tot = totalamt - amt;
					$('.finalize-payment-rev').attr('disabled', 'true');
					$.ajax({
						method: 'POST',
						url: '{{ route("payment.store") }}',
						data: {
							'_token' : $('input[name=_token]').val(),
							'bi_head_id' : {{ $so_head_id }},
							'amount' : amt,
							'description' : rem
						},
						success: function (data){
							var val = 'P';
							$.ajax({
								type: 'PUT',
								url:  "{{ route('payment.update', $so_head_id) }}",
								data: {
									'_token' : $('input[name=_token]').val(),
									'status' : val
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
									toastr["success"]('Successfully saved');
									window.location.href = "{{ route('view.index') }}";
								}
							})
						}
					})
				}

			}
			else if(amt>totalamt)
			{
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
				toastr["warning"]("The amount must not be higher than the total");
				$('.finalize-payment-rev').removeAttr('disabled');
			}
			else if(amt==totalamt)
			{
				var tot = totalamt - amt;
				$('.finalize-payment-rev').attr('disabled', 'true');
				$.ajax({
					method: 'POST',
					url: '{{ route("payment.store") }}',
					data: {
						'_token' : $('input[name=_token]').val(),
						'bi_head_id' : {{ $so_head_id }},
						'amount' : amt,
						'description' : rem
					},
					success: function (data){
						var val = 'P';
						$.ajax({
							type: 'PUT',
							url:  "{{ route('payment.update', $so_head_id) }}",
							data: {
								'_token' : $('input[name=_token]').val(),
								'paymentStatus' : val
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
								toastr["success"]('Successfully saved');
								window.location.href = "{{ route('view.index') }}";
							}
						})
					}
				})
			}
		}
		else
		{
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
			toastr["warning"]('Invalid payment');
			$('.finalize-payment-rev').removeAttr('disabled');
		}
	})
	$(document).on('click', '.finalize-payment', function(e){

		var amt = $('#bill_amount').val();
		var rem = $('#b_remarks').val();
		console.log(amt);
		if( amt > 0 ){

			if(amt < totalamt)
			{
				if(amt<bals)
				{
					var tot = totalamt - amt;
					$('.finalize-payment').attr('disabled', 'true');
					$.ajax({
						method: 'POST',
						url: '{{ route("payment.store") }}',
						data: {
							'_token' : $('input[name=_token]').val(),
							'bi_head_id' : {{ $so_head_id }},
							'amount' : amt,
							'description' : rem
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
							toastr["success"]('Successfully saved');
							location.reload();
						}
					})
				}
				else if(amt>bals)
				{
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
					toastr["warning"]("The amount must not be higher than the balance");
					$('.finalize-payment').removeAttr('disabled');

	
				}
				else if(amt==bals)
				{
					var tot = totalamt - amt;
					$('.finalize-payment').attr('disabled', 'true');
					$.ajax({
						method: 'POST',
						url: '{{ route("payment.store") }}',
						data: {
							'_token' : $('input[name=_token]').val(),
							'bi_head_id' : {{ $so_head_id }},
							'amount' : amt,
							'description' : rem
						},
						success: function (data){
							var val = 'P';
							$.ajax({
								type: 'PUT',
								url:  "{{ route('payment.update', $so_head_id) }}",
								data: {
									'_token' : $('input[name=_token]').val(),
									'status' : val
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
									toastr["success"]('Successfully saved');
									window.location.href = "{{ route('view.index') }}";
								}
							})
						}
					})
				}

			}
			else if(amt>totalamt)
			{
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
				toastr["warning"]("The amount must not be higher than the total");
				$('.finalize-payment').removeAttr('disabled');
			}
			else if(amt==totalamt)
			{
				var tot = totalamt - amt;
				$('.finalize-payment-rev').attr('disabled', 'true');
				$.ajax({
					method: 'POST',
					url: '{{ route("payment.store") }}',
					data: {
						'_token' : $('input[name=_token]').val(),
						'bi_head_id' : {{ $so_head_id }},
						'amount' : amt,
						'description' : rem
					},
					success: function (data){
						var val = 'P';
						$.ajax({
							type: 'PUT',
							url:  "{{ route('payment.update', $so_head_id) }}",
							data: {
								'_token' : $('input[name=_token]').val(),
								'paymentStatus' : val
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
								toastr["success"]('Successfully saved');
								window.location.href = "{{ route('view.index') }}";
							}
						})
					}
				})
			}
		}
		else
		{
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
			toastr["warning"]('Invalid payment');
			$('.finalize-payment').removeAttr('disabled');
		}
	})

</script>
@endpush