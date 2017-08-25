@extends('layouts.app')
@section('content')
<h2>&nbsp;Billing</h2>
<hr>
<div class="row col-md-5">
	<div class="panel-default panel">
		<div class="panel-heading" id="heading">Consignee Details</div>
		<div class="panel-body">
			<form class="inline">
				<div class="form-group">
					<label>Invoice No.:</label>
					<input type="text" class="det" value="{{ $so_head_id }}" id="so_head_id">
				</div>
				<div class="form-group">
					<label>Due Date:</label>
					<input type="text" class="det" value="{{ Carbon\Carbon::parse($bills[0]->due_date)->toFormattedDateString() }}" id="due_date">
				</div>
				<hr>
				<div class="form-group">
					<label>Consignee:</label>
					<h5>{{ $bills[0]->companyName }}</h5>
				</div>
				<div class="form-group">
					<label>Address:</label>
					<h5>{{ $bills[0]->address }}</h5>
				</div>
				<div class="form-group">
					<label>Service Order:</label>
					<h5>{{ $bills[0]->name }}</h5>
				</div>
				<div class="form-group">
					<label>Status:</label>
					@if($bills[0]->status = 'U')
					<h5>Unpaid</h5>
					@else
					<h5>Paid</h5>
					@endif
				</div>
			</form>
		</div>
	</div>
</div><div class="row col-md-7">
	<div class="panel-default panel">
		<div class="panel-heading" id="heading">List of Revenues</div>
		<div class = "panel-body">
			<form class="form-inline">
				{{ csrf_field() }}
				<table class="table" id="revenue_table">
					<thead>
						<tr>
							<td style="text-align: center;">
								NAME
							</td>
							<td style="text-align: center;">
								AMOUNT
							</td>
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
			</form>
		</div>
	</div>
</div>
<div class="row col-md-5">
</div>
<div class="row col-md-7">
	<div class="panel-default panel">
		<div class="panel-heading" id="heading">List of Expenses</div>
		<div class = "panel-body">
			<form class="form-inline">
				{{ csrf_field() }}
				<table class="table" id="expense_table">
					<thead>
						<tr>
							<td style="text-align: center;">
								NAME
							</td>
							<td style="text-align: center;">
								AMOUNT
							</td>
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
			</form>
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