@extends('layouts.app')
@section('content')
<div class = "col-md-12">
	<div class="panel" id="myModal">
		<div class="panel-header">
			<h3>Update Delivery</h3>
			<hr />
		</div>
		<div class="panel-body">
			<div class = "col-md-12">
				<div class = "col-md-12">
					<div class="tab-content">
						@if($delivery[0]->withContainer == 1)
						<div class = "panel">
							<div class = "">
								<form class="form-horizontal" role="form">
									{{ csrf_field() }}
									<div class="row">
										<h4>&nbsp;Container Information</h4>
										<div id = "containers">
											<div class="panel-group" id = "container_copy">
												@php
												$ctr = 0;
												@endphp

												@forelse($container_with_detail as $container)

												
												<div class="panel panel-default" id = "{{ $ctr }}_panel">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a data-toggle="collapse" href="#{{ $ctr }}_container ">Container</a>
															<div class="pull-right">
																<button class="btn btn-xs btn-info" data-toggle = "collapse" href="#{{ $ctr }}_container">_</button>
																<button class="remove-container-row btn btn-xs btn-danger" value = "{{ $ctr }}_panel">&times;</button>
															</div>
														</h4>
													</div>
													<div id="{{ $ctr }}_container" class="panel-collapse collapse in">
														<div class="panel-body">
															<div class = "row">
																<div class = "col-md-6">
																	<div class = "form-horizontal">
																		<div class="form-group required">
																			<label class="control-label col-sm-4" for="contactNumber">Container Number:</label>
																			<div class="col-sm-8">
																				<input type = "text" name = "containerNumber" id = "containerNumber" class = "form-control row_containerNumber" value = "{{ $container['container']->containerNumber }}"/>
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
																				<input type = "text" name = "shippingLine" id = "shippingLine " class = "form-control row_containerReturnDate" value = "{{ $container['container']->shippingLine }}"/>
																			</div>
																		</div>
																	</div>
																	<div class = "form-horizontal">
																		<div class="form-group required">
																			<label class="control-label col-sm-4" for="contactNumber">Port of Cfs Location:</label>
																			<div class="col-sm-8">
																				<input type = "text" name = "portOfCfsLocation" id = "portOfCfsLocation " class = "form-control row_containerReturnDate" value = "{{ $container['container']->portOfCfsLocation }}"/>
																			</div>
																		</div>
																	</div>
																</div>
																<div class = "col-md-6">
																	<div class = "form-horizontal">
																		<div class="form-group required">
																			<label class="control-label col-sm-4" for="contactNumber">Return Date:</label>
																			<div class="col-sm-8">
																				<input type = "date" name = "containerReturnDate" id = "containerReturnDate " class = "form-control row_containerReturnDate" value = "{{ Carbon\Carbon::parse($container['container']->containerReturnDate)->format('Y-m-d') }}"/>
																			</div>
																		</div>
																	</div>
																	<div class = "form-horizontal">
																		<div class="form-group required">
																			<label class="control-label col-sm-4" for="contactNumber">Return To:</label>
																			<div class="col-sm-8">
																				<input type = "text" name = "containerReturnTo" id = "containerReturnTo" class = "form-control row_containerReturnTo" value = "{{ $container['container']->containerReturnTo }}"/>
																			</div>
																		</div>
																	</div>
																	<div class = "form-horizontal">
																		<div class="form-group required">
																			<label class="control-label col-sm-4" for="contactNumber">Return Address:</label>
																			<div class="col-sm-8">
																				<textarea name = "containerReturnAddress" id = "containerReturnAddress " class = "form-control row_containerReturnAddress">{{ $container['container']->containerReturnAddress }}</textarea>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class = "col-md-12">
																<table class="table table-responsive table-striped" id = "{{ $ctr }}_details">
																	<thead>
																		<tr>
																			<td>
																				Description of goods
																			</td>
																			<td>
																				Gross Weight(kg)
																			</td>
																			<td>
																				Supplier/s
																			</td>
																			<td>
																				Action
																			</td>
																		</tr>
																	</thead>
																	<tbody>
																		@forelse($container['details'] as $detail)
																		<tr>
																			<td width="35%">
																				<input type = "text" name = "{{ $ctr }}_descriptionOfGoods" class = "form-control" value = "{{ $detail->descriptionOfGoods }}"/>
																			</td>
																			<td width="20%">
																				<input type = "number" name = "{{ $ctr }}_grossWeight" class = "form-control" value = "{{ $detail->grossWeight }}"/>
																			</td>
																			<td width="30%">
																				<input type = "text" name = "{{ $ctr }}_supplier"  class = "form-control" value="{{ $detail->supplier }}" />
																			</td>
																			<td width="15%">
																				<button class = "btn btn-md btn-danger remove-container-detail" value = "{{ $ctr }}">
																					x
																				</button>
																			</td>
																		</tr>
																		@empty
																		@endforelse
																	</tbody>
																</table>
															</div>
															<div class="row">
																<div class ="col-md-9">

																</div>
																<div class= "col-md-3" style="text-align: center;">
																	<button class = "btn btn-primary btn-sm new-container-detail" style="width: 80%;" value = "{{ $ctr }}">New Good</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											
											@php
											$ctr = $ctr + 1;
											@endphp

											@empty

											@endforelse
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
						@else
						<div class = "panel">
							<div class = "">
								<form class="form-horizontal" role="form">
									<div class="form-group">
										<label class="control-label" for="wodetail_table">Delivery Content:</label>
										<table class = "table-responsive table table-striped" id = "wodetail_table">
											<thead>
												<tr>
													<td>
														Description of Goods
													</td>
													<td>
														Gross Weight(kg)
													</td>
													<td>
														Supplier/s
													</td>
													<td>
														Action
													</td>
												</tr>
											</thead>
											<tbody>
												@forelse($delivery_details as $delivery_detail)
												<tr id = "wodescription_row">
													<td width="35%">
														<input type = "text" name = "wodescriptionOfGoods" class = "form-control" value = "{{ $delivery_detail->descriptionOfGoods }}"/>
													</td>
													<td width="20%">
														<input type = "number" name = "wogrossWeight" class = "form-control" value="{{ $delivery_detail->grossWeight }}" />
													</td>
													<td width="30%">
														<input type = "text" name = "wosupplier"  class = "form-control" value="{{ $delivery_detail->supplier }}" />
													</td>
													<td width="15%">
														<button class = "btn btn-md btn-danger woremove-current-detail">x</button>
													</td>
												</tr>
												@empty
												@endforelse
											</tbody>
										</table>
										<div class="row">
											<div class="col-md-4">
												<button class = "btn btn-md btn-primary woadd-new-detail" style="width: 80%;">Add good</button>
											</div>
											<div class="col-md-8">

											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						@endif
					</div>
					
				</div>
			</div>
			<!-- Separator between details -->
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
										<label class="control-label" for = "deldatecon">Pickup Date:</label>
										<input type = "date" name = "pickdatecon" id = "pickdatecon" class = "form-control pickaddcon" />
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
										<label class="control-label" for = "deldatecon">Delivery Date:</label>
										<input type = "date" name = "deldatecon" id = "deldatecon" class = "form-control deladdcon" />
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
							<div class="form-group">
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
										<option value = "0"></option>
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
			</form>
		</div>
		<div class="panel-footer">
			<button class="btn btn-md btn-success save-delivery" style="width: 100%;">Save</button>
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
						<form role="form" method = "POST" id="commentForm" class = "form-horizontal">
							{{ csrf_field() }}	
							<div class="form-group required">
								<label class = "control-label col-md-3">Name: </label>
								<div class = "col-md-9">
									<input type = "text" class = "form-control" name = "name" id = "name" minlength = "3"/>
								</div>
							</div>
							<div class="form-group required">
								<label class = "control-label col-md-3">Address: </label>
								<div class = "col-md-9">
									<textarea class = "form-control" id = "address" name = "address"></textarea>
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
									<select name = "loc_city" id="loc_city" class = "form-control">
										<option value="0"></option>
									</select>
								</div>
							</div>
							<div class="form-group required">
								<label class = "control-label col-md-3">ZIP: </label>
								<div class = "col-md-9">
									<input type = "text" class = "form-control" name = "zip" id = "zip" minlength = "3"/>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type = "submit" class="btn btn-success btnSave" >Save</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>				
					</div>
				</div>
			</div>
		</div>
	</section>
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
		var wodetail_row = '<tr id = "wodescription_row"><td width="35%"><input type = "text" name = "wodescriptionOfGoods" class = "form-control"/></td><td width="20%"><input type = "number" name = "wogrossWeight" class = "form-control"/></td><td width="30%"><input type = "text" name = "wosupplier"  class = "form-control" /></td><td width="15%"><button class = "btn btn-md btn-danger woremove-current-detail">x</button></td></tr>';
		var container_row = "<tr>" + $('#container_row').html() + "</tr>";

		var container_copy = '<div class="panel panel-default" id = "0_panel"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" href="#0_container ">Container</a><div class="pull-right"><button class="btn btn-xs btn-info" data-toggle = "collapse" href="#0_container">_</button><button class="remove-container-row btn btn-xs btn-danger" value = "0_panel">&times;</button></div></h4></div><div id="0_container" class="panel-collapse collapse in"><div class="panel-body"><div class = "row"><div class = "col-md-6"><div class = "form-horizontal"><div class="form-group required"><label class="control-label col-sm-4" for="contactNumber">Container Number:</label><div class="col-sm-8"><input type = "text" name = "containerNumber" id = "containerNumber" class = "form-control row_containerNumber" /></div></div></div><div class = "form-horizontal"><div class="form-group required"><label class="control-label col-sm-4" for="contactNumber">Container Size:</label><div class="col-sm-8"><select class = "form-control row_containerVolume" id = "containerVolume" name = "containerVolume"><option></option>@forelse($container_volumes as $container_volume)<option value = "{{ $container_volume->id }}">{{ $container_volume->name }}</option>@empty @endforelse</select></div></div></div><div class = "form-horizontal"><div class="form-group required"><label class="control-label col-sm-4" for="shippingLine">Shipping Line:</label><div class="col-sm-8"><input type = "text" name = "shippingLine" id = "shippingLine " class = "form-control row_containerReturnDate""/></div></div></div><div class = "form-horizontal"><div class="form-group required"><label class="control-label col-sm-4" for="contactNumber">Port of Cfs Location:</label><div class="col-sm-8"><input type = "text" name = "portOfCfsLocation" id = "portOfCfsLocation " class = "form-control row_containerReturnDate"/></div></div></div></div><div class = "col-md-6"><div class = "form-horizontal"><div class="form-group required"><label class="control-label col-sm-4" for="contactNumber">Return Date:</label><div class="col-sm-8"><input type = "date" name = "containerReturnDate" id = "containerReturnDate " class = "form-control row_containerReturnDate"/></div></div></div><div class = "form-horizontal"><div class="form-group required"><label class="control-label col-sm-4" for="contactNumber">Return To:</label><div class="col-sm-8"><input type = "text" name = "containerReturnTo" id = "containerReturnTo" class = "form-control row_containerReturnTo"/></div></div></div><div class = "form-horizontal"><div class="form-group required"><label class="control-label col-sm-4" for="contactNumber">Return Address:</label><div class="col-sm-8"><textarea name = "containerReturnAddress" id = "containerReturnAddress " class = "form-control row_containerReturnAddress"></textarea></div></div></div></div></div><div class = "col-md-12"><table class="table table-responsive table-striped" id = "0_details"><thead><tr><td>Description of goods</td><td>Gross Weight(kg)</td><td>Supplier/s</td><td>Action</td></tr></thead><tbody><tr><td width="35%"><input type = "text" name = "0_descriptionOfGoods" class = "form-control"/></td><td width="20%"><input type = "number" name = "0_grossWeight" class = "form-control"/></td><td width="30%"><input type = "text" name = "0_supplier"  class = "form-control" /></td><td width="15%"><button class = "btn btn-md btn-danger remove-container-detail" value = "0">x</button></td></tr></tbody></table></div><div class="row"><div class ="col-md-9"></div><div class= "col-md-3" style="text-align: center;"><button class = "btn btn-primary btn-sm new-container-detail" style="width: 80%;" value = "0">New Good</button></div></div></div></div></div>;';
		@if($delivery[0]->withContainer == 1)var container_ctr = {{ count($container_with_detail) }} @endif;
		var container_array = [0];
		var selected_container = 0;
		var selected_location = 0;

		$('#driver').val("{{ $delivery[0]->emp_id_driver }}");
		$('#helper').val("{{ $delivery[0]->emp_id_helper }}");
		$('#pickdatecon').val('{{ Carbon\Carbon::parse($delivery[0]->pickupDateTime)->format("Y-m-d") }}');
		$('#deldatecon').val('{{ Carbon\Carbon::parse($delivery[0]->deliveryDateTime)->format("Y-m-d") }}');
		fill_vehicle();
		fill_deliver();
		fill_pickup();
		function fill_vehicle()
		{
			vehicle_type_id = "{{ $delivery[0]->vehicle_types_id }}";
			vehicle_id = "{{ $delivery[0]->plateNumber }}";
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

						$('#vehicle_type').val(vehicle_type_id);
						$('#vehicle').val(vehicle_id);
					}
				},
				error: function(data) {
					if(data.status == 400){
						alert("Nothing found");
					}
				}
			})
		}

		function fill_deliver(){
			deliver_id = "{{ $delivery[0]->locations_id_del }}";
			if(deliver_id != 0)
			{
				$.ajax({
					type: 'GET',
					url: '{{ route("location.index") }}/' + deliver_id + '/getLocation',
					data: {
						'_token' : $('input[name=_token]').val(),
					},
					success: function(data){

						if(typeof(data) == "object"){
							$('#deliver_id').val(deliver_id);
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
			else{
				$('#_daddress').val("");
				$('#_dcity').val("");
				$('#_dprovince').val("");
				$('#_dzip').val("");
			}
		}
		function fill_pickup(){
			pickup_id = "{{ $delivery[0]->locations_id_pick }}";
			if(pickup_id != 0)
			{
				$.ajax({
					type: 'GET',
					url: '{{ route("location.index") }}/' + pickup_id + '/getLocation',
					data: {
						'_token' : $('input[name=_token]').val(),
					},
					success: function(data){

						if(typeof(data) == "object"){
							$('#pickup_id').val(pickup_id);
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
			}
		}

		// Trucking
		$(document).on('click', '.edit-trucking-information', function(e){
			$('#_destination').val($('#tr_destination').text().trim());
			$('#_shippingLine').val($('#tr_shippingLine').text().trim());
			$('#_portOfCfsLocation').val($('#tr_portOfCfsLocation').text().trim());
			$('#_status').val($('#tr_status').text().trim());
			
		})

		$(document).on('click', '.btnSave', function(e){
			e.preventDefault();
			console.log('aw');
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
					$('#chModal').modal('hide');
					if(selected_location == 0){	
						
						$('#_address').val($('#address').val());
						$('#_city').val($('#loc_city option:selected').text());
						$('#_province').val($('#loc_province option:selected').text().trim());
						$('#_zip').val($('#zip').val());
					}
					else{
						$('#_daddress').val($('#address').val());
						$('#_dcity').val($('#loc_city option:selected').text());
						$('#_dprovince').val($('#loc_province option:selected').text().trim());
						$('#_dzip').val($('#zip').val());

					}
					
				},
				error: function(data) {
					if(data.status == 400){
						alert("Nothing found");
					}
				}
			})
		})

		function clear_location(){
			$('#address').val("");
			$('#loc_city').val("0");
			$('#loc_province').val("0");
			$('#zip').val("");
		}

		$(document).on('click', '.pick_add_new_location', function(e){
			e.preventDefault();
			$('#chModal').modal('show');
			selected_location = 0;
		})

		$(document).on('click', '.del_add_new_location', function(e){
			e.preventDefault();
			$('#chModal').modal('show');
			selected_location = 1;
		})

		$(document).on('change', '#loc_province', function(e){
			fill_cities(0);
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
						
						var new_rows = "<option value = '0'></option>";
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
			console.log(container_ctr);
			console.log('ano ba');
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
			new_container = new_container.replace('0_', container_ctr + "_");
			new_container = new_container.replace('0_', container_ctr + "_");
			new_container = new_container.replace('0', container_ctr + "_");
			new_container = new_container.replace('value = "0"', "value = '" + container_ctr + "'");
			new_container = new_container.replace('value = "0"', "value = '" + container_ctr + "'");
			container_array.push(container_ctr);
			container_ctr++;
			$('#container_copy').append(new_container);
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
			selected_container = id;
			if(validateCurrentContainerDetail() == true){
				
				console.log(id);
				var detail_row = '<tr id = "description_row"><td width="35%"><input type = "text" name =   "'+ selected_container + '_descriptionOfGoods" class = "form-control"/></td><td width="20%"><input type = "text" name = "'+ selected_container +'_grossWeight" class = "form-control"/></td><td width="30%"><input type = "text" name = "'+ selected_container +'_supplier" class = "form-control" /></td><td width="15%"><button class = "btn btn-md btn-danger remove-container-detail" value = "'+ selected_container + '">x</button></td></tr>';
				$('#'+ selected_container + '_details' + ":last-child").append(detail_row);
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
		
		$(document).on('click', '.save-delivery', function(e){
			var checkWithoutContainer = "{{ $delivery[0]->withContainer }}";
			if(checkWithoutContainer == "0"){
				if(validateDetail() === true){
					if(validateOrder() == true){

						$.ajax({
							type: 'PUT',
							url: '{{route("trucking.index")}}/{{ $so_id }}/delivery/{{ $delivery[0]->id}}/update_delivery',
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
								'withContainer' : checkWithoutContainer,
								'del_head_id' : {{ $delivery[0]->id}},
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
						$.ajax({
							type: 'PUT',
							url: '{{route("trucking.index")}}/{{ $so_id }}/delivery/{{ $delivery[0]->id}}/update_delivery',
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
								'container_data' : results,
								'del_head_id' : {{ $delivery[0]->id}},
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
			if(pickup_id != 0)
			{
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
			}
			
		})

		$(document).on('change', '#deliver_id', function(e){
			deliver_id = $(this).val();
			if(deliver_id != 0)
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
			else{
				$('#_daddress').val("");
				$('#_dcity').val("");
				$('#_dprovince').val("");
				$('#_dzip').val("");
			}
			
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
				if(con_gw[j].value === "")
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
					if(con_gw[j].value === "")
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
						grossWeight : con_gw[j].value,
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
			if($('#helper').val() == "0"){
				$('#helper').css('border-color', 'red');
				error += "No helper";
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
			if(error.length == 0){
				return true;
			}
			else
			{
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
			descrp = document.getElementsByName("wodescriptionOfGoods");
			gw = document.getElementsByName("wogrossWeight");
			supp = document.getElementsByName("wosupplier");
			
			for(var i = 0; i < descrp.length; i++){
				if(descrp[i].value === ""){
					error += "No description";
					descrp[i].style.borderColor = 'red';
				}
				else{
					descrp_goods.push(descrp[i].value);
					descrp[i].style.borderColor = 'green';
				}
				if(gw[i].value === ""){
					error += "No gross weight";
					gw[i].style.borderColor = 'red';
				}
				else{
					gross_weights.push(gw[i].value);
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

</script>
@endpush