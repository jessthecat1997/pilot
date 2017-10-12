@extends('layouts.app')
@section('content')
<h2>&nbsp;Unconfirm Cheques</h2>
<hr>
<div class="pull-left">
	<a href="/payment" class="btn but">Back to Payment</a>
</div>
<br/>
<br/>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				List of unconfirm cheques
			</div>
			<div class="panel-body">
				<table class = "table table-responsive table-striped cell-border table-bordered" id = "chq_table">
					<thead>
						<tr>
							<th>
								Consignee
							</th>
							<th>
								Bank
							</th>
							<th>
								Amount
							</th>
							<th>
								Invoice No.
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
</div>
<div id="confirmModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Confirm Cheque Payment</h4>
			</div>
			<div class="modal-body">
				<form>
					{{ csrf_field() }}
					<p>Verify cheque payment?</p>
					<input type="hidden" id="vtID">
				</form>
			</div>
			<div class="modal-footer">
				<button  class="btn but finalize-confirm">Save</button>
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
	var vt_id = null;


	$(document).ready(function(){
		var chtable = $('#chq_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: "{{ route('chq.data') }}",
			columns: [
			{ data: 'consignee' },
			{ data: 'bankName' },
			{ data: 'amount'},
			{ data: 'bi_head_id' },
			{ data: 'action', orderable: false, searchable: false }
			],
		})
	})
	$(document).on('click', '.chq_con', function(e){
		e.preventDefault();
		vt_id = $(this).val();
	})
	$(document).on('click', '.finalize-confirm', function(e){
		console.log(vt_id);
		$.ajax({
			type: 'PUT',
			url: '{{ route("cheque.index") }}/' + vt_id,
			data: {
				'_token' : $('input[name=_token]').val(),
				'isVerify' : 1,
				'vt_id' : vt_id,
			},
			success: function (data){
				location.reload();
			}
		})
	})
</script>
@endpush