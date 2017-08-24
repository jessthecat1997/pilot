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
				<a href="/billing/{{ $bills[0]->id }}/create" class="btn but col-sm-4 pull-right">Create Bill</a>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="panel-default panel">
			<div class="panel-heading" id="heading">Billing History</div>
			<div class = "panel-body">
				<br>
				<table class = "table-responsive table" id = "bill_hist_table">
					<thead>
						<tr>
							<td>
								No.
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
	<hr>	
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
	console.log('{{ route('invoice.data',$so_head_id) }}/{{ $so_head_id }}');
	var data;
	$(document).ready(function(){
		
		var vtable = $('#bill_hist_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('invoice.data',$so_head_id) }}",
			columns: [
			{ data: 'id' },
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
</script>
@endpush