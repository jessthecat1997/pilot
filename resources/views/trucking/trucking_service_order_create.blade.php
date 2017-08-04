@extends('layouts.app')
@section('content')
<div class = "row">
	<div class = "col-md-10 col-md-offset-1">
		<div class = "panel default-panel">
			<div class = "panel-heading">
				<h3>New Trucking Service Order</h3>
				<hr />
			</div>
			<div class = "panel-body">
				<div class="panel-heading">
					<h4 id = "basic-information-heading"><small>1</small> Consignee Information</h4>
				</div>

				<div class="panel-body">
					<div>
						<div class = "collapse in" id = "collapse_1">

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
												<td width="20%">
													Full Name
												</td>
												<td width="30%">
													Company Name
												</td>
												<td width="20%">
													Email
												</td>
												<td width="10%">
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
										<div class = "collapse">
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
										</div>
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
												<input type = "submit" class = "btn btn-info btn-md" id = "btnConsigneeSave" value = "Create Consignee"/>
												<input type = "reset" class = "btn btn-danger btn-md" value = "Clear Details" />
											</div>
										</div>
									</form>	
								</div>
							</div>
						</div>
						<div class = "collapse" id = "collapse_2">
							<div class = "col-md-12">
								<div class = "row">
									<form class="form-horizontal" >
										{{ csrf_field() }}
										<div class="form-group">
											<label class="control-label col-sm-4" for="_firstName">Full Name:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" disabled name = "_firstName" id="_firstName" placeholder="Enter First Name">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-4" for="_companyName">Company Name: </label>
											<div class="col-sm-6">
												<input type="text" class="form-control"  disabled name = "_companyName" id="_companyName" placeholder="Enter First Name">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-4" for="_consigneeType">Customer:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" disabled name = "_consigneeType" id="_consigneeType" placeholder="Enter First Name">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-4" for="_email">Email:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" disabled name = "_email" id="_email" placeholder="Enter First Name">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-4" for="_contactNumber">Contact Number:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" disabled name = "_contactNumber" id="_contactNumber" placeholder="Enter First Name">
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class = "panel-heading">
					<h4><small>2</small> Trucking Information</h4>
				</div>
				<form class="form-horizontal" role="form">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="control-label col-sm-4" for="noOfDeliveries">Processed by:</label>
						<div class="col-sm-6">          
							<select name = "processedBy" id = "processedBy" class = "form-control">
								<option></option>
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
				<br />
				<br />
				<button class = "btn btn-md btn-success create-trucking-so" style="width: 100%;">Create Trucking Service Order</button>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style>
	.delivery
	{
		border-left: 10px solid #2ad4a5;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>

@push('scripts')
<script type="text/javascript">
	$('#collapse1').addClass('in');
	var data;
	var cs_id;
	$(document).ready(function(){
		var cstable = $('#cs_table').DataTable({			
			responsive: true,
			scrollX: true,
			scrollX: "100%",
			processing: false,
			deferRender: true,
			serverSide: false,
			ajax: '{{ route("consignee.data") }}',
			columns: [

			{ data: 'firstName' },
			{ data: 'companyName' },
			{ data: 'email' },
			{ data: 'contactNumber' },
			{ data: 'action', orderable: false, searchable: false }

			],

		});
		
		$(document).on('click', '.selectConsignee' ,function(e){
			$('#collapse_1').removeClass('in');
			$('#collapse_2').addClass('in');
			data = cstable.row($(this).parents()).data();
			cs_id = data.id;
			$('#_firstName').val(data.firstName);
			$('#_companyName').val(data.companyName);
			$('#_consigneeType').val(data.consigneeType);
			$('#_email').val(data.email);
			$('#_contactNumber').val(data.contactNumber);


			$("#basic-information-heading").html('<h4 id = "basic-information-heading"><small>1</small> Consignee Information<button class = "btn btn-sm btn-info changeConsignee 	pull-right">Change Consignee</button></h4>');
		})

		$(document).on('click', '.panel-title' , function(e){
			if($('#_firstName').val() == ""){

				$('#collapse_1').addClass('in');
				$('#collapse_2').removeClass('in');

			}

		})

		$(document).on('click', '.changeConsignee', function(e){
			$('#collapse_1').addClass('in');
			$('#collapse_2').removeClass('in');
			$('#_firstName').val("");
			$('#_companyName').val("");
			$('#_consigneeType').val("");
			$('#_email').val("");
			$('#_contactNumber').val("");


			$("#basic-information-heading").html('<h4 id = "basic-information-heading"><small>1</small> Consignee Information</h4>');

		})

		$(document).on('click', '.create-trucking-so', function(e){
			$.ajax({
				type: 'POST',
				url: '{{ route("trucking.store") }}',
				data: {
					'_token' : $('input[name=_token]').val(),
					'cs_id' : cs_id,
					'shippingLine' : $('#shippingLine').val(),
					'destination' : $('#destination').val(),
					'portOfCfsLocation' : $('#portOfCfsLocation').val(),
					'processedBy' : $('#processedBy').val(),
					
				},
				success: function(data){
					if(typeof(data) == "object"){
						window.location.replace('{{ route("trucking.index") }}' + "/" + data.id + "/view");
					}
				}
			})
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

							$("#basic-information-heading").html('<h5 id = "basic-information-heading">Basic Information <button class = "btn btn-sm btn-info changeConsignee 	pull-right">Change Consignee</button></h5>');

							cstable.ajax.reload();
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
		});
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
</script>
@endpush