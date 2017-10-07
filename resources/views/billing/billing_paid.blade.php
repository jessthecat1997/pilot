@extends('layouts.app')
@section('content')
<h2>&nbsp;Billing</h2>
<div class="pull-left">
	<a href="/billing" class="btn but">Back</a>
</div>
<br/>
<hr>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Paid Invoices
			</div>
			<div class="panel-body">
				<table class = "table-responsive table" id = "paid_table">
					<thead>
						<tr>
							<th>
								Invoice No.
							</th>
							<th>
								Particulars
							</th>
							<th>
								Amount
							</th>
							<th>
								Bill Type
							</th>
							<th>
								Payment Mode
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

		var vtable = $('#paid_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: "{{ route('paid_bill.data') }}",
			columns: [
			{ data: 'id' },
			{ data: 'name' },
			{ data: 'amount' },
			{ data: 'bill_type',
			"render" : function( data, type, full ) {return formatWithBillType(data); }},
			{ data: 'isCheque',
			"render" : function( data, type, full ) {return formatCheque(data); }},
			{ data: 'action', orderable: false, searchable: false }
			]
		})

		function formatWithBillType(n) {

			if (n == 'R'){
				return "Bill";
			}else{
				return "Refundable";
			}
		}
		function formatCheque(a) {

			if (a == 0){
				return "Cash";
			}else{
				return "Cheque";
			}
		}
	})
</script>
@endpush
