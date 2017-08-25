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
		<div class="col-sm-12">
			<div class="panel-heading" id="heading">Consignee Details</div>
			<div class="panel-body">
				<div class="col-sm-12">
					<div class="col-sm-3">
						<div class="form-group">
							<label for="consignee">Company:</label>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="form-group">
							<label id="consignee">{{ $bills[0]->companyName }}</label>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="col-sm-3">
						<div class="form-group">
							<label for="address">Address:</label>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="form-group">
							<label id="address">{{ $bills[0]->address }}</label>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="col-sm-3">
						<div class="form-group">
							<label for="sotype">Service Order:</label>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="form-group">
							<label id="sotype">{{ $bills[0]->name }}</label>
						</div>
					</div>
				</div>
				<button class="btn but col-sm-4 pull-right" data-toggle="modal" data-target="#billModal">Create Bill</button>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="panel-default panel">
			<div class="panel-heading" id="heading">Unpaid Invoice</div>
			<div class = "panel-body">
				<br>
				<table class = "table-responsive table" id = "hist_table">
					<thead>
						<tr>
							<td>
								No.
							</td>
							<td>
								Type
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
					<form class="form-inline">
						{{ csrf_field() }}
						<div class="col-sm-3">
							<div class="form-group">
								<label for="vat">Vat Rate:*</label>
								<input type="text" class="form-control" id="vat" value="{{ $vat[0]->rates }}">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label for="date_billed">Date Billed:*</label>
								<input type="date" class="form-control" id="date_billed">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label for="due_date">Due Date:*</label>
								<input type="date" class="form-control" id="due_date">
							</div>
						</div>
					</form>
				</div>
				<strong>Note:</strong> All fields with * are required.
			</div>
			<div class="modal-footer">
				<a class="btn but save-header">Save</a>
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
	var data;
	$(document).ready(function(){
		console.log($('input[name=_token]').val());

		var hist_table = $('#hist_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('history.data',$so_head_id) }}",
			columns: [
			{ data: 'id' },
			{ data: 'isRevenue' },
			{ data: 'due_date' },
			{ data: 'action', orderable: false, searchable: false }
			]
		})

	})
	$(document).on('click', '.save-header', function(e){
		$.ajax({
			method: 'POST',
			url: '{{ route("billing_header.store") }}',
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
</script>
@endpush