@extends('layouts.app')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3><img src="/images/bar.png"> Consignee</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#chModal" style = "width: 100%;">New Consignee</button>
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
					<form class="form-horizontal" role="form">
						{{ csrf_field() }}
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
							<label class="control-label col-sm-4" for="businessStyle">Business Style: </label>
							<div class="col-sm-6">          
								<input type="text" class="form-control" name = "businessStyle" id="businessStyle" placeholder="Enter Business Style">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="TIN">TIN: </label>
							<div class="col-sm-6">          
								<input type="text" class="form-control" name = "TIN" id="TIN" placeholder="Enter TIN number">
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success save-consignee-information" data-dismiss="modal">Save</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
@push('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		var cstable = $('#cs_table').DataTable({			
			responsive: true,
			scrollX: true,
			scrollX: "100%",
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

		$(document).on('click', '.save-consignee-information', function(e){
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
	})
</script>
@endpush