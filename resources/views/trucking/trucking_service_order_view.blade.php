@extends('layouts.app')

@section('content')
<div class = "row">
	<div class = "col-md-10 col-md-offset-1">
			<div class = "panel-heading">
				<h3>Manage Trucking</h3>
				<hr />	
			</div>
			<div class = "panel-body panel">
				<div class="col-md-8">
					@if($service_order->status == 'P')
					<h4>Trucking Information <button class="btn btn-sm btn-primary pull-right clearfix edit-trucking-information" data-toggle="modal" data-target="#trModal">Edit Information</button></h4>
					@else
					<h4>Trucking Information <button  disabled class="btn btn-sm btn-primary pull-right clearfix edit-trucking-information" data-toggle="modal" data-target="#trModal">Edit Information</button></h4>
					@endif
					<br />
					<div>
						<form class="form-horizontal" role="form">
							{{ csrf_field() }}
							<div class="form-group">
								<label class="control-label col-md-5 pull-left" for="tr_address">Trucking Service Order #:</label>
								<span class="control-label col-md-5 pull-right" id = "tr_address">{{ $service_order->id }}</span>
							</div>
							<div class="form-group">         
								<label class="control-label col-md-5 pull-left" for="tr_destination">Destination:</label>
								<span class="control-label col-md-5 pull-right" id ="tr_destination" style = "text-align: right;">{{ $service_order->destination }}</span>
							</div>
							<div class="form-group">        
								<label class="control-label col-md-5 pull-left" for="tr_deliveryDate">Delivery Date:</label>
								<span class="control-label col-sm-5 pull-right" id="tr_deliveryDate">{{ Carbon\Carbon::parse($service_order->deliveryDate)->toFormattedDateString() }}, ({{ Carbon\Carbon::parse($service_order->deliveryDate)->diffForHumans() }})</span>
							</div>

							<div class="form-group">        
								<label class="control-label col-md-5 pull-left" for="tr_shippingLine">Shipping Line: </label>
								<span class="control-label col-sm-5 pull-right" id="tr_shippingLine">
									@if($service_order->shippingLine == null)
									None
									@else
									{{ $service_order->shippingLine }}
									@endif
								</span>
							</div>
							<div class="form-group">        
								<label class="control-label col-md-5 pull-left" for="tr_portOfCfsLocation">Port of Cfs Location: </label>
								<span class="control-label col-sm-5 pull-right" id="tr_portOfCfsLocation">{{ $service_order->portOfCfsLocation }}</span>
							</div>
							<div class="form-group">        
								<label class="control-label col-md-5 pull-left" for="tr_status">Status: </label>
								<span class="control-label col-sm-5 pull-right" id="tr_status">
									@php
									switch($service_order->status){
									case 'C': echo "Cancelled"; break;
									case 'F': echo "Finished"; break;
									case 'P': echo "Pending"; break;
									default : echo "Unknown"; break; }
									@endphp
								</span>
							</div>
						</form>
					</div>
				</div>
				<div>
					<div class="col-md-4">
						<div class = "default-panel panel">
							<div class = "panel-heading">
								<h4 style="text-align: center;">Successful Deliveries</h4>
								<h1 style="text-align: center;" class = "success_delivery">{{ $success_trucking }}</h1>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class = "default-panel panel">
							<div class = "panel-heading">
								<h4 style="text-align: center;">Cancelled Deliveries</h4>
								<h1 style="text-align: center;" class = "cancelled_delivery">{{ $cancelled_trucking }}</h1>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class = "default-panel panel">
							<div class = "panel-heading">
								<h4 style="text-align: center;">Pending Deliveries</h4>
								<h1 style="text-align: center;" class = "pending_delivery">{{ $pending_trucking }}</h1>
							</div>
						</div>
					</div>
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
				<table class = "table table-responsive" id = "deliveries_table">
					<thead>
						<tr>
							<td>
								ID
							</td>
							<td>
								Address
							</td>
							<td>
								Vehicle
							</td>
							<td>
								Created At
							</td>
							<td>
								Status
							</td>
							<td>
								Actions
							</td>
						</tr>
					</thead>
					@forelse($deliveries as $delivery)
					<tr>
						<td>
							{{ $delivery->id }}
						</td>
						<td>
							{{ $delivery->deliveryAddress }}
						</td>
						<td>
							{{ $delivery->plateNumber }}
						</td>
						<td>
							{{ Carbon\Carbon::parse($delivery->created_at)->diffForHumans() }}
						</td>
						<td>
							@php
							switch($delivery->status){
							case 'C': echo "Cancelled"; break;
							case 'F': echo "Finished"; break;
							case 'P': echo "Pending"; break;
							default : echo "Unknown"; break; }
							@endphp
							
						</td>
						<td>
							<a class = "btn btn-primary btn-sm" href = "{{ route('trucking.index') }}/{{ $so_id }}/delivery/{{ $delivery->id }}/view">View </a>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="6">
							<h5 style="text-align: center;">No records found.</h5>
						</td>
					</tr>
					@endforelse
				</table> 
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
						<label class="control-label col-sm-3" for="_destination">Destination</label>
						<div class="col-sm-8"> 
							<input type = "text" class="form-control" name = "_destination" id = "_destination"/> 
						</div>
					</div>
				</div>
				<div class = "form-horizontal">
					<div class="form-group">
						<label class="control-label col-sm-3" for="_shippingLine">Shipping Line</label>
						<div class="col-sm-8"> 
							<input type = "text" class="form-control" name = "_shippingLine" id = "_shippingLine"/> 
						</div>
					</div>
				</div>
				<div class = "form-horizontal">
					<div class="form-group">
						<label class="control-label col-sm-3" for="_portOfCfsLocation">Port Of Cfs Location</label>
						<div class="col-sm-8"> 
							<input type = "text" class="form-control" name = "_portOfCfsLocation" id = "_portOfCfsLocation"/> 
						</div>
					</div>
				</div>
				<div class = "form-horizontal">
					<div class="form-group">
						<label class="control-label col-sm-3" for="_status">Status</label>
						<div class="col-sm-8"> 
							<select name = "_status" id = "_status" class = "form-control">
								<option value = "P">Pending</option>
								<option value = "C">Cancelled</option>
								@if( $pending_trucking != 0)
								<option value = "F" disabled>Finished</option>
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
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">New Delivery</h4>
			</div>
			<div class="modal-body">
				<ul class="nav nav-pills nav-justified" id = "choices">
					<li class="active"><a data-toggle="pill" href="#wcontainer">Container</a></li>
					<li><a data-toggle="pill" href="#wocontainer">Non Container</a></li>
				</ul>
				<div class="tab-content">
					<div id="wcontainer" class="tab-pane fade in active">
						<div class = "panel">
							<div class = "panel-body">
								<form class="form-horizontal" role="form">
									<h4>&nbsp;Container Information<button class = "btn btn-primary btn-sm pull-right add-new-container">New Container</button></h4>
									<hr />
									<table class = "table table-responsive" id = "container_table">
										<thead>
											<tr>
												<td width = "20%">
													Container No.
												</td>
												<td width = "15%">
													Volume
												</td>
												<td width = "20%">
													Return To
												</td>
												<td width = "20%">
													Return Address
												</td>
												<td width = "5%">
													Return Date
												</td>
												<td width="20%">
													Action
												</td>
											</tr>
										</thead>
										<tbody>
											<tr id = "container_row">
												<td>
													<input type = "text" name = "containerNumber" id = "containerNumber" class = "form-control row_containerNumber"/>
												</td>
												<td>
													<select class = "form-control row_containerVolume" id = "containerVolume" name = "containerVolume">
														<option></option>
														@forelse($container_volumes as $container_volume)
														<option value = "{{ $container_volume->id }}">{{ $container_volume->description }}</option>
														@empty

														@endforelse
													</select>
												</td>
												<td>
													<input type = "text" name = "containerReturnTo" id = "containerReturnTo" class = "form-control row_containerReturnTo" />
												</td>
												<td>
													<input type = "text" name = "containerReturnAddress" id = "containerReturnAddress " class = "form-control row_containerReturnAddress" />
												</td>
												<td>
													<input type = "date" name = "containerReturnDate" id = "containerReturnDate " class = "form-control row_containerReturnDate" />
												</td>
												<td>
													<button class = "btn btn-sm btn-success save-container-row">Add</button>
													<button class = "btn btn-sm btn-danger remove-container-row">Delete</button>
												</td>
											</tr>
										</tbody>
									</table>

									<h4>&nbsp;Delivery Information</h4>
									<hr />
									<div class="form-group">
										<label class="control-label" for = "deladdcon">Delivery Address:</label>
										<input type = "text" name = "deladdcon" id = "deladdcon" class = "form-control deladdcon" />
									</div>
									<div class="form-group">
										<label class="control-label" for="wodetail_table">Delivery Content:</label>
									</div>
									<div id = "cargo_delivery_details">

									</div>
								</form>
							</div>
						</div>
					</div>
					<div id="wocontainer" class="tab-pane fade">
						<div class = "panel">
							<div class = "panel-body">
								<form class="form-horizontal" role="form">
									<h4>&nbsp;Delivery Information</h4>
									<hr />
									<div class="form-group">
										<label class="control-label" for = "deladd">Delivery Address:</label>
										<input type = "text" name = "deladd" id = "deladd" class = "form-control deladd" />
									</div>
									<div class="form-group">
										<label class="control-label" for="wodetail_table">Delivery Content:</label>
										<table class = "table-responsive table" id = "wodetail_table">
											<thead>
												<tr>
													<td>
														Description of Goods
													</td>
													<td>
														Gross Weight(kg)
													</td>
													<td>
														Supplier
													</td>
													<td>
														Action
													</td>
												</tr>
											</thead>
											<tbody>
												<tr id = "wodescription_row">
													<td width="35%">
														<input type = "text" name = "wodescriptionOfGoods" class = "form-control"/>
													</td>
													<td width="20%">
														<input type = "text" name = "wogrossWeight" class = "form-control"/>
													</td>
													<td width="30%">
														<input type = "text" name = "wosupplier"  class = "form-control" />
													</td>
													<td width="15%">
														<button class = "btn btn-md btn-primary woadd-new-detail">+</button>
														<button class = "btn btn-md btn-danger woremove-current-detail">x</button>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				
				<hr />
				<form class = "form-horizontal">

					<h4>&nbsp;Vehicle Assignment</h4>
					
					<div class="form-group">
						<label class="control-label col-sm-3" for="vehicle_type">Vehicle Type: </label>
						<div class="col-sm-8"> 
							<select class="form-control" id = "vehicle_type">
								<option value = "0"></option>
								@forelse($vehicle_types as $vehicle_type)
								<option value = "{{ $vehicle_type->id }}">{{ $vehicle_type->description  }}</option>
								@empty
								@endforelse
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="vehicle">Vehicle:  </label>
						<div class="col-sm-8"> 
							<select class="form-control" id = "vehicle">
								<option></option>
							</select>
						</div>
					</div>
					<hr />
					<h4>&nbsp;Driver Assignment</h4>
					
					<div class="form-group">
						<label class="control-label col-sm-3" for="contactNumber">Driver:</label>
						<div class="col-sm-8">
							<select class="form-control" id = "driver">
								<option></option>
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
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-md btn-success save-delivery">Save</button>
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


		// Trucking
		$(document).on('click', '.edit-trucking-information', function(e){
			$('#_destination').val($('#tr_destination').text().trim());
			$('#_shippingLine').val($('#tr_shippingLine').text().trim());
			$('#_portOfCfsLocation').val($('#tr_portOfCfsLocation').text().trim());
			$('#_status').val($('#tr_status').text().trim());			
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