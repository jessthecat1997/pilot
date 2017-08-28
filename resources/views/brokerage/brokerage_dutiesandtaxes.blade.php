@extends('layouts.app')
@section('content')

<div class = "row">
		<div class = "panel default-panel">
			<div class = "panel-heading">
				<h3><img src="/images/bar.png"> Brokerage | Create Service Order</h3>
				<hr />
			</div>
			<div class = "panel-body">
				<div class="panel-heading">
					<h4 id = "basic-information-heading"><small>1</small> Consignee Information</h4>
				</div>
				<div class = "panel-body">
					<div class = "col-md-12">
						<div class = "col-md-6 col-md-offset-2">
							<div class = "form-horizontal">
								<div class = "form-group">
									<label class = "control-label col-md-3">Consignee: </label>
									<div class = "input-group col-md-9">
										<select id = "consignee_id" class = "form-control select2-allow-clear select2">
											<option value = "0">Select Consignee</option>
											@forelse($consignees as $consignee)
											<option value = "{{ $consignee->id }}">{{ $consignee->firstName . " " . $consignee->lastName . " - " . $consignee->companyName }}</option>

											@empty
											@endforelse
										</select>

									</div>
								</div>
							</div>
						</div>
						<div class = "col-md-4">
							<button class = "btn btn-success add_new_consignee" style="line-height: 10px; height: 28px;">New Consignee</button>
						</div>
					</div>
					<div class="col-md-12">
						<div class = "form-horizontal">
							<div class = "form-group">
								<label class = "control-label col-md-3">Name: </label>
								<div class = "col-md-9">
									<div class = "col-md-4">
										<input type = "text"  class = "form-control" id = "_cfirstName" disabled placeholder="First Name" />
									</div>
									<div class = "col-md-4">
										<input type = "text"  class = "form-control" id = "_cmidddleName" disabled placeholder="Middle Name" />
									</div>
									<div class = "col-md-4">
										<input type = "text"  class = "form-control" id = "_clastName" disabled placeholder="Last Name" />
									</div>
								</div>
							</div>
							<div class = "form-group">
								<label class = "control-label col-md-3">Contact Number: </label>
								<div class = "col-md-3">
									<div class = "col-md-12">
										<input type = "text"  class = "form-control" id = "_ccontactNumber" disabled placeholder="Contact Number" />
									</div>
								</div>
								<label class = "control-label col-md-2">Email: </label>
								<div class = "col-md-4">
									<div class = "col-md-12">
										<input type = "text"  class = "form-control" id = "_cemail" disabled placeholder="Email" />
									</div>
								</div>
							</div>
							<div class = "form-group">
								<label class = "control-label col-md-3">Company Name</label>
								<div class = "col-md-9">
									<div class = "col-md-12">
										<input type = "text"  class = "form-control" id = "_ccompanyName" disabled placeholder="Company" />
									</div>
								</div>
							</div>
							<div class = "form-group">
								<label class = "control-label col-md-3">Business Style: </label>
								<div class = "col-md-3">
									<div class = "col-md-12">
										<input type = "text"  class = "form-control" id = "_cbusinessStyle" disabled placeholder="Business Style" />
									</div>
								</div>
								<label class = "control-label col-md-2">TIN: </label>
								<div class = "col-md-4">
									<div class = "col-md-12">
										<input type = "text"  class = "form-control" id = "_cTIN" disabled placeholder="TIN" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class = "panel-heading">
					<h4><small>2</small>Brokerage Information</h4>
				</div>

				<div class = "panel-body">
					<form class="form-horizontal" role="form">
						{{ csrf_field() }}
						<div class="form-group">
				<div id="so_details" class="tab-pane fade in active">
						<br />
							<div class = "col-md-12">
								<div class = "form-horizontal">

								<div class = "form-group">
									<label class= "col-md-4 control-label">Expected Arrival Date*</label>
									 <div class = "col-md-5">
										<div class = "input-group">

												<input type="text" class = "form-control" name="expect" id = "expectedArrivalDate" disabled>
												<span class="input-group-btn">
														<button class="btn btn-default" type="button" onclick="getData()" id = "arrivalDateButton"><i class="fa fa-calendar "></i></button>
												</span>

										</div>
									</div>
								</div>

								<div class = "form-group">
									<label  class="col-md-4 control-label">Freight Type*</label>
									<div class="col-md-5">
										<div class="input-group">
											<input id = "FreightType" type="text" class="form-control" aria-label="..." name = "freightType" readonly>
											<div class="input-group-btn">
												<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Select Freight Type <span class="caret"></span></button>
												<ul class="dropdown-menu dropdown-menu-right">
													<li><a onclick = "document.getElementById('FreightType').value = 'Air Freight'">Air Freight</a></li>
													<li><a	onclick = "document.getElementById('FreightType').value = 'Sea Freight'">Sea Freight</a></li>
													<li><a  onclick = "document.getElementById('FreightType').value = 'Train Freight'">Train Freight</a></li>

												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
										<label for="email" class="col-md-4 control-label">BL\AWL Number*</label>
										<div class="col-md-5">
													<input  type="text" class="form-control" name = "freightnumber" id = "freightNumber">
										</div>
								</div>

								<div class="form-group">
									<div class="form-group required">
										<label class = "col-md-4 control-label ">Pick up point: </label>
										<div class = "col-md-5">
										<div class="input-group">
											<select class = "form-control" id = "pickup_id">
												<option value = "0"></option>
												@forelse($locations as $location)
												<option value = "{{ $location->id }}">{{ $location->name }}</option>
												@empty
												@endforelse
											</select>
											<span class="input-group-btn">
												<button class="btn btn-primary pick_add_new_location" onclick = "	$('#LocationModal').modal('show');"type="button">+</button>
											</span>
										</div>
									</div>
								</div>
								</div>

								<div class="form-group">
										<label  class="col-md-4 control-label">Shipper*</label>
										<div class="col-md-5">
													<input  type="text" class="form-control" name = "shipper" id = "shipper">
										</div>
								</div>

								<div class = "form-group">
									<label  class="col-md-4 control-label">Weight </label>
									<div class="col-md-5">
										<div class="input-group">
											<input  type="text" class="form-control" aria-label="..." name = "freightType" id = "weight">
											<div class="input-group-btn">
												<button type="button" class="btn btn-default" aria-expanded="false"> kgs</label>
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
										<label class="col-md-4 control-label">Description of goods</label>
										<div class="col-md-5">
													<textarea class="form-control" rows="3"></textarea>
										</div>
								</div>

							</div>
						</div>
					</div>

						<label class="control-label col-sm-4" for="noOfDeliveries">Processed by:</label>
						<div class="col-sm-6">
							<select name = "processedBy" id = "processedBy" class = "form-control">
								<option value = "0"></option>
								@forelse($employees as $employee)
								<option value = "{{ $employee->id }}">
									{{ $employee->lastName . ", " . $employee->firstName }}
								</option>
								@empty

								@endforelse
							</select>
						</div>
					</div>
				</form>
					</div>
				<br />
				<br />
				<button class = "btn btn-md btn-success" style="width: 100%;" id = "brokerageBtn">Create Brokerage Service Order</button>
			</div>

		</div>
	</div>
