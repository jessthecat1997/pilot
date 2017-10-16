@extends('layouts.app')
@section('content')
<div class = "col-md-12">
	<div class="panel" id="myModal">
		<div class="panel-header">
			<h3>New Delivery</h3>
			<hr />
		</div>
		<div class="panel-body">
			<ul class="nav nav-pills nav-justified" id = "choices">
				<li class="active"><a data-toggle="pill" href="#wcontainer">Container</a></li>
				<li><a data-toggle="pill" href="#wocontainer">Without Container</a></li>
			</ul>
			<br />
			<div class = "col-md-12">
				<div class = "col-md-12">
					<div class="tab-content">
						<div id="wcontainer" class="tab-pane fade in active">
							<div class = "panel">
								<div class = "">
									<form class="form-horizontal">
										{{ csrf_field() }}
										<div class="row">
											<h4>&nbsp;Container Information</h4>
											<div id = "containers">
												<div class="panel-group" id = "container_copy">
													<div class="panel panel-default" id = "0_panel">
														<div class="panel-heading">
															<h4 class="panel-title">
																<a data-toggle="collapse" href="#0_container ">Container</a>
																<div class="pull-right">
																	<button class="btn btn-xs btn-info" data-toggle = "collapse" href="#0_container">_</button>
																	<button class="remove-container-row btn btn-xs btn-danger" value = "0_panel">&times;</button>
																</div>
															</h4>
														</div>
														<div id="0_container" class="panel-collapse collapse in">
															<div class="panel-body">
																<div class = "row">
																	<div class = "col-md-6">
																		<div class = "form-horizontal">
																			<div class="form-group required">
																				<label class="control-label col-sm-4" for="contactNumber">Container Number:</label>
																				<div class="col-sm-8">
																					<input type = "text" name = "containerNumber" id = "containerNumber" class = "form-control row_containerNumber" placeholder="CSQU3054383" />
																				</div>
																			</div>
																		</div>
																		<div class = "form-horizontal">
																			<div class="form-group required">
																				<label class="control-label col-sm-4" for="contactNumber">Container Size:</label>
																				<div class="col-sm-8">
																					<select class = "form-control row_containerVolume" id = "containerVolume" name = "containerVolume">
																						<option></option>
																						@forelse($container_volumes as $container_volume)
																						<option value = "{{ $container_volume->id }}">{{ $container_volume->name }}</option>
																						@empty

																						@endforelse
																					</select>
																				</div>
																			</div>
																		</div>
																		<div class = "form-horizontal">
																			<div class="form-group required">
																				<label class="control-label col-sm-4" for="shippingLine">Shipping Line:</label>
																				<div class="col-sm-8">
																					<input type = "text" name = "shippingLine" id = "shippingLine " class = "form-control " />
																				</div>
																			</div>
																		</div>
																		<div class = "form-horizontal">
																			<div class="form-group required">
																				<label class="control-label col-sm-4" for="contactNumber">Port of Cfs Location:</label>
																				<div class="col-sm-8">
																					<input type = "text" name = "portOfCfsLocation" id = "portOfCfsLocation " class = "form-control" />
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class = "col-md-6">
																		<div class = "form-horizontal">
																			<div class="form-group required">
																				<label class="control-label col-sm-4" for="contactNumber">Return Date:</label>
																				<div class="col-sm-8">
																					<input type = "text" name = "containerReturnDate" id = "containerReturnDate " class = "form-control containerReturnDate" />
																				</div>
																			</div>
																		</div>
																		<div class = "form-horizontal">
																			<div class="form-group required">
																				<label class="control-label col-sm-4" for="contactNumber">Return To:</label>
																				<div class="col-sm-8">
																					<input type = "text" name = "containerReturnTo" id = "containerReturnTo" class = "form-control row_containerReturnTo" />
																				</div>
																			</div>
																		</div>
																		<div class = "form-horizontal">
																			<div class="form-group required">
																				<label class="control-label col-sm-4" for="contactNumber">Return Address:</label>
																				<div class="col-sm-8">
																					<textarea name = "containerReturnAddress" id = "containerReturnAddress " class = "form-control row_containerReturnAddress"></textarea>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																<div class = "col-md-12">
																	<table class="table table-responsive table-striped table-bordered" id = "0_details">
																		<thead>
																			<tr>
																				<td style="text-align: center;">
																					<div class="row">
																						<div class="form-group required">
																							<label class = "control-label">Description of goods</label>
																						</div>
																					</div>
																				</td>
																				<td style="text-align: center;">
																					<div class="row">
																						<div class="form-group required">
																							<label class = "control-label">Gross Weight (kg)</label>
																						</div>
																					</div>
																				</td>
																				<td style="text-align: center;">
																					<div class="row">
																						<div class="form-group">
																							<label class = "control-label">Supplier/s</label>
																						</div>
																					</div>
																				</td>
																				<td style="text-align: center;">
																					<div class="row">
																						<div class="form-group">
																							<label class = "control-label">Action</label>
																						</div>
																					</div>
																				</td>
																			</tr>
																		</thead>
																		<tbody>
																			<tr>
																				<td width="40%">
																					<input type = "text" name = "0_descriptionOfGoods" class = "form-control"/>
																				</td>
																				<td width="20%">
																					<input type = "text" name = "0_grossWeight" style = "text-align: right;" class = "form-control money"/ >
																				</td>
																				<td width="30%">
																					<input type = "text" name = "0_supplier"  class = "form-control" />
																				</td>
																				<td width="10%" style="text-align: center;">
																					<button class = "btn btn-md btn-danger remove-container-detail" value = "0">
																						x
																					</button>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</div>
																<div class="row">
																	<div class ="col-md-9">

																	</div>
																	<div class= "col-md-3" style="text-align: center;">
																		<button class = "btn btn-primary btn-sm new-container-detail" style="width: 80%;" value = "0_add">New Item</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class= "col-md-3" style="text-align: center;">
												<button class = "btn btn-primary btn-sm add-new-container" style="width: 80%;">New Container</button>
											</div>
											<div class ="col-md-9">

											</div>
										</div>
									</form>

								</div>
							</div>
						</div>

						<div id="wocontainer" class="tab-pane fade">
							<div class = "panel">
								<div class = "">
									<form class="form-horizontal" role="form">
										<div class="form-group">
											<label class="control-label" for="wodetail_table">Delivery Content:</label>
											<table class = "table-responsive table table-striped table-bordered" id = "wodetail_table">
												<thead>
													<tr>
														<td style="text-align: center;">
															<div class="row">
																<div class="form-group required">
																	<label class = "control-label">Description of goods</label>
																</div>
															</div>
														</td>
														<td style="text-align: center;">
															<div class="row">
																<div class="form-group required">
																	<label class = "control-label">Gross Weight (kg)</label>
																</div>
															</div>
														</td>
														<td style="text-align: center;">
															<div class="row">
																<div class="form-group">
																	<label class = "control-label">Supplier/s</label>
																</div>
															</div>
														</td>
														<td style="text-align: center;">
															<div class="row">
																<div class="form-group">
																	<label class = "control-label">Action</label>
																</div>
															</div>
														</td>
													</tr>	
												</thead>
												<tbody>
													<tr id = "wodescription_row">
														<td width="40%">
															<input type = "text" name = "wodescriptionOfGoods" class = "form-control"/>
														</td>
														<td width="20%">
															<input type = "text" name = "wogrossWeight" class = "form-control money" style = "text-align: right;" />
														</td>
														<td width="30%">
															<input type = "text" name = "wosupplier"  class = "form-control" />
														</td>
														<td width="10%" style="text-align: center;">
															<button class = "btn btn-md btn-danger woremove-current-detail">x</button>
														</td>
													</tr>
												</tbody>
											</table>
											<div class="row">
												<div class="col-md-9">

												</div>
												<div class="col-md-3">
													<button class = "btn btn-sm btn-primary woadd-new-detail" style="width: 80%;">New item</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class = "col-md-12">
				<div class = "panel panel-default">
					<div class = "panel-heading">
						Pickup Location
					</div>
					<div class="panel-body">
						<div class = "row">
							<div class = "col-md-4">
								<div class = "col-md-12">
									{{ csrf_field() }}
									<div class="form-group required">
										<label class = "control-label ">Location Name: </label>
										<div class="input-group">
											<select class = "form-control" id = "pickup_id">
												<option value = "0"></option>
												@forelse($locations as $location)
												<option value = "{{ $location->id }}">{{ $location->name }}</option>
												@empty
												@endforelse
											</select>
											<span class="input-group-btn">
												<button class="btn btn-primary pick_add_new_location" type="button">+</button>
											</span>
										</div>
									</div>
								</div>
								<div class = "col-md-12">
									<div class="form-group">
										<label class="control-label" for = "deldatecon">Pickup Date &amp; Time:</label>
										<input type = "text" name = "pickdatecon" id = "pickdatecon" class = "form-control pickaddcon" />
									</div>
								</div>
							</div>
							<div class = "col-md-8">


								{{ csrf_field() }}
								<div class = "col-md-12">
									<div class = "col-md-12">
										<div class = "col-md-12">
											<div class="form-group required">
												<label class = "control-label">Address: </label>
												<textarea class = "form-control" disabled  id = "_address"></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class = "col-md-12">
									<div class = "col-md-4">
										<div class =  "col-md-12">
											<div class = "form-group">
												<label class = "control-label">City</label>
												<input type = "text" class = "form-control" disabled id = "_city" />
											</div>
										</div>
									</div>
									<div class = "col-md-4">
										<div class = "col-md-12">
											<div class = "form-group">
												<label class = "control-label">Province</label>
												<input type = "text" class = "form-control"  disabled id = "_province" />
											</div>
										</div>
									</div>
									<div class = "col-md-4">
										<div class = "col-md-12">
											<div class = "form-group">
												<label class = "control-label">ZIP</label>
												<input type = "text" class = "form-control" disabled id = "_zip" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class = "col-md-12">
				<div class = "panel panel-default">
					<div class = "panel-heading">
						Delivery Location
					</div>
					<div class="panel-body">
						<div class = "row">
							<div class = "col-md-4">
								<div class = "col-md-12">
									{{ csrf_field() }}
									<div class="form-group required">
										<label class = "control-label ">Location Name: </label>
										<div class="input-group">
											<select class = "form-control" id = "deliver_id">
												<option value = "0"></option>
												@forelse($locations as $location)
												<option value = "{{ $location->id }}">{{ $location->name }}</option>
												@empty
												@endforelse
											</select>
											<span class="input-group-btn">
												<button class="btn btn-primary del_add_new_location" type="button">+</button>
											</span>
										</div>
									</div>
								</div>
								<div class = "col-md-12">
									<div class="form-group">
										<label class="control-label" for = "deldatecon">Delivery Date &amp; Time:</label>
										<input type = "text" name = "deldatecon" id = "deldatecon" class = "form-control deladdcon" />
									</div>
								</div>
							</div>
							<div class = "col-md-8">
								{{ csrf_field() }}
								<div class = "col-md-12">
									<div class = "col-md-12">
										<div class = "col-md-12">
											<div class="form-group required">
												<label class = "control-label">Address: </label>
												<textarea class = "form-control" disabled  id = "_daddress"></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class = "col-md-12">
									<div class = "col-md-4">
										<div class =  "col-md-12">
											<div class = "form-group">
												<label class = "control-label">City</label>
												<input type = "text" class = "form-control" disabled id = "_dcity" />
											</div>
										</div>
									</div>
									<div class = "col-md-4">
										<div class = "col-md-12">
											<div class = "form-group">
												<label class = "control-label">Province</label>
												<input type = "text" class = "form-control"  disabled id = "_dprovince" />
											</div>
										</div>
									</div>
									<div class = "col-md-4">
										<div class = "col-md-12">
											<div class = "form-group">
												<label class = "control-label">ZIP</label>
												<input type = "text" class = "form-control" disabled id = "_dzip" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<form class = "form-horizontal">
				<div class = "row">
					<div class = "col-md-6">
						<div class = "panel-default panel">
							<div class = "panel-heading" id = "rate_header">
								Rates for
							</div>
							<div class = "panel-body">
								<div class="form-group">
									<label class="col-md-4">Standard Area Rate:</label>
									<span class = "col-md-8" id = "standard_rate"></span>
								</div>
								<div class="form-group">
									<label class="col-md-4">Quotation Rate/s:</label>
									<div class = "col-md-8">
										<div class = "collapse" id = "quotation_collapse">
											<table id = "quotation_table" class = "table table-striped">
												<thead>
													<tr>
														<td>
															Size
														</td>
														<td>
															Amount
														</td>
													</tr>
												</thead>
												<tbody>

												</tbody>
											</table>
										</div>
									</div>
									<span class = "col-md-8" id = "quotation_rate"></span>
								</div>
							</div>
						</div>
					</div>
					<div class = "col-md-6">
						<div class = "panel-default panel">
							<div class = "panel-heading">
								Delivery Fee
							</div>
							<div class = "panel-body">
								<br />
								<div class="form-group">
									<label class="control-label col-sm-3" for="contactNumber">Amount:</label>
									<div class="col-sm-8">
										<div class="input-group ">
											<span class="input-group-addon" id="cdsfeeadd">Php</span>
											<input  value = "0.00" type="text" class=" form-control money" name = "deliveryFee" id = "deliveryFee" style="text-align: right;">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class = "row">
					<div class = "col-md-6">
						<div class = "panel panel-default">
							<div class = "panel-heading">
								Vehicle Assignment
							</div>
							<div class = "panel-body">
								<div class="form-group">
									<label class="control-label col-sm-3" for="vehicle_type">Vehicle Type: </label>
									<div class="col-sm-8">
										<select class="form-control" id = "vehicle_type">
											<option value = "0"></option>
											@forelse($vehicle_types as $vehicle_type)
											<option value = "{{ $vehicle_type->id }}">{{ $vehicle_type->name  }}</option>
											@empty
											@endforelse
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" for="vehicle">Vehicle:  </label>
									<div class="col-sm-8">
										<select class="form-control" id = "vehicle">
											<option value="0"></option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class = "col-md-6">
						<div class = "panel-default panel">
							<div class = "panel-heading">
								Driver Assignment
							</div>
							<div class = "panel-body">
								<div class="form-group required">
									<label class="control-label col-sm-3" for="contactNumber">Driver:</label>
									<div class="col-sm-8">
										<select class="form-control" id = "driver">
											<option value = "0"></option>
											@forelse($employees as $employee)
											<option value = "{{ $employee->id }}">{{ $employee->firstName . " " . $employee->lastName }}</option>
											@empty
											@endforelse
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" for="contactNumber">Helper:</label>
									<div class="col-sm-8">
										<select class="form-control" id = "helper">
											<option></option>
											@forelse($employees as $employee)
											<option value = "{{ $employee->id }}">{{ $employee->firstName . " " . $employee->lastName }}</option>
											@empty
											@endforelse
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>

		</div>
		<div class="panel-footer">
			<button class="btn btn-md btn-primary save-delivery" style="width: 100%;">Save</button>
		</div>
	</div>

	<section class="content">
		<div class="modal fade" id="chModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">New Location</h4>
					</div>
					<div class="modal-body">
						<form id="loc_form" class = "form-horizontal">
							{{ csrf_field() }}
							<div class="form-group required">
								<label class = "control-label col-md-3">Name: </label>
								<div class = "col-md-9">
									<input type = "text" class = "form-control" name = "name" id = "name" minlength = "3" required />
								</div>
							</div>
							<div class="form-group required">
								<label class = "control-label col-md-3">Address: </label>
								<div class = "col-md-9">
									<textarea class = "form-control" id = "address" name = "address" required></textarea>
								</div>
							</div>
							<div class="form-group required">
								<label class = "control-label col-md-3">Province: </label>
								<div class = "col-md-9">
									<select name = "loc_province" id="loc_province" class = "form-control">
										<option value = '0'></option>
										@forelse($provinces as $province)
										<option value="{{ $province->id }}" >
											{{ $province->name }}
										</option>
										@empty

										@endforelse
									</select>
								</div>
							</div>
							<div class="form-group required">
								<label class = "control-label col-md-3">City: </label>
								<div class = "col-md-9">
									<select name = "loc_city" id="loc_city" class = "form-control" required>
										<option></option>
									</select>
								</div>
							</div>
							<div class="form-group required">
								<label class = "control-label col-md-3">ZIP: </label>
								<div class = "col-md-9">
									<input type = "text" class = "form-control" name = "zip" id = "zip" minlength = "3" required />
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type = "button" class="btn btn-success btnSave" >Save</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="confirm-create" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Delivery
			</div>
			<div class="modal-body">
				Save Delivery
			</div>
			<div class="modal-footer">

				<button class = "btn btn-success" id = "confirm-save" >Confirm</button>
				<button class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<link rel="stylesheet" type="text/css" href="/js/jqueryDateTimePicker/jquery.datetimepicker.css">
