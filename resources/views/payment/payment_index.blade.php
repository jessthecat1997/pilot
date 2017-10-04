@extends('layouts.app')
@section('content')
<h2>&nbsp;Payment</h2>
<div class="pull-right">
	<a href="/cheque" class="btn but">Unconfirm Cheques</a>
</div>
<br/>
<hr>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					Payment History
				</div>
				<div class="panel-body">
					<table class = "table-responsive table" id="bill_hist_table">
						<thead>
							<tr>
								<th>
									No.
								</th>
								<th>
									Consignee
								</th>
								<th>
									Amount
								</th>
								<th>
									Payment Mode
								</th>
								<th>
									Allowance (days)
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
		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					Select Billing Invoice
				</div>
				<div class="panel-body">
					<table class = "table-responsive table" id = "so_table">
						<thead>
							<tr>
								<th>
									Invoice No.
								</th>
								<th>
									Amount
								</th>
								<th>
									Balance
								</th>
								<th>
									Actions
								</th>
							</tr>
						</thead>
					</table>
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
			{ data: 'isCheque', "render" : function( data, type, full ) 
			{
				return formatStatus(data); 
			}},
			{ data: 'payment_allowance' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "desc" ]],

			
		});
		var sptable = $('#so_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: "{{ route('p_order.data') }}",
			columns: [
			{ data: 'id' },
			{ data: 'totall' },
			{ data: 'balance' },
			{ data: 'action', orderable: false, searchable: false }
			], "order": [[ 0, "desc" ]],
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
	$(document).on('click', '.payment_receipt', function(e){
		e.preventDefault();
		type = $(this).closest('tr').find('.type').val();
		console.log($(this).val());
		window.open("{{ route('payment_receipt') }}/" + $(this).val());
	})
</script>
@endpush