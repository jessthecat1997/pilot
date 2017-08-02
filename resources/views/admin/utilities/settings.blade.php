@extends('layouts.app')

@section('content')
<div class = "col-md-12">
	<div class = "panel panel-default">
		<div class = "panel-header">
			<div class = "col-md-12">
				<h3>Default Settings</h3>
			</div>
		</div>
		<div class = "panel-body">

			<div class = "col-md-10 col-md-offset-1">
				<div class = "col-md-10">
					<h4>Basic Information</h4>
					<hr />
					<form class="form-horizontal" role="form">
						{{ csrf_field() }}
						<div class="form-group required">
							<label class="control-label col-sm-3" for="com_name">Company Name:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name = "com_name" id="com_name" placeholder="Company Name" required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="com_image">Company Logo:</label>
							<div class="col-sm-8">          
								<input type="file" class="form-control" name = "com_image" id="com_image" placeholder="">
							</div>
						</div>
						<div class="form-group required">
							<label class="control-label col-sm-3" for="com_owner_firstName">First Name:</label>
							<div class="col-sm-8">          
								<input type="text" class="form-control" name = "com_owner_firstName" id="com_owner_firstName" placeholder="Enter First Name">
							</div>
						</div>
						<div class="form-group required">
							<label class="control-label col-sm-3" for="com_owner_middleName">Middle Name:</label>
							<div class="col-sm-8">          
								<input type="text" class="form-control" name = "com_owner_middleName" id="com_owner_middleName" placeholder="Enter Middle Name">
							</div>
						</div>
						<div class="form-group required">
							<label class="control-label col-sm-3" for="com_owner_lastName">Last Name:</label>
							<div class="col-sm-8">          
								<input type="text" class="form-control" name = "com_owner_lastName" id="com_owner_lastName" placeholder="Enter Last Name">
							</div>
						</div>
						<div class="form-group required">

							<label class="control-label col-sm-3">Address:</label>
							<div class="col-sm-8">
								<div class = "block">
									<div class = "col-md-6">     
										<input type="text" class="form-control" name = "com_address_roomUnitStall" id="com_address_roomUnitStall" placeholder="Room Unit Stall">
									</div>
									<div class = "col-md-6">
										<input type="text" class="form-control" name = "com_address_buildingFloor" id="com_address_buildingFloor" placeholder="Building Floor">
									</div>

									<div class = "col-md-12">
										<input type="text" class="form-control" name = "com_address_buildingName" id="com_address_buildingName" placeholder="Building Name">
									</div>
									<div class = "col-md-6">     
										<input type="text" class="form-control" name = "com_address_lotHouseNo" id="com_address_lotHouseNo" placeholder="Lot House No.">
									</div>
									<div class = "col-md-6">
										<input type="text" class="form-control" name = "com_address_street" id="com_address_street" placeholder="Street">
									</div>
									<div class = "col-md-12">
										<input type="text" class="form-control" name = "com_address_subdivision" id="com_address_subdivision" placeholder="Subdivision">
									</div>
									<div class = "col-md-12">
										<input type="text" class="form-control" name = "com_address_barangay" id="com_address_barangay" placeholder="Barangay">
									</div>

								</div>
							</div>
						</div>
						<div class="form-group required">
							<label class="control-label col-sm-3" for="com_address_province">Province:</label>
							<div class="col-sm-8">          
								<input type="text" class="form-control" name = "com_address_province" id="com_address_province" placeholder="Enter Province">
							</div>
						</div>
						<div class="form-group required">
							<label class="control-label col-sm-3" for="com_address_city">City:</label>
							<div class="col-sm-8">          
								<input type="text" class="form-control" name = "com_address_city" id="com_address_city" placeholder="Enter City">
							</div>
						</div>
						<div class="form-group required">
							<label class="control-label col-sm-3" for="com_address_zipCode">Zip Code:</label>
							<div class="col-sm-8">          
								<input type="text" class="form-control" name = "com_address_zipCode" id="com_address_zipCode" placeholder="Enter Zip Code">
							</div>
						</div>
						<div class="form-group">
							<div class = "col-md-10">

							</div>
							<div class="col-md-2">
								<button class = "btn btn-success save-settings" style="width: 100%;">Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '.save-settings', function(e){
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url:  '{{ route("settings.index") }}',
				data: {
					'_token' : $('input[name=_token]').val(),
					'com_name' : $('#com_name').val(),
					'com_image' : $('com_image').val(),
					'com_owner_firstName' : $('#com_owner_firstName').val(),
					'com_owner_middleName' : $('#com_owner_middleName').val(),
					'com_owner_lastName' : $('#com_owner_lastName').val(),
					'com_address_roomUnitStall' : $('#com_address_roomUnitStall').val(),
					'com_address_buildingFloor' : $('#com_address_buildingFloor').val(),
					'com_address_buildingName' : $('#com_address_buildingName').val(),
					'com_address_lotHouseNo' : $('#com_address_lotHouseNo').val(),
					'com_address_street' : $('#com_address_street').val(),
					'com_address_subdivision' : $('#com_address_subdivision').val(),
					'com_address_barangay' : $('#com_address_barangay').val(),
					'com_address_province' : $('#com_address_province').val(),
					'com_address_city' : $('#com_address_city').val(),
					'com_address_zipCode' : $('#com_address_zipCode').val()		
				},
				success: function (data)
				{

				}
			});

		})
	})
</script>
@endpush