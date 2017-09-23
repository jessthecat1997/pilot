@extends('layouts.app')
@section('content')
<h2>&nbsp;Payment</h2>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">Consignee Details</div>
				<div class="panel-body">
					<div class="form-group">
						<label>Invoice No:</label>
						<input type="text" class="det" value="{{ $so_head_id }}" id="companyName" disabled>
					</div>
					@forelse($pays as $pay)
					<div class="form-group">
						<label>Consignee:</label>
						<input type="text" class="det" value="{{ $pay->con_name }}" id="consignee" disabled>
					</div>
					<div class="form-group">
						<label>Company Name:</label>
						<input type="text" class="det" value="{{ $pay->companyName }}" id="sotype" disabled>
					</div>
					<div class="form-group">
						<h5 id="address"><strong>Address:</strong> {{ $pay->address }}</h5>
					</div>
					<div class="form-group">
						<label>Service Order:</label>
						<input type="text" class="det" value="{{ $pay->name }} Service Order No: {{ $pay->id }}" id="sotype" disabled>
					</div>
					@empty
					@endforelse
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">Payment</div>
				<div class="panel-body">
					<form class="form" onsubmit="this.preventDefault();">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="bal">Balance: &nbsp;</label>
							<strong>Php</strong>&nbsp;&nbsp;<input type="text" class="txt money" id="bal" disabled>
						</div>
						<div class="form-group">
							<input type="hidden" class="txt" id="total" value="{{ $total[0]->Total }}" disabled>
						</div>
						<div class="form-group">
							@forelse($paid as $pd)
							<input type="hidden" class="txt" id="paid" value="{{ $pd->total }}" disabled>
							@empty
							<input type="hidden" class="txt" id="paid" value="0.00" disabled>
							@endforelse
						</div>
					</form>
					<ul class="nav nav-pills">
						<li class="active"><a data-toggle="pill" href="#home">Cash</a></li>
						<li><a data-toggle="pill" href="#menu1">Cheque</a></li>
						<li><a data-toggle="pill" href="#menu2">Deposits</a></li>
					</ul>
					<div class="tab-content">
						<div id="home" class="tab-pane fade in active">
							<br>
							<form class="form" onsubmit="this.preventDefault();">
								{{ csrf_field() }}
								<div class="form-group">
									<label>*Amount</label>
									<input type = "number" name="amount" id="amount" class="form-control col-sm-2" style="text-align: right" required>
								</div>
								<div class="form-group">
									<label for="remarks">Remarks:</label>
									<textarea class="form-control" rows="3" id="remarks" name="remarks"></textarea>
								</div>
								<button class="btn btn-primary finalize-payment-rev">Save</button>
							</form>
						</div>
						<div id="menu1" class="tab-pane fade">
							<br>
							<form class="form">
								{{ csrf_field() }}
								<div class="form-group">
									<label for="bank">*Cheque Number: &nbsp;</label>
									&nbsp;&nbsp;<input type="text" id="chqNo" class="form-control">
								</div>
								<div class="form-group">
									<label for="bank">*Bank Name: &nbsp;</label>
									&nbsp;&nbsp;<input type="text" id="bank" class="form-control">
								</div>
								<div class="form-group">
									<label for="check_amt">*Amount: &nbsp;</label>
									&nbsp;&nbsp;<input type="text" id="check_amt" class="form-control">
								</div>
								<button class="btn btn-primary finalize-cheque">Save</button>
							</form>
						</div>
						<div id="menu2" class="tab-pane fade">
							<br>
							<table class = "table table-hover">
								<thead>
									<tr>
										<th style="text-align: center;">
											Remaining Balance
										</th>
										<th style="text-align: center;">
											Action
										</th>
									</tr>
								</thead>
								<tbody>
									@if($pays[0]->status != 'P')
									@forelse($deposits as $deposit)
									<tr>
										<td style="text-align: right;">
											Php {{ $deposit->currentBalance }}
										</td>
										<td style="text-align: center;">
											<button class="btn but deposit-payment">Make Payment</button>
											<input type = "hidden" class = "deposit_id" value="{{ $deposit->id }}" />
										</td>
									</tr>
									@empty
									<tr>
										<td colspan="3">No Deposits</td>
									</tr>
									@endforelse
									@else
									@forelse($deposits as $deposit)
									<tr>
										<td>
											{{ Carbon\Carbon::parse($deposit->created_at)->toFormattedDateString() }}
										</td>
										<td style="text-align: right;">
											Php {{ $deposit->currentBalance }}
										</td>
										<td style="text-align: center;">

										</td>
									</tr>
									@empty
									<tr>
										<td colspan="3">No Deposits</td>
									</tr>
									@endforelse
									@endif

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel-body">
				<div class="panel-group" id="accordion">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">List of Payables</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse in">
							<div class="panel-body">
								<table class = "table-responsive table" id = "bills_table">
									<thead>
										<tr>
											<th>
												Name
											</th>
											<th>
												Amount
											</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Payment History</a>
							</h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse">
							<div class="panel-body">
								<table class = "table-hover table" id = "hist_table">
									<thead>
										<tr>
											<th style="width: 15%;">
												Date of Payment
											</th>
											<th style="width: 25%:">
												No.
											</th>
											<th style="width: 20%;">
												Amount
											</th>
											<th style="width: 40%;">
												Remarks
											</th>
											<th>
												Action
											</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="depModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">New Deposit Payment</h4>
			</div>
			<div class="modal-body">
				<form class = "form-horizontal">
					<div class = "form-group">
						<label class = "col-md-5 control-label pull-left">Remaining Balance: </label>
						<label class="col-md-7 control-label pull-left" id = "remain_balance" style="text-align: left;"></label>
					</div>
					<div class = "form-group required">
						<label class = "col-md-3 control-label pull-left">Amount: </label>
						<div class= "col-md-9">
							<div class="input-group">
								<span class="input-group-addon" id="freightadd">Php</span>
								<input type="number" class="form-control"  id = "depositPayment" style = "text-align: right" required>
							</div>
						</div>
					</div>
					<div class = "form-group">
						<label class = "col-md-3 control-label pull-left" >Description:</label>
						<div class = "col-md-9">
							<textarea class="form-control" id = "depositDescription"></textarea>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button  class="btn but finalize-deposit-payment">Save</button>
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
	var dep_balance = "";
	var totalamt = @if( $total[0]->totall == null) 0 @else {{ $total[0]->totall }} @endif;
	var balance = 
	@if( $total[0]->totdpay == null && $total[0]->totpay == null && $total[0]->balance == null && $total[0]->totall == null)
	0
	@else
	@if($total[0]->totpay == null && $total[0]->totdpay != null)
	{{ ( $total[0]->totall - $total[0]->totdpay )}}
	@elseif($total[0]->totpay != null && $total[0]->totdpay == null)
	{{ ( $total[0]->totall - $total[0]->totpay )}}
	@else
	{{ $total[0]->balance }}
	@endif
	{{ $total[0]->totall }}
	@endif ;
	var paid =  @if( $total[0]->totpay == null) 0 @else {{ $total[0]->totpay + $total[0]->totdpay }} @endif ;
	n = totalamt - paid;
	var bals = balance.toFixed(2);
	document.getElementById("bal").value = bals;

	$(document).ready(function(){
		var b_table = $('#hist_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender:true,
			ajax: "{{ route('payments.data', $so_head_id) }}",
			columns: [
			{ data: 'created_at'},
			{ data: 'record' },
			{ data: 'amount' },
			{ data: 'description'},
			{data : 'action'}
			]
		})
		var p_table = $('#bills_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: "{{ route('paybills.data', $so_head_id) }}",
			columns: [
			{ data: 'name' },
			{ data: 'amount',
			"render" : function( data, type, full ) {
				return formatNumber(data); } },

				]
			})

	})

	
	$(document).on('click', '.payment_receipt', function(e){
		e.preventDefault();
		type = $(this).closest('tr').find('.type').val();
		console.log($(this).val());
		if(type == 1){
			window.open("{{ route('payment_receipt') }}/" + $(this).val());
		}
		else
		{
			window.open("{{ route('payment_deposit_receipt') }}/" + $(this).val());
		}

	})
	$(document).on('click', '.finalize-payment-check', function(e){
		$.ajax({
			method: 'POST',
			url: 'cheques/{{ $pays[0]->bi_head }}',
			data: {
				'_token' : $('input[name=_token]').val(),
				'bankName' : $('#bank').val(),
				'bi_head_id' : {{ $pays[0]->bi_head }},
				'isVerify' : 1
			},
			success: function (data){
				$('#checkModal').modal('hide');
				$('#depModal').modal('show');
			}
		})
		console.log({{ $pays[0]->bi_head }})

	})

	$(document).on('click', '.finalize-deposit-payment', function(e){

		var amt = parseFloat($('#depositPayment').val());
		var rem = $('#depositDescription').val();
		console.log("AMOUNT : " + amt + " DEP BALANCE: " + dep_balance + " BALS :" + bals);
		console.log(typeof(dep_balance));
		if(amt <= dep_balance && amt <= bals && amt > 0)
		{	

			console.log('mawo');
			if(amt < bals)
			{
				var tot = totalamt - amt;
				$('.finalize-deposit-payment').attr('disabled', true);
				$.ajax({
					type: 'POST',
					url: '{{ route("dpayment.index") }}',
					data : {
						'_token' : $('input[name=_token]').val(),
						'deposit_id' : deposit_id,
						'description' : $('#depositDescription').val(),
						'bi_head_id' : "{{ $pays[0]->bi_head }}",
						'amount' : $('#depositPayment').val(),
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
				toastr.options = 
				{
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
				console.log('wow');
				var tot = totalamt - amt;
				$('.finalize-deposit-payment').attr('disabled', true);
				$.ajax({
					type: 'POST',
					url: '{{ route("dpayment.index") }}',
					data : {
						'_token' : $('input[name=_token]').val(),
						'deposit_id' : deposit_id,
						'description' : $('#depositDescription').val(),
						'bi_head_id' : "{{ $pays[0]->bi_head }}",
						'amount' : $('#depositPayment').val(),
					},
					success: function (data){
						console.log('wow');
						var val = 'P';
						$.ajax({
							type: 'PUT',
							url:  "{{ route('payment.update', $so_head_id) }}",
							data: {
								'_token' : $('input[name=_token]').val(),
								'status' : val
							},
							success: function (data)
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
								toastr["success"]('Successfully saved');
								window.location.href = "{{ route('view.index') }}";
							}
						})
					}
				})
			}
			else if(amt > totalamt)
			{
				toastr.options = 
				{
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
				$('.finalize-deposit-payment').attr('disabled', true);
				$.ajax({
					type: 'POST',
					url: '{{ route("dpayment.index") }}',
					data : {
						'_token' : $('input[name=_token]').val(),
						'deposit_id' : deposit_id,
						'description' : $('#depositDescription').val(),
						'bi_head_id' : "{{ $pays[0]->bi_head }}",
						'amount' : $('#depositPayment').val(),
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
				$('.finalize-deposit-payment').attr('disabled', true);
			}
		}

	})
$(document).on('click', '.deposit-payment', function(e){
	e.preventDefault();
	deposit_id = $(this).closest('tr').find('.deposit_id').val();
	$('#remain_balance').text($(this).closest('tr').find('td').eq(1).html());
	var balance_string = $('#remain_balance').text().trim();
	dep_balance = parseFloat(balance_string.slice(3, balance_string.length));
	console.log(dep_balance);

	$('#rem_bal').val($(''))
	$('#depModal').modal('show');
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
	var amt = parseFloat($('#amount').val());
	var rem = $('#remarks').val();

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
						'isCheque' : 0,
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
						'isCheque' : 0,
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
					'isCheque' : 0,
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

	var amt = parseFloat($('#bill_amount').val());
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
						'isCheque' : 0,
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
						'isCheque' : 0,
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
					'isCheque' : 0,
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
$(document).on('click', '.finalize-cheque', function(e){
	$.ajax({
		method: 'POST',
		url: '{{ route("postCheque") }}',
		data: {
			'_token' : $('input[name=_token]').val(),
			'chequeNumber' : $('#chqNo').val(),
			'bankName' : $('#bank').val(),
			'isVerify' : 0
			'bi_head_id' : {{ $so_head_id }},
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
		}
	})
})


</script>
@endpush