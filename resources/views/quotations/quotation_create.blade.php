@extends('layouts.app')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<div class = "col-md-10 col-md-offset-1">
			<div class = "panel-default panel">
				<div class = "panel-heading">
					<h2 id = "page_title">Quotation</h2>
				</div>
				<div class = "panel-body">
					<div class = "col-md-12">
						<h3 id = "con-info-header"><small>1</small>&nbsp;&nbsp;Consignee Information</h3>
						<div class = "collapse" id = "consignee_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> No selected consignee.
							</div>
						</div>
						<div class = "panel-default">
							<div id="con_collapse" class="collapse in">
								<ul class="nav nav-tabs">
									<li><a data-toggle="tab" href="#new_con">New</a></li>
									<li class = "active"><a data-toggle="tab" href="#old_con">Old</a></li>
								</ul>

								<div class="tab-content">
									<div id="old_con" class="tab-pane fade in active">
										<br />

										<table class="table table-responsive" id = "cs_table">
											<thead>
												<tr>
													<td width="25%">
														Full Name
													</td>
													<td width="25%">
														Company Name
													</td>
													<td width="25%">
														Email
													</td>
													<td width="10%">
														Action
													</td>
												</tr>
											</thead>
										</table>

									</div>
									<div id="new_con" class="tab-pane fade">
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
											<div class="form-group required">
												<label class="control-label col-sm-4" for="email">Email</label>
												<div class="col-sm-6">          
													<input type="text" class="form-control" name = "email" id="email" placeholder="Enter Email Address">
												</div>
											</div>
											<div class="form-group required">
												<label class="control-label col-sm-4" for="address">Address:</label>
												<div class="col-sm-6">          
													<input type="text" class="form-control" name = "address" id="address" placeholder="Enter Address">
												</div>
											</div>
											<div class="form-group required">
												<label class="control-label col-sm-4" for="contactNumber">Contact Number:</label>
												<div class="col-sm-6">          
													<input type="text" class="form-control" name = "contactNumber" id="contactNumber" placeholder="Enter Contact Number">
												</div>
											</div>
											<div class="form-group">        
												<div class="col-sm-offset-5 col-sm-10">
													<button class = "btn btn-info btn-md" id = "btnConsigneeSave" >Save Consignee</button>
													<input type = "reset" class = "btn btn-danger btn-md" value = "Clear Details" />
												</div>
											</div>
										</form>	
									</div>
								</div>
							</div>
							<div id ="detail_collapse" class = "collapse">
								<form class="form-horizontal" role="form">
									{{ csrf_field() }}
									<div class="form-group">
										<label class="control-label col-sm-3" for="pwd">Full Name:</label>
										<div class="col-sm-8">          
											<input type="text" disabled class="form-control" name = "_lastName" id="_lastName" placeholder="Enter Last Name">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3" for="companyName">Company Name:</label>
										<div class="col-sm-8">          
											<input type="text" disabled class="form-control" name = "_companyName" id="_companyName" placeholder="Enter Company Name">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3" for="email">Email</label>
										<div class="col-sm-8">          
											<input type="text" disabled class="form-control" name = "_email" id="_email" placeholder="Enter Email Address">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3" for="contactNumber">Contact Number:</label>
										<div class="col-sm-8">          
											<input type="text" disabled class="form-control" name = "_contactNumber" id="_contactNumber" placeholder="Enter Contact Number">
										</div>
									</div>
								</form>	
							</div>
							
						</div>
						<br />
					</div>
					<div class = "col-md-12">
						<hr />
						<h3 id = "contract_rate_title"><small>2</small>&nbsp;&nbsp;Area Rates</h3>
						<br />
						<div class = "collapse" id = "contract_rates_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Something is wrong with the rates.
							</div>
						</div>
						<div class = "col-md-12" style="overflow-x: auto;">
							<div class = "panel-default">
								<form id = "contract_rates_form">
									<table class="table responsive table-hover" width="100%" id= "contract_parent_table" style = "overflow-x: scroll;">
										<thead>
											<tr>
												<th width="30%">
													<strong>Pickup Point</strong>
												</th>
												<th width="30%">
													<strong>Delivery Point</strong>
												</th>

												<th width="30%">
													<strong>Amount</strong>
												</th>
												<th width="10%" style="text-align: center;">
													<strong>Action</strong>
												</th>
											</tr>
										</thead>
										<tr id = "contract-row">
											<td>
												<select name = "areas_id_from" id = "areas_id_from" class = "form-control area_from_valid" required = "true">
													<option></option>
													@forelse($locations as $location)
													<option value = "{{ $location->id }}">{{ $location->name }}</option>
													@empty

													@endforelse
												</select>
											</td>
											<td>
												<select name = "areas_id_to" id = "areas_id_to" class = "form-control area_to_valid" required="true">
													<option></option>
													@forelse($locations as $location)
													<option value = "{{ $location->id }}">{{ $location->name }}</option>
													@empty

													@endforelse
												</select>
											</td>

											<td>
												<input type = "number" name = "amount" class = "form-control amount_valid" style="text-align: right">

											</td>
											<td style="text-align: center;">
												<button class = "btn btn-danger btn-md delete-contract-row">x</button>
											</td>
										</tr>
									</table>
								</form>
							</div>
						</div>
						<div class="row">
							<div class = "col-md-4">
								<button  type = "submit" style="width: 100%;" class = "btn btn-primary btn-sm new-contract-row pull-left">New Rate</button>
							</div>
							<div class = "col-md-4">

							</div>
							<div class = "col-md-4">
								<a class = "btn pull-left" data-target="#arModal" data-toggle = "modal">+ New Area</a>
							</div>
						</div>
					</div>
					<br />
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
									@forelse($term_array as $term)
									<tr id = "term-condition-row">
										<td>
											<textarea class = "form-control specificDetails" style = "max-width: 100%; min-width: 100%;" placeholder="Enter Terms and Conditions . . . " name = "specificDetails">{{ substr($term, 3, strlen($term)) }}</textarea>
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
								<button  type = "submit" style="width: 100%;" class = "btn btn-primary btn-sm new-term-row pull-right">New Term &amp; Condition</button>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<h3><small>4</small>&nbsp;&nbsp;Finalize</h3>
						<div style=" text-align: center;">
							<button class = "btn btn-md btn-success finalize-contract" style = "width: 100%;">Create Quotation</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<section class="content">
		<form role="form" method = "POST" id = "commentForm">
			{{ csrf_field() }}
			<div class="modal fade" id="arModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Area</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group required">
								<label class = "control-label">Name: </label>
								<input type = "text" class = "form-control" name = "description" id = "description"  minlength = "2" data-rule-required="true" />
								
							</div>
						</div>
						<div class="modal-footer">
							<input id = "btnSave" type = "submit" class="btn btn-success submit" value = "Save" />
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>				
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>
@endsection

