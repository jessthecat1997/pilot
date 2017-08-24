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
				<h4 id = "basic-information-heading" ><small>1</small>Consignee Information</h4>
			</div>
			<div class = "collapse" id = "consignee_warning">
				<div class="alert alert-danger">
					<strong>Warning!</strong> No selected consignee.
				</div>
			</div>
			<div class = "panel-default">
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
						<button class = "btn but add_new_consignee" style="line-height: 10px; height: 28px;">New Consignee</button>
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
		</div>
		<div class = "panel-heading">
			<h4><small>2</small>Brokerage Information</h4>
		</div>
	</div>
	<div class = "panel panel-default">
		<ul class="nav nav-tabs">
			<li class = "active" ><a data-toggle="tab" href="#so_details">Basic Information</a></li>
			<li><a data-toggle="tab" href="#dutiesandtaxes_details">Duties</a></li>
		</ul>
		<div class="panel-body">
			<div class = "tab-content">
				<div id="so_details" class="tab-pane fade in active">
					<br />
					<div class = "col-md-12">
						<div class = "form-horizontal">
							<div class="form-group">
								<label class="col-md-2 control-label">Service Order Type*</label>
								<div class = "col-md-5">
									<div class = "input-group">
										<input id = "ServOrdText" type="text" class="form-control" aria-label="..." name = "serviceordertype" readonly>
										<div class="input-group-btn">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Select Service Order Type <span class="caret"></span></button>
											<ul class="dropdown-menu dropdown-menu-right">
												<li><a href="#" onclick = "document.getElementById('ServOrdText').value = 'Brokerage'">Brokerage</a></li>
												<li class = "disabled"><a  href="#">Trucking</a></li>
												<li><a  href="#" "document.getElementById('ServOrdText').value = 'Brokerage and Trucking'">Brokerage and Trucking</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class = "form-group">
								<label class="col-md-2 control-label">Expected Date Of Arrival</label>
								<div class="col-md-3">
									<input type="date" class = "form-control" name="arrivalDate" id = "arrivalDate">
								</div>
							</div>

							<div class = "form-group">
								<label  class="col-md-2 control-label">Freight Type*</label>
								<div class="col-md-5">
									<div class="input-group">
										<input id = "FreightType" type="text" class="form-control" aria-label="..." name = "freightType" readonly>
										<div class="input-group-btn">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Select Freight Type <span class="caret"></span></button>
											<ul class="dropdown-menu dropdown-menu-right">
												<li><a href="#" onclick = "document.getElementById('FreightType').value = 'Air Freight'">Air Freight</a></li>
												<li><a href="#" onclick = "document.getElementById('FreightType').value = 'Sea Freight'">Sea Freight</a></li>
												<li><a href="#" onclick = "document.getElementById('FreightType').value = 'Train Freight'">Train Freight</a></li>

											</ul>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="email" class="col-md-2 control-label">BL\AWL Number*</label>
								<div class="col-md-5">
									<input  type="text" class="form-control" name = "freightnumber" id = "freightNumber">
								</div>
							</div>

							<div class="form-group">
								<label for="email" class="col-md-2 control-label">Port*</label>
								<div class="col-md-5">
									<input  type="text" class="form-control" name = "port" id = "port">
								</div>
							</div>

							<div class="form-group">
								<label  class="col-md-2 control-label">Shipper*</label>
								<div class="col-md-5">
									<input  type="text" class="form-control" name = "shipper" id = "shipper">
								</div>
							</div>

							<div class = "form-group">
								<label  class="col-md-2 control-label">Weight </label>
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
									<label class="col-md-2 control-label">Description of goods</label>
									<div class="col-md-5">
										<textarea class="form-control" rows="3"></textarea>
									</div>
								</div>

							</div>
						</div>
					</div>


					<div id = "dutiesandtaxes_details" class="tab-pane fade in active">
						<div class = "col-md-12">
							<div class = "form-horizontal">
								<div class="form-group">
									<label class="col-md-2 control-label">Exhange Rate*</label>
									<div class="col-md-5">
										<div class="input-group input-group-lg">
											<input  type="text" class="form-control" name = "exchangeRate" id = "exchangeRate" readonly = "true" value = '@php echo number_format((float)$exchange_rate[$currentExchange_id-1]->rate, 3, '.', '') @endphp' style="text-align: right;">
											<span class="input-group-addon">
												<input type="checkbox" checked data-toggle="toggle" data-size="mini" data-on="Current" data-off="Custom" data-onstyle="success"  id = "exchangeRate_toggle" style="text-align: right;">
											</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">CDS Fee*</label>
									<div class = "col-md-5">
										<div class="input-group  input-group-lg">
											<input  type="text" class="form-control" name = "CDSFee" id = "CDSFee" readonly = "true" value = "@php echo number_format((float)$cds_fee[$currentCds_id-1]->fee, 2, '.', '') @endphp" style="text-align: right;">
											<span class="input-group-addon">
												<input type="checkbox" checked data-toggle="toggle" data-size="mini" data-on="Current" data-off="Custom" data-onstyle="success"  id = "cdsFee_toggle">
											</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label ">IPF Fee*</label>
									<div class = "col-md-5">
										<div class="input-group  input-group-lg">
											<input type="checkbox" checked data-toggle="toggle" data-size="normal" data-on="Current" data-off="Custom" data-onstyle="success"  id = "ipfFee_toggle" style="text-align: right;">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Arrastre*</label>
									<div class="col-md-5">
										<div class="input-group ">
											<span class="input-group-addon" id="cdsfeeadd">Php</span>
											<input  type="text" class=" form-control" name = "arrastre" id = "arrastre" style="text-align: right;">
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">Wharfage*</label>
									<div class="col-md-5">
										<div class="input-group">
											<span class="input-group-addon" id="cdsfeeadd">Php</span>
											<input  type="text" class="form-control" name = "wharfage" id = "wharfage" style="text-align: right;">
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">Bank Charges</label>
									<div class="col-md-5">
										<div class="input-group">
											<span class="input-group-addon" id="cdsfeeadd">Php</span>
											<input  type="text" class=" form-control" name = "wharfage" id = "bankCharges" style="text-align: right;">
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class = "panel panel-default table-responsive">
										<table id = "itemTable" class = "table table-hover table-responsive">
											<tr  class="info">
												<td>Item Name</td>
												<td>HS Code</td>
												<td>Rate Of Duty</td>
												<td>Value in USD</td>
												<td>Insurance</td>
												<td>Freight</td>
												<td>Action</td>
											</tr>
											<tr>
											</tr>
										</table>
									</div>
								</div>

								<button  type="reset" class="btn btn-default" onclick="$('#ItemModal').modal('show');">
									Add Item  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
								</button >
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr>

		</div>
		<hr>
		<div class="form-group">

			<label class = "col-md-12 control-label">
				<button  class="btn btn-success" id = "generateDAT">
					Generate Duties And Taxes
				</button>
			</label>
			<p class = "col-md-12">Note: All fields with the '*' are required</p>
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
										<label class="control-label col-sm-3" for="phy_address">Blk/ Lot/ Street:</label>
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
<div class="modal fade" id="ItemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="$('#ItemModal').modal('hide');" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add Item</h4>
			</div>
			<div class="modal-body">
				<form class = "form-horizontal">
					<div class="form-group">
						<label class="col-md-3 control-label">Item Name</label>
						<div class="col-md-7">
							<input  type="text" class="form-control" id = "itemName">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">HS Code</label>
						<div class="col-md-7">
							<input  type="text" class="form-control" id = "HSCode">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Rate Of Duty</label>
						<div class="col-md-7">
							<input  type="text" class="form-control" id = "RateOfDuty">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Value</label>
						<div class = "col-md-7">
							<div class="input-group">
								<span class="input-group-addon" id="valuefeeadd">$</span>
								<input type="text" class="form-control"  aria-describedby="valuefeeadd" id = "Value">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Insurance</label>
						<div class = "col-md-7">
							<div class="input-group">
								<span class="input-group-addon" id="insuranceadd">$</span>
								<input type="text" class="form-control"  aria-describedby="insuranceadd" id = "Freight">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Freight</label>
						<div class = "col-md-7">
							<div class="input-group">
								<span class="input-group-addon" id="freightadd">$</span>
								<input type="text" class="form-control"  aria-describedby="freightadd" id = "Insurance">
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" id = "addItem" >Add</button>
					<input type = "reset" class = "btn btn-danger btn-md" value = "Clear" />
					<button type="button" class="btn btn-default" onclick="$('#ItemModal').modal('hide');">Close</button>
				</form>
			</div>
		</div>
	</div>
