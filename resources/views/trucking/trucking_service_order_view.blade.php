@extends('layouts.app')

@push('styles')
<style type="text/css">
	span.control-label {
		font-size: 20px;
	}
	span.label {
		font-size: 15px;
	}
	strong {
		font-size: 15px;
	}
</style>
@endpush

@section('content')
<div class = "row">
	<div class = "col-md-10 col-md-offset-1">
		<div class = "panel-heading">
			<h2>&nbsp;Manage Trucking</h2>
			<hr/>
		</div>
		<div class = "panel-body panel">
			<div class="col-md-12">
				@if($service_order->status == 'P')
				<h4>Trucking Information <button class="btn btn-sm btn-primary pull-right clearfix edit-trucking-information" data-toggle="modal" data-target="#trModal">Update Trucking Status</button></h4>
				@else
				<h4>Trucking Information <button  disabled class="btn btn-sm btn-primary pull-right clearfix edit-trucking-information" data-toggle="modal" data-target="#trModal">Update Trucking Status</button></h4>
				@endif
				<br />
				<table class="table table-responsive">
					<tbody>
						<tr>
							<td class="active"><strong>Trucking Service Order #: </strong></td>

							<td class = "success" id="consignee"><strong>{{ $service_order->id }}</strong></td>
							<td class="success">

							</td>
						</tr>
						<tr>
							<td class="active"><strong>Consignee: </strong></td>
							<td class="success" id="address"><strong>{{ $service_order_details[0]->firstName  . " " . $service_order_details[0]->lastName }}</strong></td>
							<td class="success">

							</td>
						</tr>
						<tr>
							<td class="active"><strong>Company Name: </strong></td>

							<td class="success" id="sotype"><strong>{{ $service_order_details[0]->companyName }}</strong></td>
							<td class="success">

							</td>
						</tr>
						<tr>
							<td class="active"><strong>Status: </strong></td>
							<td class="success">
								@php
								switch($service_order->status){
								case 'C': echo "<span class = 'label label-default'>Cancelled</span>"; break;
								case 'F': echo "<span class = 'label label-success'>Finished</span>"; break;
								case 'P': echo "<span class = 'label label-warning'>Pending</span>"; break;
								default : echo "<span class = 'label label-default'>Unknown</span>"; break; }
								@endphp
							</td>
							<td class="success">
							</td>
						</tr>
						<tr>
							<td class="active">
								<strong>Estimated Delivery Fee: </strong>
							</td>
							
							<td class="success" colspan="2">
								<strong>Php {{ number_format((float)$estimate, 3, '.', '') }}</strong>
							</td>
						</tr>
						<tr>
							<td class = "active">
								<strong>Delivery Status: </strong><br><br>

							</td>
							<td class="success" colspan="2">
								<span class = "label label-danger">Cancelled  <span class="badge cancelled_delivery">{{ $cancelled_trucking }}</span></span>
								<span class = "label label-success">Finished  <span class="badge success_delivery">{{ $success_trucking }}</span></span>
								<span class = "label label-warning">Pending  <span class="badge pending_delivery">{{ $pending_trucking }}</span></span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class = "row">
	<div class = "col-md-10 col-md-offset-1">
		<div class = "panel default-panel">
			<div class = "panel-body">
				@if($service_order->status == 'P' )
				<h4>Delivery History <button class = "btn btn-md btn-success col-md-5 pull-right new-delivery">New Delivery</button></h4>
				@else
				<h4>Delivery History <button class = "btn btn-md btn-success col-md-5 pull-right new-delivery disabled" disabled >New Delivery</button></h4>
				@endif
				<hr />
				<table class = "table table-responsive table-striped" id = "delivery_table">
					<thead>
						<tr>
							<td style="width: 5%;">
								ID
							</td>
							<td style="width: 10%;">
								Origin Name
							</td>
							<td style="width: 10%;">
								Origin City
							</td>
							<td style="width: 10%;">
								Pickup Date
							</td>
							<td style="width: 10%;">
								Destination Name
							</td>
							<td style="width: 10%;">
								Destination City
							</td>
							<td style="width: 10%;">
								Delivery Date
							</td>
							<td style="width: 5%;">
								Status
							</td>
							<td style="width: 15%;">
								Actions
							</td>
						</tr>
					</thead>
				</table> 
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="confirm-create" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Create Bill
			</div>
			<div class="modal-body">
				Confirm Creating new Bill
			</div>
			<div class="modal-footer">

				<button class = "btn btn-success confirm-create-bill">Confirm</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="deposit_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				New Deposit
			</div>
			<div class="modal-body">
				<div class = "form-horizontal">
					<div class = "form-group">
						<label class="col-md-12">Amount</label>
						<div class = "col-md-12">
							<input type="number" class = "form-control" id = "deposit" required />
						</div>
					</div>
					<div class = "form-group">
						<label class= "col-md-12">Description</label>
						<div class="col-md-12">
							<textarea class = "form-control" id = "description" required></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class = "btn btn-success confirm-create-deposit">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div class = "row">
	<div class = "col-md-10 col-md-offset-1">
		<div class = "panel">
			<div class = "panel-body">
				@if($service_order->bi_head_id_rev != null)
				<h4>List of Billings <button class = "btn but new_revenue pull-right">New Revenue</button></h4>
				@else
				<h4>List of Billings</h4>
				@endif
				<br />
				@if($service_order->bi_head_id_rev != null)
				<table class="table table-responsive table-striped" style="width: 100%;" id = "revenues_table">
					<thead>
						<tr>
							<td>
								Name
							</td>
							<td>
								Amount
							</td>
							<td>
								Description
							</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>

							</td>
							<td>

							</td>
							<td>

							</td>
						</tr>
					</tbody>
				</table>
				@else
				<div class = "form-horizontal">
					<div class = "col-md-10">
						Create Billing First to Add Payables.
					</div>
					<div class="col-md-2">
						<button class = "btn but new_revenue_bill btn-sm">New Bill</button>
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>