</div>
<div id="chModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Consignee Information</h4>
			</div>
			<div class="modal-body">
				<div class = "panel-default">
					<div id="con_collapse" class="collapse in">
						<ul class="nav nav-tabs">
							<li class = "active" ><a data-toggle="tab" href="#new_con">Basic Information</a></li>
							<li><a data-toggle="tab" href="#physical_address">Current Address</a></li>
							<li><a data-toggle="tab" href="#billing_address">Billing Address</a></li>
						</ul>

						<div class="tab-content">
							<div id="physical_address" class="tab-pane fade in ">
								<br />
								<div class = "form-horizontal">
									<div class="form-group required">
										<label class="control-label col-sm-3" for="phy_address">Blk/Lot/Street:</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name = "phy_address" id="phy_address" placeholder="Enter Address">
										</div>
									</div>
									<div class="form-group required">
										<label class="control-label col-sm-3" for="phy_province">Province:</label>
										<div class="col-sm-8">
											<select name = "phy_province" id="phy_province" class = "form-control">
												<option value="0"></option>
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
										<label class="control-label col-sm-3" for="phy_city">City:</label>
										<div class="col-sm-8">
											<select name = "phy_city" id="phy_city" class = "form-control">
												<option value="0"></option>
											</select>
										</div>
									</div>
									<div class="form-group required">
										<label class="control-label col-sm-3" for="phy_zip">Zip Code:</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name = "phy_zip" id="phy_zip" placeholder="Enter Zip Code">
										</div>
									</div>
									<div class="form-group required">
										<label class="control-label col-sm-4" for="same_billing_address">Same billing address:</label>
										<div class="col-md-8">
											<input type="checkbox" class = "checkbox same_billing_address">
										</div>
									</div>
								</div>
							</div>
							<div id="billing_address" class="tab-pane fade in ">
								<br />
								<div class = "form-horizontal">
									<div class="form-group required">
										<label class="control-label col-sm-3" for="bill_address">Blk/ Lot/ Street:</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name = "bill_address" id="bill_address" placeholder="Enter  Address">
										</div>
									</div>
									<div class="form-group required">
										<label class="control-label col-sm-3" for="bill_province">Province:</label>
										<div class="col-sm-8">
											<select name = "bill_province" id="bill_province"  class = "form-control">
												<option value = '0'></option>
												@forelse($provinces as $province)
												<option value="{{ $province->id }}">
													{{ $province->name }}
												</option>
												@empty

												@endforelse
											</select>
										</div>
									</div>
									<div class="form-group required">
										<label class="control-label col-sm-3" for="bill_city">City:</label>
										<div class="col-sm-8">
											<select name = "bill_city" id="bill_city" class = "form-control">
												<option value="0"></option>
											</select>
										</div>
									</div>
									<div class="form-group required">
										<label class="control-label col-sm-3" for="bill_zip">Zip Code:</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name = "bill_zip" id="bill_zip" placeholder="Enter Zip Code">
										</div>
									</div>
								</div>
							</div>
							<div id="new_con" class="tab-pane fade in active">
								<br />
								<form class="form-horizontal" role="form">
									{{ csrf_field() }}
									<div class="form-group required">
										<label class="control-label col-sm-4" for="firstName">First Name:</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name = "firstName" id="firstName" placeholder="Enter First Name">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-4" for="middleName">Middle Name:</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name = "middleName" id="middleName" placeholder="Enter Middle Name">
										</div>
									</div>
									<div class="form-group required">
										<label class="control-label col-sm-4" for="pwd">Last Name:</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name = "lastName" id="lastName" placeholder="Enter Last Name">
										</div>
									</div>
									<div class="form-group required">
										<label class="control-label col-sm-4" for="email">Email</label>
										<div class="col-sm-6">
											<input type="email" class="form-control" name = "email" id="email" placeholder="Enter Email Address">
										</div>
									</div>
									<div class="form-group required">
										<label class="control-label col-sm-4" for="contactNumber">Contact Number:</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name = "contactNumber" id="contactNumber" placeholder="Enter Contact Number">
										</div>
									</div>
									<div class="form-group required">
										<label class="control-label col-sm-4" for="companyName">Company Name:</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name = "companyName" id="companyName" placeholder="Enter Company Name">
										</div>
									</div>
									<div class="form-group required">
										<label class="control-label col-sm-4" for="businessStyle">Business Style:</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name = "businessStyle" id="businessStyle" placeholder="Enter Business Style">
										</div>
									</div>
									<div class="form-group required">
										<label class="control-label col-sm-4" for="TIN">TIN:</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name = "TIN" id="TIN" placeholder="Enter TIN">
										</div>
									</div>

								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class = "btn btn-info btn-md save-consignee-information" id = "btnConsigneeSave" >Save Consignee</button>
				<input type = "reset" class = "btn btn-danger btn-md" value = "Clear Details" />
			</div>
		</div>




