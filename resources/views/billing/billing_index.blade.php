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
						
						<td class = "success" id="consignee"><strong>{{ $bills[0]->companyName }}</strong></td>
						<td class="success">
							
						</td>
					</tr>
					<tr>
						<td class="active"><strong>Address: </strong></td>
						<td class="success" id="address"><strong>{{ $bills[0]->address }}</strong></td>
						<td class="success">
							
						</td>
					</tr>
					<tr>
						<td class="active"><strong>Service Order: </strong></td>

						<td class="success" id="sotype"><strong>{{ $bills[0]->name }}</strong></td>
						<td class="success">
							
						</td>
					</tr>
					<tr>
						<td>

						</td>
						<td>
							<button class="btn btn-info col-sm-3 pull-right" id="bill_hist">View Billing History</button>
						</td>
						<td>
							<a value='/billing/{{ $bills[0]->id }}/create' class="btn btn-info col-sm-12 add_bill">New Bill</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<hr>
	<div class="row collapse in" id="bill_collapse">
		<div class="panel-default col-sm-6">
			<div class="panel-heading" id="heading">List of Revenues</div>
			<div class="panel-body">
				<table class = "table-responsive table" id = "br_bill_table">
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
		<div class="panel-default col-sm-6">
			<div class="panel-heading" id="heading">List of Expenses</div>
			<div class="panel-body">
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
	<div class="row">
		<div class="panel-default panel">
			<div class="panel-heading" id="heading">Delivery Bill</div>
			<div class="panel-body">
				<table class="table-responsive table">
					<thead>
						<tr>
							<td>
								Charges
							</td>
							<td>
								Amount
							</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							@forelse($delivery as $del)
							<td>
								{{ $del->description }}
							</td>
							@empty
							@endforelse
							@forelse($delivery as $del)
							<td>
								{{ $del->amount }}
							</td>
							@empty
							@endforelse
						</tr>
					</tbody>
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
			ajax: "{{ route('expenses.data') }}",
			columns: [
			{ data: 'name' },
			{ data: 'Total' }
			]
		})
		var rc_table = $('#br_rc_table').DataTable({
			processing: false,
			serverSide: true,
			ajax: "{{ route('revenue.data') }}",
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