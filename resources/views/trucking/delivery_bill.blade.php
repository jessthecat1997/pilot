@extends('layouts.app')

@section('content')
<div class = "row">
	<div class = "col-md-10 col-md-offset-1">
		<div class = "panel-default panel">
			<div class = "panel-heading">
				<h3>Bill Delivery <button class="btn btn-sm btn-success pull-right new-delivery-bill">New Delivery Bill</button></h3>
			</div>
			<div class = "panel-body">
				<div class = "col-md-8">
					<h4>Basic Information:</h4>
					<hr />
					<div class = "col-md-10">
						<div class="form-horizontal">
							{{ csrf_field() }}
							<div class="form-group">
								<label class="control-label col-md-5 pull-left" for="deliveryID">Delivery #:</label>
								<span class="control-label col-md-7 pull-right" id = "deliveryID">{{ $delivery[0]->id }}</span>
							</div>
							<div class="form-group">         
								<label class="control-label col-md-5 pull-left" for="deliveryDestination">Consignee:</label>
								<span class="control-label col-md-7 pull-right" id ="deliveryDestination" style = "text-align: right;">{{ $consignee[0]->firstName }}</span>
							</div>
							<div class="form-group">         
								<label class="control-label col-md-5 pull-left" for="deliveryDestination">Destination:</label>
								<span class="control-label col-md-7 pull-right" id ="deliveryDestination" style = "text-align: right;">{{ $delivery[0]->deliveryAddress }}</span>
							</div>

							<div class="form-group">        
								<label class="control-label col-md-5 pull-left" for="status">Status: </label>
								<span class="control-label col-sm-7 pull-right" id="status">
									@php
									switch($delivery[0]->status){
									case 'C': echo "Cancelled"; break;
									case 'F': echo "Finished"; break;
									case 'P': echo "Pending"; break;
									default : echo "Unknown"; break; }
									@endphp
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class = "col-md-4">
					<div class = "col-md-12">
						<h5><strong>Delivery Fee:</strong></h5>
						<hr />
						<h3 style="text-align: center;" class = "pending_delivery">Php {{ $delivery[0]->amount }}</h3>
					</div>
					<div class = "col-md-12">
						<h5><strong>Total Consignee Charges: </strong></h5>
						<hr />
						<h3 style="text-align: center;">Php {{ $total_penalty_consignee }}</h3>
					</div>
					<div class = "col-md-12">
						<h5><strong>Total Pilot Charges:</strong></h5>
						<hr />
						<h3 style="text-align: center;">Php {{ $total_penalty_client }}</h3>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="deliveryModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Delivery Bill</h4>
			</div>
			<div class="modal-body">
				<ul class="nav nav-pills nav-justified">
					<li class="active"><a data-toggle="pill" href="#wocontract">Contract Based</a></li>
					<li><a data-toggle="pill" href="#contract">Non-Contract</a></li>

				</ul>

				<div class="tab-content">
					<div id="contract" class="tab-pane fade">
						<br />
						<form class="form-horizontal" role="form" name = "del_bill_form_con">
							{{ csrf_field() }}

							<div class="form-group">
								<label class="control-label col-sm-3" for="dbfc_amount">Delivery Fee: *</label>
								<div class="col-sm-8"> 
									<input class = "form-control" type = "number" name = "dbfc_amount" id = "dbfc_amount" style="text-align: right" />
								</div>
							</div>

							<div class = "form-group" style="margin-right: 2.0%;">
								<div class='btn-toolbar pull-right'>
									<button class = "btn btn-md btn-success save-delivery-fee-direct">Save</button>
									<button class="btn btn-md  btn-danger" data-dismiss = "modal">Close</button>
								</div>
							</div>
						</form>
					</div>
					<div id="wocontract" class="tab-pane fade in active">
						<br />
						<h4>Consignee Contracts</h4>
						<table class = "table table-responsive" id = "con_contracts">
							<thead>
								<tr>
									<td>		
										
									</td>
									<td>
										Date Effective
									</td>
									<td>
										Date Expiration
									</td>
									<td>
										Status
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
	</div>