<style>
.delivery
{
	border-left: 10px solid #8ddfcc;
	background-color:rgba(128,128,128,0.1);
	color: #fff;
}
</style>
@endpush
@push('scripts')
<script type="text/javascript" src = "/js/jqueryDateTimePicker/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#collapse1").addClass('in');
		var json;
		var results;
		var detail_object = [];
		var con_Number = [];
		var con_Volume = [];
		var con_ShippingLine = [];
		var con_PortOfCfsLocation = [];
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

		var container_copy = "<div class='panel-group'>" + $('#container_copy').html() + "</div>";
		var container_ctr = 1;
		var container_array = [0];
		var selected_container = 0;
		var selected_location = 0;

		var selected_from = 0;
		var selected_to = 0;

		//containerNumber
		Inputmask("A{3} A{1} 9{6} 9{1}").mask($("input[name=containerNumber]"));

		$('#loc_form').validate({

			rules: 
			{
				name:
				{
					required: true,
					minlength: 3,
					maxlength: 50,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},	

				},
				address:
				{
					required: true,
					minlength: 3,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},	

				},
				zip:
				{
					required: true,
					minlength: 4,
					maxlength: 4,
				},
				loc_city:
				{
					required:true,
				},

			},onkeyup: function(element) {$(element).valid()}, 

		});


		$(document).on('keyup keydown keypress', '#deliveryFee', function (event) {
			var len = $('#deliveryFee').val();
			var value = $('#deliveryFee').inputmask('unmaskedvalue');
			if (event.keyCode == 8) {
				if(parseFloat(value) == 0 || value == ""){
					$('#deliveryFee').val("0.00");
				}
			}
			else
			{
				if(value == ""){
					$('#deliveryFee').val("0.00");
				}
				if(parseFloat(value) <= 9999999999999999.99){
					
				}
				else{
					if(event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 116){

					}
					else{
						return false;
					}
				}
			}
			if(event.keyCode == 189)
			{
				return false;
			}			
		});

		$.datetimepicker.setLocale('en');
		$('#pickdatecon').datetimepicker({
			mask:'9999/19/39',
			dayOfWeekStart : 1,
			lang:'en',
			step: 5,
			format:'Y/m/d H:i',
			formatDate:'Y/m/d H:i',
			value: "{{ Carbon\Carbon::now('Asia/Hong_Kong')->format('Y/m/d H:i') }}",
			startDate:	"{{ Carbon\Carbon::now('Asia/Hong_Kong')->format('Y/m/d H:i') }}",
		});

		$('#deldatecon').datetimepicker({
			mask:'9999/19/39',
			dayOfWeekStart : 1,
			lang:'en',
			step: 5,
			format:'Y/m/d H:i',
			formatDate:'Y/m/d H:i',
			value: "{{ Carbon\Carbon::now('Asia/Hong_Kong')->addDays(1)->format('Y/m/d H:i') }}",
			startDate:	"{{ Carbon\Carbon::now('Asia/Hong_Kong')->addDays(1)->format('Y/m/d H:i') }}",
		});

		$('.containerReturnDate').datetimepicker({
			mask:'9999/19/39',
			dayOfWeekStart : 1,
			timepicker: false,
			lang:'en',
			format:'Y/m/d',
			formatDate:'Y/m/d',
			value: "{{ Carbon\Carbon::now()->format('Y/m/d') }}",
			startDate:	"{{ Carbon\Carbon::now()->format('Y/m/d') }}",
		});


		// Trucking
		$(document).on('click', '.edit-trucking-information', function(e){
			$('#_destination').val($('#tr_destination').text().trim());
			$('#_shippingLine').val($('#tr_shippingLine').text().trim());
			$('#_portOfCfsLocation').val($('#tr_portOfCfsLocation').text().trim());
			$('#_status').val($('#tr_status').text().trim());

		})

		$(document).on('click', '.btnSave', function(e){
			e.preventDefault();
			$('.btnSave').removeAttr('disabled');
			$('#zip').valid();
			$('#name').valid();
			$('#address').valid();
			$('#loc_city').valid();

			if($('#zip').valid() && $('#name').valid() && $('#address').valid() && $('#loc_city').valid()){
				$('.btnSave').attr('disabled', 'true');
				$.ajax({
					type: 'POST',
					url: "{{ route('location.index')}}",
					data: {
						'_token' : $('input[name=_token]').val(),
						'name' : $('#name').val(),
						'address' : $('#address').val(),
						'cities_id' : $('#loc_city').val(),
						'zipCode' : $('#zip').val(),
					},
					success: function(data){
						if(typeof(data) == "object"){
							if(selected_location == 0){
								$('#pickup_id > option:last').after("<option value = " + data.id +">"+ data.name +"</option>");
								$('#deliver_id > option:last').after("<option value = " + data.id +">"+ data.name +"</option>");
								$('#pickup_id').val(data.id);

								$('#_address').val($('#address').val());
								$('#_city').val($('#loc_city option:selected').text());
								$('#_province').val($('#loc_province option:selected').text().trim());
								$('#_zip').val($('#zip').val());

								$('#address').val("");
								$('#loc_city').val("0");
								$('#loc_province').val("0");
								$('#zip').val("");
								$('#chModal').modal('hide');
							}
							else{
								$('#pickup_id > option:last').after("<option value = " + data.id +">"+ data.name +"</option>");
								$('#deliver_id > option:last').after("<option value = " + data.id +">"+ data.name +"</option>");
								$('#deliver_id').val(data.id);
								$('#_daddress').val($('#address').val());
								$('#_dcity').val($('#loc_city option:selected').text());
								$('#_dprovince').val($('#loc_province option:selected').text().trim());
								$('#_dzip').val($('#zip').val());

								$('#address').val("");
								$('#loc_city').val("0");
								$('#loc_province').val("0");
								$('#zip').val("");
								$('#chModal').modal('hide');
								$('.btnSave').removeAttr('disabled');
							}
						}
						else{
							resetErrors();
							var invdata = JSON.parse(data);
							$.each(invdata, function(i, v) {
								console.log(i + " => " + v);
								var msg = '<label class="error" for="'+i+'">'+v+'</label>';
								$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);


							});
							$('.btnSave').removeAttr('disabled');
						}

					},
					error: function(data) {
						if(data.status == 400){
							alert("Nothing found");
						}
					}
				})
			}
			else{
				$('.btnSave').removeAttr('disabled');
			}
		})

		function clear_location(){
			$('#address').val("");
			$('#loc_city').val("0");
			$('#loc_province').val("0");
			$('#zip').val("");
		}

		$(document).on('click', '.pick_add_new_location', function(e){
			e.preventDefault();
			$('.btnSave').removeAttr('disabled');
			$('#chModal').modal('show');
			selected_location = 0;
		})

		$(document).on('click', '.del_add_new_location', function(e){
			e.preventDefault();
			$('.btnSave').removeAttr('disabled');
			$('#chModal').modal('show');
			selected_location = 1;
		})

		$(document).on('change', '#loc_province', function(e){
			fill_cities(0);
		})

		$(document).on('change', '#driver', function(e)
		{
			e.preventDefault();
			if($(this).val() == 0 || $(this).val() == $('#helper').val())
			{
				$(this).css('border-color', 'red');
				$('#helper').css('border-color', 'red');
			}
			else
			{
				$(this).css('border-color', 'green');
				$('#helper').css('border-color', 'green');
			}
		})
		$(document).on('change', '#helper', function(e)
		{
			e.preventDefault();
			if($(this).val() == $('#driver').val())
			{
				$(this).css('border-color', 'red');
				$('#driver').css('border-color', 'red');
			}
			else
			{
				$(this).css('border-color', 'green');
			}
			if($(this).val() == "")
			{
				$(this).css('border-color', 'green');
				$('#driver').css('border-color', 'green');
			}
		})

		function fill_cities(num)
		{
			console.log(num);
			$.ajax({
				type: 'GET',
				url: "{{ route('get_prov_cities')}}/" + $('#loc_province').val(),
				data: {
					'_token' : $('input[name=_token]').val(),
				},
				success: function(data){
					if(typeof(data) == "object"){

						var new_rows = "<option></option>";
						for(var i = 0; i < data.length; i++){
							new_rows += "<option value = '"+ data[i].id+"'>"+ data[i].name +"</option>";
						}
						$('#loc_city').find('option').not(':first').remove();
						$('#loc_city').html(new_rows);

						$('#loc_city').val(num);
					}
				},
				error: function(data) {
					if(data.status == 400){
						alert("Nothing found");
					}
				}
			})
		}


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
		$(document).on('click', '.save-delivery-information', function(e){
			$.ajax({
				type: 'PUT',
				url: '{{ route("trucking.store") }}/{{ $so_id }}/update_delivery',
				data: {
					'_token' : $('input[name=_token]').val(),
					'status' : $('#deliveryStatus').val(),
					'delivery_head_id' : delivery_id,

				},
				success: function(data){
					location.reload();
				}
			})
		})
		// Container
		$(document).on('click', '.add-new-container', function(e){
			e.preventDefault();
			new_container = container_copy.replace('0_', container_ctr + "_");
			new_container = new_container.replace('0_', container_ctr + "_");
			new_container = new_container.replace('0_', container_ctr + "_");
			new_container = new_container.replace('0_', container_ctr + "_");
			new_container = new_container.replace('0_', container_ctr + "_");
			new_container = new_container.replace('0_', container_ctr + "_");
			new_container = new_container.replace('0_', container_ctr + "_");
			new_container = new_container.replace('0_', container_ctr + "_");
			new_container = new_container.replace('0_', container_ctr + "_");
			new_container = new_container.replace('0_', container_ctr + "_");
			container_array.push(container_ctr);
			container_ctr++;
			$('#container_copy:last-child').append(new_container);
			$('.containerReturnDate:last').each(function(i){
				$(this).datetimepicker({
					mask:'9999/19/39',
					dayOfWeekStart : 1,
					timepicker: false,
					lang:'en',
					format:'Y/m/d',
					formatDate:'Y/m/d',
					value: "{{ Carbon\Carbon::now()->format('Y/m/d') }}",
					startDate:	"{{ Carbon\Carbon::now()->format('Y/m/d') }}",
				});
			})
			Inputmask("A{3} A{1} 9{6} 9{1}").mask($("input[name=containerNumber]"));
			
		})
		$(document).on('click', '.remove-container-row', function(e){
			e.preventDefault();
			var id = $(this).val();
			for(var i = 0; i < container_array.length; i ++){
				if(container_array[i] == id[0])
				{
					container_array.splice(i, 1);
				}
			}
			console.log(container_array);
			$('#' + $(this).val()).remove();

		})
		$(document).on('click', '.save-container-row', function(e){
			e.preventDefault();
			var id = $(this).closest("tr").find('.row_containerNumber').val() + '_table';
			if($('#' + id).length === 0){
				$('#cargo_delivery_details').append('<table class = "table-responsive table" id = "' + $(this).closest("tr").find('.row_containerNumber').val() + '_table"><thead><tr><td>Container Number: '+ $(this).closest("tr").find('.row_containerNumber').val() +'</tr></td><tr><td>Description of Goods</td><td>Gross Weight(kg)</td><td>Supplier/s</td><td>Action</td></tr></thead><tbody><tr id = "description_row"><td width="35%"><input type = "text" name = "'+ id +'_descriptionOfGoods" class = "form-control"/></td><td width="20%"><input type = "number" name = "'+ id +'_grossWeight" class = "form-control"/></td><td width="30%"><input type = "text" name = "'+ id +'_supplier"  class = "form-control" /></td><td width="15%"><button class = "btn btn-md btn-primary add-container-detail" value = "'+  id + '">+</button><button class = "btn btn-md btn-danger remove-container-detail" value = "' + id +'">x</button></td></tr></tbody></table>');
			}
		})

		$(document).on('click', '.new-container-detail', function(e){
			e.preventDefault();
			var id = $(this).val();
			selected_container = id[0];
			if(validateCurrentContainerDetail() == true){

				console.log(id);
				var detail_row = '<tr id = "description_row"><td width="35%"><input type = "text" name =   "'+ id[0] + '_descriptionOfGoods" class = "form-control"/></td><td width="20%"><input type = "text" name = "'+ id[0] +'_grossWeight" class = "form-control money"/></td><td width="30%"><input type = "text" name = "'+id[0] +'_supplier" class = "form-control" /></td><td width="15%" style = "text-align: center;"><button class = "btn btn-md btn-danger remove-container-detail" value = "'+ $(this).val() + '">x</button></td></tr>';
				$('#'+ id[0] + '_details' + ":last-child").append(detail_row);

				$('.money').each(function(i)
				{
					$(this).inputmask("numeric",
					{
						radixPoint: ".",
						groupSeparator: ",",
						digits: 2,
						autoGroup: true,
						rightAlign: true,
						removeMaskOnSubmit:true,
					});
				})
			}

		})
		$(document).on('click', '.remove-container-detail', function(e){
			e.preventDefault();
			$(this).closest('tr').remove();
		})
		// Without Container ------------------------------------------------------------------------------------------------------------------------
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
				$('#wodetail_table:last').append(wodetail_row);
				$('.money').each(function(i)
				{
					$(this).inputmask("numeric",
					{
						radixPoint: ".",
						groupSeparator: ",",
						digits: 2,
						autoGroup: true,
						rightAlign: true,
						removeMaskOnSubmit:true,
					});
				})
			}
		})
		$(document).on('click', '.woremove-current-detail', function(e){
			e.preventDefault();
			if($('#wodetail_table > tbody > tr').length > 1){
				$(this).closest('tr').remove();
			}
		})
		$(document).on('change', '#vehicle', function(e){
			e.preventDefault();
			if($(this).val() == 0)
			{
				$(this).css('border-color', 'red');
			}
			else
			{
				$(this).css('border-color', 'green');
			}
		})
		$(document).on('change', '#vehicle_type', function(e){
			vehicle_type_id = $(this).val();
			if(vehicle_type_id != 0)
			{
				$(this).css('border-color', 'green');
				$.ajax({
					type: 'GET',
					url: '{{ route("trucking.index") }}/0/' + vehicle_type_id +'/getVehicles',
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
			}
			else
			{
				$(this).css('border-color', 'red');
			}
			
		})
		$(document).on('click', '.save-delivery', function(e){
			e.preventDefault();

			if($("#choices li.active").text() === "Without Container"){
				if(validateDetail() === true){
					if(validateOrder() == true){

						$('#confirm-create').modal('show');
					}
				}
			}
			else{
				if(validateContainer() == true){
					if(validateOrder() == true){

						validateContainerDetail();
						$('#confirm-create').modal('show');
					}
				}
			}

		})
		$(document).on('click', '#confirm-save', function(e){
			if($("#choices li.active").text() === "Without Container"){
				if(validateDetail() === true){
					if(validateOrder() == true){
						$('#confirm-save').attr('disabled', 'true');
						$.ajax({
							type: 'POST',
							url: '{{route("trucking.index")}}/{{ $so_id }}/store_delivery',
							data: {
								'_token' : $('input[name=_token]').val(),
								'plateNumber' : $('#vehicle').val(),
								'descrp_goods' : descrp_goods,
								'gross_weights' : gross_weights,
								'suppliers' : suppliers,
								'emp_id_driver' : $('#driver').val(),
								'emp_id_helper' : $('#helper').val(),
								'locations_id_pick' : $('#pickup_id').val(),
								'locations_id_del' : $('#deliver_id').val(),
								'deliveryDate' : $('#deldatecon').val(),
								'pickupDate' : $('#pickdatecon').val(),
								'amount' : $('#deliveryFee').inputmask('unmaskedvalue'),
							},
							success: function(data){
								window.location.href = "{{ route('trucking.index')}}/{{ $so_id }}/view";
							}
						})
					}
				}
			}
			else{
				if(validateContainer() == true){
					if(validateOrder() == true){
						validateContainerDetail();
						$('#confirm-save').attr('disabled', 'true');
						$.ajax({
							type: 'POST',
							url: '{{ route("trucking.store") }}/{{ $so_id }}/store_delivery',
							data: {
								'_token' : $('input[name=_token]').val(),
								'plateNumber' : $('#vehicle').val(),
								'emp_id_driver' : $('#driver').val(),
								'emp_id_helper' : $('#helper').val(),
								'locations_id_pick' : $('#pickup_id').val(),
								'locations_id_del' : $('#deliver_id').val(),
								'deliveryDate' : $('#deldatecon').val(),
								'pickupDate' : $('#pickdatecon').val(),
								'containerNumber' : con_Number,
								'containerVolume' : con_Volume,
								'containerReturnTo' : con_ReturnTo,
								'containerReturnAddress' : con_ReturnAddress,
								'containerReturnDate' : con_ReturnDate,
								'shippingLine' : con_ShippingLine,
								'portOfCfsLocation' : con_PortOfCfsLocation,
								'amount' : $('#deliveryFee').inputmask('unmaskedvalue'),
								'container_data' : results,
							},
							success: function(data){
								window.location.href = "{{ route('trucking.index')}}/{{ $so_id }}/view";
							}
						})
					}
				}
			}
		})

		$(document).on('change', '#pickup_id', function(e){
			pickup_id = $(this).val();
			selected_from = $(this).val();
			if(pickup_id != 0)
			{
				if($(this).val() == $('#deliver_id').val())
				{
					$(this).css('border-color', 'red');
					$('#deliver_id').css('border-color', 'red');
				}
				else
				{
					$(this).css('border-color', 'green');
					$('#deliver_id').css('border-color', 'green');
					if($('#deliver_id').val() == 0)
					{
						$('#deliver_id').css('border-color', 'red');
					}
				}
				$.ajax({
					type: 'GET',
					url: '{{ route("location.index") }}/' + pickup_id + '/getLocation',
					data: {
						'_token' : $('input[name=_token]').val(),
					},
					success: function(data){

						if(typeof(data) == "object"){
							$('#_address').val(data[0].address);
							$('#_city').val(data[0].city_name);
							$('#_province').val(data[0].province_name);
							$('#_zip').val(data[0].zipCode);
						}
					},
					error: function(data) {
						if(data.status == 400){
							alert("Nothing found");
						}
					}
				})
			}
			else{
				$('#_address').val("");
				$('#_city').val("");
				$('#_province').val("");
				$('#_zip').val("");

				$(this).css('border-color', 'red');
			}

			if(selected_from != 0 && selected_to != 0){
				$('#rate_header').html("Rate/s for <strong>" + $('#pickup_id option:selected').text() + "</strong> to <strong>" + $('#deliver_id option:selected').text());
				$.ajax({
					type: 'GET',
					url: '{{ route("get_area_rate") }}',
					data: {
						'area_from' : selected_from,
						'area_to' : selected_to,
						'consignee_id' : {{ $consignee[0]->id }}
					},
					success : function(data) {
						if(data[1].length == 0){
							$('#standard_rate').html('No set standard rate.');
							$('#deliveryFee').val("0.00");
						}
						else{
							$('#standard_rate').html("Php " + data[1][0].amount);
							$('#deliveryFee').val(data[1][0].amount);
						}
						if(data[0].length == 0){
							$('#quotation_rate').html('No existing quotation rates');
							$('#deliveryFee').val("0.00");
							$('#quotation_collapse').removeClass('in');
						}
						else
						{
							var quotation_rows = "";
							for(var i = 0; i < data[0].length; i++)
							{
								console.log(data[0][i].from);
								quotation_rows += "<tr><td>" + data[0][i].volume + "</td><td>Php " + data[0][i].amount + "</td></tr>";
							}
							console.log(quotation_rows);
							$('#quotation_collapse').addClass('in');
							$('#quotation_table > tbody').html(quotation_rows);
						}
					}
				})
			}

			if(selected_from == 0 || selected_to == 0)
			{
				$('#deliveryFee').val("0.00");
				$('#standard_rate').html("");
			};


		})

		$(document).on('change', '#deliver_id', function(e){
			deliver_id = $(this).val();
			selected_to = $(this).val();
			if(deliver_id != 0)
			{
				if($(this).val() == $('#pickup_id').val())
				{
					$(this).css('border-color', 'red');
					$('#pickup_id').css('border-color', 'red');
				}
				else
				{
					$(this).css('border-color', 'green');
					$('#pickup_id').css('border-color', 'green');
					if($('#pickup_id').val() == 0)
					{
						$('#pickup_id').css('border-color', 'red');
					}
				}

				if($('#deliver_id').val() != $('#pickup_id').val())
				{
					$.ajax({
						type: 'GET',
						url: '{{ route("location.index") }}/' + deliver_id + '/getLocation',
						data: {
							'_token' : $('input[name=_token]').val(),
						},
						success: function(data){

							if(typeof(data) == "object"){
								$('#_daddress').val(data[0].address);
								$('#_dcity').val(data[0].city_name);
								$('#_dprovince').val(data[0].province_name);
								$('#_dzip').val(data[0].zipCode);
							}
						},
						error: function(data) {
							if(data.status == 400){
								alert("Nothing found");
							}
						}
					})
				}
				else
				{
					$('#deliver_id').css('border-color', 'red');
				}

			}
			else{
				$('#_daddress').val("");
				$('#_dcity').val("");
				$('#_dprovince').val("");
				$('#_dzip').val("");
				$(this).css('border-color', 'red');
			}
			if(selected_from != 0 && selected_to != 0){
				$('#rate_header').html("Rate/s for <strong>" + $('#pickup_id option:selected').text() + "</strong> to <strong>" + $('#deliver_id option:selected').text());
				$.ajax({
					type: 'GET',
					url: '{{ route("get_area_rate") }}',
					data: {
						'area_from' : selected_from,
						'area_to' : selected_to,
						'consignee_id' : {{ $consignee[0]->id }}
					},
					success : function(data) {
						if(data[1].length == 0){
							$('#standard_rate').html('No set standard rate.');
							$('#deliveryFee').val("0.00");
						}
						else{
							$('#standard_rate').html("Php " + data[1][0].amount);
							$('#deliveryFee').val(data[1][0].amount);
						}
						if(data[0].length == 0){
							$('#quotation_rate').html('No existing quotation rates');
							$('#deliveryFee').val("0.00");
							$('#quotation_collapse').removeClass('in');
						}
						else
						{
							var quotation_rows = "";
							for(var i = 0; i < data[0].length; i++)
							{
								console.log(data[0][i].from);
								quotation_rows += "<tr><td>" + data[0][i].volume + "</td><td>Php " + data[0][i].amount + "</td></tr>";
							}
							console.log(quotation_rows);
							$('#quotation_collapse').addClass('in');
							$('#quotation_table > tbody').html(quotation_rows);
						}
					}
				})
			}
			if(selected_from == 0 || selected_to == 0)
			{
				$('#deliveryFee').val("0.00");
				$('#standard_rate').html("");
				$('#quotation_rate').html("");
			};

		})


		function validateCurrentContainerDetail()
		{
			error = "";
			con_descrp = document.getElementsByName(selected_container + '_descriptionOfGoods');
			con_gw = document.getElementsByName(selected_container + '_grossWeight');
			con_supp = document.getElementsByName(selected_container + '_supplier');
			for (var j = 0; j < con_descrp.length; j++) {
				if(con_descrp[j].value === "")
				{
					con_descrp[j].style.borderColor = "red";
					error += "Description is required";
				}
				else
				{
					con_descrp[j].style.borderColor = 'green';
				}
				if(con_gw[j].value === "" || $(con_gw[j]).inputmask('unmaskedvalue') < 0)
				{
					error+= "Weight is required";
					con_gw[j].style.borderColor = 'red';
				}
				else
				{
					con_gw[j].style.borderColor = 'green';
				}
			}
			if(error.length == 0){
				return true;
			}
			else
			{
				return false;
			}

		}
		function validateContainerDetail(){
			error = "";
			json = [];
			var linkData;
			for (var i = 0; i < container_array.length; i++) {
				var child = [{ }];
				child[0]['container'] = [{
					containerNumber : con_Number[i],
					containerVolume : con_Volume[i],
					shippingLine : con_ShippingLine[i],
					portOfCfsLocation : con_PortOfCfsLocation[i],
					containerReturnTo : con_ReturnTo[i],
					containerReturnAddress : con_ReturnAddress[i],
					containerReturnDate : con_ReturnDate[i]
				}];
				child[0]['details'] = [];
				table_detail_row_count = $('#' + container_array[i] + "_details > tbody > tr").length;

				var name = container_array[i];


				con_descrp = document.getElementsByName(name + '_descriptionOfGoods');
				con_gw = document.getElementsByName(name + '_grossWeight');
				con_supp = document.getElementsByName(name + '_supplier');
				for (var j = 0; j < table_detail_row_count; j++) {
					if(con_descrp[j].value === "")
					{
						con_descrp[j].style.borderColor = "red";
						error += "Description is required";
					}
					else
					{
						con_descrp[j].style.borderColor = 'green';
					}
					if(con_gw[j].value === "" || $(con_gw[j]).inputmask('unmaskedvalue') < 0)
					{
						error+= "Weight is required";
						con_gw[j].style.borderColor = 'red';
					}
					else
					{
						con_gw[j].style.borderColor = 'green';
					}
					child[0].details.push({
						descriptionOfGood : con_descrp[j].value,
						grossWeight : $(con_gw[j]).inputmask('unmaskedvalue'),
						supplier : con_supp[j].value
					});
				}
				json.push(child);
			}
			results = JSON.stringify(json);
			console.log(results);

			if(error.length == 0){
				return 0;
			}
			else
			{
				console.log(error);
				return false;
			}


		}
		function validateOrder(){
			var error = "";
			if($('#deliveryFee').val() == "" || $('#deliveryFee').inputmask('unmaskedvalue') < 0)
			{
				$('#deliveryFee').css('border-color', 'red');
			}
			else
			{
				$('#deliveryFee').css('border-color', 'green');
			}
			if($('#deldatecon').val() === ""){
				$('#deldatecon').css("border-color", 'red');
				error += "Delivery Date";
			}
			else{
				$('#deldatecon').css("border-color", 'green');
			}
			if($('#pickdatecon').val() === ""){
				$('#pickdatecon').css("border-color", 'red');
				error += "Pickup Date";
			}
			else{
				$('#pickdatecon').css("border-color", 'green');
			}
			if($('#deldatecon').val() <= $('#pickdatecon').val()){
				$('#deldatecon').css('border-color', 'red');
				$('#pickdatecon').css('border-color', 'red');
				error+= "Invalid date";
			}
			else{
				$('#deldatecon').css('border-color', 'green');
				$('#pickdatecon').css('border-color', 'green');
			}
			
			if($('#vehicle_type').val() == "0"){
				$('#vehicle_type').css("border-color", 'red');
				error += "Delivery Date";
			}
			else{
				$('#vehicle_type').css("border-color", 'green');
			}
			if($('#vehicle').val() == "0"){
				$('#vehicle').css("border-color", 'red');
				error += "Delivery Date";
			}
			else{
				$('#vehicle').css("border-color", 'green');
			}
			if($('#driver').val() == "0"){
				$('#driver').css("border-color", 'red');
				error += "No driver";
			}
			else{
				$('#driver').css("border-color", 'green');
			}
			if($('#helper').val() === $('#driver').val()){
				$('#helper').css('border-color', 'red');
				error += "Cannot be driver and helper";
			}
			else{
				$('#helper').css('border-color', 'green');
			}
			if($('#pickup_id').val() == "0"){
				$('#pickup_id').css('border-color', 'red');
				error += "No pickup location";
			}
			else{
				$('#pickup_id').css('border-color', 'green');
			}
			if($('#deliver_id').val() == "0"){
				$('#deliver_id').css('border-color', 'red');
				error += "No delivery location";
			}
			else{
				$('#deliver_id').css('border-color', 'green');
			}
			if($('#deliver_id').val() === $('#pickup_id').val()){
				$('#deliver_id').css('border-color', 'red');
				$('#pickup_id').css('border-color', 'red');
				error += "Same pickup and delivery point";
			}
			else{
				$('#deliver_id').css('border-color', 'green');
				$('#pickup_id').css('border-color', 'green');
			}

			if(error.length == 0){
				return true;
			}
			else
			{
				console.log(error);
				return false;
			}

		}
		function validateContainer(){
			con_Number = [];
			con_Volume = [];
			con_ReturnTo = [];
			con_ReturnAddress = [];
			con_ReturnDate = [];
			con_ShippingLine = [];
			con_PortOfCfsLocation = [];
			var error = "";
			con_number = document.getElementsByName("containerNumber");
			con_volume = document.getElementsByName("containerVolume");
			con_to = document.getElementsByName("containerReturnTo");
			con_address = document.getElementsByName("containerReturnAddress");
			con_date = document.getElementsByName("containerReturnDate");
			con_ship = document.getElementsByName('shippingLine');
			con_port = document.getElementsByName('portOfCfsLocation');
			for(var i = 0; i < con_number.length; i++)
			{
				if(con_number[i].value === ""){
					error += "Container number is required.";
					con_number[i].style.borderColor = 'red';
				}
				else{
					con_Number.push(con_number[i].value);
					con_number[i].style.borderColor = 'green';
				}
				if(con_volume[i].value === ""){
					error += "Container volume is required.";
					con_volume[i].style.borderColor = 'red';
				}
				else{
					con_Volume.push(con_volume[i].options[con_volume[i].selectedIndex].text);
					con_volume[i].style.borderColor = 'green';
				}
				if(con_to[i].value === ""){
					error += "Container return to is required.";
					con_to[i].style.borderColor = 'red';
				}
				else{
					con_ReturnTo.push(con_to[i].value);
					con_to[i].style.borderColor = 'green';
				}
				if(con_address[i].value === ""){
					error += "Container return address is required.";
					con_address[i].style.borderColor = 'red';
				}
				else{
					con_ReturnAddress.push(con_address[i].value);
					con_address[i].style.borderColor = 'green';
				}
				if(con_date[i].value === ""){
					error += "Container return date is required.";
					con_date[i].style.borderColor = 'red';
				}
				else{
					con_ReturnDate.push(con_date[i].value);
					con_date[i].style.borderColor = 'green';
				}
				if(con_port[i].value === ""){
					error += "Container port is required.";
					con_port[i].style.borderColor = 'red';
				}
				else{
					con_PortOfCfsLocation.push(con_port[i].value);
					con_port[i].style.borderColor = 'green';
				}
				if(con_ship[i].value === ""){
					error += "Container ship is required.";
					con_ship[i].style.borderColor = 'red';
				}
				else
				{
					con_ShippingLine.push(con_ship[i].value);
					con_ship[i].style.borderColor = 'green';
				}

			}
			console.log(error);
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
			if($("#choices li.active").text() === "Without Container"){
				descrp = document.getElementsByName("wodescriptionOfGoods");
				gw = document.getElementsByName("wogrossWeight");
				supp = document.getElementsByName("wosupplier");
			}
			for(var i = 0; i < descrp.length; i++){
				if(descrp[i].value === ""){
					error += "No description";
					descrp[i].style.borderColor = 'red';
				}
				else{
					descrp_goods.push(descrp[i].value);
					descrp[i].style.borderColor = 'green';
				}
				if(gw[i].value === "" || $(gw[i]).inputmask('unmaskedvalue') < 0 ){
					error += "No gross weight";
					gw[i].style.borderColor = 'red';
				}
				else{
					gross_weights.push($(gw[i]).inputmask('unmaskedvalue'));
					gw[i].style.borderColor = 'green';
				}
				if(supp[i].value === ""){
					suppliers.push("");
				}
				else{
					suppliers.push(supp[i].value);
				}
			}
			if(error.length === 0){

				return true;
			}
			else{
				return false;
			}
		}

	})
function resetErrors() {
	$('form input, form select').removeClass('inputTxtError');
	$('label.error').remove();
}

</script>
@endpush
