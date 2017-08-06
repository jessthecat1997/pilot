@extends('layouts.app')
@section('content')
<h3><img src="/images/bar.png"> Billing</h3>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel">
			<div class="panel-heading" id="heading">Consignee Details</div>
			<table class="table">
				<tbody>
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
					<tr>
						<td>
							<button class="btn btn-info" id="bill_hist">View Billing History</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<hr>
	<div class="row collapse in" id="bill_collapse">
		<div class="panel-default panel">
			<div class="panel-heading" id="heading">List of Bills and Refundable Charges</div>
			<div class="panel-body">
				<table class = "table-responsive table" id = "br_bill_table">
					<thead>
						<tr>
							<td>
								&nbsp;
							</td>
							<td>
								<a href='/billing/{{ $bill->id }}/create' class="btn btn-info form-control col-sm-4 add_bill">New Bill</a>
							</td>
						</tr>
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
				<table class = "table-responsive table" id = "br_rc_table">
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
	</div>
	<div class="row collapse" id="hist_collapse">
		<div class="panel-default panel">
			<div class="panel-heading" id="heading">Billing History</div>
			<div class = "panel-body">
				<br>
				<table class = "table-responsive table" id = "bill_hist_table">
					<thead>
						<tr>
							<td>
								ID
							</td>
							<td>
								Payment Allowance
							</td>
							<td>
								Date Billed
							</td>
							<td>
								Actions
							</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection
@push('styles')
<style>
	.class-billing
	{
		border-left: 10px solid #3ce28e;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	$('#collapse1').addClass('in');
	console.log('{{ $so_head_id }}')
	console.log('{{ route('invoice.data',$so_head_id) }}/{{ $so_head_id }}');
	var data;
	$(document).ready(function(){
		var br_table = $('#br_bill_table').DataTable({
			processing: false,
			serverSide: true,
			ajax: "{{ route('br_bill.data') }}",
			columns: [
			{ data: 'name' },
			{ data: 'Total' }
			]
		})
		var rc_table = $('#br_rc_table').DataTable({
			processing: false,
			serverSide: true,
			ajax: "{{ route('br_rc.data') }}",
			columns: [
			{ data: 'description' },
			{ data: 'amount' }
			]
		})
	})
	$(document).on('click', '#bill_hist', function(e){
		$("#bill_collapse").removeClass('in');
		$("#hist_collapse").addClass('in');
		var vtable = $('#bill_hist_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('invoice.data',$so_head_id) }}",
			columns: [
			{ data: 'id' },
			{ data: 'paymentAllowance' },
			{ data: 'created_at' },
			{ data: 'action', orderable: false, searchable: false }
			]
		})
	})
</script>
@endpush