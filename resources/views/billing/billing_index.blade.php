@extends('layouts.app')
@section('content')
<h3><img src="/images/bar.png"> Billing</h3>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel">
			<div class="panel-heading" id="heading">Consignee Details</div>
			<div class = "panel-body col-sm-12">
				<form class="form-horizontal col-sm-4">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="control-label col-sm-1">Consignee: </label>
						@forelse($bills as $bill)
						<label class="control-label col-sm-6" id="consignee"><strong>{{ $bill->companyName }}</strong></label>
						@empty
						@endforelse
					</div>
					<div class="form-group">
						<label class="control-label col-sm-1">Address: </label>
						@forelse($bills as $bill)
						<label class="control-label col-sm-6" id="address"><strong>{{ $bill->address }}</strong></label>
						@empty
						@endforelse
					</div>
					<div class="form-group">
						<label class="control-label col-sm-1">Service: </label>
						@forelse($bills as $bill)
						<label class="control-label col-sm-6" id="sotype"><strong>{{ $bill->name }}</strong></label>
						@empty
						@endforelse
					</div>
					<div class="form-group col-sm-12">
						<a href='/billing/view/{{ $bill->id }}/create' class="btn btn-info form-control col-sm-4 add_bill">New Bill</a>
					</div>
				</form>

				<div class="col-sm-8">
					<div class="panel-heading"><center><strong>Billing Invoice</strong></center></div>
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
				<br>
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