</div>


<div id="contractModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Contract</h3>
			</div>
			<div class="modal-body" id = "contract_details">
				<h4><strong>Information</strong></h4>
				<hr />
				<div>
					<div class = "form-horizontal">
						<div class="form-group">
							<label class="control-label col-md-4 pull-left" for="contract_companyName">Consignee:</label>
							<span class="control-label col-md-8 pull-right" id = "contract_companyName">{{ $consignee[0]->companyName }}</span>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-4 pull-left" for="contract_dateEffective">Date Effective:</label>
							<span class="control-label col-md-8 pull-right" id = "contract_dateEffective"></span>
						</div>

						<div class="form-group">
							<label class="control-label col-md-4 pull-left" for="contract_dateExpiration">Contract Expiration Date:</label>
							<span class="control-label col-md-8 pull-right" id = "contract_dateExpiration"></span>
						</div>

						<div class="form-group">
							<label class="control-label col-md-4 pull-left" for="contract_status">Status:</label>
							<span class="control-label col-md-8 pull-right" id = "contract_status"></span>
						</div>
					</div>
				</div>

				<h4><strong>Rates</strong></h4>
				<hr />
				<table class = "table table-responsive table-hover" id = "contract_details_table">
					<thead>
						<tr>
							<td>
								<h5><strong>From</strong></h5>
							</td>
							<td>
								<h5><strong>To</strong></h5>
							</td>
							<td>
								<h5><strong>Amount</strong></h5>
							</td>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>

				<h4><strong>Terms &amp; Conditions</strong></h4>
				<hr />
				<label id="contract_specifications"></label>

				<hr />

				<form class="form-horizontal" role="form" id = "contract_form" name="contract_form">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="control-label col-sm-3" for="cdf_amount">Delivery Fee: *</label>
						<div class="col-sm-8"> 
							<input class = "form-control" type = "number" name = "cdf_amount" id = "cdf_amount" style="text-align: right" />
						</div>
					</div>

					<div class = "form-group" style="margin-right: 2.0%;">
						<div class='btn-toolbar pull-right'>
							<input type="submit" class = "btn btn-md btn-success save-delivery-fee-contract" value = "Save ">
							<button class="btn btn-md  btn-danger close-delivery-fee-contract" data-dismiss = "modal">Close</button>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>


<div id="othersModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Add Charge</h3>
			</div>
			<div class = "modal-body">
				<form class="form-horizontal" role="form" id = "penalty_non_contract_form">
					{{ csrf_field() }}

					<div class="form-group">         
						<label class="control-label col-md-5 pull-left" for="status">Charged To:</label>
						<div class = "col-md-7">
							<label class="radio-inline"><input type = "radio" checked name = "pncf_responsible" value = "N" class = " pull-right checkradio pncf_consignee"/>Consignee</label>
							<label class="radio-inline"><input type = "radio" name = "pncf_responsible"  value = "Y" class = "pull-right checkradio pncf_client"/>Pilot</label>

						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-5" for="containerNumber">Charge:</label>
						<div class = "col-md-6">
							<select class = "form-control pncf_penalty_penalty" id = "pncf_penalty" required id = "pncf_client">
								<option value = "0"></option>
								@forelse($charges as $charge)
								<option value = "{{ $charge->id }}">{{ $charge->description }}</option>
								@empty

								@endforelse
							</select>
						</div>
					</div>
					<div class="form-group">         
						<label class="control-label col-md-5" for="containerReturnTo">Charge Fee:</label>
						<div class = "col-md-6">
							<input type = "number" class = "form-control" style="text-align: right;" id = "pncf_penalty_amount"/>
						</div>
					</div>
					<div class="form-group">         
						<label class="control-label col-md-5" for="containerReturnTo">Remarks:</label>
						<div class = "col-md-6">
							<textarea  class = "form-control"  id = "pncf_penalty_remarks" style="width: 100%;"></textarea>
						</div>
					</div>

					<div class = "form-group" style="margin-right: 2.0%;">
						<div class='btn-toolbar pull-right'>
							<button class = "btn btn-md btn-success save-penalty-fee-noncontract">Save</button>
							<button class="btn btn-md  btn-danger close-penalty-fee-noncontract" data-dismiss = "modal">Close</button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>