</div>


<!-- Custom Exchange Rate-->
<div class="modal fade" id="ExchangeRateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="$('#ExchangeRateModal').modal('hide');" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Select Custom Exchange Rate </h4>
			</div>
			<div class="modal-body">
				<table id = "exchangeRateTable" class = "table table-hover table-responsive">
					<tr  class="info">
						<td>Rate</td>
						<td>Date Effective</td>
						<td>Actions</td>
					</tr>
					@php
					$exchangeRate_ctr = 0;
					@endphp
					@forelse($exchange_rate as $exchange_rates)
					<tr>

						<td>
							{{ $exchange_rates->rate }}
						</td>
						<td>
							{{ date_format(date_create($exchange_rates->dateEffective), "Y-m-d")}}
						</td>
						<td>
							@php
							$exchangeRate_ctr++;
							@endphp
							<button type="button" class="btn btn-success" onclick = "$('#ExchangeRateModal').modal('hide');
							currentExchange_id = <?php echo $exchangeRate_ctr; ?>;

							if(currentExchange_id == <?php echo $currentExchange_id?>)
							{
								document.getElementById('exchangeRate').value =  {{ number_format((float)$exchange_rates->rate, 3, '.', '') }};
								$('#exchangeRate_toggle').bootstrapToggle('on')
							}
							else{
								document.getElementById('exchangeRate').value =  {{ number_format((float)$exchange_rates->rate, 3, '.', '') }};
							}"
							> Select </button>
						</td>
					</tr>
					@empty
					@endforelse
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" onclick="$('#ExchangeRateModal').modal('hide'); ">Close</button>
			</form>
		</div>
	</div>