<div class = "row">
	<div class = "col-md-10 col-md-offset-1">
		<div class = "panel">
			<div class = "panel-body">
				@if($service_order->bi_head_id_exp != null)
				<h4>List of Refundable Charges <button class = "btn but new_expense pull-right">New Expense</button></h4>
				@else
				<h4>List of Refundable Charges</h4>
				@endif
				<br />
				@if($service_order->bi_head_id_exp != null)
				<table class="table table-responsive table-striped" style="width: 100%;" id = "expense_table">
					<thead>
						<tr>
							<td>
								Name
							</td>
							<td>
								Amount
							</td>
							<td>
								Description
							</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>

							</td>
							<td>

							</td>
							<td>

							</td>
						</tr>
					</tbody>
				</table>
				@else
				<div class = "form-horizontal">
					<div class = "col-md-10">
						Create Billing First to Add Payables.
					</div>
					<div class="col-md-2">
						<button class = "btn but new_expense_bill btn-sm">New Bill</button>
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
<div class = "row">
	<div class = "col-md-10 col-md-offset-1">
		<div class = "panel">
			<div class = "panel-body">

				<h4>Consignee Deposits<button class = "btn but new_deposit pull-right">New Deposit</button></h4>
				<br />
				<table class="table table-responsive table-striped" style="width: 100%;" id = "deposits_table">
					<thead>
						<tr>
							<td>
								Date Added
							</td>
							<td>
								Amount
							</td>
							<td>
								Current Balance
							</td>
							<td>
								Description
							</td>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<form>
	<div id="revModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">New Payable</h4>
				</div>
				<div class = "modal-body">
					<div class = "col-md-12">
						<div class="form-horizontal">
							<div class = "col-md-6">
								<div class = "form-group">
									<label class = "control-label col-md-3">Name *</label>
									<div class = "col-md-9">
										<select id = "rev_bill_id" name="rev_bill_id" class = "form-control ">
											<option value = "0">Select Charges</option>
											@forelse($bill_revs as $rev)
											<option value = "{{ $rev->id }}">{{ $rev->name }}</option>

											@empty

											@endforelse
										</select>
									</div>
								</div>
							</div>
							<div class = "col-md-6">
								<div class = "form-group">
									<label class = "control-label col-md-3">Amount *</label>
									<div class = "col-md-9">
										<input type = "number" name = "rev_amount" id="rev_amount" class = "form-control" required style="text-align: right">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class = "col-md-12 collapse">
						<table style="width: 100%;" id = "delivery_fees_table" class = "table table-striped">
							<thead>
								<tr style="width: 40%; text-align: center;">
									<td>
										Delivery No.
									</td>
									<td style="width: 60%; text-align: center;">
										Amount
									</td>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
					<div class = "col-md-12">
						<label for="rev_description">Description:</label>
						<textarea class="form-control" rows="3" id="rev_description" name="rev_description"></textarea>
					</div>
					<strong>Note:</strong> All fields with * are required.
				</div>
				<div class="modal-footer">
					<a class="btn but finalize-rev">Save</a>
				</div>
			</div>
		</div>
	</div>