@if($delivery[0]->status  == 'F')		
<div class = "row">
	<div class = "col-md-10 col-md-offset-1">
		<div class = "panel-default panel">
			<div class = "panel-heading">
				<h3>Delivery Charges<button class="btn btn-sm btn-success pull-right new-delivery-others">New Delivery Charge</button></h3>
			</div>
			<div class = "panel-body">
				<div class = "col-md-12" style="overflow-x:auto">
					<table class = "table table-responsive table-hover" >
						<thead>
							<tr>
								<td width="5%">

								</td>
								<td width="10%">
									<strong>Billed To</strong>
								</td>
								<td width="20%">
									<strong>Description</strong>
								</td>
								<td width="30%">
									<strong>Remarks</strong>
								</td>
								<td width="15%">
									<strong>Amount</strong>
								</td>
								<td width="10%">
									<strong>Actions</strong>
								</td>
							</tr>
						</thead>
						<tbody>
							@php 
							$delivery_bill_ctr = 1;
							@endphp

							@forelse($delivery_bills as $delivery_bill)

							@if($delivery_bill->isBilledTo == '0')<tr style="background-color: rgba(230, 255, 179, 0.3);">
							@else
							<tr style="background-color: rgba(255, 133, 102, 0.3);">
								@endif
								<td style="text-align: center;">
									{{ $delivery_bill_ctr++}}
								</td>
								<td>
									@php
									switch($delivery_bill->isBilledTo){
									case '0': echo "Consignee"; break;
									case '1': echo "Pilot"; break;
									default : echo "Unknown"; break; }
									@endphp
								</td>
								<td>
									{{ $delivery_bill->charge_description }}
								</td>
								<td>
									{{ $delivery_bill->remarks}}
								</td>
								<td style="text-align: right;">
									Php {{ $delivery_bill->amount }}
								</td>
								<td style="text-align: center;">
									<button class = "btn btn-sm btn-primary">View</button>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="6">
									<h5 style="text-align: center;">No records available.</h5>
								</td>
							</tr>
							@endforelse
							<tr>
								<td colspan="4">
									<h4 style="text-align: right;"><strong>Total:</strong></h4>
								</td>
								<td>
									<h4 style="text-align: right;"><strong>Php 9999.00</strong></h4>
								</td>
								<td>

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endif

@endsection

