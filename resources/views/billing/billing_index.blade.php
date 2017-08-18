@extends('layouts.app')
@section('content')
<h2>&nbsp;Billing</h2>
<div class="pull-left">
	<a href="/billing" class="btn but">Back</a>
</div>
<br/>
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
							<button class="btn but col-sm-3 pull-right" id="bill_hist">View Billing History</button>
						</td>
						<td>
							<a href='/billing/{{ $bills[0]->id }}/create' class="btn but col-sm-12 add_bill">New Bill</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<hr>

	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Modal Header</h4>
				</div>
				<div class="modal-body">
					<p>Some text in the modal.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
	<div class="row collapse in" id="bill_collapse">
		<div class="panel-default col-sm-6">
			<button type="button" class="btn but pull-right" data-toggle="modal" data-target="#myModal">New Revenue</button>
			<br/>
			<br/>
			<div class="panel-heading" id="heading">List of Revenues</div>
			<div class="panel-body">
				<table class = "table-responsive table" id = "rev_table">
					<thead>
						<tr>
							<td>
								Name
							</td>
							<td>
								Description
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
		<button type="button" class="btn but pull-right" data-toggle="modal" data-target="#myModal">New Revenue</button>
			<br/>
			<br/>
			<div class="panel-heading" id="heading">List of Expenses</div>
			<div class="panel-body">
				<table class = "table-responsive table" id = "exp_table">
					<thead>
						<tr>
							<td>
								Name
							</td>
							<td>
								Description
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
								Vat Rate
							</td>
							<td>
								Date Billed
							</td>
							<td>
								Due Date
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
		border-left: 10px solid #8ddfcc;
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
		var br_table = $('#exp_table').DataTable({
			processing: false,
			serverSide: true,
			ajax: "{{ route('expenses.data', $so_head_id) }}",
			columns: [
			{ data: 'name' },
			{ data: 'description' },
			{ data: 'amount' }
			]
		})
		var rc_table = $('#rev_table').DataTable({
			processing: false,
			serverSide: true,
			ajax: "{{ route('revenue.data',$so_head_id) }}",
			columns: [
			{ data: 'name' },
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
			{ data: 'vatRate' },
			{ data: 'date_billed' },
			{ data: 'due_date' },
			{ data: 'action', orderable: false, searchable: false }
			]
		})
	})
</script>
@endpush