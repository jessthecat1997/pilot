@extends('layouts.app')
@section('content')
<h2>&nbsp;Billing</h2>
<hr>
<div class="pull-right">
	<a class="btn but" id="btn_newBill">Create New Bill</a>
</div>
<br/>
<br/>
<br/>
<div class="container-fluid">
	<div class="row collapse in" id="history_collapse">
		<div class="panel-default panel">
			<div class="panel-heading" id="heading">List of Invoice</div>
			<div class = "panel-body">
				<br>
				<table class = "table-responsive table" id = "bill_hist_table">
					<thead>
						<tr>
							<td>
								No.
							</td>
							<td>
								Consignee
							</td>
							<td>
								Type
							</td>
							<td>
								Amount
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
	<div class="row collapse" id="so_collapse">
		<div class="panel-default panel">
			<div class="panel-heading" id="heading">Brokerage Service Order</div>
			<div class = "panel-body">
				<br>
				<table class = "table-responsive table" id = "brso_head_table">
					<thead>
						<tr>
							<td>
								No.
							</td>
							<td>
								Consignee
							</td>
							<td>
								Date
							</td>
							<td>
								Actions
							</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
		<hr>	
		<div class="panel-default panel">
			<div class="panel-heading" id="heading">Trucking Service Order</div>
			<div class = "panel-body">
				<br>
				<table class = "table-responsive table" id = "trso_head_table">
					<thead>
						<tr>
							<td>
								No.
							</td>
							<td>
								Consignee
							</td>
							<td>
								Date
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
	var data;
	var so_head_id;


	$(document).ready(function(){

		var vtable = $('#bill_hist_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: "{{ route('invoice.data') }}",
			columns: [
			{ data: 'id' },
			{ data: 'companyName' },
			{ data: 'isRevenue' },
			{ data: 'Total' },
			{ data: 'due_date' },
			{ data: 'action', orderable: false, searchable: false }
			]
		})

		function formatWithStatus(n) { 

			if (n == 'P'){
				return "Paid";
			}else{
				return "Unpaid";
			}
		} 
	})

	$(document).on('click', '#btn_newBill', function(e){
		$('#history_collapse').removeClass('in');
		$('#so_collapse').addClass('in');
		var vtable = $('#brso_head_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{ route("brso_head.data") }}',
			columns: [
			{ data: 'id' },
			{ data: 'companyName' },
			{ data: 'created_at'},
			{ data: 'action', orderable: false, searchable: false, processing:false }
			]
		})
		var trtable = $('#trso_head_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{ route("trso_head.data") }}',
			columns: [
			{ data: 'id' },
			{ data: 'companyName' },
			{ data: 'created_at'},
			{ data: 'action', orderable: false, searchable: false, processing:false }
			]
		})
	})

</script>
@endpush