@push('scripts')
<script>
	$(document).ready(function(){
		var contracts = $('#con_contracts').DataTable({
			processing: true,
			serverSide: true,

			ajax: "{{ route('get_contracts') }}/{{ $consignee[0]->id }}",
			columns: [
			{ data: 'id' }, 
			{ data: 'dateEffective' },
			{ data: 'dateExpiration' },
			{ data: 'status' },
			{ data: 'action', orderable: false, searchable: false }

			],

		});

		var others_modal_reset = $('#othersModal').html();
		var contract_table_reset = $('#contract_details').html();
		var pncf_responsible  = 0;

		$(document).on('click', '.new-delivery-bill', function(e){
			e.preventDefault();
			$('#deliveryModal').modal('show');
		})

		$(document).on('click', '.select-contract-header', function(e){
			e.preventDefault();
			$('#deliveryModal').modal('hide');
			var date_eff = $(this).closest('tr').find('td:eq(1)').text();
			var date_exp = $(this).closest('tr').find('td:eq(2)').text();
			var status = $(this).closest('tr').find('td:eq(3)').text();
			$.ajax({
				type: 'GET',
				url:  '{{ route("get_contract_details")}}/' + $(this).closest('tr').find('.contract_header_value').val(),
				data: {
					'_token' : $('input[name=_token').val(),
				},
				success : function (data) {
					contract_rows = "";
					contract_header = data[0];
					contract_details = data[1];
					for(var i = 0; i < contract_details.length; i++){
						contract_rows += '<tr><td>'+ contract_details[i].from +'</td><td>'+ contract_details[i].to +'</td><td>' + contract_details[i].amount + '</td></tr>'
					}
					$('#contract_details').html(contract_table_reset);

					//Apply changes
					$('#contract_dateEffective').text(date_eff);
					$('#contract_dateExpiration').text(date_exp);
					$('#contract_status').text(status);
					$('#contract_specifications').text(data[0].specificDetails);
					$('#contract_details_table > tbody').append(contract_rows);
					$('#contractModal').modal('show');
				}
			})

		})

		$(document).on('click', '.new-delivery-others', function(e){
			e.preventDefault();
			$('#othersModal').modal('show');
		})


		$(document).on('click', '.save-delivery-fee-direct', function(e){
			e.preventDefault();
			if(del_bill_form_con.valid()){
				$('#deliveryModal').modal('hide');
				$.ajax({
					type: 'PUT',
					url:  '{{ route("trucking.index")}}/{{ $so_id }}/delivery/{{ $delivery[0]->id }}/update_delivery_bill',
					data: {
						'_token' : $('input[name=_token').val(),
						'amount' : $('input[name=dbfc_amount').val(),
					},
					success : function (data) {		
						window.location.reload();
					}
				})
			}
		})

		$(document).on('click', '.save-delivery-fee-contract', function(e){
			e.preventDefault();
			if(contract_form.valid()){
				$('#contractModal').modal('hide');
				$.ajax({
					type: 'PUT',
					url:  '{{ route("trucking.index")}}/{{ $so_id }}/delivery/{{ $delivery[0]->id }}/update_delivery_bill',
					data: {
						'_token' : $('input[name=_token').val(),
						'amount' : $('input[name=cdf_amount').val(),
					},
					success : function (data) {		
						window.location.reload();
					}
				})
			}
		})

		$(document).on('click', '.save-penalty-fee-noncontract', function(e){
			e.preventDefault();
			if(penalty_non_contract_form.valid()){
				$('#othersModal').modal('hide');
				console.log($('.pncf_penalty_penalty').val());
				$.ajax({
					type: 'POST',
					url:  '{{ route("trucking.index")}}/{{ $so_id }}/delivery/{{ $delivery[0]->id }}/store_delivery_bill',
					data: {
						'_token' : $('input[name=_token').val(),
						'charges_id' : $('.pncf_penalty_penalty').val(),
						'amount' : 	$('#pncf_penalty_amount').val(),
						'isBilled' : 0,
						'isBilledTo' : pncf_responsible,
						'remarks' : $('#pncf_penalty_remarks').val(),
						'del_head_id' : {{ $delivery[0]->id }},
					},
					success : function (data) {		

					}
				})
			}
		})

		$(document).on('click', '.close-penalty-fee-noncontract', function(e){

			$('#pncf_penalty_amount').val("");

		})

		$(document).on('change', '.pncf_consignee', function(e){
			pncf_responsible = 0;
		})
		$(document).on('change', '.pncf_client', function(e){
			pncf_responsible = 1;
		})

		//Validations
		var contract_form = $('#contract_form').validate({
			rules: {
				cdf_amount: {
					required: true,
					number: true,
				}

			},
			messages: {
				cdf_amount : {
					required : "Amount is required.",
					number : "Enter a valid number."
				}
			}

		});

		var penalty_non_contract_form = $('#penalty_non_contract_form').validate({
			rules: {
				pncf_penalty_penalty : {
					required: true,
				},

				pncf_amount : {
					required: true,
					number: true,
				},
				

			},
			messages: {
				pncf_penalty_penalty : {
					required : "Please select a penalty",
				},

				pncf_amount : {
					required : "Amount is required.",
					number : "Enter a valid number."
				}

				
			}
		});

		var del_bill_form_con = $("form[name='del_bill_form_con']").validate({
			rules: {
				dbfc_amount: {
					required: true,
					number : true,
				}
			},
			messages: {
				dbfc_amount : {
					required : "Amount is required.",
					number : "Enter a valid number."
				}
			}

		});
	})
</script>
@endpush