</div>
</div>


<!-- Custom CDS Fee-->
<div class="modal fade" id="CdsFeeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="$('#CdsFeeModal').modal('hide');" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Select Custom CDS Fee </h4>
			</div>
			<div class="modal-body">
				<table id = "cdsTable" class = "table table-hover table-responsive">
					<tr  class="info">
						<td>Fee</td>
						<td>Date Effective</td>
						<td>Actions</td>
					</tr>
					@php
					$cdsFee_ctr = 0;
					@endphp
					@forelse($cds_fee as $cds_fees)
					<tr>

						<td>
							{{ $cds_fees->fee }}
						</td>
						<td>
							{{ date_format(date_create($cds_fees->dateEffective), "Y-m-d")}}
						</td>
						<td>
							@php
							$cdsFee_ctr++;
							@endphp
							<button type="button" class="btn btn-success" onclick = "$('#CdsFeeModal').modal('hide');
							currentCds_id = <?php echo $cdsFee_ctr; ?>;

							if(currentCds_id == <?php echo $currentCds_id?>)
							{
								$('#cdsFee_toggle').bootstrapToggle('on')
								document.getElementById('CDSFee').value =  '{{ number_format((float)$cds_fees->fee, 3, '.', '') }}';

							}
							else{
								document.getElementById('CDSFee').value =  '{{ number_format((float)$cds_fees->fee, 3, '.', '') }}';
							}"
							> Select </button>
						</td>
					</tr>
					@empty
					@endforelse
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" onclick="$('#CdsFeeModal').modal('hide'); ">Close</button>
			</form>
		</div>
	</div>
</div>
</div>

<!-- Custom IPF Fee-->
<div class="modal fade" id="IPFModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="$('#IPFModal').modal('hide');" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Select Custom Import Processing Fee </h4>
			</div>
			<div class="modal-body">
				<table id = "cdsTable" class = "table table-hover table-responsive">
					<tr  class="info">
						<td>Minimum Dutiable Value</td>
						<td>Maximum Dutiable Value</td>
						<td>IPF Amount</td>
						<td>Date Effective</td>
						<td>Actions</td>
					</tr>
					@php
					$Ipf_ctr = 0;
					@endphp
					@forelse($ipf_fee_header as $ipf_fee_headers)
					<tr>
						<td>
							@forelse($ipf_fee_detail as $ipf_fee_details)
							@if($ipf_fee_details->ipf_headers_id == $ipf_fee_headers->id)
							{{
							$ipf_fee_details->minimum
						}}
						@endif
					</br>
					@empty
					@endforelse
				</td>

				<td>
					@forelse($ipf_fee_detail as $ipf_fee_details)
					@if($ipf_fee_details->ipf_headers_id == $ipf_fee_headers->id)
					{{
					$ipf_fee_details->maximum
				}}
				@endif
			</br>
			@empty
			@endforelse
		</td>

		<td>
			@forelse($ipf_fee_detail as $ipf_fee_details)
			@if($ipf_fee_details->ipf_headers_id == $ipf_fee_headers->id)
			{{
			$ipf_fee_details->amount
		}}
		@endif
	</br>
	@empty
	@endforelse
</td>

