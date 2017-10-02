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
		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">Consignee Details</div>
				<div class="panel-body">
					<div class="form-group">
						<label>Consignee:</label>
						<input type="text" class="det" value="{{ $bills[0]->companyName }}" id="companyName" disabled>
					</div>
					<div class="form-group">
						<h5 id="address"><strong>Address:</strong> {{ $bills[0]->address }}</h5>
					</div>
					<div class="form-group">
						<label>Service Order:</label>
						<input type="text" class="det" value="{{ $bills[0]->name }}" id="sotype" disabled>
					</div>
					<button class="btn btn-primary col-sm-4 pull-right new_bill_modal" data-toggle="modal" data-target="#billModal">Create Bill</button>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					Pending Invoice
				</div>
				<div class="panel-body">
					<table class = "table table-hover" id = "hist_table">
						<thead>
							<tr>
								<th>
									No.
								</th>
								<th>
									Status
								</th>
								<th>
									Due Date
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
	<hr>
</div>
<div id="billModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">New Billing Invoice</h4>
			</div>
			<div class="modal-body">
				<div class="col-sm-12">
					<form class="form">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="date_billed">Date Billed:*</label>
							<input type="date" class="form-control" id="date_billed">
						</div>
						<div class="form-group">
							<label for="due_date">Due Date:*</label>
							<input type="date" class="form-control" id="due_date">
						</div>
						<input type="hidden" class="form-control" id="vat" value="{{ $vat[0]->rates }}" disabled>
					</form>
				</div>
				<strong>Note:</strong> All fields with * are required.
			</div>
			<div class="modal-footer">
				<button class="btn but save-header">Save</button>
			</div>
		</div>
	</div>
</div>
<div id="updateModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Update Billing Invoice</h4>
			</div>
			<div class="modal-body">
				<div class="col-sm-12">
					<form class="form">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="date_billed">Date Billed:*</label>
							<input type="date" class="form-control" id="update_billed">
						</div>
						<div class="form-group">
							<label for="due_date">Due Date:*</label>
							<input type="date" class="form-control" id="updue_date">
						</div>
						<input type="hidden" class="form-control" id="update_vat" value="{{ $vat[0]->rates }}">
					</form>
				</div>
				<strong>Note:</strong> All fields with * are required.
			</div>
			<div class="modal-footer">
				<a class="btn but update-header">Save</a>
			</div>
		</div>
	</div>
</div>
<div id="voidModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Void Billing Invoice</h4>
			</div>
			<div class="modal-body">
				<form>
					{{ csrf_field() }}
					<strong>Are you to sure to void the billing invoice?</strong>
				</form>
			</div>
			<div class="modal-footer">
				<a class="btn btn-success void-header">Confirm</a>
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
	console.log('{{ route('history.data',$so_head_id) }}/{{ $so_head_id }}');

	var void_id = null;
	var update_id = null;
	var data;
	$(document).ready(function(){
		$(document).on('click', '.new_bill_modal', function(e){
			e.preventDefault();
		})
		var hist_table = $('#hist_table').DataTable({
			processing: false,
			serverSide: false,
			ajax: "{{ route('history.data',$so_head_id) }}",
			columns: [
			{ data: 'id' },
			{ data: 'isFinalize',
			"render" : function( data, type, full ) {return formatWithBillType(data); }},
			{ data: 'due_date' },
			{ data: 'action', orderable: false, searchable: false }
			]
		})
		function formatWithBillType(n) {

			if (n == 0){
				return "Pending";
			}else{
				return "Posted";
			}
		}

	})

	$(document).on('click', '.updateBill', function(e){
		e.preventDefault();
		update_id = $(this).val();
	})

	$(document).on('click', '.voidBill', function(e){
		e.preventDefault();
		void_id = $(this).val();
	})
	$(document).on('click', '.save-header', function(e){
		$.ajax({
			method: 'POST',
			url: '/postHeader',
			data: {
				'_token' : $('input[name=_token]').val(),
				'so_head_id' : {{ $bills[0]->id }},
				'vatRate' : $('#vat').val(),
				'status' : 'U',
				'date_billed' : $('#date_billed').val(),
				'due_date' : $('#due_date').val()
			},
			success: function (data){
				location.reload();
			}
		})
	})
	$(document).on('click', '.update-header', function(e){
		console.log($('#update_billed').val());

		$.ajax({
			method: 'PUT',
			url: '{{ route("billing_header.update", $so_head_id) }}',
			data: {
				'_token' : $('input[name=_token]').val(),
				'vatRate' : $('#update_vat').val(),
				'date_billed' : $('#update_billed').val(),
				'due_date' : $('#updue_date').val(),
				'bi_head' : update_id,
			},
			success: function (data){
				location.reload();
			}
		})

	})
	$(document).on('click', '.void-header', function(e){
		$.ajax({
			method: 'PUT',
			url: '{{ route("void_bill") }}/{{ $so_head_id }}' ,
			data: {
				'_token' : $('input[name=_token]').val(),
				'bi_head' : void_id,
				'isVoid' : 1
			},
			success: function (data){
				location.reload();
			}
		})

	})
</script>
@endpush
