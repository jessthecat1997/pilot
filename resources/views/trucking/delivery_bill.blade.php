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
								<span class="control-label col-md-7 pull-right" id ="deliveryDestination" style = "text-align: right;">{{ $consignee[0]->companyName }}</span>
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
						<h3 style="text-align: center;" class = "delivery_fee">Php {{ $delivery[0]->amount }}</h3>
						<hr />
					</div>
					
					<div class = "col-md-12">
						<h5><strong>Total Consignee Charges: </strong></h5>
						<h3 style="text-align: center;" class="total_penalty_consignee">Php {{ $total_penalty_consignee }}</h3>
						<hr />
					</div>
					<div class = "col-md-12">
						<h5><strong>Total Pilot Charges:</strong></h5>
						<h3 style="text-align: center;" class="total_penalty_client">Php {{ $total_penalty_client }}</h3>
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
						<div class="modal_non_contract_form">
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
					</div>
					<div id="wocontract" class="tab-pane fade in active">
						<br />
						<h4>Consignee Contracts</h4>
						<table class = "table table-responsive con_contracts" id = "con_contracts">
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
							<td>
								<h5><strong>Action</strong></h5>
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
				<div class = "collapse" id = "contract_delivery_collapse">
					<form class="form-horizontal" role="form" name = "con_bill_form_con">
						{{ csrf_field() }}

						<div class="form-group">
							<label class="control-label col-sm-3" for="cbfc_amount">Delivery Fee: *</label>
							<div class="col-sm-8"> 
								<input class = "form-control" type = "number" name = "cbfc_amount" id = "cbfc_amount" style="text-align: right" />
							</div>
						</div>

						<div class = "form-group" style="margin-right: 2.0%;">
							<div class='btn-toolbar pull-right'>
								<button class = "btn btn-md btn-success save-delivery-fee-contract">Save</button>
								<button class="btn btn-md  btn-danger" data-dismiss = "modal">Close</button>
							</div>
						</div>
					</form>

				</div>
				<div class = "collapse" id = "contract_penalty_collapse">
					
				</div>
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
				<ul class="nav nav-pills nav-justified">
					<li class="active"><a data-toggle="pill" href="#wocontract_charge">Contract Based</a></li>
					<li><a data-toggle="pill" href="#contract_charge">Non-Contract</a></li>

				</ul>

				<div class="tab-content">
					<div id="contract_charge" class="tab-pane fade">
						<br />
						<div class = "pncf_form">
							<form class="form-horizontal" role="form" name="penalty_non_contract_form">
								{{ csrf_field() }}

								<div class="form-group">         
									<label class="control-label col-md-3 pull-left" for="status">Charged To:</label>
									<div class = "col-md-9">
										<label class="radio-inline"><input type = "radio" checked id = "pncf_responsibleCon" name = "pncf_responsible" value = "N" class = " pull-right checkradio pncf_consignee"/>Consignee</label>
										<label class="radio-inline"><input type = "radio" id = "pncf_responsibleCli" name = "pncf_responsible"  value = "Y" class = "pull-right checkradio pncf_client"/>Pilot</label>

									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3" for="containerNumber">Charge:</label>
									<div class = "col-md-9">
										<select class = "form-control" required id = "pncf_penalty_penalty" name="pncf_penalty_penalty">
											<option></option>
											@forelse($charges as $charge)
											<option value = "{{ $charge->id }}">{{ $charge->description }}</option>
											@empty

											@endforelse
										</select>
									</div>
								</div>
								<div class="form-group">         
									<label class="control-label col-md-3" for="containerReturnTo">Charge Fee:</label>
									<div class = "col-md-9">
										<input type = "number" class = "form-control" style="text-align: right;" id = "pncf_penalty_amount"  name = "pncf_penalty_amount" required />
									</div>
								</div>
								<div class="form-group">         
									<label class="control-label col-md-3" for="containerReturnTo">Remarks:</label>
									<div class = "col-md-9">
										<textarea  class = "form-control"  id = "pncf_penalty_remarks" name = "pncf_penalty_remarks" style="width: 100%;"></textarea>
									</div>
								</div>

								<div class = "form-group" style="margin-right: 2.0%;">
									<div class='btn-toolbar pull-right'>
										<button type = "submit" class = "btn btn-md btn-success save-penalty-fee-noncontract">Save</button>
										<button class="btn btn-md  btn-danger close-penalty-fee-noncontract" data-dismiss = "modal">Close</button>
									</div>
								</div>

							</form>
						</div>
					</div>
					<div id="wocontract_charge" class="tab-pane fade in active">
						<br />
						<h4>Consignee Contracts</h4>
						<table class = "table table-responsive" id = "con_contract_penalty">
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

