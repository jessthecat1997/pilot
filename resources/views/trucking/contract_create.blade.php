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
									<tr id = "term-condition-row">
										<td>
											<textarea class = "form-control specificDetails" style = "max-width: 100%; min-width: 100%;" placeholder="Enter Terms and Conditions . . . " name = "specificDetails"></textarea>
										</td>
										<td style="text-align: center;">
											<button class = "btn btn-danger btn-md delete-term-row">x</button>
										</td>
									</tr>
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
		var term_condition_row = "<tr>" + $('#term-condition-row').html() + "</tr>";
		$('#collapse1').addClass('in');
		$('#contract-row').remove();

		var cstable = $('#cs_table').DataTable({			
			responsive: true,
			"scrollX": true,
			deferRender: true,
			processing: true,
			serverSide: true,
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
						
						'consigneeID' : consigneeID,
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

	if(consigneeID === null)
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