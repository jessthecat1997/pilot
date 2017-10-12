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
				@if( count($truckings) < 1)
				<div class="panel panel-primary" >

					<div class="panel-heading heading">
						New Trucking Service Order
					</div>
					<div class = "form-horizontal " id ="table-new-trucking">

						<button class = "btn but  btn-sm pull-right new_trucking">New Trucking Service Order</button>

					</div>

				</div>
				@else
				<div class="panel panel-primary" >
					<div class="panel-heading heading">
						List of Deliveries
					</div>
					<div class="panel-body">
						<div class = "form-horizontal ">
							<div class="col-md-12">
								<button class = "btn but view_trucking btn-sm pull-right">View Trucking Service Order</button>
							</div>
						</div>
						<br>
						<br>
						<div id = "table-trucking">
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
									</tr>
								</thead>
							</table>
							<div>
							</div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class = "row">
			<div class = "col-md-4">
				<div class="panel panel-primary" >
					<div class="panel-heading heading">
						List of Attachments
					</div>
					<div class="panel-body">
						<table class = "table table-responsive table-striped cell-border table-bordered" id = "attachments_table">
							<thead>
								<tr>
									<td>
										File Name
									</td>
									<td >
										File
									</td>
									<td >
										Remarks
									</td>
									<td >
										Action
									</td>
									
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<div class = "col-md-8">
				@if( count($brokerages) < 1)
				<div id = "table-new-brokerage">
					<div class="panel panel-primary" >

						<div class="panel-heading heading">
							New Brokerage Service Order
						</div>
						<div class="panel-body">
							<div class = "form-horizontal col-md-12 ">
								<br>
								<button class = "btn but  btn-sm pull-right new_brokerage">New Brokerage Service Order</button>
								<br>
								<br>
							</div>
						</div>
					</div>
				</div>
				@else
				<div id = "new_brokerage">
					<div class="panel panel-primary" >
						<div class="panel-heading heading">
							List of Brokerage
						</div>
						<div class="panel-body">
							<table class = "table table-responsive table-striped cell-border table-bordered"  id = "dutiesandtaxes_table">
								<thead>
									<tr>
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
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
				@endif
			</div>
			<div class = "col-md-4">
			</div>
			<div class = "col-md-8">
				<div class="panel panel-primary" >
					<div class="panel-heading heading">
						List of Billings
					</div>
					<div class="panel-body">
						<table class = "table table-responsive table-striped cell-border table-bordered" id = "billing_table">
							<thead>
								<tr>

								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<div class = "col-md-4">

			</div>
			<div class = "col-md-8">
				<div class="panel panel-primary" >
					<div class="panel-heading heading">
						List of Refundables
					</div>
					<div class="panel-body">
						<table class = "table table-responsive table-striped cell-border table-bordered" id = "refundable_table">
							<thead>
								<tr>

								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</form>
	<div class="modal fade" id="confirm-create-t" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Create Trucking Service Order
				</div>
				<div class="modal-body">
					Confirm creating trucking service order
				</div>
				<div class="modal-footer">

					<button class = "btn btn-primary confirm-create-so-t">Confirm</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="confirm-create-b" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Create Brokerage Service Order
				</div>
				<div class="modal-body">
					Confirm creating brokerage service order
				</div>
				<div class="modal-footer">

					<button class = "btn btn-primary confirm-create-so-b">Confirm</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
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
		console.log('consignee is ' + {{$so_head[0]->consignees_id}});
		$(document).on('click', '.new_trucking', function(e){
			e.preventDefault();
			$('#confirm-create-t').modal('show');
			service_type = 2;
		});

		$(document).on('click', '.new_brokerage', function(e){
			e.preventDefault();
			$('#confirm-create-b').modal('show');
			service_type = 1;
		});


		$(document).on('click', '.view_trucking', function(e){
			e.preventDefault();
			window.location.replace('{{ route("trucking.index") }}' + "/" + {{$truckings[0]->id}} + "/view");

		});

		$(document).on('click', '.confirm-create-so-b', function(e){
			e.preventDefault();
			window.location.replace('{{route("brokerageOrder")}}');
		});



		@if(count($truckings)>0)
		var delivery_table = $('#delivery_table').DataTable({
			processing: false,
			deferRender: true,
			serverSide: false,
			ajax: '{{ route("trucking.index") }}/{{$truckings[0]->id}}/get_deliveries',
			columns: [

			
			{ data: 'pickup_name' },
			{ data: 'pickup_city'},
			{ data: 'pickupDateTime'},
			{ data: 'deliver_name' },
			{ data: 'deliver_city' },
			{ data: 'deliveryDateTime'},
			{ data: 'status' },


			],	"order": [[ 0, "desc" ]],
		});

		@endif

		@if(count($brokerages)>0)
		var dutiesandtaxes_tableVar = $('#dutiesandtaxes_table').DataTable({
			processing: false,
			deferRender: true,
			serverSide: false,
			scrollX: true,
			ajax: '{{route("brokerage.index")}}/{{ brokerages[0]->id }}/get_dutiesandtaxes',
			columns: [
			{ data: 'rate'},
			{ data: 'brokerageFee'},
			{ data: 'processedBy'},
			{ data: 'statusType'},
			{ data: 'action', orderable: false, searchable: false },

			],	"order": [[ 0, "desc" ]],
		});
		@endif





		$(document).on('click', '.confirm-create-so-t', function(e){
			e.preventDefault();
			$.ajax({

				type: 'POST',
				url: '/orders/create_so_detail/',
				data: {
					'_token' : $('input[name=_token]').val(),
					'so_headers_id' : so_id,
					'sot_type' : service_type,
				},
				success: function(data){
					$('#confirm-create-t').modal('hide');
					$('#table-new-trucking').hide();
					$('#table-trucking').show();
					toastr.options = {
						"closeButton": false,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"rtl": false,
						"positionClass": "toast-bottom-right",
						"preventDuplicates": false,
						"onclick": null,
						"showDuration": 300,
						"hideDuration": 1000,
						"timeOut": 2000,
						"extendedTimeOut": 1000,
						"showEasing": "swing",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					}
					toastr["success"]("Trucking service order created successfully");
					window.location.reload();
				}
			})
		});




	});

</script>
@endpush