</form>

<form>
	<div id="expModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">New Payable</h4>
				</div>
				<div class = "modal-body">
					<div class = "col-md-12">
						<div class="form-horizontal">
							<div class = "col-md-6">
								<div class = "form-group">
									<label class = "control-label col-md-3">Name *</label>
									<div class = "col-md-9">
										<select id = "exp_bill_id" name="exp_bill_id" class = "form-control">
											<option value = "0">Select Charges</option>
											@forelse($bill_exps as $exp)
											<option value = "{{ $exp->id }}">{{ $exp->name }}</option>

											@empty

											@endforelse
										</select>
									</div>
								</div>
							</div>
							<div class = "col-md-6">
								<div class = "form-group">
									<label class = "control-label col-md-3">Amount *</label>
									<div class = "col-md-9">
										<input type = "number" name = "exp_amount" id="exp_amount" required class = "form-control" style="text-align: right">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class = "col-md-12 collapse">
						<table style="width: 100%;" id = "delivery_fees_table" class="table table-striped table-responsive">
							<thead>
								<tr style="width: 40%; text-align: center;">
									<td>
										Delivery No.
									</td>
									<td style="width: 60%; text-align: center;">
										Amount
									</td>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
					<div class = "col-md-12">
						<label for="rev_description">Description:</label>
						<textarea class="form-control" rows="3" id="exp_description" name="exp_description"></textarea>
					</div>
					<strong>Note:</strong> All fields with * are required.
				</div>
				<div class="modal-footer">
					<a class="btn but finalize-exp">Save</a>
				</div>
			</div>
		</div>
	</div>
</form>

<div id="deliveryModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Delivery Information</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form">
					{{ csrf_field() }}
					<div class="form-group required">
						<label class="control-label col-sm-3" for="deliveryStatus">Delivery Status</label>
						<div class="col-sm-8"> 
							<select class = "form-control" name = "deliveryStatus" id = "deliveryStatus">
								<option value = "P">Pending</option>
								<option value = "C">Cancelled</option>
								<option value = "F">Finished</option>
							</select>
						</div>
					</div>
					<div class = "collapse delivery_remarks_collapse fade">
						<div class="form-group required">
							<label class="control-label col-sm-3" for="deliveryCancel">Date Cancelled</label>
							<div class="col-sm-8"> 
								<input type = "date" class = "form-control" name = "deliveryCancel" id = "deliveryCancel" />
							</div>
						</div>
						<div class="form-group required">
							<label class="control-label col-sm-3" for="deliveryRemarks">Remarks</label>
							<div class="col-sm-8"> 
								<textarea class = "form-control" name = "deliveryRemarks" id = "deliveryRemarks"></textarea>
							</div>
						</div>
					</div>
				</form>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-success save-delivery-information" >Save</button>
				<button type="button" class="btn btn-danger close-delivery-information" data-dismiss = "modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="trModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Trucking Information</h4>
			</div>
			<div class="modal-body">	
				<div class = "form-horizontal">
					<div class="form-group">
						<label class="control-label col-sm-3" for="_status">Status</label>
						<div class="col-sm-8"> 
							<select name = "_status" id = "_status" class = "form-control">
								<option value = "P">Pending</option>
								<option value = "C">Cancelled</option>
								@if( $pending_trucking != 0)
								<option value = "F" disabled title="There are still pending deliveries.">Finished</option>
								@else
								<option value = "F" >Finished</option>
								@endif
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success save-trucking-information" data-dismiss="modal">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>