<div id="viewChargeModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">View Charge</h3>
			</div>
			<div class = "modal-body">

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
					<table class = "table table-responsive" >
						<thead>
							<tr>
								
								<td width="15%">
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
							@forelse($delivery_bills as $delivery_bill)

							@if($delivery_bill->isBilledTo == '0')<tr style="background-color: rgba(230, 255, 179, 0.3);">
							@else
							<tr style="background-color: rgba(255, 133, 102, 0.3);">
								@endif
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
									<button class = "btn btn-sm btn-primary view-charge-information">View</button>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="5">
									<h5 style="text-align: center;">No records available.</h5>
								</td>
							</tr>
							@endforelse
							<tr>
								<td colspan="3">
									<h4 style="text-align: right;">Total Consignee Charge:</h4>
									<h4 style="text-align: right;">Total Pilot Charge:</h4>
								</td>
								<td colspan="2">
									<h4 style="text-align: right;" class="total_penalty_consignee"><strong>Php {{ $total_penalty_consignee }}</strong></h4>
									<h4 style="text-align: right;" class="total_penalty_client"><strong>Php {{ $total_penalty_client }}</strong></h4>
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
		//Validations

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

		var con_bill_form_con = $("form[name='con_bill_form_con']").validate({
			rules: {
				cbfc_amount: {
					required: true,
					number : true,
				}
			},
			messages: {
				cbfc_amount : {
					required : "Amount is required.",
					number : "mmm a valid number."
				}
			}

		});

		var penalty_non_contract_form = $("form[name='penalty_non_contract_form']").validate({
			rules: {
				pncf_penalty_penalty : {
					required: true,
				},

				pncf_penalty_amount : {
					required: true,
					number: true,
				},
				
			},
			messages: {
				pncf_penalty_penalty : {
					required : "Please select a penalty",
				},

				pncf_penalty_amount : {
					required : "Amount is required.",
					number : "Enter a valid number."
				}

				
			}
		});

		var contracts = $('#con_contracts').DataTable({
			processing: true,
			serverSide: true,

			ajax: "{{ route('get_contracts') }}/{{ $consignee[0]->id }}/0",
			columns: [
			{ data: 'id' }, 
			{ data: 'dateEffective' },
			{ data: 'dateExpiration' },
			{ data: 'status' },
			{ data: 'action', orderable: false, searchable: false }

			],

		});
		var contracts_pen = $('#con_contract_penalty').DataTable({
			processing: true,
			serverSide: true,

			ajax: "{{ route('get_contracts') }}/{{ $consignee[0]->id }}/1",
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
						contract_rows += '<tr><td>'+ contract_details[i].from +'</td><td>'+ contract_details[i].to +'</td><td>' + contract_details[i].amount + '</td><td><button class = "btn btn-md btn-success">Select</td></tr>'
					}
					$('#contract_details').html(contract_table_reset);

					//Apply changes
					$('#contract_dateEffective').text(date_eff);
					$('#contract_dateExpiration').text(date_exp);
					$('#contract_status').text(status);
					$('#contract_specifications').text(data[0].specificDetails);
					$('#contract_details_table > tbody').append(contract_rows);

					$('#contract_penalty_collapse').removeClass('in');
					$('#contract_delivery_collapse').addClass('in');

					$('#contractModal').modal('show');

				}
			})

		})

		$(document).on('click', '.select-contract-penalty', function(e){
			e.preventDefault();
			$('#othersModal').modal('hide');
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
						contract_rows += '<tr><td>'+ contract_details[i].from +'</td><td>'+ contract_details[i].to +'</td><td>' + contract_details[i].amount + '</td><td><button class = "btn btn-md btn-success">Select</td></tr>'
					}
					$('#contract_details').html(contract_table_reset);

					//Apply changes
					$('#contract_dateEffective').text(date_eff);
					$('#contract_dateExpiration').text(date_exp);
					$('#contract_status').text(status);
					$('#contract_specifications').text(data[0].specificDetails);
					$('#contract_details_table > tbody').append(contract_rows);

					$('#contract_penalty_collapse').addClass('in');
					$('#contract_delivery_collapse').removeClass('in');

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
			$('#dbfc_amount').valid();
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
						var delivery_fee = parseFloat(Math.round(data.amount * 100) / 100).toFixed(2);
						$('.delivery_fee').text("Php " + delivery_fee);

					}
				})
			}
		})

		$(document).on('click', '.save-delivery-fee-contract', function(e){
			e.preventDefault();
			$('#cbfc_amount').valid();
			con_bill_form_con.valid();
			if($('#cbfc_amount').valid()){
				
				$.ajax({
					type: 'PUT',
					url:  '{{ route("trucking.index")}}/{{ $so_id }}/delivery/{{ $delivery[0]->id }}/update_delivery_bill',
					data: {
						'_token' : $('input[name=_token').val(),
						'amount' : $('input[name=cbfc_amount').val(),
					},
					success : function (data) {		
						var delivery_fee = parseFloat(Math.round(data.amount * 100) / 100).toFixed(2);
						$('.delivery_fee').text("Php " + delivery_fee);

					}
				})
			}
		})

		$(document).on('click', '.save-penalty-fee-noncontract', function(e){
			e.preventDefault();
			$('#pncf_penalty_amount').valid();	
			$('#pncf_penalty_penalty').valid();

			if(penalty_non_contract_form.valid()){
				$('#othersModal').modal('hide');
				$.ajax({
					type: 'POST',
					url:  '{{ route("trucking.index")}}/{{ $so_id }}/delivery/{{ $delivery[0]->id }}/store_delivery_bill',
					data: {
						'_token' : $('input[name=_token').val(),
						'charges_id' : $('#pncf_penalty_penalty').val(),
						'amount' : 	$('#pncf_penalty_amount').val(),
						'isBilled' : 0,
						'isBilledTo' : pncf_responsible,
						'remarks' : $('#pncf_penalty_remarks').val(),
						'del_head_id' : {{ $delivery[0]->id }},
					},
					success : function (data) {		
						if(data.isBilledTo == 0){
							var delivery_fee = parseFloat(Math.round(data.amount * 100) / 100) + $;
							// $('.total_penalty_consignee').text(data.)
						}
						else{

						}
					}
				})
			}
		})


		$(document).on('click', '.close-penalty-fee-noncontract', function(e){

			$('#pncf_penalty_amount').val("");

		})
		$(document).on('change', '.pncf_client', function(e){
			pncf_responsible = 1;
		})
		$(document).on('change', '.pncf_consignee', function(e){
			pncf_responsible = 0;
		})

		$(document).on('click', '.view-charge-information',function(e){
			e.preventDefault();
			$('#viewChargeModal').modal('show');
		})


	})
</script>
@endpush