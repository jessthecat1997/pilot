@extends('layouts.app')
@section('content')
<h2>&nbsp;Contracts</h2>
<hr>
<div class = "container-fluid">
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<div class = "col-md-12">
					<h3 id = "con-info-header"><small>1</small>&nbsp;&nbsp;Consignee Information</h3>
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
					<hr />
					<h3 id = "contract_duration_title"><small>2</small>&nbsp;&nbsp;Contract Duration</h3>
					<br />
					<div class = "collapse" id = "contract_duration_warning">
						<div class="alert alert-danger">
							<strong>Warning!</strong> Something is wrong with the duration.
						</div>
					</div>
					<form class = "form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-3" for="dateEffective">Date Effective:</label>
							<div class="col-sm-8">
								<input type="date" class="form-control" name = "dateEffective" id="dateEffective" placeholder="Enter Effective Date">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="dateExpiration">Date Expiration:</label>
							<div class="col-sm-8">
								<input type="date" class="form-control" name = "dateExpiration" id="dateExpiration" placeholder="Enter Expiration Date">
							</div>
						</div>
					</form>

					<br />
					<br />
				</div>

				<div class="col-md-12">
					<hr />
					<h3><small>3</small>&nbsp;&nbsp;Terms &amp; Conditions</h3>
					<div class = "collapse" id = "term_condition_warning">
						<div class="alert alert-danger">
							<strong>Warning!</strong> Terms and Condition(s) is required.
						</div>
					</div>
					<div class = "collapse" id = "term_condition_count_warning">
						<div class="alert alert-danger">
							<strong>Warning!</strong> Requires at least one term and condition.
						</div>
					</div>
					<div class = "col-md-12">
						<table style="width: 100%;" class="table table-responsive" id = "term_table">
							<thead>
								<tr>
									<th style="width: 95%;">
										Description
									</th>
									<th style="width: 5%; text-align: center;">
										Action
									</th>
								</tr>
							</thead>
							<tbody>
								@forelse($desc_array as $desc)

								<tr>
									<td>
										<textarea class = "form-control specificDetails"  rows = "5" style = "max-width: 100%; min-width: 100%;" placeholder="Enter Agreements . . . " name = "specificDetails">{{ substr($desc, 3, strlen($desc)) }}</textarea>
									</td>
									<td style="text-align: center;">
										<button class = "btn btn-danger btn-md delete-term-row">x</button>
									</td>
								</tr>
								@empty
								@endforelse
							</tbody>
						</table>
					</div>
					<div class="row">
						<div classs = "col-md-8">

						</div>
						<div class = "col-md-4" style="text-align: center;">
							<button  type = "submit" style="width: 100%;" class = "btn btn-primary btn-sm new-term-row pull-right">New Agreement</button>
						</div>
					</div>
				</div>
				<div class="col-md-12 ">
					<h3><small>4</small>&nbsp;&nbsp;Finalize</h3>
					<div style=" text-align: center;" class="pull-right">
						<button class = "btn btn-md btn-success finalize-contract " >&nbsp;&nbsp;&nbsp;&nbsp;Create Contract&nbsp;&nbsp;&nbsp;&nbsp;</button>

						<button class = "btn btn-md btn but  draft-contract" ">Save as Draft</button>
					</div>

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
</div> 
@endsection
@push('styles')
<style>
	.contracts
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	


	var consigneeID = null;
	
	$(document).ready(function(){

		var contract_row = "<tr>" + $('#contract-row').html() + "</tr>";
		var term_condition_row = '<tr><td><textarea class = "form-control specificDetails" style = "max-width: 100%; min-width: 100%;" placeholder="Enter Agreements . . . " name = "specificDetails"></textarea></td><td style="text-align: center;"><button class = "btn btn-danger btn-md delete-term-row">x</button></td></tr>';
		$('#collapse1').addClass('in');
		$('#contract-row').remove();

		$.fn.dataTable.ext.errMode = 'throw';

		$("#commentForm").validate({
			rules: 
			{
				description:
				{
					required: true,
					minlength: 2,
					maxlength: 50,
				},

			},


		});

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

							$("#basic-information-heading").html('<h5 id = "basic-information-heading">Basic Information <button class = "btn btn-sm btn-info changeConsignee 	pull-right">Change Consignee</button></h5>');

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

		

		

		$(document).on('click', '.delete-contract-row', function(e){
			e.preventDefault();
			$('#contract_rates_warning').removeClass('in');
			if($('#contract_parent_table > tbody > tr').length == 1){
				$(this).closest('tr').remove();
				$('#contract_table_warning').addClass('fade in');
			}
			else{
				$(this).closest('tr').remove();
			}
		})

		$(document).on('click', '.delete-term-row', function(e){
			e.preventDefault();
			$('#term_condition_count_warning').removeClass('in');
			if ($('#term_table > tbody > tr').length == 1)
			{
				$(this).closest('tr').remove();
				$('#term_condition_count_warning').addClass('fade in');
			}
			else
			{
				$(this).closest('tr').remove();			
			}
		})
		$(document).on('click', '.new-term-row', function(e){
			e.preventDefault();
			$('#term_condition_count_warning').removeClass('in');
			if(validate() === true){
				$('#term_table > tbody').append(term_condition_row);
			}

		})

		$(document).on('click', '.new-contract-row', function(e){
			e.preventDefault();
			$('#contract_table_warning').removeClass('fade in');
			if(validateContractRows() === true){
				$('#contract_parent_table').append(contract_row);
			}
		})

		

		$(document).on('click', '.finalize-contract', function(e){
			if(finalvalidateContractRows() === true){
				$.ajax({
					method: 'POST',
					url: '{{ route("create_contract") }}',
					data: {
						'_token' : $('input[name=_token]').val(),
						'consigneeName' : $('#consigneeName').val(),
						'dateEffective' : $('#dateEffective').val(),
						'dateExpiration' : $('#dateExpiration').val(),
						'isFinalize' : 1,
						'consigneeID' : consigneeID,
						'specificDetails' : terms_and_condition_string,
					},

					success: function (data){
						window.location.replace("{{route('contracts.index')}}"+ "/" + data + "/view");
					}

				})
			}
		})



		$(document).on('click', '.draft-contract', function(e){
			if(validateDraft() === true){
				$.ajax({
					method: 'POST',
					url: '{{ route("create_contract") }}',
					data: {
						'_token' : $('input[name=_token]').val(),
						'consigneeName' : $('#consigneeName').val(),
						'dateEffective' : $('#dateEffective').val(),
						'dateExpiration' : $('#dateExpiration').val(),
						'isFinalize':0,
						'consigneeID' : consigneeID,
						'specificDetails' : terms_and_condition_string,
					},

					success: function (data){
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
						toastr["success"]("Contract save as draft successfully")
					}

				})
			}
		})




	})



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

