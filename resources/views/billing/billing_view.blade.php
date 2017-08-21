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
		<div class = "panel-default panel">
			<div class="panel-heading" id="heading">Consignee Details</div>
			<table class="table">
				<tbody>
					<tr>
						<td class="active"><strong>Consignee: </strong></td>
						
						<td class = "success" id="consignee"><strong>{{ $bills[0]->companyName }}</strong></td>
						<td class="success">
							
						</td>
					</tr>
					<tr>
						<td class="active"><strong>Address: </strong></td>
						<td class="success" id="address"><strong>{{ $bills[0]->address }}</strong></td>
						<td class="success">
							
						</td>
					</tr>
					<tr>
						<td class="active"><strong>Service Order: </strong></td>

						<td class="success" id="sotype"><strong>{{ $bills[0]->name }}</strong></td>
						<td class="success">
							
						</td>
					</tr>
					<tr>
						<td>

						</td>
						<td>
							
						</td>
						<td>
							<a href="/billing/{{ $bills[0]->id }}/create" class="btn but col-sm-6 pull-right">Create Bill</a>
						</td>
					</tr>
				</tbody>
			</table>
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
								ID
							</td>
							<td>
								Vat Rate
							</td>
							<td>
								Status
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
			{ data: 'vatRate' },
			{ data: 'status' },
			{ data: 'amount' },
			{ data: 'due_date' },
			{ data: 'action', orderable: false, searchable: false }
			]
		})
		
	})
</script>
@endpush