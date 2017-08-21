@extends('layouts.app')
@section('content')
<h2>&nbsp;Consignee</h2>
<hr>
<div class = "container-fluid">
	<div class = "row">
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn but btn-md new-consignee" style = "width: 100%;">New Consignee</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class="table table-responsive" id = "cs_table">
					<thead>
						<tr>
							<td width="20%">
								Full Name
							</td>
							<td width="20%">
								Company Name
							</td>
							<td width="20%">
								Email
							</td>
							<td width="10%"> 
								Contact Number
							</td>
							<td width="10%">
								Created At
							</td>
							<td width="10%">
								Actions
							</td>
						</tr>
					</thead>
				</table>
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
											<label class="control-label col-sm-3" for="phy_address">Block/Lot/Street:</label>
											<div class="col-sm-8">          
												<input type="text" class="form-control" name = "phy_address" id="phy_address" placeholder="Enter Address">
											</div>
										</div>
										<div class="form-group required">
											<label class="control-label col-sm-3" for="phy_province">Province:</label>
											<div class="col-sm-8">          
												<select name = "phy_province" id="phy_province" class = "form-control">
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
												<label class="switch">
													<input type="checkbox" class = "checkbox same_billing_address">
												</label>
											</div>
										</div>
									</div>
								</div>
								<div id="billing_address" class="tab-pane fade in ">
									<br />
									<div class = "form-horizontal">
										<div class="form-group required">
											<label class="control-label col-sm-3" for="bill_address">Address:</label>
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
	<section class="content">
		<form role = "form" method = "POST">
			{{ csrf_field() }}
			{{ method_field('DELETE') }}
			<div class="modal fade" id="confirm-delete" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							Delete record
						</div>
						<div class="modal-body">
							Confirm Deleting
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<button class = "btn btn-danger	" id = "btnDelete" >Deactivate</button>
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
	.consignee
	{
		border-left: 10px solid #8ffdcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush

@push('scripts')
<script type="text/javascript">
	$('#collapse1').addClass('in');
	$(document).ready(function(){
		var cstable = $('#cs_table').DataTable({			
			responsive: true,
			scrollX: true,
			scrollX: "100%",
			deferRender: true,
			processing: false,
			serverSide: false,
			ajax: '{{ route("consignee_get_data") }}',
			columns: [

			{ data: 'firstName' },
			{ data: 'companyName' },
			{ data: 'email' },
			{ data: 'contactNumber' },
			{ data: 'created_at' },
			{ data: 'action', orderable: false, searchable: false }

			],

		});

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

		$(document).on('click', '.edit', function(e){
			e.preventDefault();
			console.log($(this).closest('tr').find('.businessStyle').val());
			$('#chModal').modal('show');
			$('#firstName').val($(this).closest('tr').find('.firstName').val());
			$('#middleName').val($(this).closest('tr').find('.middleName').val());
			$('#lastName').val($(this).closest('tr').find('.lastName').val());
			$('#companyName').val($(this).closest('tr').find('.companyName').val());
			$('#email').val($(this).closest('tr').find('.email').val());
			$('#address').val($(this).closest('tr').find('.address').val());
			$('#contactNumber').val($(this).closest('tr').find('.contactNumber').val());
			$('#businessStyle').val($(this).closest('tr').find('.businessStyle').val());
			$('#TIN').val($(this).closest('tr').find('.TIN').val());

			$('#phy_address').val($(this).closest('tr').find('.address').val());
			$('#phy_zip').val($(this).closest('tr').find('.zip').val());
			$('#bill_address').val($(this).closest('tr').find('.b_address').val());
			$('#bill_zip').val($(this).closest('tr').find('.b_zip').val());
			
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
</script>
@endpush