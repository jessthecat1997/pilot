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
					<div style="overflow-y: scroll;">
						<table style="width: 100%;" class="table table-striped">
							<thead>
								<tr>
									<td colspan="2">
										<strong>Changes</strong>
									</td>
								</tr>
							</thead>
							<tbody>
								@php $ctr = 1; @endphp
								@forelse($amendments as $amendment)
								<tr>
									<td>
										{{ $ctr++ }}.
									</td>
									<td>
										{{ $amendment->amendment }}
									</td>
								</tr>
								@empty

								@endforelse

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class = "row">
	<div class  = "col-md-10 col-md-offset-1">
		<div class = "">
			<div class = "panel-body">
				<h3>Contract Rates</h3>
				<hr />
				<div class = "col-md-12	">
					<br />
					<table class = "table table-striped table-responsive" id = "contract_rates_table" style="width: 100%;">
						<thead>
							<tr>
								<td>
									<strong>Area From</strong>
								</td>
								<td>
									<strong>Area To</strong>
								</td>
								<td>
									<strong style="text-align: center;">Amount</strong>
								</td>
								<td>
									<strong style="text-align: center;">Action</strong>
								</td>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
					<br />
					<div class="row">
						<div class = "col-md-4">
							<button  type = "submit" style="width: 100%;" class = "btn btn-primary btn-sm new_delivery_rate pull-left">New Rate</button>
						</div>
						<div class = "col-md-4">

						</div>
						<div class = "col-md-4">
							<a class = "btn pull-left" data-target="#arModal" data-toggle = "modal">+ New Area</a>
						</div>
					</div>
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
						<h4 class="modal-title" id = "delivery_modal_title">Update Delivery Rate</h4>
					</div>
					<div class="modal-body">			
						<div class="form-group required">
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
						<div class="form-group required">
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
							<input type = "number" class = "form-control" name = "amount" id = "amount" style = "text-align: right;" required />
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
<section class="content">
	<form role="form" method = "POST" id = "commentForm">
		{{ csrf_field() }}
		<div class="modal fade" id="arModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">New Area</h4>
					</div>
					<div class="modal-body">			
						<div class="form-group required">
							<label class = "control-label">Name: </label>
							<input type = "text" class = "form-control" name = "description" id = "description"  minlength = "2" data-rule-required="true" />

						</div>
					</div>
					<div class="modal-footer">
						<input id = "btnSave" type = "submit" class="btn btn-success submit" value = "Save" />
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
		var crtable = $('#contract_rates_table').DataTable({
			processing: false,
			serverSide: true,
			ajax: '{{ route("trucking.index") }}/contracts/{{ $contract[0]->id }}/rates',
			columns: [
			{ data: 'from' },
			{ data: 'to' },
			{ data: 'amount' },
			{ data: 'action', orderable: false, searchable: false }

			],

		});

		$(document).on('click', '.generate_pdf', function(e){
			window.open("{{ route('contracts.index') }}/{{ $contract[0]->id }}/show_pdf");
		})

		$(document).on('click', '.update-contract-rate', function(e){
			e.preventDefault();
			$('#crModal').modal('show');

			$('#delivery_modal_title').html('Update Delivery Rate');

			$('.selected_contract_detail').val($(this).closest('tr').find('.selected_contract_detail').val());

			console.log($(this).closest('tr').find('.selected_from_id').val());
			$('#area_from').val($(this).closest('tr').find('.selected_from_id').val());
			$('#area_to').val($(this).closest('tr').find('.selected_to_id').val());
			$('#amount').val($(this).closest('tr').find('.selected_amount').val());

		})

		$(document).on('click', '.new_delivery_rate', function(e){
			e.preventDefault();
			$('#delivery_modal_title').html('New Delivery Rate');

			$('#area_from').val("");
			$('#area_to').val("");
			$('#amount').val("");

			$('#crModal').modal('show');

		})

		$(document).on('click', '.change-contract-duration', function(e){
			e.preventDefault();
			$('#dateEffective').val($('.actualDateEffective').val());
			$('#dateExpiration').val($('.actualDateExpiration').val());

			$('#drModal').modal('show');
		})

		$(document).on('click', '.update_delivery_rate_save', function(e){
			e.preventDefault();

			var title = $('#delivery_modal_title').html();

			if(title == "New Delivery Rate")
			{
				
				$.ajax({
					type: 'POST',
					url:  '{{ route("trucking.index")}}/contracts/{{ $contract[0]->id }}/store_rates',
					data: {
						'_token' : $('input[name=_token').val(),
						'update_type' : 2,
						'areas_id_from' : $('#area_from').val(),
						'areas_id_to' :  $('#area_to').val(),
						'amount' : $('#amount').val(),
						'from_descrp' : $('#area_from option:selected').text(),
						'to_descrp' : $('#area_to option:selected').text(),
					},
					success: function (data)
					{
						$('#crModal').modal('hide');

						$('#area_from').val("");
						$('#area_to').val("");
						$('#amount').val("");

						crtable.ajax.reload();
					}
				});
			}

			else 
			{
				$.ajax({
					type: 'PUT',
					url:  '{{ route("trucking.index")}}/contracts/' + $(this).val(),
					data: {
						'_token' : $('input[name=_token').val(),
						'update_type' : 2,
						'areas_id_from' : $('#area_from').val(),
						'areas_id_to' :  $('#area_to').val(),
						'amount' : $('#amount').val(),
						'contract_detail_id' : $('.selected_contract_detail').val(),

					},
					success: function (data)
					{
						$('#crModal').modal('hide');

						$('#area_from').val("");
						$('#area_to').val("");
						$('#amount').val("");

						crtable.ajax.reload();
					}
				});
			}

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
					$('#drModal').modal('hide');
				}
			});

		})
	})
</script>
@endpush