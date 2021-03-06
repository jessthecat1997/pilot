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

	.table-borderless > tbody > tr > td,
	.table-borderless > tbody > tr > th,
	.table-borderless > tfoot > tr > td,
	.table-borderless > tfoot > tr > th,
	.table-borderless > thead > tr > td,
	.table-borderless > thead > tr > th {
		border: none;
	}

</style>
@endpush

@section('content')
<div class = "row">

		<div class = "panel-heading">
			<h2>&nbsp;Brokerage | Order</h2>
			<hr>
		</div>
		<div class = "panel-body panel">
			<div class="col-md-12">

					<button class="btn btn-sm btn-primary pull-right clearfix edit-trucking-information" data-toggle="modal" data-target="#trModal">Update Brokerage Status</button>
						<br /><br />
					<div class="panel panel-primary">
						<div class="panel-heading">
								Brokerage Information
						</div>
						<div class="panel-body">
							<br />
									<table class="table">

											<tr>
												<td class="active" width = "30%" ><strong>Brokerage Service Order #: </strong></td>
												<td class = "success" id="consignee">{{ $brokerage_id }}</td>
												<td class="success">
												</td>
											</tr>

											<tr>
												<td class="active"><strong>Status: </strong></td>
												<td class="success">
													@php
													switch($brokerage_header[0]->statusType){
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
													<strong>Estimated Total Brokerage Fee: </strong>
												</td>

												<td class="success" colspan="2">
													@php $totalBrokerageFee = 0.00;@endphp
													@forelse($dutiesandtaxes_header as $brokerageFee)
														@php
															$totalBrokerageFee += floatval($brokerageFee->brokerageFee);
														@endphp
													@empty
															@php $totalBrokerageFee = 0.00; @endphp
													@endforelse
													Php {{number_format((float)$totalBrokerageFee, 2, '.', ',')}}
												</td>
											</tr>
									</table>
									<div id = "containers">
										<div class="panel-group" id = "container_copy">
											<div class="panel panel-default" id = "0_panel">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a data-toggle="collapse" href="#0_container " style = "text-decoration: none;">Order Details</a>
														<div class="pull-right">
															<button class="btn btn-xs btn-info" data-toggle = "collapse" href="#0_container">_</button>
															</div>
													</h4>
												</div>
												<div id="0_container" class="panel-collapse collapse in">
													<div class="panel-body">
														<table class = "table table-borderless">
															<tr>
																<td width = "30%"><strong>Consignee:
																	&nbsp;&nbsp;&nbsp;{{ $brokerage_header[0]->firstName  . " " . $brokerage_header[0]->lastName }}
																	</td>
																<td width = "30%">
									                <strong>Company Name: </strong>
																	<strong>&nbsp;&nbsp;&nbsp;{{ $brokerage_header[0]->companyName }}</strong>
																</td>

																<td width = "30%">
																	<label  id = "shipper"> Shipper: @php echo $brokerage_header[0]->shipper @endphp </label>
																</td>
															</tr>
															<tr>

																<td width = "30%">
																	<label  id = "certificateOfOrigin"> Certificate Of Origin: @php
																		if($brokerage_header[0]->withCO == 1)
																			echo 'Included';
																		if($brokerage_header[0]->withCO == 0)

																			echo 'Not Included'
																		@endphp </label>
																</td>

																<td width = "30%">
																		<label  id = "weight"> Weight: {{ number_format((float)$brokerage_header[0]->Weight, 2, '.', ',')}} (kgs)</label>
																</td>
																<td width = "30%">
																	<label  id = "blNo" > Bill No.: @php echo $brokerage_header[0]->freightBillNo @endphp </label>
																</td>

															</tr>
															<tr>
																<td>
																	<label  id = "arrivalDate"> Expected Date Of Arrival: <br/>
																		@php
																		$date = $brokerage_header[0]->expectedArrivalDate;
																			echo $date =  date("F j, Y (l)") @endphp </label>
																</td>
																<td>
																	<label class = "control-label" id = "port"> Pickup location: <br/> @php  echo $brokerage_header[0]->location @endphp  </label>
																</td>

															</tr>

														</table>


														@if($withContainer == false)
														<div class = "">
															<div class = "panel-default panel">
																<div class = "panel-heading">
																	<h5>Delivery Details: </h5>
																</div>
																<div class = "panel-body">
																	<div class = "col-md-10">
																		<form class="form-horizontal" role="form">
																			<table id = "detail_table" class = "table table-responsive">
																				<thead>
																					<tr>
																						<td>

																						</td>
																						<td>
																							Description Of Good
																						</td>
																						<td>
																							LCL Type
																						</td>
																						<td>
																							Basis
																						</td>
																						<td>
																							Cubic Meters
																						</td>
																						<td>
																							Gross Weight(kg)
																						</td>
																						<td>
																							Supplier/s
																						</td>
																					</tr>
																				</thead>
																				<tbody>
																					@php
																					$num = 1;
																					@endphp
																					@forelse($brokerage_details as $delivery_detail)
																					<tr>
																						<td>
																							{{ $num++ }}
																						</td>
																						<td>
																							{{ $delivery_detail->descriptionOfGoods }}
																						</td>
																						<td>
																							{{ $delivery_detail->lcl_type }}
																						</td>
																						<td>
																							{{ $delivery_detail->basis }}
																						</td>
																						<td>
																							{{ $delivery_detail->cubicMeters }}
																						</td>
																						<td>
																							{{ $delivery_detail->grossWeight }}
																						</td>
																						<td>
																							{{ $delivery_detail->supplier }}
																						</td>
																					</tr>
																					@empty
																					<tr>
																						<td colspan="4">
																							<h5>No records found.</h5>
																						</td>
																					</tr>
																					@endforelse
																				</tbody>
																			</table>
																		</form>
																	</div>
																</div>
															</div>
														</div>
														@endif
														@if($withContainer == true)
														<div class = "">
															<div class = "panel-default panel">
																<div class = "panel-heading">
																	<h5>List Of Containers: </h5>
																</div>
																<div class = "panel-body">
																	<div class = "col-md-12">
																		<form class="form-horizontal" role="form">
																			<table id = "detail_table" class = "table table-responsive" style="width: 100%;">
																				<thead>
																					<tr>
																						<td style="width: 5%;">

																						</td>
																						<td style="width: 25%;">
																							Container Number
																						</td>
																						<td>
																							Cargo Type
																						</td>
																						<td style="width: 20%;">
																							Volume
																						</td>

																						<td style="width: 20%;">
																							Container Return Date
																						</td>


																					</tr>
																				</thead>
																				<tbody>
																					@php
																					$num = 1
																					@endphp

																					@forelse($brokerage_containers as $delivery_container)
																					<tr>
																						<td>
																							{{ $num++ }}
																							<input type = "hidden" class = "containerReturnDate" value= "{{ Carbon\Carbon::parse($delivery_container->containerReturnDate)->toFormattedDateString() }}" />
																							<input type = "hidden" class = "containerID" value= "{{ $delivery_container->id }}" />
																							<input type = "hidden" class = "containerReturnAddress" value= "{{ $delivery_container->containerReturnAddress }}" />
																							<input type = "hidden" class = "shippingLine" value= "{{ $delivery_container->shippingLine }}" />
																							<input type = "hidden" class = "portOfCfsLocation" value= "{{ $delivery_container->portOfCfsLocation }}" />
																							<input type = "hidden" class = "containerReturnTo" value = "{{ $delivery_container->containerReturnTo }}" />
																							<input type = "hidden" class = "dateReturned"
																							value = "@if($delivery_container->dateReturned == null)
																							@else
																							{{ Carbon\Carbon::parse($delivery_container->dateReturned)->toFormattedDateString() }}
																							@endif"
																							/>
																							<input type = "hidden" class = "remarks" value = "{{ $delivery_container->remarks }}" />
																						</td>
																						<td>
																							<span class = "containerNumber">{{ $delivery_container->containerNumber }}</span>
																						</td>
																						<td>
																							@php
																							switch($delivery_container->cargoType){
																								case 'G':  echo "General Cargo"; break;
																								case 'C':  echo "Chemical"; break;
																								case 'D':  echo "Dangerous Cargo"; break;
																							default : echo "Unknown"; break; }
																							@endphp
																						</td>
																						<td>
																							<span class = "containerVolume">{{ $delivery_container->containerVolume }}</span>
																						</td>

																						<td>
																							<span class = "containerReturnDate">{{ Carbon\Carbon::parse($delivery_container->containerReturnDate)->toFormattedDateString() }}</span>
																						</td>
																						@if($delivery_container->dateReturned != null)
																						<td>
																							<span class = "containerReturnDate">{{ Carbon\Carbon::parse($delivery_container->dateReturned)->toFormattedDateString() }}</span>
																						</td>
																						@else

																						@endif

																					</tr>
																					@empty
																					<tr>
																						<td colspan="4">
																							<h5>No records found.</h5>
																						</td>
																					</tr>
																					@endforelse
																				</tbody>
																			</table>
																		</form>
																	</div>
																</div>
															</div>
														</div>
														<br/>
														<div class = "">
															<div class = "panel-default panel">
																<div class = "panel-heading">
																	<h5>Container Contents: </h5>
																</div>
																<div class = "panel-body">
																	<div class = "col-md-10 col-md-offset-1">
																		<form class="form-horizontal" role="form">
																			@php $cont_ctr = 0; @endphp
																			@forelse($container_with_detail as $container)
																			<label class = "control-label">Container Number : {{ $container['container']->containerNumber }}</label>
																			<table class = "table table-responsive" id = "{{ $container['container']->id }}_table" style="width: 100%;"

																				>
																				<thead>
																					<tr>
																						<td>
																							Description of Goods
																						</td>
																						@if($brokerage_containers[$cont_ctr]->cargoType == 'D')
																							<td>
																								Class
																							</td>
																						@else
																							<Td>

																							</td>
																						@endif

																						<td>
																							Gross Weight(kg)
																						</td>
																						<td>
																							Supplier/s
																						</td>
																					</tr>
																				</thead>
																				<tbody>
																					@forelse($container['details'] as $detail)
																					<tr>
																						<td>
																							{{ $detail->descriptionOfGoods }}
																						</td>

																						@if($brokerage_containers[$cont_ctr]->cargoType == 'D')
																							<td >

																								@forelse($dangerous_cargo_types as $dct)

																									@if($dct->id == $detail->class_id)
																										{{$dct->name}}
																									@endif

																								@empty
																								@endforelse
																							</td>
																						@else
																							<Td>

																							</td>
																						@endif


																						<td>
																							{{ $detail->grossWeight }}
																						</td>
																						<td>
																							{{ $detail->supplier }}
																						</td>
																					</tr>
																					@empty
																					<tr>
																						<td colspan="4">
																							<h5 style="text-align: center;">No records found.</h5>
																						</td>
																					</tr>
																					@endforelse
																				</tbody>
																				@php $cont_ctr++ @endphp
																			</table>
																			@empty
																			@endforelse
																		</form>
																	</div>
																</div>
															</div>
														</div>
														@endif
													</div>
												</div>
											</div>
										</div>
									</div>
						</div>
					</div>
					<hr />
				</div>
			</div>

		</div>

</div>

<div class = "row">

		<div class = "panel default-panel">


			<div class = "panel-body">
				<button class = "btn btn-md btn-success col-md-5 pull-right collapse" id = "newDutiesAndTaxes">New Duties and Taxes</button>
				<br /><br />


				<div class="panel panel-primary">
					<div class="panel-heading">
						Declared Duties And Taxes
					</div>
					<div class="panel-body">
								<table class = "table table-responsive table-striped cell-border table-bordered" id = "dutiesandtaxes_table">
							<thead>
								<tr>
									<td style="width: 5%;">
										ID
									</td>
									<td style="width: 5%;">
									  Exchange Rate
									</td>
									<td style="width: 20%;">
										Brokerage Fee
									</td>
									<td style="width: 20%;">
										Processed By
									</td>
									<td style = "width: 10%">
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
</div>


<div class = "row">
		<div class = "panel">
			<div class = "panel-body">

			</div>
		</div>

</div>
<hr>
<div class = "row">
	<div class="col-lg-12">
		<div class="panel-body">
			<div class="panel-group" id="accordion">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Billing</h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse in">
						<div class="panel-body">
							<div class="panel-primary">
								<div class="col-lg-6">
									@if($brokerage_header[0]->bi_head_id_rev)
									<h4>List of Billings <button class = "btn but new_revenue pull-right collapse">New Revenue</button></h4>
									@else
									<h4>List of Billings</h4>
									@endif
									<br />
									@if($brokerage_header[0]->bi_head_id_rev != null)
									<table class="table table-responsive table-striped cell-border table-bordered" style="width: 100%;" id = "revenues_table">
										<thead>
											<tr>
												<td>
													Name
												</td>
												<td>
													Description
												</td>
												<td>
													Amount
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
										<div class = "col-md-10 collapse" id = "CreateBillingFirst">
											Create Billing First to Add Payables.
										</div>
										<div class = "col-md-10 collapse" id = "NoBillingRecords">
											No Billing Records Found
										</div>

										<div class="col-md-2">
											<button class = "btn but new_revenue_bill btn-sm collapse">New Bill</button>
										</div>
									</div>
									@endif
								</div>
							</div>
							<div class="panel-primary">
								<div class="col-lg-6">
									@if($brokerage_header[0]->bi_head_id_exp != null)
									<h4>List of Refundable Charges <button class = "btn but new_expense pull-right collapse">New Expense</button></h4>
									@else
									<h4>List of Refundable Charges</h4>
									@endif
									<br />
									@if($brokerage_header[0]->bi_head_id_exp != null)
									<table class="table table-responsive table-striped" style="width: 100%;" id = "expense_table">
										<thead>
											<tr>
												<td>
													Name
												</td>
												<td>
													Description
												</td>
												<td>
													Amount
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
										<div class = "col-md-10 collapse" id = "CreatePayableFirst">
											Create Bill First to Add Payables.
										</div>
										<div class = "col-md-10 collapse" id = "NoPayableRecords">
											No Payables Record Found.
										</div>
										<div class="col-md-2">
											<button class = "btn but new_expense_bill btn-sm collapse">New Bill</button>
										</div>
									</div>
									@endif

								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Consignee Deposits</h4>
					</div>
					<div id="collapseTwo" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="panel-primary">
								<div class="col-lg-12">
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
			</div>
		</div>
	</div>
</div>
</div>


<!-- Revenue Modal -->
<div id="revModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">New Payable</h4>
			</div>
			<div class = "modal-body">

					<div class="form-horizontal">
						<div class = "col-md-12">
							<div class = "form-group">
								<label class = "control-label col-md-3">Name *</label>
								<div class = "col-md-9">
									<select id = "rev_bill_id" name="rev_bill_id" class = "form-control ">
										<option value = "0">Select Charges</option>
										@php $ctr = 0; @endphp
										@forelse($bill_revs as $rev)
										<option value = "{{$rev->id}}">{{ $rev->name }}</option>
										@empty
										@endforelse
									</select>
								</div>
							</div>
						</div>
						<div class = "form-group">
							<div class = "col-md-12">
								<label class = "control-label col-md-3">Amount *</label>
								<div class = "col-md-9">
									<input type = "text" name = "rev_amount" id="rev_amount" class = "form-control" style="text-align: right">
								</div>
							</div>
						</div>

						<div class = "form-group">
							<div class = "col-md-12 collapse" id = "1_panel">
							<div id = "brokerage" >
								<div class="panel-group" id = "brokerage_copy">
									<div class="panel panel-default" >
										<div class="panel-heading">
											<h4 class="panel-title">
												<label data-toggle="collapse">Declared Duties And Taxes</label>
												<div class="pull-right">
													</div>
										</h4>
									</div>
									<div id="1_container" class="panel-collapse collapse in">
										<div class="panel-body">
												<table class="table table-responsive table-striped" style="width: 100%;" id = "declared_dutiesandtaxes">
													<thead>
														<tr>
															<td >
																	ID
															</td  >
															<td>
																Date Created
															</td>
															<td>
																Brokerage Fee
															</td>
															<td >
																Action
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
					</div>
						<div class = "form-group">
							<div class = "col-md-12">
								<label for="rev_description " class = "control-label col-md-3">Description:</label>
								<div class = "col-md-9">
									<textarea class="form-control" rows="3" id="rev_description" name="rev_description"></textarea>
								</div>
							</div>
						</div>
					</div>

				<div class = "col-md-12 collapse">

				</div>
				<strong>Note:</strong> All fields with * are required.
		</div>
			<div class="modal-footer">
				<a class="btn but finalize-rev">Save</a>
			</div>
		</div>
	</div>
</div>

<!-- Expenses Modal -->
<div class="modal fade" id="expModal"  role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">New Payable</h4>
			</div>
			<div class = "modal-body">

					<div class="form-horizontal">
						<div class = "col-md-12">
							<div class = "form-group">
								<label class = "control-label col-md-3">Name *</label>
								<div class = "col-md-9">
									<select id = "exp_bill_id" name="exp_bill_id" class = "form-control">
										<option value = "0">Select Charges</option>
										@php $ctr = 0; @endphp
										@forelse($bill_exps as $exp)
										<option value = "{{$exp->id}}">{{ $exp->name }}</option>
										@empty

										@endforelse
									</select>
								</div>
							</div>
						</div>
						<div class = "col-md-12">
							<div class = "form-group">
								<label class = "control-label col-md-3">Amount *</label>
								<div class = "col-md-9">
									<input type = "text" name = "exp_amount" id="exp_amount" class = "form-control" style="text-align: right">
								</div>
							</div>
						</div>

						<div class = "col-md-12">
							<div class = "form-group">
							<label for="rev_description" class = "control-label col-md-3">Description:</label>
							<div class = "col-md-9">
								<textarea class="form-control" rows="3" id="exp_description" name="exp_description"></textarea>
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

				<strong>Note:</strong> All fields with * are required.
			</div>
			<div class="modal-footer">
				<a class="btn but finalize-exp">Save</a>
			</div>
		</div>
	</div>
</div>

<!-- Update Brokerage Status -->
<div class="modal fade" id="trModal"  role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Brokerage Information</h4>
			</div>
			<div class="modal-body">
				<div class = "form-horizontal">
					<div class="form-group">
						<label class="control-label col-sm-3" for="_status">Status</label>
						<div class="col-sm-8">
								<select name = "_status" id = "_status" class = "form-control">
									<option value = "P" @if($brokerage_header[0]->statusType == 'P')
										selected disabled title="The order is already pending."
										@endif>Pending</option>
									<option value = "C" @if($brokerage_header[0]->statusType == 'C')
										selected disabled title="The order is already cancelled."
										@endif>Cancelled</option>
											<option value = "F" @if($brokerage_header[0]->statusType == 'F')
												selected disabled title="The order is already finished."
												@endif
											>Finished</option>

								</select>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<form role = "form" method = "PATCH">
						{{ csrf_field() }}
				<button type="button" class="btn btn-success save-trucking-information" data-dismiss="modal" id = "StatusUpdate">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Update Duties And Taxes -->
<div class="modal fade" id="updateModal"  role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Duties And Taxes Information</h4>
			</div>
			<div class="modal-body">
				<div class = "form-horizontal">
					<div class="form-group">
						<label class="control-label col-sm-3" for="_status">Status</label>
						<div class="col-sm-8">
								<select name = "_status" id = "_taxstatus" class = "form-control">
									<option value = "P">Pending</option>
									<option value = "A">Approved</option>
									<option value = "R">Rejected</option>
								</select>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success save-tax-information" data-dismiss="modal" id = "TaxStatusUpdate">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!--Update Confirm Create Bill -->
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

<!--Update Confirm Create Deposit -->
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

<!--Select Container -->
<div class="modal fade" id="select_container" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Select Container
			</div>
			<div class="modal-body">
					@if($withContainer == true)
				<table id = "detail_table" class = "table table-responsive" style="width: 100%;">
					<thead>

						<tr>
							<td style="width: 5%;">

							</td>
							<td style="width: 25%;">
								Container Number
							</td>
							<td style="width: 20%;">
								Volume
							</td>
							<td style="width: 20%;">
								Container Return Date
							</td>
							<td style="width: 20%;">
								Action
							</td>

						</tr>
					</thead>
					<tbody>
						@php
						$num = 1
						@endphp

						@forelse($brokerage_containers as $delivery_container)
						<tr>
							<td>
								{{ $num++ }}
								<input type = "hidden" class = "containerReturnDate" value= "{{ Carbon\Carbon::parse($delivery_container->containerReturnDate)->toFormattedDateString() }}" />
								<input type = "hidden" class = "containerID" value= "{{ $delivery_container->id }}" />
								<input type = "hidden" class = "containerReturnAddress" value= "{{ $delivery_container->containerReturnAddress }}" />
								<input type = "hidden" class = "shippingLine" value= "{{ $delivery_container->shippingLine }}" />
								<input type = "hidden" class = "portOfCfsLocation" value= "{{ $delivery_container->portOfCfsLocation }}" />
								<input type = "hidden" class = "containerReturnTo" value = "{{ $delivery_container->containerReturnTo }}" />
								<input type = "hidden" class = "dateReturned"
								value = "@if($delivery_container->dateReturned == null)
								@else
								{{ Carbon\Carbon::parse($delivery_container->dateReturned)->toFormattedDateString() }}
								@endif"
								/>
								<input type = "hidden" class = "remarks" value = "{{ $delivery_container->remarks }}" />
							</td>
							<td>
								<span class = "containerNumber">{{ $delivery_container->containerNumber }}</span>
							</td>
							<td>
								<span class = "containerVolume">{{ $delivery_container->containerVolume }}</span>
							</td>

							<td>
								<span class = "containerReturnDate">{{ Carbon\Carbon::parse($delivery_container->containerReturnDate)->toFormattedDateString() }}</span>
							</td>
							<td>
								<button class = "btn btn-info" value = "{{$delivery_container->id}}" onclick = "">Select</button>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="4">
								<h5>No records found.</h5>
							</td>
						</tr>
						@endforelse
					</tbody>
				</table>
				@endif
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>


@endsection
@push('styles')
<style>
	.brokerage
	{
		border-left: 10px solid #2ad4a5;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
<link href= "/js/select2/select2.css" rel = "stylesheet">
@endpush
@push('scripts')
<script type = "text/javascript">

var bill_rev_amount = [];
var bill_exp_amount = [];

var bill_rev_amount = <?php echo json_encode($bill_revs) ?>;
var chargeAmount = 0;
var isBrokerageFee = 0;
var BrokerageFeeId = 0;
var brokerage_fees;

$(document).on('click', '.new_deposit', function(e){
	e.preventDefault();
	$('#deposit_modal').modal('show');
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

$(document).on('click', '.new_expense ', function(e){
	e.preventDefault();
	$('#expModal').modal('show');
})

$(document).on('click', '.new_revenue', function(e){
	e.preventDefault();
	$('#revModal').modal('show');
})

$(document).on('click', '.confirm-create-deposit', function(e){
	e.preventDefault();
	$.ajax({
		type : 'POST',
		url : "{{ route('cdeposit.index') }}",
		data : {
			'_token' : $('input[name=_token]').val(),
			'amount' : $('#deposit').val(),
			'description' : $('#description').val(),
			'consignees_id' : " {{ $brokerage_header[0]->consigneeid }}",
		},
		success : function (data){
			console.log(data);
			window.location.reload();
		}
	})
})

$(document).on('click', '.confirm-create-bill', function(e){
	e.preventDefault();

	$('.confirm-create-bill')[0].setAttribute('disabled', 'true');

	switch(create_bill){
		case 0 :
		$.ajax({

			type: 'POST',
			url: '{{ route("create_br_billing_header") }}',
			data: {
				'_token' : $('input[name=_token]').val(),
				'isRevenue' : create_bill,
				'br_so_id' : '{{ $brokerage_header[0]->id }}',

			},
			success: function(data){
				window.location.reload();
			}
		})
		break;

		case 1 :
		$.ajax({

			type: 'POST',
			url: '{{ route("create_br_billing_header") }}',
			data: {
				'_token' : $('input[name=_token]').val(),
				'isRevenue' : create_bill,
				'br_so_id' : '{{ $brokerage_header[0]->id }}',
			},
			success: function(data){
				window.location.reload();
			}
		})
		break
	}
})

@if($brokerage_header[0]->bi_head_id_exp != null)
$(document).on('click', '.finalize-exp', function(e){
	$.ajax({
		method: 'POST',
		url: "{{ route('postBrokerageRefundable') }}",
		data: {
			'_token' : $('input[name=_token]').val(),
			'charge_id' : $('#exp_bill_id').val(),
			'description' : $('#exp_description').val(),
			'amount' : $('#exp_amount').val(),
			'bi_head_id' : '{{ $brokerage_header[0]->bi_head_id_exp }}',
		},
		success: function (data){
			location.reload();
		}
	})
})
@endif

@if($brokerage_header[0]->bi_head_id_rev != null)
$(document).on('click', '.finalize-rev', function(e){

	$.ajax({
		method: 'POST',
		url: "{{ route('post_brokerage_payables') }}",
		data: {
			'_token' : $('input[name=_token]').val(),
			'isBrokerageFee' : ''+isBrokerageFee,
			'declaration_id' : ''+BrokerageFeeId,
			'charge_id' : $('#rev_bill_id').val(),
			'description' : $('#rev_description').val(),
			'amount' : document.getElementById("rev_amount").value,
			'bi_head_id' : '{{ $brokerage_header[0]->bi_head_id_rev }}',
		},
		success: function (data){
			isBrokerageFee = 0;
			location.reload();
		}
	})
})
@endif

$('#newDutiesAndTaxes').on('click', function(e){
		e.preventDefault();
		window.location.replace('{{route("brokerage.index")}}/{{$brokerage_id}}/create_dutiesandtaxes');
});

function redirect_selectedContainer()
{
	window.location.replace('{{route("brokerage.index")}}/{{$brokerage_id}}/containerized//create_dutiesandtaxes');

}

$(document).on('change', '#rev_bill_id', function(e){
	document.getElementById("rev_amount").value = "";
	revID = $('#rev_bill_id').val();
	if($('#rev_bill_id').val() != 0){
		var e = document.getElementById("rev_bill_id");
		var strUser = e.options[e.selectedIndex].text;
		var brokerage_fees_rows = "";

		if(strUser == "Brokerage Fee"){

			$('#1_panel').addClass('in');
			document.getElementById("rev_amount").disabled = true;
			$.ajax({
				type: 'GET',
				url: '{{ route("getBrokerageFees")}}/{{ $brokerage_id }}',
				data: {
					'_token' : $('input[name=_token]').val(),
					'br_so_id' : '{{ $brokerage_id }}',
				},

				success: function(data){


					for(var i = 0; i < data.length; i++){
						brokerage_fees_rows += "<tr><td style = 'text-align: center;	'>"  + data[i].id + "</td><td>" +
						"<input type = 'number' style = 'text-align: right;' class = 'form-control' value = '" + data[i].amount + "' /></td><td>" +
						"<button class = 'btn btn-md btn-primary ' onclick = '+	document.getElementById('rev_amoun').value ='+data[i].brokerageFee+';+'>+</button>";
					}
					$('#brokerage_fees_table > tbody').html("");
					$('#brokerage_fees_table > tbody').append(brokerage_fees_rows);

				}
			})


		}
	}
	if($('#rev_bill_id').val() != 0 &&  strUser != "Brokerage Fee")
	{
		isBrokerageFee = 0;
		$('#1_panel').removeClass('in');
		document.getElementById("rev_amount").disabled = false;
		$.ajax({
			type: 'GET',
			url: '{{ route("getCharges") }}/{{ $brokerage_id }}',
			data: {
				'_token' : $('input[name=_token]').val(),
				'charge_id' : $('#rev_bill_id').val(),
			},
			success: function(data){
				document.getElementById("rev_amount").value = parseFloat(data[0].amount).toFixed(2);
					}
		})
	}
	if($('#rev_bill_id').val() == 0 )
	{
		document.getElementById("rev_amount").value = 0.00;
		chargeAmount = 0.00;
	}
	else
	{

	}
})

$(document).on('change', '#exp_bill_id', function(e){
	document.getElementById("exp_amount").value = "";
	revID = $('#exp_bill_id').val();
	if($('#exp_bill_id').val() != 0 )
	{
		$.ajax({

			type: 'GET',
			url: '{{ route("getCharges") }}/{{ $brokerage_id }}',
			data: {
				'_token' : $('input[name=_token]').val(),
				'charge_id' : $('#exp_bill_id').val(),
			},
			success: function(data){
				document.getElementById("exp_amount").value = parseFloat(data[0].amount).toFixed(2);
					}
		})
	}
	if($('#rev_bill_id').val() == 0 )
	{
		document.getElementById("exp_amount").value = 0.00;
		chargeAmount = 0.00;
	}
	else
	{

	}
})

@if($brokerage_header[0]->bi_head_id_rev != null)
var delivery_table = $('#revenues_table').DataTable({
	processing: false,
	deferRender: true,
	serverSide: false,
	scrollX: true,
	ajax: '{{ route("getBrokerageBillingDetails") }}/{{  $brokerage_id }}',
	columns: [

	{ data: 'name' },
	{ data: 'description' },
	{ data: 'amount'},

	],	"order": [[ 0, "desc" ]],
});
@endif



$(document).ready(function(){
  var dutiesandtaxes_tableVar = $('#dutiesandtaxes_table').DataTable({
    processing: false,
    deferRender: true,
    serverSide: false,
    scrollX: true,
		lengthMenu: [[5, 10, 15, -1], [5, 10, 15, "All"]],
    ajax: '{{route("brokerage.index")}}/{{ $brokerage_id }}/get_dutiesandtaxes',
    columns: [

    { data: 'id' },
		{ data: 'rate'},
    { data: 'brokerageFee'},
    { data: 'processedBy'},
		{ data: 'statusType'},
    { data: 'action', orderable: false, searchable: false },

    ],	"order": [[ 0, "desc" ]],
  });


		var declared_dutiesandtaxesvar = $('#declared_dutiesandtaxes').DataTable({
			processing: false,
			deferRender: true,
			serverSide: false,
			ajax: '{{ route("brokerage.index") }}/{{  $brokerage_id }}/get_approveddutiesandtaxes',
			columns: [

			{ data: 'duty_header_id' },
			{ data: 'created_at' },
			{ data: 'amount'},
			{ data: 'action', orderable: false, searchable: false}

			],	"order": [[ 0, "desc" ]],
		});

	$('#TaxStatusUpdate').on('click', function(e){

		$.ajax({
			type: 'PATCH',
			url: '{{route("brokerage.index")}}/'+update_id+'/order/statusTaxUpdate',
			data: {
				'_token' : $('input[name=_token]').val(),
				'status' : document.getElementById('_taxstatus').value,
			},
			success: function(data){
				dutiesandtaxes_tableVar.ajax.reload();
				declared_dutiesandtaxesvar.ajax.reload();
				toastr.options = {
					"closeButton": false,
					"debug": false,
					"newestOnTop": false,
					"progressBar": false,
					"rtl": false,
					"positionClass": "toast-bottom-right",
					"preventDuplicates": false,
					"onclick": null,
					"showDuration": 300,
					"hideDuration": 1000,
					"timeOut": 2000,
					"extendedTimeOut": 1000,
					"showEasing": "swing",
					"hideEasing": "linear",
					"showMethod": "fadeIn",
					"hideMethod": "fadeOut"
				}
				toastr["success"]("Update successful");
				window.location.reload();

			},
			error: function(data) {

			}
		})
	});



	@if($brokerage_header[0]->bi_head_id_exp != null)
	var delivery_table = $('#expense_table').DataTable({
		processing: false,
		deferRender: true,
		serverSide: false,
		scrollX: true,
		ajax: '{{ route("getBrokerageRefundableDetails") }}/{{ $brokerage_id }}',
		columns: [

		{ data: 'name' },
		{ data: 'description' },
		{ data: 'amount'},

		],	"order": [[ 0, "desc" ]],
	});
	@endif

	var delivery_table = $('#deposits_table').DataTable({
		processing: false,
		deferRender: true,
		serverSide: false,
		ajax: '{{ route("depositView") }}/{{ $brokerage_id }}',
		columns: [

		{ data: 'created_at' },
		{ data: 'amount' },
		{ data: 'currentBalance'},
		{ data: 'description'},
		],	"order": [[ 0, "desc" ]],
	});

})

$('#StatusUpdate').on('click', function(e){

	$.ajax({
		type: 'PATCH',
		url: '{{route("brokerage.index")}}/{{$brokerage_id}}/order/statusupdate',
		data: {
			'_token' : $('input[name=_token]').val(),
			'status' : document.getElementById('_status').value,

		},
		success: function(data){

			window.location.replace('/brokerage/'+data+'/order');
		},
		error: function(data) {

		}
	})
});

var update_id = 0;
var select_id = 0;
$(document).on('click', '.updateTax', function(e){
	e.preventDefault();
	update_id = $(this).val();
})

$(document).on('click', '.selectedBrokerage', function(e){
	e.preventDefault();

	selected_decleration($(this).val());
})
var brokerage_fee = <?php echo json_encode($brokerage_fees)?>;
var brokerage_ctr = <?php echo count($brokerage_fees)?>;
function selected_decleration(duty_det_id){



	for(var x = 0; x < brokerage_ctr; x++)
	{
		if(brokerage_fee[x].duty_header_id == duty_det_id)
		{
			document.getElementById("rev_amount").value = parseFloat(brokerage_fee[x].brokerageFee).toFixed(2);
			$('#1_panel').removeClass('in');
			document.getElementById("rev_amount").disabled = true;
			BrokerageFeeId = duty_det_id;
			isBrokerageFee = 1;
		}
	}
}

window.onload = function(){

	@if($brokerage_header[0]->statusType == 'P')
		$('#newDutiesAndTaxes').addClass('in');

		$('.new_expense').addClass('in');
		$('.new_revenue').addClass('in');

		$('.updateTax').addClass('in');

		$('.new_expense_bill').addClass('in');
		$('.new_revenue_bill').addClass('in');
	  		$('#CreateBillingFirst').addClass('in');
		$('#CreatePayableFirst').addClass('in');
		$('#NoBillingRecords').removeClass('in');
		$('#NoPayableRecords').removeClass('in');


	@endif
	@if($brokerage_header[0]->statusType == 'C')
		$('#newDutiesAndTaxes').removeClass('in');

		$('.new_expense').removeClass('in');
		$('.new_revenue').removeClass('in');

		$('.updateTax').removeClass('in');

		$('.new_expense_bill').removeClass('in');
		$('.new_revenue_bill').removeClass('in');
		$('#CreateBillingFirst').removeClass('in');
		$('#CreatePayableFirst').removeClass('in');
		$('#NoBillingRecords').addClass('in');
		$('#NoPayableRecords').addClass('in');


	@endif
	@if($brokerage_header[0]->statusType == 'F')

		$('#newDutiesAndTaxes').removeClass('in');

		$('.new_expense').addClass('in');
		$('.new_revenue').addClass('in');

		$('.updateTax').removeClass('in');

		$('.new_expense_bill').removeClass('in');
		$('.new_revenue_bill').removeClass('in');
		$('#CreateBillingFirst').removeClass('in');
		$('#CreatePayableFirst').removeClass('in');
		$('#NoBillingRecords').addClass('in');
		$('#NoPayableRecords').addClass('in');

	@endif
}
</script>
@endpush
