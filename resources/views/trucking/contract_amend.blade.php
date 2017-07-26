@extends('layouts.app')

@section('content')
<div class = "row">
	<div class  = "col-md-10 col-md-offset-1">
		<div class = "panel default-panel">
			<div class = "panel-heading">
				<h2>View Contract <button class="btn btn-md btn-primary pull-right generate_pdf">Generate Quotation</button></h2>
				<hr />
			</div>
			<div class = "panel-body">
				<div class = "col-md-6">
					<h3>Contract Information</h3>
					<hr />
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label class="control-label col-sm-5" for="contactNumber">Contract #:</label>
							<span class="control-label col-sm-7" for="address" style = "text-align: left;">{{ $contract[0]->id }}</span>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-5" for="contactNumber">Consignee:</label>
							<span class="control-label col-sm-7" for="address" style = "text-align: left;">{{ $contract[0]->name }}</span>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-5" for="contactNumber">Company Name:</label>
							<span class="control-label col-sm-7" for="address" style = "text-align: left;">{{ $contract[0]->companyName }}</span>
						</div>
						<div class="form-group">        
							<label class="control-label col-sm-5" for="contactNumber">Date Effective:</label>
							<span class="control-label col-sm-7" for="address" style = "text-align: left;">{{ Carbon\Carbon::parse($contract[0]->dateEffective)->toFormattedDateString() }}</span>
						</div>
						<div class="form-group">        
							<label class="control-label col-sm-5" for="contactNumber">Date Expiration:</label>
							<span class="control-label col-sm-7" for="address" style = "text-align: left;">{{ Carbon\Carbon::parse($contract[0]->dateExpiration)->toFormattedDateString() }}, ({{ Carbon\Carbon::parse($contract[0]->dateExpiration)->diffForHumans() }})</span>
						</div>
						<div class="form-group" style="text-align: center;">
							<button class="btn btn-primary btn-md change-contract-duration" style="width: 50%;"><span>Change Contract Duration</span></button>
						</div>
						<input type="hidden" name="actualDateEffective" value= "{{ $contract[0]->dateEffective }}" class="actualDateEffective">
						<input type="hidden" name="actualDateExpiration" value = "{{ $contract[0]->dateExpiration }}" class="actualDateExpiration">
					</form>
				</div>
				<div class = "col-md-6">
					<h3>Contract Amendments</h3>
					<hr />

				</div>
			</div>
		</div>
	</div>
</div>
<div class = "row">
	<div class  = "col-md-10 col-md-offset-1">
		<div class = "panel default-panel">
			<div class = "panel-body">
				<h3>Contract Rates</h3>
				<hr />
				<div class = "col-md-10 col-md-offset-1 panel-default panel">
					<table class = "table table-striped table-responsive">
						<thead>
							<tr>
								<td>
									<h4>Area From</h4>
								</td>
								<td>
									<h4>Area To</h4>
								</td>
								<td>
									<h4 style="text-align: center;">Amount</h4>
								</td>
								<td>
									<h4 style="text-align: center;">Action</h4>
								</td>
							</tr>
						</thead>
						@forelse($contract_details as $contract_detail)
						<tr>
							<td>
								{{ $contract_detail->from }}
							</td>
							<td>
								{{ $contract_detail->to }}
							</td>
							<td style="text-align: right;"> 
								Php {{ $contract_detail->amount }}
							</td>
							<td style="text-align: center;">
								<input type="hidden" value = "{{ $contract_detail->id }}" class = "contract_detail_id">
								<input type="hidden" value = "{{ $contract_detail->area_from_id }}" class = "contract_area_from_id">
								<input type="hidden" value = "{{ $contract_detail->area_to_id }}" class = "contract_area_to_id">
								<input type="hidden" value = "{{ $contract_detail->amount }}" class = "contract_amount">
								<button class="btn btn-sm btn-primary update-contract-rate">Update</button>
							</td>

						</tr>
						@empty
						<tr>
							<td colspan="4">
								<h5 style="text-align: center;">No records available.</h5>
							</td>
						</tr>
						@endforelse
					</table>
					<br />
				</div>
			</div>
		</div>
	</div>
