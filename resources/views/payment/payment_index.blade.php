@extends('layouts.app')
@section('content')
<h2>&nbsp;Payment</h2>
<hr>
<div class="container-fluid">
	<div class="row collapse in" id="history_collapse">
		<div class="panel-default panel">
			<br>
			<div class="pull-right">
				<a class="btn but collapse in" id="btn_pso">Select Service Order</a>
			</div>
			<br>
			<br>
			<div class="panel-heading" id="heading">Payment History</div>
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
								Amount
							</td>
							<td>
								Payment Mode
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
	<div class="row collapse" id="pso_collapse">
		<div class="panel-default panel">
			<br>
			<div class="pull-right">
				<a class="btn but collapse in" id="btn_back">Back to Payment History</a>
			</div>
			<br>
			<br>
			<div class="panel-heading" id="heading">Service Order</div>
			<div class = "panel-body">
				<br>
				<table class = "table-responsive table" id = "so_table">
					<thead>
						<tr>
							<td>
								No.
							</td>
							<td>
								Consignee
							</td>
							<td>
								Service Order
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
	var data;
	var so_head_id;


	$(document).ready(function(){
		var vtable = $('#bill_hist_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: "{{ route('pso_head.data') }}",
			columns: [
			{ data: 'id' },
			{ data: 'companyName' },
			{ data: 'amount' },
			{ data: 'isCheque',
			"render" : function( data, type, full ) {return formatStatus(data); }},
			{ data: 'action', orderable: false, searchable: false }
			],
			columnDefs: [

			{"className": "dt-right", "targets": "1"}

			]
		})
		function formatStatus(n) {

			if (n == '0'){
				return "Cash";
			}else{
				return "Cheque";
			}
		}
	})
	$(document).on('click', '#btn_pso', function(e){
		$('#pso_collapse').addClass('in');
		$('#history_collapse').removeClass('in');
		var vtable = $('#so_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: "{{ route('p_order.data') }}",
			columns: [
			{ data: 'id' },
			{ data: 'companyName' },
			{ data: 'name' },
			{ data: 'action', orderable: false, searchable: false }
			],
			columnDefs: [

			{"className": "dt-right", "targets": "1"}

			]
		})
	})
	$(document).on('click', '#btn_back', function(e){
		location.reload();
	})
</script>
@endpush