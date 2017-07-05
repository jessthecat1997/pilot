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
					<h4 class="modal-title">Trucking Information</h4>
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
					<button type="button" class="btn btn-success save-trucking-information" data-dismiss="modal">Save</button>
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
			processing: true,
			serverSide: true,
			ajax: '{{ route("consignee.data") }}',
			columns: [

			{ data: 'firstName' },
			{ data: 'companyName' },
			{ data: 'email' },
			{ data: 'contactNumber' },
			{ data: 'created_at' },
			{ data: 'action', orderable: false, searchable: false }

			],

		});
	})
</script>
@endpush