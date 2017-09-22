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
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					List of unconfirm cheques
				</div>
				<div class="panel-body">
					<table class = "table-hover table" id = "chq_table">
						<thead>
							<tr>
								<th>
									Consignee
								</th>
								<th>
									Bank
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
<div id="confirmModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Confirm Cheque Payment</h4>
			</div>
			<div class="modal-body">
				<p>Verify cheque payment?</p>
			</div>
			<div class="modal-footer">
				<button  class="btn but finalize-confirm">Confirm</button>
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
		var chtable = $('#chq_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: "{{ route('chq.data') }}",
			columns: [
			{ data: 'companyName' },
			{ data: 'bankName' },
			{ data: 'action', orderable: false, searchable: false }
			],
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
	$(document).on('click', '.chq_con', function(e){
		var vt_id = $(this).val();
		console.log(vt_id);
		$.ajax({
			method: 'PUT',
			url: "payment/"+vt_id+"/cheques",
			data: {
				'_token' : $('input[name=_token]').val(),
				'id' : vt_id,
				'isVerify' : 1,
			},
			success: function (data){
				location.reload();
			}
		})
	})
</script>
@endpush