</div>
</div>


		<!-- Add Item Modal -->

			<section class="content">
				<div class="modal fade" id="LocationModal" role="dialog">
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
								<button type = "submit" class="btn btn-success btnSave"  >Save</button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</section>
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
@push('scripts')
<script  type = "text/javascript" charset = "utf8" src="/js/select2/select2.full.js"></script>
<script type="text/javascript">


	$('#collapse1').addClass('in');

	var data;
	var cs_id;
	var consigneeID = null;
	var selected_location = 0;
	$(document).ready(function(){

		$('#consignee_id').select2();

		$('#expectedArrivalDate').datepicker({
		    onSelect: function(value, ui) {

		    },
		    minDate: 0,
		    changeMonth: true,
		    changeYear: true
		});

		$('#arrivalDateButton').click(function () {
		 $('#expectedArrivalDate').datepicker('show');
		 });


		 $(document).on('click', '.pick_add_new_location', function(e){
			 e.preventDefault();

		 })

		$(document).on('change', '#consignee_id', function(e){
			consigneeID = $('#consignee_id').val();
			if($('#consignee_id').val() != 0){
				$.ajax({
					type: 'GET',
					url: "{{ route('consignee.index')}}/" + $('#consignee_id').val() + "/getConsignee",
					data: {
						'_token' : $('input[name=_token]').val(),
					},
					success: function(data){
						if(typeof(data) == "object"){
							console.log(data);
							$('#_cfirstName').val(data[0].firstName);
							$('#_cmidddleName').val(data[0].middleName);
							$('#_clastName').val(data[0].lastName);
							$('#_ccontactNumber').val(data[0].contactNumber);
							$('#_cemail').val(data[0].email);
							$('#_ccompanyName').val(data[0].companyName);
							$('#_cbusinessStyle').val(data[0].businessStyle);
							$('#_cTIN').val(data[0].TIN);
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
				$('#_cfirstName').val("");
				$('#_cmidddleName').val("");
				$('#_clastName').val("");
				$('#_ccontactNumber').val("");
				$('#_cemail').val("");
				$('#_ccompanyName').val("");
				$('#_cbusinessStyle').val("");
				$('#_cTIN').val("");
			}
		})

		$(document).on('click', '.add_new_consignee', function(e){
			e.preventDefault();
			$('#chModal').modal('show');
		})

		$(document).on('change', '#phy_province', function(e){

			$.ajax({
				type: 'GET',
				url: "{{ route('get_prov_cities')}}/" + $('#phy_province').val(),
				data: {
					'_token' : $('input[name=_token]').val(),
				},
				success: function(data){
					if(typeof(data) == "object"){
						console.log(data);
						var new_rows = "<option value = '0'></option>";
						for(var i = 0; i < data.length; i++){
							new_rows += "<option value = '"+ data[i].id+"'>"+ data[i].name +"</option>";
						}
						$('#phy_city').find('option').not(':first').remove();
						$('#phy_city').html(new_rows);
					}
				},
				error: function(data) {
					if(data.status == 400){
						alert("Nothing found");
					}
				}
			})
		})

		$(document).on('change', '#bill_province', function(e){

			$.ajax({
				type: 'GET',
				url: "{{ route('get_prov_cities')}}/" + $('#bill_province').val(),
				data: {
					'_token' : $('input[name=_token]').val(),
				},
				success: function(data){
					if(typeof(data) == "object"){
						console.log(data);
						var new_rows = "<option value = '0'></option>";
						for(var i = 0; i < data.length; i++){
							new_rows += "<option value = '"+ data[i].id+"'>"+ data[i].name +"</option>";
						}
						$('#bill_city').find('option').not(':first').remove();
						$('#bill_city').html(new_rows);
					}
				},
				error: function(data) {
					if(data.status == 400){
						alert("Nothing found");
					}
				}
			})
		})

		$(document).on('change', '.same_billing_address', function(e){
			e.preventDefault();
			var checked = $('.same_billing_address').is(":checked");
			if(checked == true){
				$('#bill_address').attr('disabled', 'true');
				$('#bill_address').val("");
				$('#bill_zip').val("");
				$('#bill_zip').attr('disabled', 'true');
				$('#bill_city').attr('disabled', 'true');
				$('#bill_province').attr('disabled', 'true');
			}
			else{
				$('#bill_province').val("");
				$('#bill_city').val("");
				$('#bill_address').removeAttr('disabled');
				$('#bill_province').removeAttr('disabled');
				$('#bill_city').removeAttr('disabled');
				$('#bill_zip').removeAttr('disabled');
			}

		})

		$(document).on('click', '.new-consignee', function(e){
			e.preventDefault();
			$('#chModal').modal('show');

		})

		$(document).on('click', '.save-consignee-information', function(e){
			e.preventDefault();
			var checked = $('.same_billing_address').is(":checked");

			if(validateConsignee() == true){

				$.ajax({
					type: 'POST',
					url: '{{ route("consignee.index") }}',
					data: {
						'_token' : $('input[name=_token]').val(),
						'firstName' : $('#firstName').val(),
						'middleName' : $('#middleName').val(),
						'lastName' : $('#lastName').val(),
						'companyName' : $('#companyName').val(),
						'email' : $('#email').val(),
						'contactNumber' : $('#contactNumber').val(),
						'businessStyle' : $('#businessStyle').val(),
						'TIN' : $('#TIN').val(),

						'address' : $('#phy_address').val(),
						'city' : $('#phy_city option:selected').text(),
						'st_prov' : $('#phy_province option:selected').text(),
						'zip' : $('#phy_zip').val(),

						'b_address' : $('#bill_address').val(),
						'b_city' : $('#bill_city option:selected').text(),
						'b_st_prov' : $('#bill_province option:selected').text(),
						'b_zip' : $('#bill_zip').val(),

						'same_billing_address' : checked,



					},
					success: function (data) {
						console.log(data);
						if(typeof(data) == "object"){
							consigneeID = data.id;
							$('#chModal').modal('hide');
							$('#collapse_1').removeClass('in');
							$('#collapse_2').addClass('in');
							$('#_firstName').val($('#firstName').val() + " " + $('#middleName').val() + " " + $('#lastName').val());
							$('#_companyName').val($('#companyName').val());

							$('#_email').val($('#email').val());
							$('#_contactNumber').val($('#contactNumber').val());

							$('#firstName').val("");
							$('#middleName').val("");
							$('#lastName').val("");
							$('#companyName').val("");
							$('#email').val("");
							$('#address').val("");
							$('#contactNumber').val("");
							$('#TIN').val("");
							$('#businessStyle').val("");


							$('#_cfirstName').val(data.firstName);
							$('#_cmidddleName').val(data.middleName);
							$('#_clastName').val(data.lastName);
							$('#_ccontactNumber').val(data.contactNumber);
							$('#_cemail').val(data.email);
							$('#_ccompanyName').val(data.companyName);
							$('#_cbusinessStyle').val(data.businessStyle);
							$('#_cTIN').val(data.TIN);
						}
					}
				})
			}
		})

		function validateOrder()
		{
			error = "";
			if(consigneeID == null || consigneeID == 0){
				error += "No selected consignee";
				$('#consignee_id').css('border-color', 'red');
			}
			else{
				$('#consignee_id').css('border-color', 'green');
			}
			if($('#processedBy').val() == "0"){
				error += "No processedBy";
				$('#processedBy').css('border-color', 'red');
			}
			else{
				$('#processedBy').css('border-color', 'green');
			}
			if(error.length == 0){
				return true;
			}
			else{
				return false;
			}
		}



		function validateConsignee()
		{
			var error = "";
			if($('#firstName').val() === ""){
				$('#firstName').css('border-color', 'red');
				error += "First name is required. \n";
			}
			else
			{
				$('#firstName').css('border-color', 'green');
			}
			if($('#middleName').val() === ""){
				$('#middleName').css('border-color', 'green');
			}
			else
			{
				$('#middleName').css('border-color', 'green');
			}
			if($('#lastName').val() === ""){
				$('#lastName').css('border-color', 'red');
				error += "Last name is required.\n";
			}
			else
			{
				$('#lastName').css('border-color', 'green');
			}

			if($('#companyName').val() === ""){
				$('#companyName').css('border-color', 'red');
				error += "Company name is required.\n";
			}
			else
			{
				$('#companyName').css('border-color', 'green');
			}

			if($('#businessStyle').val() === ""){
				$('#businessStyle').css('border-color', 'red');
				error += "Business Style is required.\n";
			}
			else
			{
				$('#businessStyle').css('border-color', 'green');
			}

			if($('#TIN').val() === ""){
				$('#TIN').css('border-color', 'red');
				error += "TIN is required.\n";
			}
			else
			{
				$('#TIN').css('border-color', 'green');
			}
			if($('#email').val() === ""){
				$('#email').css('border-color', 'red');
				error += "Email is required.\n";
			}
			else
			{
				$('#email').css('border-color', 'green');
			}
			if($('#contactNumber').val() === ""){
				$('#contactNumber').css('border-color', 'red');
				error += "Contact Number is required.\n";
			}
			else
			{
				$('#contactNumber').css('border-color', 'green');
			}
			console.log(error);
			if(error.length == 0){

				return true;
			}
			else{
				return false;
			}

		}
	})

	$(document).on('change', '#deliver_id', function(e){
		deliver_id = $(this).val();
		selected_to = $(this).val();
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
		if(selected_from != 0 && selected_to != 0){
			$.ajax({
				type: 'GET',
				url: '{{ route("get_area_rate") }}',
				data: {
					'area_from' : selected_from,
					'area_to' : selected_to,
				},
				success : function(data) {
					if(data.length == 0){
						$('#standard_rate').html('No set standard rate for <strong>' + $('#pickup_id :selected').text() + "</strong> to <strong>" + $('#deliver_id :selected').text() + "<strong>");
						$('#deliveryFee').val("0.00");
					}
					else{
						$('#standard_rate').html("<strong>" + $('#pickup_id :selected').text() + "</strong> to <strong>" + $('#deliver_id :selected').text() + "</strong> : <strong>Php " + data[0].amount + "</strong>");
						$('#deliveryFee').val(data[0].amount);
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

	$(document).on('change', '#loc_province', function(e){
		fill_cities(0);
	})

	$(document).on('click', '.btnSave', function(e){

		e.preventDefault();
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
					$('#LocationModal').modal('hide');
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
					$('#LocationModal').modal('hide');
				}

			$('#LocationModal').modal('hide');

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

	$('#brokerageBtn').on('click', function(e){

		$.ajax({
			type: 'POST',
			url: "{{ route('saveBrokerageOrder') }}",
			data: {
				'_token' : $('input[name=_token]').val(),
				'cs_id' : consigneeID,
				'employee_id' : $('#processedBy').val(),
				'location_id': $('#pickup_id').val(),
				'shipper' : document.getElementById('shipper').value,
				'companyName' : document.getElementById('freightNumber').value,
				'freightType' : document.getElementById('FreightType').value,
				'arrivalDate' : document.getElementById('expectedArrivalDate').value,
				'freightNumber' : document.getElementById('freightNumber').value,
				'weight' : document.getElementById('weight').value,
			},
			success: function(data){
				if(typeof(data) == "object"){
					console.log(data);
					$('#_cfirstName').val(data[0].firstName);
					$('#_cmidddleName').val(data[0].middleName);
					$('#_clastName').val(data[0].lastName);
					$('#_ccontactNumber').val(data[0].contactNumber);
					$('#_cemail').val(data[0].email);
					$('#_ccompanyName').val(data[0].companyName);
					$('#_cbusinessStyle').val(data[0].businessStyle);
					$('#_cTIN').val(data[0].TIN);
				}
				window.location.replace('/brokerage/'+data+'/order');
			},
			error: function(data) {
				if(data.status == 400){
					alert("Nothing found");
				}
			}
		})
	});

</script>
@endpush