@push('styles')
<style>
	.quotation
	{
		border-left: 10px solid #2ad4a5;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush

@push('scripts')
<script type="text/javascript">
	var from_id = [];
	var to_id = [];

	var amount_value = [];
	var consigneeID = null;
	var from_id_descrp = [];
	var to_id_descrp = [];
	var amount_value_descrp = [];

	$(document).ready(function(){
		var contract_row = "<tr>" + $('#contract-row').html() + "</tr>";
		var term_condition_row = '<tr><td><textarea class = "form-control specificDetails" style = "max-width: 100%; min-width: 100%;" placeholder="Enter Terms and Conditions . . . " name = "specificDetails"></textarea></td><td style="text-align: center;"><button class = "btn btn-danger btn-md delete-term-row">x</button></td></tr>';
		$('#collapse1').addClass('in');
		$('#contract-row').remove();

		var cstable = $('#cs_table').DataTable({			
			responsive: true,
			"scrollX": true,
			deferRender: true,
			processing: false,
			serverSide: false,
			ajax: 'http://localhost:8000/admin/csData',
			columns: [

			{ data: 'firstName' },
			{ data: 'companyName' },
			{ data: 'email' },
			{ data: 'action', orderable: false, searchable: false }

			],

		});
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
		$(document).on('click', '#btnSave', function(e){
			e.preventDefault();
			$('#description').valid();

			if($('#description').valid()){
				$('#btnSave').attr('disabled', 'true');
				$.ajax({
					type: 'POST',
					url:  "{{ route('area.store') }}",
					data: {
						'_token' : $('input[name=_token]').val(),
						'description' : $('input[name=description]').val(),
					},
					success: function (data)
					{
						if(typeof(data) === "object"){
							$('#description').val("");

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
							toastr["success"]("Record addded successfully");

							$('#btnSave').removeAttr('disabled');
							$('#arModal').modal('hide');
						}
						else{
							var invdata = JSON.parse(data);
							$.each(invdata, function(i, v) {
								console.log(i + " => " + v); 
								var msg = '<label class="error" for="'+i+'">'+v+'</label>';
								$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);

								$('#btnSave').removeAttr('disabled');
							});

						}
					},

				})
			}
		})

		$(document).on('click', '.changeConsignee', function(e){
			$('#con_collapse').addClass('in');
			$('#detail_collapse').removeClass('in');
			$('#firstName').val("");
			$('#companyName').val("");
			$('#email').val("");
			$('#contactNumber').val("");
			$('#businessStyle').val("");
			$('#TIN').val("");
			$("#con-info-header").html('<h3 class = "con-info-header"><small>1</small>&nbsp;&nbsp;Consignee Information</h3>');
			consigneeID = null;
		})


		$('#btnConsigneeSave').on('click', function(e){
			e.preventDefault();

			if(validateConsignee() == true){
				$.ajax({
					type: 'POST',
					url: '{{ route("consignee.store") }}',
					data: {
						'_token' : $('input[name=_token]').val(),
						'firstName' : $('#firstName').val(),
						'middleName' : $('#middleName').val(),
						'lastName' : $('#lastName').val(),
						'companyName' : $('#companyName').val(),
						'email' : $('#email').val(),
						'address' : $('#contactNumber').val(),
						'contactNumber' : $('#contactNumber').val(),
						'businessStyle' : $('#businessStyle').val(),
						'TIN' : $('#TIN').val(),

					},
					success: function (data) {
						if(typeof(data) == "object"){
							$('#collapse_1').removeClass('in');
							$('#collapse_2').addClass('in');
							$('#_firstName').val($('#firstName').val() + " " + $('#middleName').val() + " " + $('#lastName').val());
							$('#_companyName').val($('#companyName').val());

							cs_id = data.id;

							switch ($('#consigneeType').val()){
								case "0":
								$('#_consigneeType').val("Walk-in");
								break;
								case "1":
								$('#_consigneeType').val("Regular");
							}
							$('#_email').val($('#email').val());
							$('#_contactNumber').val($('#contactNumber').val());

							$("#con-info-header").html('<h3 class = "con-info-header"><small>1</small>&nbsp;&nbsp;Consignee Information<button class="btn btn-info pull-right changeConsignee">Change Consignee</button></h3>');

							cstable.ajax.reload();
							$('#firstName').val("");
							$('#middleName').val("");
							$('#lastName').val("");
							$('#companyName').val("");
							$('#email').val("");
							$('#address').val("");
							$('#contactNumber').val("");
							$('#detail_collapse').addClass('in');
							$('#con_collapse').removeClass('in');

							$('#_lastName').val(data.firstName + ' ' + data.middleName + ' ' + data.lastName);
							consigneeID = data.id;
							$('#consignee_warning').removeClass('in');
						}	
					}
				})
			}
		});

		$(document).on('click', '.selectConsignee' ,function(e){
			consigneeID = $(this).val();
			$('#con_collapse').removeClass('in');
			$('#detail_collapse').addClass('in');
			var cs_id = $(this).val();
			data = cstable.row($(this).parents()).data();
			$('#_lastName').val(data.firstName);
			$('#consigneeName').val(data.firstName);
			$('#_companyName').val(data.companyName);
			$('#_email').val(data.email);
			$('#_contactNumber').val(data.contactNumber);

			$("#con-info-header").html('<h3 class = "con-info-header"><small>1</small>&nbsp;&nbsp;Consignee Information<button class="btn btn-info pull-right changeConsignee">Change Consignee</button></h3>');
			$('#consignee_warning').removeClass('in');
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
			$('#term_table > tbody').append(term_condition_row);
		})

		$(document).on('click', '.new-contract-row', function(e){
			e.preventDefault();
			$('#contract_table_warning').removeClass('fade in');
			if(validateContractRows() === true){
				$('#contract_parent_table').append(contract_row);
			}
		})

		$(document).on('change', '.area_from_valid', function(e){
			$(".area_from_valid").each(function(){
				if($(this).val() != ""){
					$(this).css('border-color', 'green');
				}
				else{
					$(this).css('border-color', 'red');
				}
			});
		})

		$(document).on('change', '.area_to_valid', function(e){
			$(".area_to_valid").each(function(){
				if($(this).val() != ""){
					$(this).css('border-color', 'green');
				}
				else{
					$(this).css('border-color', 'red');
				}
			});
		})

		$(document).on('keypress', '.amount_valid', function(e){
			$(".amount_valid").each(function(){
				try{
					var amount = parseFloat($(this).val());
				}
				catch(err){
					
				}
				if(typeof(amount) === "string"){
					
				}
				else{

				}
				if($(this).val() != ""){
					$(this).css('border-color', 'green');
				}
				else{
					$(this).css('border-color', 'red');
				}
			});
		})

		$(document).on('click', '.finalize-contract', function(e){
			if(finalvalidateContractRows() === true){
				$.ajax({
					method: 'POST',
					url: '{{ route("quotation.index") }}',
					data: {
						'_token' : $('input[name=_token]').val(),
						'areas_from' : from_id,
						'areas_to' : to_id,
						'from_id_descrp' : from_id_descrp,
						'to_id_descrp' : to_id_descrp,
						'amount' : amount_value,
						'consignees_id' : consigneeID,
						'specificDetails' : terms_and_condition_string,
					},

					success: function (data){
						window.location.replace("{{ route('quotation.index') }}/" + data.id);
					}

				})
			}
		})


	})

