@extends('layouts.app')
@section('content')
<h2>&nbsp;Payment</h2>
<hr>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-8">
			<div class="panel panel-primary">
				<div class="panel-heading">
					Payment History
				</div>
				<div class="panel-body">
					<table class = "table-responsive table" id="bill_hist_table">
						<thead>
							<tr>
								<th>
									Consignee
								</th>
								<th>
									Amount
								</th>
								<th>
									Payment Mode
								</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="panel panel-primary">
				<div class="panel-heading">
					Select Service Order
				</div>
				<div class="panel-body">
					<table class = "table-responsive table" id = "so_table">
						<thead>
							<tr>
								<th>
									Consignee
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
			{ data: 'companyName' },
			{ data: 'amount' },
			{ data: 'isCheque', "render" : function( data, type, full ) 
			{
				return formatStatus(data); 
			}
		},
		]
	})
		var sptable = $('#so_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: "{{ route('p_order.data') }}",
			columns: [
			{ data: 'companyName' },
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
</script>
@endpush