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
						<hr />
						<div class = "collapse" id = "consignee_warning">
							<div class="alert alert-danger">
								<strong>Danger!</strong> No selected consignee.
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
													<td width="30%">
														Full Name
													</td>
													<td width="30%">
														Company Name
													</td>
													<td width="15%">
														Email
													</td>
													<td width="15%"> 
														Contact Number
													</td>
													<td width="10%">
														Actions
													</td>
												</tr>
											</thead>
										</table>

									</div>
									<div id="new_con" class="tab-pane fade">
										<br />
										<form class="form-horizontal" role="form">
											{{ csrf_field() }}
											<div class="form-group">
												<label class="control-label col-sm-4" for="firstName">Consignee:</label>
												<div class="col-sm-6">
													<select name = "consigneeType" id = "consigneeType" class="form-control">
														<option value = "0">
															Walk-in
														</option>
														<option value = "1">
															Regular
														</option>
													</select>
												</div>
											</div>
											<div class="form-group">
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
											<div class="form-group">
												<label class="control-label col-sm-4" for="pwd">Last Name:</label>
												<div class="col-sm-6">          
													<input type="text" class="form-control" name = "lastName" id="lastName" placeholder="Enter Last Name">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-4" for="companyName">Company Name:</label>
												<div class="col-sm-6">          
													<input type="text" class="form-control" name = "companyName" id="companyName" placeholder="Enter Company Name">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-4" for="email">Email</label>
												<div class="col-sm-6">          
													<input type="text" class="form-control" name = "email" id="email" placeholder="Enter Email Address">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-4" for="address">Address:</label>
												<div class="col-sm-6">          
													<input type="text" class="form-control" name = "address" id="address" placeholder="Enter Address">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-4" for="contactNumber">Contact Number:</label>
												<div class="col-sm-6">          
													<input type="text" class="form-control" name = "contactNumber" id="contactNumber" placeholder="Enter Contact Number">
												</div>
											</div>
											<div class="form-group">        
												<div class="col-sm-offset-5 col-sm-10">
													<input type = "submit" class = "btn btn-info btn-md" id = "btnConsigneeSave" value = "Create Consignee"/>
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
						<br />
						<h3><small>2</small>&nbsp;&nbsp;Contract Information</h3>
						<hr />
						<form class = "form-horizontal">
							<div class="form-group">
								<label class="control-label col-sm-3" for="consigneeName">Consignee:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name = "consigneeName" id="consigneeName" placeholder="Consignee Name">
								</div>
							</div>
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
					<div class = "col-md-12">
						<h3 id = "contract_rate_title"><small>3</small>&nbsp;&nbsp;Contract Rates</h3>
						<hr />
						<div class = "col-md-12" style="overflow-x: auto;">
							<div class = "panel-default">
								<div class = "collapse" id = "contract_table_warning">
									<div class="alert alert-danger">
										<strong>Danger!</strong> Requires at least one contract rate.
									</div>
								</div>
								<div class = "collapse" id = "contract_rates_warning">
									<div class="alert alert-danger">
										<strong>Danger!</strong> Something is wrong with the rates.
									</div>
								</div>
								<form id = "contract_rates_form">
									<table class="table responsive table-hover" width="100%" id= "contract_parent_table" style = "overflow-x: scroll;">
										<thead>
											<tr>
												<td width="30%">
													<strong>Area From</strong>
												</td>
												<td width="30%">
													<strong>Area To</strong>
												</td>

												<td width="30%">
													<strong>Amount</strong>
												</td>
												<td width="10%" style="text-align: center;">
													<strong>Action</strong>
												</td>
											</tr>
										</thead>
										<tr id = "contract-row">
											<td>
												<select name = "areas_id_from" id = "areas_id_from" class = "form-control area_from_valid" required = "true">
													<option></option>
													@forelse($areas as $area)
													<option value = "{{ $area->id }}">
														{{ $area->description }}
													</option>
													@empty

													@endforelse
												</select>
											</td>
											<td>
												<select name = "areas_id_to" id = "areas_id_to" class = "form-control area_to_valid" required="true">
													<option>

													</option>
													@forelse($areas as $area)
													<option value = "{{ $area->id }}">
														{{ $area->description }}
													</option>
													@empty

													@endforelse
												</select>
											</td>

											<td>
												<input type = "number" name = "amount" class = "form-control amount_valid" style="text-align: right">

											</td>
											<td style="text-align: center;x">
												<button class = "btn btn-danger btn-md delete-contract-row">x</button>
											</td>
										</tr>
									</table>
									<div class = "col-md-4">
										<button  type = "submit" style="width: 100%;" class = "btn btn-primary btn-md new-contract-row pull-left">New Rate</button>
									</div>
									<div classs = "col-md-8">

									</div>
									<br />
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<h3><small>4</small>&nbsp;&nbsp;Terms &amp; Conditions</h3>
						<hr />
						<textarea class = "form-control" style = "max-width: 100%; min-width: 100%;" placeholder="Enter Terms and Conditions . . . " name = "specificDetails" id = "specificDetails"></textarea>
					</div>
					<div class="col-md-12">
						<h3><small>5</small>&nbsp;&nbsp;Finalize</h3>
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
	var from_id = [];
	var to_id = [];

	var amount_value = [];
	var consigneeID = null;
	var from_id_descrp = [];
	var to_id_descrp = [];
	var amount_value_descrp = [];

	$(document).ready(function(){
		var contract_row = "<tr>" + $('#contract-row').html() + "</tr>";
		$('#collapse1').addClass('in');

		var cstable = $('#cs_table').DataTable({			
			responsive: true,
			"scrollX": true,
			processing: true,
			serverSide: true,
			ajax: 'http://localhost:8000/admin/csData',
			columns: [

			{ data: 'firstName' },
			{ data: 'companyName' },
			{ data: 'email' },
			{ data: 'contactNumber' },
			{ data: 'action', orderable: false, searchable: false }

			],

		});
		$.fn.dataTable.ext.errMode = 'throw';

		$(document).on('click', '.changeConsignee', function(e){
			$('#con_collapse').addClass('in');
			$('#detail_collapse').removeClass('in');
			$('#firstName').val("");
			$('#companyName').val("");
			$('#email').val("");
			$('#contactNumber').val("");

			$("#con-info-header").html('<h3 class = "con-info-header"><small>1</small>&nbsp;&nbsp;Consignee Information</h3>');
			consigneeID = null;
		})


		$('#btnConsigneeSave').on('click', function(e){
			e.preventDefault();

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
					'consigneeType' : $('#consigneeType').val(),

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
					console.log(typeof(amount));
				}
				if(typeof(amount) === "string"){
					console.log("boi");
				}
				else{
					console.log(typeof(amount));
					console.log('pak');
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
					url: '{{ route("create_contract") }}',
					data: {
						'_token' : $('input[name=_token]').val(),
						'consigneeName' : $('#consigneeName').val(),
						'dateEffective' : $('#dateEffective').val(),
						'dateExpiration' : $('#dateExpiration').val(),
						'areas_from' : from_id,
						'areas_to' : to_id,
						'from_id_descrp' : from_id_descrp,
						'to_id_descrp' : to_id_descrp,
						'amount' : amount_value,
						'consigneeID' : consigneeID,
						'specificDetails' : $('#specificDetails').val(),
					},

					success: function (data){
						window.location.replace("{{route('contracts.index')}}"+ "/" + data + "/view");
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
			amount[i].style.borderColor = 'green';
			amount_value.push(amount[i].value);
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

	from = document.getElementsByName('areas_id_from');
	to = document.getElementsByName('areas_id_to');
	amount = document.getElementsByName('amount');
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

	if($('#contract_parent_table > tbody > tr').length == 0){
		error+= "No rates";
		location.href='#contract_rate_title';
	}
	else{
		$('#contract_rates_warning').removeClass('in');
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
			amount[i].style.borderColor = 'green';
			amount_value.push(amount[i].value);
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

</script>
@endpush