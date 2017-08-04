@extends('layouts.app')
@section('content')
<h3><img src="/images/bar.png"> Billing</h3>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel">
			<div class="panel-heading" id="heading"><h4>Consignee Details</h4></div>
			<div class = "panel-body">
				<div class="col-sm-12">
					<form class="form-horizontal col-sm-12">
						{{ csrf_field() }}
						<div class="form-group">
							<label class="control-label col-sm-2">Consignee: </label>
							@forelse($bills as $bill)
							<label class="control-label col-sm-5" id="consignee"><strong>{{ $bill->companyName }}</strong></label>
							@empty
							@endforelse
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">Address: </label>
							@forelse($bills as $bill)
							<label class="control-label col-sm-5" id="address"><strong>{{ $bill->address }}</strong></label>
							@empty
							@endforelse
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">Service: </label>
							@forelse($bills as $bill)
							<label class="control-label col-sm-5" id="sotype"><strong>{{ $bill->description }}</strong></label>
							@empty
							@endforelse
						</div>
					</form>
					<br>
					<div class="form-group col-sm-3">
						<a href='/billing/view/{{ $bill->id }}/create' class="btn btn-info form-control col-sm-3 add_bill">New Bill</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<hr>
<div class="container-fluid">
	<div class="row" id="bill_hist">
		<div class = "panel-default panel">
			<div class="panel-heading" id="heading"><h4>Billing Invoice</h4></div>
			<div class = "panel-body">
				<br>
				<table class = "table-responsive table" id = "bill_hist_table">
					<thead>
						<tr>
							<td>
								ID
							</td>
							<td>
								Payment Allowance
							</td>
							<td>
								Date Billed
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
	.class-billing
	{
		border-left: 10px solid #3ce28e;
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
		$('#bill_hist').addClass('in');
		var vtable = $('#bill_hist_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('invoice.data',$so_head_id) }}",
			columns: [
			{ data: 'id' },
			{ data: 'paymentAllowance' },
			{ data: 'created_at' },
			{ data: 'action', orderable: false, searchable: false }
			]
		})
	})
</script>
@endpush