<td>
	{{ date_format(date_create($cds_fees->dateEffective), "Y-m-d")}}
</td>
<td>
	@php
	$Ipf_ctr++;
	@endphp
	<button type="button" class="btn btn-success" onclick = "$('#IPFModal').modal('hide');
	currentIpf_id = <?php echo $Ipf_ctr; ?>;

	if(currentIpf_id == <?php echo $currentIpf_id?>)
	{
		$('#ipfFee_toggle').bootstrapToggle('on')
	}
	else{

	}"
	> Select </button>
</td>
</tr>
@empty
@endforelse
</table>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="$('#IPFModal').modal('hide'); ">Close</button>
</form>
</div>
</div>
</div>
</div>

</div>
</div>
@endsection

@push('styles')
<link href="/css/bootstrap-toggle.min.css" rel="stylesheet">
<style>
	.brokerage
	{
		border-left: 10px solid #2ad4a5;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush

@push('scripts')

<script src="/js/bootstrap-toggle.min.js"></script>
<script  type = "text/javascript">

	var currentExchange_id = <?php echo $currentExchange_id; ?>;
	var exchangeRate = <?php echo json_encode($exchange_rate); ?>;
	var currentCds_id = <?php echo $currentCds_id; ?>;
	var cdsFee = <?php echo json_encode($cds_fee); ?>;
	var currentIpf_id = <?php echo $currentIpf_id; ?>;
	var ipfFeeHeader = <?php echo json_encode($ipf_fee_header); ?>;
	var ipfFeeDetail = <?php echo json_encode($ipf_fee_detail); ?>;
	$('#collapse1').addClass('in');

	$('#exchangeRate_toggle').change(function() {
		var sam = $(this).prop('checked');
		if(String(sam) == "false")
		{
			$('#ExchangeRateModal').modal('show');
		}

		if(String(sam) == "true")
		{
			var currentExchange_id = <?php echo $currentExchange_id; ?>;
			document.getElementById('exchangeRate').value =  '<?php echo number_format((float)$exchange_rate[$currentExchange_id-1]->rate, 3, '.', '') ?>';
		}
	})

	$('#cdsFee_toggle').change(function() {
		var sam = $(this).prop('checked');
		if(String(sam) == "false")
		{
			$('#CdsFeeModal').modal('show');
		}

		if(String(sam) == "true")
		{
			var currentExchange_id = <?php echo $currentCds_id; ?>;
			document.getElementById('CDSFee').value =  '<?php echo number_format((float)$cds_fee[$currentCds_id-1]->fee, 3, '.', '') ?>';
		}
	})


	$('#ipfFee_toggle').change(function() {
		var sam = $(this).prop('checked');
		if(String(sam) == "false")
		{
			$('#IPFModal').modal('show');
		}

		if(String(sam) == "true")
		{
			currentIpf_id = <?php echo $currentIpf_id; ?>;
		}
	})

	$('#consignee_id').select2();

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
	});
	$(document).on('click', '.add_new_consignee', function(e){
		e.preventDefault();
		$('#chModal').modal('show');
	})

	$('#addItem').on('click', function(e){
		var table = document.getElementById('itemTable');
		var row = table.insertRow();
		var cell0 = row.insertCell(0);
		var cell1 = row.insertCell(1);
		var cell2 = row.insertCell(2);
		var cell3 = row.insertCell(3);
		var cell4 = row.insertCell(4);
		var cell5 = row.insertCell(5);
		var cell6 = row.insertCell(6);
		cell0.innerHTML = document.getElementById('itemName').value;
		cell0.contentEditable = true;
		cell1.innerHTML = document.getElementById('HSCode').value;
		cell1.contentEditable = true;
		cell2.innerHTML = document.getElementById('RateOfDuty').value;
		cell2.contentEditable = true;
		cell3.innerHTML = document.getElementById('Value').value;
		cell3.contentEditable = true;
		cell4.innerHTML = document.getElementById('Freight').value;
		cell4.contentEditable = true;
		cell5.innerHTML = document.getElementById('Insurance').value;
		cell5.contentEditable = true;
		cell6.innerHTML = "<button class = 'btn btn-danger btn-md' onclick = 'clicked(this)' >Delete</button>";

		$('#ItemModal').modal('hide');
	});

	$('#generateDAT').on('click', function(e){

		var addedItems = new Array();
		var table = document.getElementById('itemTable');
		var ctr = 0;
		localStorage.setItem("tblRowLength", table.rows.length);

		for (var r = 0, n = table.rows.length; r < n; r++) {
			for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {
				addedItems[ctr] = table.rows[r].cells[c].innerHTML;
				ctr++;
			}
		}

		localStorage.setItem("addedItems", JSON.stringify(addedItems));
		localStorage.setItem("itemCtr", ctr);

		localStorage.setItem("shipper", document.getElementById('shipper').value);
		localStorage.setItem("freightNumber", document.getElementById('freightNumber').value);
		localStorage.setItem("arrivalDate", document.getElementById('arrivalDate').value);
		localStorage.setItem("weight", document.getElementById('weight').value);
		localStorage.setItem("port", document.getElementById('port').value);
		localStorage.setItem("companyName",  document.getElementById('_ccompanyName').value);
		localStorage.setItem("freightType",  document.getElementById('FreightType').value);
		localStorage.setItem("bankCharges", document.getElementById('bankCharges').value);
		localStorage.setItem("arrastre", document.getElementById('arrastre').value);
		localStorage.setItem("wharfage", document.getElementById('wharfage').value);

		localStorage.setItem("currentExchange_id", currentExchange_id);
		localStorage.setItem("exchangeRate",  document.getElementById('exchangeRate').value);
		localStorage.setItem("currentCds_id", currentCds_id);
		localStorage.setItem("CDSFee",  document.getElementById('CDSFee').value);
		localStorage.setItem("currentIpf_id", currentIpf_id);
		localStorage.setItem("ipfFeeHeader", JSON.stringify(ipfFeeHeader));
		localStorage.setItem("ipfFeeDetail", JSON.stringify(ipfFeeDetail));

		window.location.replace("/dutiesandtaxes");

	});

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
		if($('#address').val() === ""){
			$('#address').css('border-color', 'red');
			error += "Address is required.\n";
		}
		else
		{
			$('#address').css('border-color', 'green');
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

  //currency scripts
  $(document).ready(function () {
  	$("input[type=text].currenciesOnly").on('keydown', currenciesOnly)
  	.on('blur', function () { $(this).formatCurrency(); });
  })


  var allowedSpecialCharKeyCodes = [46,8,37,39,35,36,9];
  var numberKeyCodes = [44, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105];
  var commaKeyCode = [188];
  var decimalKeyCode = [190,110];

  function numbersOnly(event) {
  	var legalKeyCode =
  	(!event.shiftKey && !event.ctrlKey && !event.altKey)
  	&&
  	(jQuery.inArray(event.keyCode, allowedSpecialCharKeyCodes) >= 0
  		||
  		jQuery.inArray(event.keyCode, numberKeyCodes) >= 0);

  	if (legalKeyCode === false)
  		event.preventDefault();
  }

  function numbersAndCommasOnly(event) {
  	var legalKeyCode =
  	(!event.shiftKey && !event.ctrlKey && !event.altKey)
  	&&
  	(jQuery.inArray(event.keyCode, allowedSpecialCharKeyCodes) >= 0
  		||
  		jQuery.inArray(event.keyCode, numberKeyCodes) >= 0
  		||
  		jQuery.inArray(event.keyCode, commaKeyCode) >= 0);

  	if (legalKeyCode === false)
  		event.preventDefault();
  }

  function decimalsOnly(event) {
  	var legalKeyCode =
  	(!event.shiftKey && !event.ctrlKey && !event.altKey)
  	&&
  	(jQuery.inArray(event.keyCode, allowedSpecialCharKeyCodes) >= 0
  		||
  		jQuery.inArray(event.keyCode, numberKeyCodes) >= 0
  		||
  		jQuery.inArray(event.keyCode, commaKeyCode) >= 0
  		||
  		jQuery.inArray(event.keyCode, decimalKeyCode) >= 0);

  	if (legalKeyCode === false)
  		event.preventDefault();
  }

  function currenciesOnly(event) {
  	var legalKeyCode =
  	(!event.shiftKey && !event.ctrlKey && !event.altKey)
  	&&
  	(jQuery.inArray(event.keyCode, allowedSpecialCharKeyCodes) >= 0
  		||
  		jQuery.inArray(event.keyCode, numberKeyCodes) >= 0
  		||
  		jQuery.inArray(event.keyCode, commaKeyCode) >= 0
  		||
  		jQuery.inArray(event.keyCode, decimalKeyCode) >= 0);

	    // Allow for $
	    if (!legalKeyCode && event.shiftKey && event.keyCode == 52)
	    	legalKeyCode = true;

	    if (legalKeyCode === false)
	    	event.preventDefault();
	}




</script>
@endpush
