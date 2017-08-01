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
			<h4>Basic Information</h4>
			<hr />
			<form class="form-horizontal" role="form">
				{{ csrf_field() }}
				<div class="form-group required">
					<label class="control-label col-sm-3" for="com_name">Company Name:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name = "com_name" id="com_name" placeholder="Company Name">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="com_image">Company Logo:</label>
					<div class="col-sm-8">          
						<input type="text" class="form-control" name = "com_image" id="com_image" placeholder="">
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
						<input type="text" class="form-control" name = "com_owner_middleName" id="com_owner_middleName" placeholder="Enter Company Name">
					</div>
				</div>
				<div class="form-group required">
					<label class="control-label col-sm-3" for="com_owner_lastName">Last Name:</label>
					<div class="col-sm-8">          
						<input type="text" class="form-control" name = "com_owner_lastName" id="com_owner_lastName" placeholder="Enter Business Style">
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
						<button class = "btn btn-success" style="width: 100%;">Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

'com_name',
	'com_image',
	'com_owner_firstName',
	'com_owner_middleName',
	'com_owner_lastName',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	''