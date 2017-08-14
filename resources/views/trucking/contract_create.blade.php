@extends('layouts.app')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<div class = "col-md-10 col-md-offset-1">
			<div class = "panel-default panel">
				<div class = "panel-heading">
					<h2 id = "page_title">Contracts</h2>
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
						<h3><small>4</small>&nbsp;&nbsp;Terms &amp; Conditions</h3>
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
									<tr id = "term-condition-row">
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
					<div class="col-md-12">
						<h3><small>5</small>&nbsp;&nbsp;Finalize</h3>
						<div style=" text-align: center;">
							<button class = "btn btn-md btn-success finalize-contract" style = "width: 100%;">Create Contract</button>
						</div>
					</div>
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
		border-left: 10px solid #2ad4a5;
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
		$("#consignee_id").select2('data', {id: 5, text: "HELLO"});   

		$(document).on('change', '#consignee_id', function(e){
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
							$('#collapse_1').removeClass('in');
							$('#collapse_2').addClass('in');
							$('#_firstName').val($('#firstName').val() + " " + $('#middleName').val() + " " + $('#lastName').val());
							$('#_companyName').val($('#companyName').val());
							
							cs_id = data.id;
						
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
			$('#term_table > tbody').append(term_condition_row);
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
						
						'consigneeID' : $('#consignee_id').val(),
						'specificDetails' : terms_and_condition_string,
					},

					success: function (data){
						window.location.replace("{{route('contracts.index')}}"+ "/" + data + "/view");
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

	if($('#consignee_id').val() == 0)
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
			terms_and_condition_string += (i + 1) + ". " + terms[i].value + "<br />";
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

</script>
@endpush