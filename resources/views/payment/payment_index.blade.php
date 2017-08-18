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
		<h1 class="pull-left col-sm-3">Total: </h1>
		<button type="button" class="btn but pull-right" data-toggle="modal" data-target="#revModal">New Payment</button>
		<br/>
		<br/>
		<br/>
		<br/>
		<div class="panel-heading" id="heading">Payment</div>
		<div class="panel-body">
			<table class = "table-responsive table" id = "revTable">
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
		</div>
	</div>
	<hr>
	<!-- <div class="row">
		<div class="panel-default col-sm-6">
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
							<td>
								Action
							</td>
						</tr>
					</thead>
				</table>
				<br>
			</div>
		</div>
		<div class="panel-default col-sm-6">
			<div class="panel-heading" id="heading">Payment details</div>
			<div class = "panel-body">
				<form class="form-inline">
					{{ csrf_field() }}
					<div class="form-group col-sm-10">
						<label for="total">Total:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<input type="text" class="form-control" id="total" disabled>
					</div>
				</form>
				<br>
				<br>
				<div class="form-group">
					<a class="btn but finalize-payment col-sm-6">Save</a>
					<a href="/payment/{{ $pay->id }}/show_pdf" class="btn but col-sm-6 pull-right">Generate Receipt</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		@forelse($rev as $r)
		<input type="text" value="{{ $r->Total }}" id="rev" hidden/>
		@empty
		@endforelse
		@forelse($exp as $e)
		<input type="text" value="{{ $e->Total }}" id="exp" hidden/>
		@empty
		@endforelse
	</div> -->
	<div id="revModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">New Payment</h4>
				</div>
				<div class="modal-body">
					<table class = "table-responsive table" id = "rev_table">
						<thead>
							<tr>
								<td colspan="5">
									<button class = "btn but btn-md new-rev-row pull-right">Add Payment</button>
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
									Action
								</td>
							</tr>
						</thead>
						<tbody>
							<tr id = "revenue-row" name="revenue-row">
								<form class="form-horizontal">
									{{ csrf_field() }}
									<td>
										<select name = "rev_bill_id" class = "form-control ">
											<option>

											</option>
											@forelse($bill_revs as $rev)
											<option value = "{{ $rev->id }}">
												{{ $rev->name }}
											</option>
											@empty
											@endforelse
										</select>
									</td>
									<td>
										<input type = "text" name = "rev_amount" class = "form-control" style="text-align: right">
									</td>
									<td>
										<button class = "btn btn-danger btn-md delete-billing-row">Remove</button>
									</td>
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
	var rev = $('#rev').val();
	var exp = $('#exp').val();
	var totalamt = $('#total');
	var totals = 0;
	totals = +rev + +exp;
	totalamt.val(totals);

	var tot = $('#total').val();
	$(document).ready(function(){
		var b_table = $('#bill_table').DataTable({
			processing: false,
			serverSide: true,
			ajax: "{{ route('payments.data', $so_head_id) }}",
			columns: [
			{ data: 'name' },
			{ data: 'amount' },
			{ data: 'action'}
			]
		})
	})
	$(document).on('click', '.makePayment', function(e){
		var amount = $(this).val();
		console.log(amount);
		totalamt.val(amount);
	})
	$(document).on('click', '.finalize-payment', function(e){
		$.ajax({
			method: 'POST',
			url: '{{ route("payment.store") }}',
			data: {
				'_token' : $('input[name=_token]').val(),
				'so_head_id' : {{ $so_head_id }},
				'amount' : totals,
				'bi_head_id' : {{ $so_head_id }}
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
						window.location.href = "{{ route('view.index') }}";
					}
				})
			}
		})
	})

</script>
@endpush