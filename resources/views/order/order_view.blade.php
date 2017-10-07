@extends('layouts.app')
@section('content')
<h2>&nbsp;Order <small><strong>{{ $so_head[0]->id }}</strong></small>.</h2>
<hr>
<div class="container-fluid">
	<form>
		<div class = "row">
			<div class = "col-md-4">
				<div class="panel panel-primary">
					<div class="panel-heading heading">
						Order Information
					</div>
					<div class="panel-body">
						<div class = "form-group">
							<label class="control-label col-md-4">Name</label>
							<div class = "col-md-8">
								{{ $so_head[0]->firstName }} {{ $so_head[0]->middleName }} {{ $so_head[0]->lastName }}
							</div>
						</div>
						<br />
						<div class = "form-group">
							<label class="control-label col-md-4">Company Name</label>
							<div class = "col-md-8">
								{{ $so_head[0]->companyName }}
							</div>
						</div>
						<br />
						<div class = "form-group">
							<label class="control-label col-md-4">Billing Address</label>
							<div class = "col-md-8">
								{{ $so_head[0]->b_address }} {{ $so_head[0]->b_city }} {{ $so_head[0]->b_st_prov }}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class = "col-md-8">
				<div class="panel panel-primary" >
					<div class="panel-heading heading">
						List of Deliveries
					</div>
					<div class="panel-body">
						<div class = "form-horizontal">
							<div class = "col-md-8">
								New trucking service 
							</div>
							<div class="col-md-2">
								<button class = "btn but new_trucking btn-sm">New trucking service</button>
							</div>
						</div>
						<div class = "hidden">
							<table class = "table table-responsive table-striped cell-border table-bordered" id = "delivery_table" style="width: 100%;">
								<thead>
									<tr>
										<th>
											Origin Name
										</th>
										<th>
											Origin City
										</th>
										<th>
											Pickup Date
										</th>
										<th>
											Destination Name
										</th>
										<th>
											Destination City
										</th>
										<th>
											Delivery Date
										</th>
										<th>
											Status
										</th>
										<th>
											Actions
										</th>
									</tr>
								</thead>
							</table>
							<div>
							</div>
						</div>
					</div>

					<div class = "col-md-7 hidden">
						<div class="panel panel-primary" >
							<div class="panel-heading heading">
								List of Brokerage
							</div>
							<div class="panel-body">
								<table class = "table table-responsive table-striped cell-border table-bordered" id = "dutiesandtaxes_table">
									<thead>
										<tr>
											<td >
												ID
											</td>
											<td>
												Exchange Rate
											</td>
											<td >
												Brokerage Fee
											</td>
											<td >
												Processed By
											</td>
											<td >
												Status
											</td>
											<td >
												Actions
											</td>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</form>
	<div class="modal fade" id="confirm-create-t" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Create Bill
				</div>
				<div class="modal-body">
					Confirm Creating new Bill
				</div>
				<div class="modal-footer">

					<button class = "btn btn-primary confirm-create-so">Confirm</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	@endsection
	@push('styles')
	<style>
	.orders
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	$('#collapse1').addClass('in');

	var service_type = null;
	var so_id = {{ $so_head[0]->id }};

	$(document).ready(function(){

		$(document).on('click', '.new_trucking', function(e){
			e.preventDefault();
			$('#confirm-create-t').modal('show');
			service_type = 2;
		});

		$(document).on('click', '.confirm-create-so', function(e){
			e.preventDefault();

			
			$.ajax({

				type: 'POST',
				url: '/orders',
				data: {
					'_token' : $('input[name=_token]').val(),
					'so_headers_id' : so_id,
					'sot_type' : service_type,
				},
				success: function(data){
					alert("yay");
				}
			})

		});

	});
</script>
@endpush