</div>
<div class = "row">
	<div class  = "col-md-10 col-md-offset-1">
		<div class = "panel default-panel">
			<div class = "panel-body">
				<h3>Terms &amp; Conditions</h3>
				<hr />
				<div style = "overflow-y: scroll; overflow-wrap: none; height: 300px;" class="panel-default panel">
					@if($contract[0]->specificDetails == null)
					<h5 style="text-align: center;">No specified details</h5>
					@else
					<p><pre class = "">{!! $contract[0]->specificDetails !!}</pre></p>

					@endif
				</div>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<form role="form" method = "POST" id = "commentForm">
		{{ csrf_field() }}
		<div class="modal fade" id="crModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Update Delivery Rate</h4>
					</div>
					<div class="modal-body">			
						<div class="form-group">
							<input type = "hidden" value="" class="selected_contract_detail">
							<label class = "control-label">Area From: </label>
							<select id = "area_from" class="form-control">
								<option></option>
								@forelse($areas as $area)
								<option value = "{{ $area->id }}">{{ $area->description }}</option>
								@empty

								@endforelse
							</select>
						</div>
						<div class="form-group">
							<label class = "control-label">Area To: </label>
							<select id = "area_to" class="form-control">
								<option></option>
								@forelse($areas as $area)
								<option value = "{{ $area->id }}">{{ $area->description }}</option>
								@empty

								@endforelse
							</select>
						</div>
						<div class="form-group required">
							<label class = "control-label">Amount: </label>
							<input type = "number" class = "form-control" name = "amount" id = "amount" required />
						</div>
					</div>
					<div class="modal-footer">
						<input id = "btnSave" type = "submit" class="btn btn-success update_delivery_rate_save" value = "Save" />
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>				
					</div>
				</div>
			</div>
		</div>
	</form>
</section>

<section class="content">
	<form role="form" method = "POST" id = "commentForm">
		{{ csrf_field() }}
		<div class="modal fade" id="drModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Update Contract Duration</h4>
					</div>
					<div class="modal-body">			
						<div class="form-group required">
							<label class = "control-label">Date Effective: </label>
							<input type = "date" class = "form-control" name = "dateEffective" id = "dateEffective" required />
						</div>
						<div class="form-group">
							<label class = "control-label">Date Expiration: </label>
							<input type = "date" class = "form-control" name = "dateExpiration" id = "dateExpiration" required />
						</div>
					</div>
					<div class="modal-footer">
						<input id = "btnSave" type = "submit" class="btn btn-success update_contract_duration_save" value = "Save" />
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>				
					</div>
				</div>
			</div>
		</div>
	</form>
</section>

@endsection
@push('styles')
<style>
	.contracts
	{
		border-left: 10px solid #2ad4a5;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
	pre {border: 0; background-color: transparent;}
</style>
@endpush

@push('scripts')
<script type="text/javascript">
	$(document).ready(function(){

		$(document).on('click', '.generate_pdf', function(e){
			window.open("{{ route('contracts.index') }}/{{ $contract[0]->id }}/show_pdf");
		})

		$(document).on('click', '.update-contract-rate', function(e){
			e.preventDefault();
			$('#crModal').modal('show');

			console.log(this);
			console.log($(this).closest('tr').find(".contract_detail_id").val());


			$('.selected_contract_detail').val($(this).closest('tr').find('.contract_detail_id').val());
			$('#area_from').val($(this).closest('tr').find('.contract_area_from_id').val());
			$('#area_to').val($(this).closest('tr').find('.contract_area_to_id').val());
		})

		$(document).on('click', '.change-contract-duration', function(e){
			e.preventDefault();
			$('#dateEffective').val($('.actualDateEffective').val());
			$('#dateExpiration').val($('.actualDateExpiration').val());

			$('#drModal').modal('show');
		})

		$(document).on('click', '.update_delivery_rate_save', function(e){
			e.preventDefault();
			
			$.ajax({
				type: 'PUT',
				url:  '{{ route("trucking.index")}}/contracts/' + $(this).val(),
				data: {
					'_token' : $('input[name=_token').val(),
					'update_type' : 2,
					'areas_id_from' : $('#area_from').val(),
					'areas_id_to' :  $('#area_to').val(),
					'amount' : $('#amount').val(),
					'contract_detail_id' : $(),

				},
				success: function (data)
				{
					console.log(data);
				}
			});

		})

		$(document).on('click', '.update_contract_duration_save', function(e){
			e.preventDefault();

			$.ajax({
				type: 'PUT',
				url:  '{{ route("trucking.index")}}/contracts/' + $(this).val(),
				data: {
					'_token' : $('input[name=_token').val(),
					'update_type' : 1,
					'dateEffective' : $('#dateEffective').val(),
					'dateExpiration' : $('#dateExpiration').val(),
					'contract_id' : {{ $contract[0]->id }},

				},
				success: function (data)
				{
					console.log(data);
				}
			});

		})
	})
</script>
@endpush