function finalvalidateContractRows()
{
	


	terms_and_condition_string = "";

	rate_pairs = [];

	terms = document.getElementsByName('specificDetails');
	error = "";

	if($('#dateEffective').val() != "" && $('#dateExpiration').val() != "")
	{
		if($('#dateExpiration').val() < $('#dateEffective').val()){
			error += "Invalid duration";
			$('#contract_duration_warning').addClass('in');
			location.href = "#contract_duration_title";
		}
		else{
			$('#contract_duration_warning').removeClass('in');
		}
	}
	else{
		error += "No date effective";
		$('#contract_duration_warning').addClass('in');
		location.href = "#contract_duration_title";
	}

	if(consigneeID == 0 || consigneeID == null)
	{
		error+= "No selected consignee";
		$('#consignee_warning').addClass('in');
		location.href='#page_title';
	}
	else{
		$('#consignee_warning').removeClass('in');
	}
	
	
	for (var i = 0; i < terms.length; i++){
		if(terms[i].value === ""){
			terms[i].style.borderColor = 'red';
			error += "Terms and Condition is required";
		}
		else{
			terms[i].style.borderColor = "green";
			terms_and_condition_string += (i + 1) + ". " + terms[i].value + "<br /><br />";
		}
	}
	console.log(terms_and_condition_string);

	
	console.log(error);
	if(error.length == 0){
		return true;

	}

	else
	{
		return false;
	}

}


function validateDraft()
{
	


	terms_and_condition_string = "";

	terms = document.getElementsByName('specificDetails');
	error = "";


	if(consigneeID == 0 || consigneeID == null)
	{
		error+= "No selected consignee";
		$('#consignee_warning').addClass('in');
		location.href='#page_title';
	}
	else{
		$('#consignee_warning').removeClass('in');
	}

	if($('#dateExpiration').val() < $('#dateEffective').val()){
		error += "Invalid duration";
		$('#contract_duration_warning').addClass('in');
		location.href = "#contract_duration_title";
	}
	else{
		$('#contract_duration_warning').removeClass('in');
	}
	
	
	for (var i = 0; i < terms.length; i++){
		if(terms[i].value === ""){
			terms[i].style.borderColor = 'red';
			error += "Terms and Condition is required";
		}
		else{
			terms[i].style.borderColor = "green";
			terms_and_condition_string += (i + 1) + ". " + terms[i].value + "<br /><br />";
		}
	}
	console.log(terms_and_condition_string);

	
	console.log(error);
	if(error.length == 0){
		return true;

	}

	else
	{
		return false;
	}

}



function validate(){
	var term = [];
	error = "";
	detail = "";
	term_descrp = document.getElementsByName('specificDetails');
	for(var i = 0; i < term_descrp.length; i++)
	{
		if(term_descrp[i].value === "")
		{
			term_descrp[i].style.borderColor = 'red';
			error += "Agreements is required";
		}
		else
		{
			term.push(term_descrp[i].value);
			detail += (i + 1) + ". " + term_descrp[i].value + "<br /><br />";
			term_descrp[i].style.borderColor = 'green';
		}
	}

	if(error.length == 0)
	{
		return true;
		console.log(detail);
	}
	else
	{
		return false;
	}
}






</script>
@endpush