@endsection


@push('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		var json;
		var results;
		var detail_object = [];
		var con_Number = [];
		var con_Volume = [];
		var con_ReturnTo = [];
		var con_ReturnAddress = [];
		var con_ReturnDate = [];

		var descrp_goods = [];
		var gross_weights = [];
		var suppliers = [];

		var modal_reset = $('#myModal').html();
		var delivery_id = 0;
		var vehicle_type_id = 0;
		var wodetail_row = "<tr>" + $('#wodescription_row').html() + "</tr>";
		var container_row = "<tr>" + $('#container_row').html() + "</tr>";

		var create_bill = null;

		var selected_delivery = null;

		$(document).on('click', '.confirm-create-deposit', function(e){
			e.preventDefault();
			$.ajax({
				type : 'POST',
				url : "{{ route('cdeposit.index') }}",
				data : {
					'_token' : $('input[name=_token]').val(),
					'amount' : $('#deposit').val(),
					'description' : $('#description').val(),
					'consignees_id' : " {{ $service_order_details[0]->id }}",
				},
				success : function (data){
					console.log(data);
				}
			})
		})
		
		$(document).on('click', '.new_deposit', function(e){
			e.preventDefault();
			$('#deposit_modal').modal('show');
		})
		$(document).on('click', '.new_expense ', function(e){
			e.preventDefault();
			$('#expModal').modal('show');
		})
		@if($service_order->bi_head_id_exp != null)
		$(document).on('click', '.finalize-exp', function(e){
			$('#exp_amount').valid();
			if($('#exp_amount').valid() && $('#exp_amount').val() > 0 && $('#exp_bill_id').val() != 0){
				$('.finalize-exp').attr('disabled', true);
				$.ajax({
					method: 'POST',
					url: "{{ route('post_trucking_expense') }}",
					data: {
						'_token' : $('input[name=_token]').val(),
						'charge_id' : $('#exp_bill_id').val(),
						'description' : $('#exp_description').val(),
						'amount' : $('#exp_amount').val(),
						'bi_head_id' : '{{ $service_order->bi_head_id_exp }}',
					},
					success: function (data){
						location.reload();
					}
				})
			}
		})
		@endif

		@if($service_order->bi_head_id_rev != null)
		$(document).on('click', '.finalize-rev', function(e){
			$('#rev_amount').valid();
			if($('#rev_amount').valid() && $('#rev_amount').val() > 0 && $('#rev_bill_id').val() != 0){
				$('.finalize-rev').attr('disabled', true);
				$.ajax({
					method: 'POST',
					url: "{{ route('post_trucking_payables') }}",
					data: {
						'_token' : $('input[name=_token]').val(),
						'charge_id' : $('#rev_bill_id').val(),
						'description' : $('#rev_description').val(),
						'amount' : $('#rev_amount').val(),
						'bi_head_id' : '{{ $service_order->bi_head_id_rev }}',
					},
					success: function (data){
						location.reload();
					}
				})
			}
		})
		@endif

		$(document).on('change', '#rev_bill_id', function(e){
			revID = $('#rev_bill_id').val();
			if($('#rev_bill_id').val() != 0){
				switch($('#rev_bill_id').val()){
					case '1':
					$.ajax({

						type: 'GET',
						url: '{{ route("getDeliveryFees") }}/{{ $service_order->id }}',
						data: {
							'_token' : $('input[name=_token]').val(),
							'tr_so_id' : '{{ $service_order->id }}',
						},
						success: function(data){
							var delivery_fees_rows = "";
							console.log(data);
							for(var i = 0; i < data.length; i++){
								delivery_fees_rows += "<tr><td style = 'text-align: center;	'>"  + data[i].id + "</td><td>" +
								"<input type = 'number' style = 'text-align: right;' class = 'form-control' value = '" + data[i].amount + "' /></td></tr>";
							}
							$('#delivery_fees_table > tbody').html("");
							$('#delivery_fees_table > tbody').append(delivery_fees_rows);
						}
					})

					break;					
				}
			}
			else
			{
				
			}
		})

		$(document).on('click', '.new_revenue', function(e){
			e.preventDefault();
			$('#revModal').modal('show');
		})

		$(document).on('click', '.new_revenue_bill', function(e){
			e.preventDefault();
			$('#confirm-create').modal('show');
			create_bill = 1;
		})
		$(document).on('click', '.new_expense_bill', function(e){
			e.preventDefault();
			$('#confirm-create').modal('show');
			create_bill = 0;
		})

		@if($service_order->bi_head_id_rev != null)
		var delivery_table = $('#revenues_table').DataTable({
			processing: false,
			deferRender: true,
			serverSide: false,
			scrollX: true,
			ajax: '{{ route("getBillingDetails") }}/{{  $service_order->bi_head_id_rev }}',
			columns: [

			{ data: 'name' },
			{ data: 'amount'},
			{ data: 'description' },
			
			],	"order": [[ 0, "desc" ]],
		});
		@endif

		@if($service_order->bi_head_id_exp != null)
		var delivery_table = $('#expense_table').DataTable({
			processing: false,
			deferRender: true,
			serverSide: false,
			scrollX: true,
			ajax: '{{ route("getBillingDetails") }}/{{ $service_order->bi_head_id_exp }}',
			columns: [

			{ data: 'name' },
			{ data: 'amount'},
			{ data: 'description' },
			
			],	"order": [[ 0, "desc" ]],
		});
		@endif

		$(document).on('click', '.confirm-create-bill', function(e){
			e.preventDefault();

			switch(create_bill){
				case 0 : 
				$.ajax({

					type: 'POST',
					url: '{{ route("create_tr_billing_header") }}',
					data: {
						'_token' : $('input[name=_token]').val(),
						'isRevenue' : create_bill,
						'tr_so_id' : '{{ $service_order->id }}',
					},
					success: function(data){
						window.location.reload();
					}
				})
				break;

				case 1 :
				$.ajax({

					type: 'POST',
					url: '{{ route("create_tr_billing_header") }}',
					data: {
						'_token' : $('input[name=_token]').val(),
						'isRevenue' : create_bill,
						'tr_so_id' : '{{ $service_order->id }}',
					},
					success: function(data){
						window.location.reload();
					}
				})
				break
			}
		})

		$(document).on('click', '.view_delivery', function(e){
			e.preventDefault();
			window.location.href = "{{ route('trucking.index') }}/{{ $so_id }}/delivery/" + $(this).closest("tr").find('.delivery-id').val() + "/view";
		})
		$(document).on('click', '.edit_delivery', function(e){
			e.preventDefault();
			window.location.href = "{{ route('trucking.index') }}/{{ $so_id }}/delivery/" + $(this).closest("tr").find('.delivery-id').val() + "/edit";
		})
		var delivery_table = $('#delivery_table').DataTable({
			processing: false,
			deferRender: true,
			serverSide: false,
			scrollX: true,
			ajax: '{{ route("trucking.index") }}/{{ $service_order->id }}/get_deliveries',
			columns: [

			{ data: 'id' },
			{ data: 'pickup_name' },
			{ data: 'pickup_city'},
			{ data: 'pickupDateTime'},
			{ data: 'deliver_name' },
			{ data: 'deliver_city' },
			{ data: 'deliveryDateTime'},
			{ data: 'status' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "desc" ]],
		});

		$(document).on('change', '#deliveryStatus', function(e){
			e.preventDefault();
			if($('#deliveryStatus').val() == "C"){
				console.log('aa');
				$('.delivery_remarks_collapse').addClass('in');
				var now = new Date();
				var day = ("0" + now.getDate()).slice(-2);
				var month = ("0" + (now.getMonth() + 1)).slice(-2);
				var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
				$('#deliveryCancel').val(today);
			}
			else
			{
				$('.delivery_remarks_collapse').removeClass('in');
			}

		})

		// Trucking
		$(document).on('click', '.edit-trucking-information', function(e){
			status = "{{ $service_order->status }}";
			switch(status){
				case 'P' : $('#_status > option:eq(0)').attr('selected', 'true');
				break;
				case 'C' : $('#_status > option:eq(1)').attr('selected', 'true');
				break;
				case 'F' : $('#_status > option:eq(2)').attr('selected', 'true');
				break;
				
			}
		})
		$(document).on('click', '.new-delivery', function(e){
			e.preventDefault();
			window.location.href = "{{ route('trucking.index') }}/{{ $so_id }}/delivery/create";	
		})

		$(document).on('click', '.save-trucking-information', function(e){
			$.ajax({

				type: 'PUT',
				url: '{{ route("trucking.store") }}/{{ $so_id }}',
				data: {
					'_token' : $('input[name=_token]').val(),
					'destination' : $('#_destination').val(),
					'shippingLine' : $('#_shippingLine').val(),
					'portOfCfsLocation' : $('#_portOfCfsLocation').val(),
					'status' : $('#_status').val(),
				},
				success: function(data){
					$('#tr_destination').text($('#_destination').val());
					$('#tr_shippingLine').text($('#_shippingLine').val());
					$('#tr_portOfCfsLocation').text($('#_portOfCfsLocation').val());
					$('#tr_status').text($('#_status > option:selected').text());

					$('#_destination').val();
					$('#_shippingLine').val();
					$('#_portOfCfsLocation').val();

					window.location.reload();
				}
			})
		})

		$(document).on('click', '.view-delivery-information', function(e){

		})

		$(document).on('click', '.select-delivery', function(e){
			e.preventDefault();
			selected_delivery = $(this).closest("tr").find('.delivery-id').val();
		})

		// Container

		$(document).on('click', '.add-new-container', function(e){
			e.preventDefault();
			if(validateContainer() === true){
				$('#container_table tr:last').after(container_row);
			}
		})
		$(document).on('click', '.remove-container-row', function(e){
			e.preventDefault();
			$(this).closest('tr').remove();
			var id = $(this).closest("tr").find('.row_containerNumber').val() + '_table';
			$('#' + id).remove();
		})
		$(document).on('click', '.save-container-row', function(e){
			e.preventDefault();
			var id = $(this).closest("tr").find('.row_containerNumber').val() + '_table';
			alert(id);
			if($('#' + id).length === 0){
				alert($(this).closest("tr").find('.row_containerNumber').val());
				$('#cargo_delivery_details').append('<table class = "table-responsive table" id = "' + $(this).closest("tr").find('.row_containerNumber').val() + '_table"><thead><tr><td>Container Number: '+ $(this).closest("tr").find('.row_containerNumber').val() +'</tr></td><tr><td>Description of Goods</td><td>Gross Weight(kg)</td><td>Supplier</td><td>Action</td></tr></thead><tbody><tr id = "description_row"><td width="35%"><input type = "text" name = "'+ id +'_descriptionOfGoods" class = "form-control"/></td><td width="20%"><input type = "text" name = "'+ id +'_grossWeight" class = "form-control"/></td><td width="30%"><input type = "text" name = "'+ id +'_supplier"  class = "form-control" /></td><td width="15%"><button class = "btn btn-md btn-primary add-container-detail" value = "'+  id + '">+</button><button class = "btn btn-md btn-danger remove-container-detail" value = "' + id +'">x</button></td></tr></tbody></table>');
			}
		})


		$(document).on('click', '.add-container-detail', function(e){
			e.preventDefault();
			var id = $(this).val();
			var detail_row = '<tr id = "description_row"><td width="35%"><input type = "text" name =   "'+ id + '_descriptionOfGoods" class = "form-control"/></td><td width="20%"><input type = "text" name = "'+ id +'_grossWeight" class = "form-control"/></td><td width="30%"><input type = "text" name = "'+id+'_supplier" class = "form-control" /></td><td width="15%"><button class = "btn btn-md btn-primary add-container-detail" value = "'+  $(this).val() + '">+</button><button class = "btn btn-md btn-danger remove-container-detail" value = "'+ $(this).val() + '">x</button></td></tr>';
			$('#'+ $(this).val() + ":last-child").append(detail_row);
		})

		$(document).on('click', '.remove-container-detail', function(e){
			e.preventDefault();
			if($('#'+ $(this).val() +' > tbody > tr').length > 1){
				$(this).closest('tr').remove();
			}
		})







		// Non Container ------------------------------------------------------------------------------------------------------------------------

		$(document).on('click', '.add-new-detail', function(e){
			e.preventDefault();

			if(validateDetail() === true){
				$('#detail_table:last-child').append(wodetail_row);
			}
		})

		$(document).on('click', '.remove-current-detail', function(e){
			e.preventDefault();
			if($('#detail_table > tbody > tr').length > 1){
				$(this).closest('tr').remove();
			}
			else{
				//Do nothing
			}
		})

		$(document).on('click', '.woadd-new-detail', function(e){
			e.preventDefault();
			
			if(validateDetail() === true){
				$('#wodetail_table:last-child').append(wodetail_row);
			}
		})

		$(document).on('click', '.woremove-current-detail', function(e){
			e.preventDefault();
			if($('#wodetail_table > tbody > tr').length > 1){
				$(this).closest('tr').remove();
			}
		})
		$(document).on('change', '#vehicle_type', function(e){
			vehicle_type_id = $(this).val();
			$.ajax({
				type: 'GET',
				url: 'http://localhost:8000/admin/' + vehicle_type_id +'/getVehicles',
				data: {
					'_token' : $('input[name=_token]').val(),
					'vehicle_type' : vehicle_type_id,
				},
				success: function(data){
					if(typeof(data) == "object"){
						var new_rows = "<option value = '0'></option>";
						for(var i = 0; i < data.length; i++){
							new_rows += "<option value = '"+ data[i].plateNumber+"'>"+ data[i].plateNumber+ " - " + data[i].model +"</option>";
						}
						$('#vehicle').find('option').not(':first').remove();
						$('#vehicle').html(new_rows);

					}
				},
				error: function(data) {
					if(data.status == 400){
						alert("Nothing found");
					}
				}
			})
		})
		
		$(document).on('click', '.save-delivery-information', function(e){
			$.ajax({
				type: 'PUT',
				url: '{{ route("trucking.store") }}/{{ $so_id }}/update_delivery',
				data: {
					'_token' : $('input[name=_token]').val(),
					'status' : $('#deliveryStatus').val(),
					'remarks' : $('#deliveryRemarks').val(),
					'cancelDateTime' : $('#deliveryCancel').val(),
					'delivery_head_id' : selected_delivery,
					
				},
				success: function(data){
					delivery_table.ajax.reload();
					$('#deliveryModal').modal('hide');
					window.location.reload();
				}	
			})
		})

		$(document).on('click', '.save-delivery', function(e){
			if($("#choices li.active").text() === "Non Container"){
				if(validateDetail() === true){
					$.ajax({
						type: 'POST',
						url: 'http://localhost:8000/trucking/{{ $so_id }}/store_delivery',
						data: {
							'_token' : $('input[name=_token]').val(),
							'plateNumber' : $('#vehicle').val(),
							'descrp_goods' : descrp_goods,
							'gross_weights' : gross_weights,
							'suppliers' : suppliers,
							'emp_id_driver' : $('#driver').val(),
							'emp_id_helper' : $('#helper').val(),
							'deliveryAddress' : $('.deladd').val(),

						},
						success: function(data){
							$('#myModal').modal('hide');
							$('#myModal').html(modal_reset);
						}
					})
				}
			}
			else{
				if(validateContainer() == true){
					validateContainerDetail();
					$.ajax({

						type: 'POST',
						url: '{{ route("trucking.store") }}/{{ $so_id }}/store_delivery',
						data: {
							'_token' : $('input[name=_token]').val(),
							'plateNumber' : $('#vehicle').val(),
							'emp_id_driver' : $('#driver').val(),
							'emp_id_helper' : $('#helper').val(),
							'deliveryAddress' : $('.deladdcon').val(),
							'containerNumber' : con_Number,
							'containerVolume' : con_Volume,
							'containerReturnTo' : con_ReturnTo,
							'containerReturnAddress' : con_ReturnAddress,
							'containerReturnDate' : con_ReturnDate,
							'container_data' : results,

						},
						success: function(data){
							$('#myModal').modal('hide');
							$('#myModal').html(modal_reset);
						}
					})
				}
			}
		})
		function validateContainerDetail(){
			json = [];
			var linkData;
			for (var i = 0; i < con_Number.length; i++) {

				var child = [{ }];


				child[0]['container'] = [{
					containerNumber : con_Number[i],
					containerVolume : con_Volume[i],
					containerReturnTo : con_ReturnTo[i],
					containerReturnAddress : con_ReturnAddress[i],
					containerReturnDate : con_ReturnDate[i]
				}];

				child[0]['details'] = [];

				table_detail_row_count = $('#' + con_Number[i] + "_table > tbody > tr").length;
				var name = con_Number[i] + "_table";

				con_descrp = document.getElementsByName(name + '_descriptionOfGoods');
				con_gw = document.getElementsByName(name + '_grossWeight');
				con_supp = document.getElementsByName(name + '_supplier');

				for (var j = 0; j < table_detail_row_count; j++) {
					
					child[0].details.push({
						descriptionOfGood : con_descrp[j].value,
						grossWeight : con_gw[j].value,
						supplier : con_supp[j].value
					});
				}

				json.push(child);
			}

			results = JSON.stringify(json);
			console.log(results);
		}

		function validateContainer(){
			con_Number = [];
			con_Volume = [];
			con_ReturnTo = [];
			con_ReturnAddress = [];
			con_ReturnDate = [];

			var error = "";

			con_number = document.getElementsByName("containerNumber");
			con_volume = document.getElementsByName("containerVolume");
			con_to = document.getElementsByName("containerReturnTo");
			con_address = document.getElementsByName("containerReturnAddress");
			con_date = document.getElementsByName("containerReturnDate");

			for(var i = 0; i < con_number.length; i++)
			{
				if(con_number[i].value === ""){
					error += "Container number is required.";
				}
				else{
					con_Number.push(con_number[i].value);
				}
				if(con_volume[i].value === ""){
					error += "Container volume is required.";
				}
				else{
					con_Volume.push(con_volume[i].options[con_volume[i].selectedIndex].text);
				}
				if(con_to[i].value === ""){
					error += "Container return to is required.";
				}
				else{
					con_ReturnTo.push(con_to[i].value);
				}
				if(con_address[i].value === ""){
					error += "Container return address is required.";
				}
				else{
					con_ReturnAddress.push(con_address[i].value);
				}
				if(con_date[i].value === ""){
					error += "Container return date is required.";
				}
				else{
					con_ReturnDate.push(con_date[i].value);
				}
			}

			if(error.length === 0){
				return true;
			}
			else{
				return false;
			}

		}

		function validateDetail(){
			descrp_goods = [];
			gross_weights = [];
			suppliers = [];

			var error = "";
			if($("#choices li.active").text() === "Non Container"){
				descrp = document.getElementsByName("wodescriptionOfGoods");
				gw = document.getElementsByName("wogrossWeight");
				supp = document.getElementsByName("wosupplier");
			}
			for(var i = 0; i < descrp.length; i++){
				if(descrp[i].value === ""){
					error += "No description";
				}
				else{
					descrp_goods.push(descrp[i].value);
				}
				if(gw[i].value === ""){
					error += "No gross weight";
				}
				else{
					gross_weights.push(gw[i].value);
				}
				if(supp[i].value === ""){
					suppliers.push("");
				}
				else{
					suppliers.push(supp[i].value);
				}
			}
			if(error.length === 0){
				error = "";
				return true;
			}
			else{
				error = "";
				return false;
			}
		}
	})
</script>
@endpush