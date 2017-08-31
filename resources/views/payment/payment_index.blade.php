@extends('layouts.app')
@section('content')
<h2>&nbsp;Payment</h2>
<hr>
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
			{ data: 'isRevenue' },
			{ data: 'totall',
			"render" : function( data, type, full ) {
				return formatNumber(data); } },
			{ data: 'due_date' },
			{ data: 'action', orderable: false, searchable: false }
			],
			columnDefs: [

                 {"className": "dt-right", "targets": "1"}

          ]
		})
	})
</script>
@endpush