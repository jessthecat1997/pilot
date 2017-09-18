@extends('layouts.app')
@section('content')
<h2>&nbsp;Billing</h2>
<hr>
<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-info">
			<div class="panel-heading"><h4>Consignee Details</h4></div>
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
				<div class="form-group">
					<label>Status:</label>
					@if($bills[0]->status == 'P')
					<label class="label label-success" id="status">Paid</label>
					@else
					<label class="label label-danger" id="status">Not Paid</label>
					@endif
				</div>
				<div class="form-group">
					<label>Invoice No.:</label>
					<input type="text" class="det" value="{{ $so_head_id }}" id="so_head_id" disabled>
				</div>
				<div class="form-group">
					<label>Due Date:</label>
					<input type="text" class="det" value="{{ Carbon\Carbon::parse($bills[0]->due_date)->toFormattedDateString() }}" id="due_date" disabled>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="panel panel-info">
			@if($bills[0]->isRevenue == 1)
			<div class="panel-heading">
				List of Bills
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Name</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
							@forelse($rev_bill as $bill)
							<tr>
								<td style="text-align: center;">{{ $bill->name }}</td>
								<td style="text-align: center;">Php&nbsp;{{ $bill->amount }}</td>
							</tr>
							@empty
							<tr>
								<td colspan="2" style="text-align: center;"><strong>No records available.</strong></td>
							</tr>
							@endforelse
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							@forelse($rev_vat as $vr)
							<tr>
								<td style="text-align: center;"><strong>{{ $vr->rates }}% VAT</strong></td>
								<td style="text-align: center;">Php&nbsp;{{ $vr->Total }}</td>
							</tr>
							@empty
							<tr>
								<td colspan="2">No records available.</td>
							</tr>
							@endforelse
							@forelse($rev_total as $rt)
							<tr>
								<td style="text-align: right;">
									<label for="bal"><strong>TOTAL: &nbsp;</strong></label>
								</td>
								<td style="text-align: center;">
									<h3>Php&nbsp;&nbsp;{{ $rt->Total }}</h3>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="2">No records available.</td>
							</tr>
							@endforelse
						</tbody>
					</table>
					<div class="form-group  pull-left">
						<a href="/billing/{{ $so_head_id }}/show_pdf" class="btn but">Print Invoice</a>
					</div>
				</div>
			</div>
			@else
			<div class="panel-heading"><h4>List of Refundable Charges</h4></div>
			<div class = "panel-body">
				<table class="table table-hover" id="expense_table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						@forelse($exp_bill as $bill)
						<tr>
							<td style="text-align: center;">{{ $bill->name }}</td>
							<td style="text-align: center;">Php&nbsp;{{ $bill->amount }}</td>
						</tr>
						@empty
						<tr>
							<td colspan="2" style="text-align: center;"><strong>No records available.</strong></td>
						</tr>
						@endforelse
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						@forelse($exp_vat as $vr)
						<tr>
							<td style="text-align: center;"><strong>{{ $vr->rates }}% VAT</strong></td>
							<td style="text-align: center;">Php&nbsp;{{ $vr->Total }}</td>
						</tr>
						@empty
						<tr>
							<td colspan="2">No records available.</td>
						</tr>
						@endforelse
						@forelse($exp_total as $rt)
						<tr>
							<td style="text-align: right;">
								<label for="bal"><strong>TOTAL: &nbsp;</strong></label>
							</td>
							<td style="text-align: center;">
								<h3>Php&nbsp;&nbsp;{{ $rt->Total }}</h3>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="2">No records available.</td>
						</tr>
						@endforelse
					</tbody>
				</table>
				<div class="form-group  pull-left">
					<a href="/billing/{{ $so_head_id }}/show_pdf" class="btn but">Print Invoice</a>
				</div>
			</div>
			@endif
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
@push('scripts')
<script type="text/javascript">
	$('#collapse1').addClass('in');


	$(document).ready(function(){
		var bi_id = document.getElementById("so_head_id").value;
		console.log(bi_id);

	})
</script>
@endpush