function validateContractRows()
{
	from_id = [];
	to_id = [];
	cv_id = [];
	amount_value = [];

	from_id_descrp = [];
	to_id_descrp = [];
	cv_id_descrp = [];
	amount_value_descrp = [];

	rate_pairs = [];

	from = document.getElementsByName('areas_id_from');
	to = document.getElementsByName('areas_id_to');
	amount = document.getElementsByName('amount');
	error = "";

	for(var i = 0; i < from.length; i++){
		if(from[i].value === "")
		{
			from[i].style.borderColor = 'red';	
			error += "From Required.";
		}

		else
		{
			from[i].style.borderColor = 'green';
			from_id_descrp.push(from[i].options[from[i].selectedIndex].text);
			from_id.push(from[i].value);
		}
		if(to[i].value === "")
		{
			to[i].style.borderColor = 'red';
			error += "To Required.";
		}

		else
		{
			to[i].style.borderColor = 'green';
			to_id_descrp.push(to[i].options[to[i].selectedIndex].text);
			to_id.push(to[i].value);
		}

		if(amount[i].value === "")
		{
			amount[i].style.borderColor = 'red';
			error += "Amount Required.";
		}

		else
		{
			if(amount[i].value < 0){
				amount[i].style.borderColor = 'red';
				error += "Amount Required.";
			}
			else{
				amount[i].style.borderColor = 'green';
				amount_value.push(amount[i].value);
			}
		}

		if(from[i].value === to[i].value){
			from[i].style.borderColor = 'red';
			to[i].style.borderColor = 'red';
			error += "Same.";
		}

		pair = {
			from: from[i].value,
			to : to[i].value
		};
		rate_pairs.push(pair);
	}

	var i, j, n;
	found = false;
	n = rate_pairs.length;

	for (i=0; i<n; i++) {                        
		for (j=i+1; j<n; j++)
		{              
			if (rate_pairs[i].from === rate_pairs[j].from && rate_pairs[i].to === rate_pairs[j].to){
				found = true;
				from[i].style.borderColor = 'red';
				to[i].style.borderColor = 'red';

				from[j].style.borderColor = 'red';
				to[j].style.borderColor = 'red';
			}
		}	
	}
	if(found == true){
		error+= "Existing rate.";
	}

	//Final validation
	if(error.length == 0){
		return true;
	}

	else
	{
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
	from_id = [];
	to_id = [];
	cv_id = [];
	amount_value = [];

	from_id_descrp = [];
	to_id_descrp = [];
	cv_id_descrp = [];
	amount_value_descrp = [];

	terms_and_condition_string = "";

	rate_pairs = [];

	from = document.getElementsByName('areas_id_from');
	to = document.getElementsByName('areas_id_to');
	amount = document.getElementsByName('amount');
	terms = document.getElementsByName('specificDetails');
	error = "";


	if(consigneeID === null)
	{
		error+= "No selected consignee";
		$('#consignee_warning').addClass('in');
		location.href='#page_title';
	}
	else{
		$('#consignee_warning').removeClass('in');
	}

	
	for(var i = 0; i < from.length; i++){


		if(from[i].value === "")
		{
			from[i].style.borderColor = 'red';	
			error += "From Required.";
			$('#contract_rates_warning').addClass('in');
		}

		else
		{
			from[i].style.borderColor = 'green';
			from_id_descrp.push(from[i].options[from[i].selectedIndex].text);
			from_id.push(from[i].value);
		}
		if(to[i].value === "")
		{
			to[i].style.borderColor = 'red';
			error += "To Required.";
			$('#contract_rates_warning').addClass('in');
		}

		else
		{
			to[i].style.borderColor = 'green';
			to_id_descrp.push(to[i].options[to[i].selectedIndex].text);
			to_id.push(to[i].value);
		}

		if(amount[i].value === "")
		{
			amount[i].style.borderColor = 'red';
			error += "Amount Required.";
			$('#contract_rates_warning').addClass('in');
		}

		else
		{
			if(amount[i].value < 0){
				amount[i].style.borderColor = 'red';
				error += "Amount Required.";
			}
			else{
				amount[i].style.borderColor = 'green';
				amount_value.push(amount[i].value);
			}
		}

		if(from[i].value === to[i].value){
			from[i].style.borderColor = 'red';
			to[i].style.borderColor = 'red';
			error += "Same.";
			$('#contract_rates_warning').addClass('in');
		}	

		pair = {
			from: from[i].value,
			to : to[i].value
		};
		rate_pairs.push(pair);
	}

	var i, j, n;
	found= false;
	n=rate_pairs.length;

	for (i=0; i<n; i++) {                        
		for (j=i+1; j<n; j++)
		{              
			if (rate_pairs[i].from === rate_pairs[j].from && rate_pairs[i].to === rate_pairs[j].to){
				found = true;
				from[i].style.borderColor = 'red';
				to[i].style.borderColor = 'red';

				from[j].style.borderColor = 'red';
				to[j].style.borderColor = 'red';
			}
		}	
	}

	for (var i = 0; i < terms.length; i++){
		if(terms[i].value === ""){
			terms[i].style.borderColor = 'red';
			error += "Terms and Condition is required";
		}
		else{
			terms[i].style.borderColor = "green";
			terms_and_condition_string += (i + 1) + ". " + terms[i].value + "<br />";
		}
	}
	console.log(terms_and_condition_string);

	if(found == true){
		error+= "Existing rate.";
		$('#contract_rates_warning').addClass('in');
	}
	console.log(error);
	if(error.length == 0){
		return true;

	}

	else
	{
		return false;
	}

}

</script>
@endpush