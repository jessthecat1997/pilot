@extends('layouts.app')
@section('content')
<h2>&nbsp;Delivery</h2>
<hr>
<div class="container-fluid">
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-heading">
				@if($delivery[0]->status == 'F' || $delivery[0]->status == 'C')
				<h3>Delivery Information: <button  disabled class = "btn btn-primary btn-sm pull-right update-delivery-information" >Update Delivery Status</button></h3>
				@elseif($delivery[0]->status == 'P')
				<h3>Delivery Information: <button  class = "btn btn-primary btn-sm pull-right update-delivery-information" >Update Delivery Status</button></h3>
				@endif
			</div>
			<div class = "panel-body">
				<div class = "col-md-6">
					<h4>Basic Information:</h4>
					<div class = "col-md-10 col-md-offset-1">
						<form class="form-horizontal" role="form">
							{{ csrf_field() }}
							<div class = "col-md-12">
								<div class="form-group">        
									<label class="control-label col-md-5" for="status">Delivery ID: </label>
									<span class="control-label col-md-7" style="text-align: left;">{{ $delivery[0]->id }}</span>
								</div>
								<div class="form-group">
									<label class="control-label col-md-5" for="status">Driver: </label>
									<span class="control-label col-md-7" style="text-align: left;">{{ $delivery[0]->driverName }}</span>
									<label class="control-label col-md-5" for="status">Helper: </label>
									<span class="control-label col-md-7" style="text-align: left;">{{ $delivery[0]->helperName }}</span>
									<label class="control-label col-md-5" for="status">Vehicle: </label>
									<span class="control-label col-md-7" style="text-align: left;">{{ $delivery[0]->plateNumber }}</span>
								</div>
								<div class="form-group">        
									<label class="control-label col-md-5" for="status">Pick-up Date: </label>
									<span class="control-label col-md-7" style="text-align: left;">{{ Carbon\Carbon::parse($delivery[0]->pickupDateTime)->format('F j, Y h:i:s A') }}</span>
									<label class="control-label col-md-5" for="status">Delivery Date: </label>
									<span class="control-label col-md-7" style="text-align: left;">{{ Carbon\Carbon::parse($delivery[0]->deliveryDateTime)->format('F j, Y h:i:s A') }}</span>
									@if($delivery[0]->status == 'C')
									<label class="control-label col-md-5" for="status">Date Cancelled: </label>
									<span class="control-label col-md-7" style="text-align: left;">{{ Carbon\Carbon::parse($delivery[0]->cancelDateTime)->format('F j, Y h:i:s A') }}</span>
									@endif
									<label class="control-label col-md-5" for="status">Status: </label>
									<span class="control-label col-sm-7" style="text-align: left;" id="status">
										@php
										switch($delivery[0]->status){
										case 'P': echo "<span class = 'label label-warning'>Pending</span>"; break;
										case 'F': echo "<span class = 'label label-success'>Finished</span>"; break;
										case 'C': echo "<span class = 'label label-danger'>Cancelled</span>"; break;
										default : echo "<span class = 'label label-default'>Unknown</span>"; break; }
										@endphp
									</span>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class = "col-md-6">
					<h4>Delivery Information:</h4>
					<div class = "col-md-12">
						<label class="control-label">Pick-up Location</label>
						<form class="form-horizontal" role="form">
							<div class="form-group">
								<label class="control-label col-md-5">Block/Lot/St : </label>
								<span class="control-label col-md-7" style="text-align: left;">{{ $delivery[0]->pick_up_address }}</span>
								<label class="control-label col-md-5">City :</label>
								<span class="control-label col-md-7" style="text-align: left;">{{ $delivery[0]->pick_up_city }}</span>
								<label class="control-label col-md-5">Province: </label>
								<span class="control-label col-md-7" style="text-align: left;">{{ $delivery[0]->pick_up_province }}</span>
							</div>
						</form>
					</div>
					<div class = "col-md-12">
						<label class="control-label">Delivery Location</label>
						<form class="form-horizontal" role="form">
							<div class="form-group">
								<label class="control-label col-md-5">Block/Lot/St : </label>
								<span class="control-label col-md-7" style="text-align: left;">{{ $delivery[0]->del_address }}</span>
								<label class="control-label col-md-5">City :</label>
								<span class="control-label col-md-7" style="text-align: left;">{{ $delivery[0]->del_city }}</span>
								<label class="control-label col-md-5">Province: </label>
								<span class="control-label col-md-7" style="text-align: left;">{{ $delivery[0]->del_province }}</span>
							</div>
						</form>
					</div>
					@if($delivery[0]->remarks != null)
					<div class = "col-md-12">
						<label class="control-label">Remarks</label>
						<form class="form-horizontal" role="form">
							<div class="form-group">
								<span class="control-label col-md-12" style="text-align: left;">{{ $delivery[0]->remarks }}</span>
							</div>
						</form>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
	<div id="deliveryModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delivery Information</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form">
						{{ csrf_field() }}
						<div class="form-group required">
							<label class="control-label col-sm-3" for="deliveryStatus">Delivery Status</label>
							<div class="col-sm-8"> 
								<select class = "form-control" name = "deliveryStatus" id = "deliveryStatus">
									<option value = "P">Pending</option>
									<option value = "C">Cancelled</option>
									<option value = "F">Finished</option>
								</select>
							</div>
						</div>
						<div class = "collapse delivery_remarks_collapse fade">
							<div class="form-group required">
								<label class="control-label col-sm-3" for="deliveryCancel">Date Cancelled</label>
								<div class="col-sm-8"> 
									<input type = "date" class = "form-control" name = "deliveryCancel" id = "deliveryCancel" />
								</div>
							</div>
							<div class="form-group required">
								<label class="control-label col-sm-3" for="deliveryRemarks">Remarks</label>
								<div class="col-sm-8"> 
									<textarea class = "form-control" name = "deliveryRemarks" id = "deliveryRemarks"></textarea>
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-success save-delivery-information" >Save</button>
					<button type="button" class="btn btn-danger close-delivery-information" data-dismiss = "modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div id="drModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Container Information</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form">
						{{ csrf_field() }}
						<div class="form-group">
							<input type = "hidden" id = "containerID" name = "containerID" />
							<label class="control-label col-md-5 pull-left" for="containerNumber">Container Number:</label>
							<strong><span class="control-label col-md-7" id = "containerNumber" style = "text-align: left;"></span></strong>
						</div>
						<div class="form-group">
							<label class="control-label col-md-5 pull-left" for="shippingLine">Shipping Line:</label>
							<strong><span class="control-label col-md-7" id = "shippingLine" style = "text-align: left;"></span></strong>
						</div>
						<div class="form-group">
							<label class="control-label col-md-5 pull-left" for="portOfCfsLocation">Port of Cfs Location:</label>
							<strong><span class="control-label col-md-7" id = "portOfCfsLocation" style = "text-align: left;"></span></strong>
						</div>
						<div class="form-group">         
							<label class="control-label col-md-5 pull-left" for="containerReturnTo">Container Return To:</label>
							<span class="control-label col-md-7 " id ="containerReturnTo"  style = "text-align: left;"></span>
						</div>
						<div class="form-group">         
							<label class="control-label col-md-5 pull-left" for="containerReturnAddress">Container Return Address:</label>
							<span class="control-label col-md-7 " id ="containerReturnAddress"  style = "text-align: left;"></span>
						</div>
						<div class="form-group">         
							<label class="control-label col-md-5 pull-left" for="status">Container Returned:</label>
							<div class = "col-md-7" style="text-align: left;">
								<div class="radio">
									<label class="radio-inline"><input type = "radio" name = "status" id = "yes" value = "Y" class = "col-md-3 pull-right checkradio"/>Yes</label>
									<label class="radio-inline"><input checked type = "radio" name = "status" id = "no" value = "N" class = "col-md-3 pull-right checkradio" />No</label>
								</div>
							</div>
						</div>
						<div class="form-group">         
							<label class="control-label col-md-5 pull-left" for="containerReturnDate">Declared Return Date:</label>
							<span class="control-label col-md-7" id ="containerReturnDate"  style = "text-align: left;"></span>
						</div>
						<div class="form-group">         
							<label class="control-label col-md-5 pull-left" for="actutaldateReturned">Date Returned:</label>
							<div class = "collapse" id = "returned_date">
								<input type="date" id = "actutaldateReturned" class="form-control" />
							</div>
							<div class = "collapse" id = "unreturned_date">
								<span class="control-label col-md-7" id ="ac_returned"  style = "text-align: left;"></span>
							</div>
						</div>

						<table class = "table table-responsive" id = "container_detail">
							<thead>
								<tr>
									<td>
										Description Of Goods
									</td>
									<td>
										Gross Weight(kg)
									</td>
									<td>
										Supplier/s
									</td>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
						<div class="form-group">         
							<label class="control-label col-md-5" style="text-align: left;" for="remarks">Remarks: </label>
							<br />
							<div class = "col-md-12">
								<textarea name = "remarks" id = "remarks"  class = "form-control" placeholder=""></textarea>
							</div>
						</div>
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-success save-container-information" >Save</button>
					<button type="button" class="btn btn-danger close-container-information" >Close</button>
				</div>
			</div>
		</div>
	</div>
	@if($delivery[0]->withContainer == 0)
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-heading">
				<h3>Delivery Details: </h3>
			</div>
			<div class = "panel-body">
				<div class = "col-md-10">
					<form class="form-horizontal" role="form">
						<table id = "detail_table" class = "table table-responsive">
							<thead>
								<tr>
									<td>

									</td>
									<td>
										Description Of Good
									</td>
									<td>
										Gross Weight(kg)
									</td>
									<td>
										Supplier/s
									</td>
								</tr>
							</thead>
							<tbody>
								@php
								$num = 1;
								@endphp
								@forelse($delivery_details as $delivery_detail)
								<tr>
									<td>
										{{ $num++ }}
									</td>
									<td>
										{{ $delivery_detail->descriptionOfGoods }}
									</td>
									<td>
										{{ $delivery_detail->grossWeight }}
									</td>
									<td>
										{{ $delivery_detail->supplier }}
									</td>
								</tr>
								@empty
								<tr>
									<td colspan="4">
										<h5>No records found.</h5>
									</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
	@endif
	@if($delivery[0]->withContainer == 1)
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-heading">
				<h3>List Of Containers: </h3>
			</div>
			<div class = "panel-body">
				<div class = "col-md-12">
					<form class="form-horizontal" role="form">
						<table id = "detail_table" class = "table table-responsive" style="width: 100%;">
							<thead>
								<tr>
									<td style="width: 5%;">

									</td>
									<td style="width: 25%;">
										Container Number
									</td>
									<td style="width: 20%;">
										Volume
									</td>
									<td style="width: 20%;">
										Status
									</td>
									<td style="width: 20%;">
										Container Return Date
									</td>
									<td style="width: 20%;">
										Date Returned
									</td>
									<td style="width: 10%;">
										Action
									</td>
								</tr>
							</thead>
							<tbody>
								@php
								$num = 1
								@endphp

								@forelse($delivery_containers as $delivery_container)
								<tr>
									<td>
										{{ $num++ }}
										<input type = "hidden" class = "containerReturnDate" value= "{{ Carbon\Carbon::parse($delivery_container->containerReturnDate)->toFormattedDateString() }}" />
										<input type = "hidden" class = "containerID" value= "{{ $delivery_container->id }}" />
										<input type = "hidden" class = "containerReturnAddress" value= "{{ $delivery_container->containerReturnAddress }}" />
										<input type = "hidden" class = "shippingLine" value= "{{ $delivery_container->shippingLine }}" />
										<input type = "hidden" class = "portOfCfsLocation" value= "{{ $delivery_container->portOfCfsLocation }}" />
										<input type = "hidden" class = "containerReturnTo" value = "{{ $delivery_container->containerReturnTo }}" />
										<input type = "hidden" class = "dateReturned" 
										value = "@if($delivery_container->dateReturned == null)
										@else
										{{ Carbon\Carbon::parse($delivery_container->dateReturned)->toFormattedDateString() }}
										@endif"
										/>
										<input type = "hidden" class = "remarks" value = "{{ $delivery_container->remarks }}" />
									</td>
									<td>
										<span class = "containerNumber">{{ $delivery_container->containerNumber }}</span>
									</td>
									<td>
										<span class = "containerVolume">{{ $delivery_container->containerVolume }}</span>
									</td>
									<td>
										<span class = "containerReturnStatus">
											@php
											switch($delivery_container->containerReturnStatus){
											case 'Y':  echo "<span class = 'label label-success'>Returned</span>"; break;
											case 'N':  echo "<span class = 'label label-warning'>Pending</span>"; break;
											default : echo "Unknown"; break; }
											@endphp
										</span>
									</td>
									<td>
										<span class = "containerReturnDate">{{ Carbon\Carbon::parse($delivery_container->containerReturnDate)->toFormattedDateString() }}</span>
									</td>
									@if($delivery_container->dateReturned != null)
									<td>
										<span class = "containerReturnDate">{{ Carbon\Carbon::parse($delivery_container->dateReturned)->toFormattedDateString() }}</span>
									</td>
									@else
									<td>
										<span class = "containerReturnDate">Unreturned</span>
									</td>
									@endif

									<td>
										<button class = "btn btn-sm btn-primary view-container-detail" value = "{{ $delivery_container->id }}">View</button>
									</td>
								</tr>
								@empty
								<tr>
									<td colspan="4">
										<h5>No records found.</h5>
									</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-heading">
				<h3>Container Contents: </h3>
			</div>
			<div class = "panel-body">
				<div class = "col-md-10 col-md-offset-1">
					<form class="form-horizontal" role="form">				
						@forelse($container_with_detail as $container)
						<label class = "control-label">Container Number : {{ $container['container']->containerNumber }}</label>
						<table class = "table table-responsive" id = "{{ $container['container']->id }}_table" style="width: 100%;">
							<thead>	
								<tr>
									<td>
										Description of Goods
									</td>
									<td>
										Gross Weight(kg)
									</td>
									<td>
										Supplier/s
									</td>
								</tr>
							</thead>
							<tbody>
								@forelse($container['details'] as $detail)
								<tr>
									<td>
										{{ $detail->descriptionOfGoods }}
									</td>
									<td>
										{{ $detail->grossWeight }}
									</td>
									<td>
										{{ $detail->supplier }}
									</td>
								</tr>
								@empty
								<tr>
									<td colspan="4">
										<h5 style="text-align: center;">No records found.</h5>
									</td>
								</tr>
								@endforelse
							</tbody>
						</table>
						@empty
						@endforelse
					</form>
				</div>
			</div>
		</div>
	</div>
	@endif
	<div class = "row">
		<div class = "col-md-10 col-md-offset-1">
			<div class = "col-md-8">

			</div>
			<div class = "col-md-4">
				<button class="btn btn-md btn-primary generate_delivery_receipt" style="width: 90%;">Print Delivery Receipt</button>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style>
	.delivery
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
	$(document).ready(function(){
		var container_status;
		var reset_container_table = $('#drModal').html();
		var return_date_html = '<span class="control-label" id ="view_return_date"  style = "text-align: left"></span>';
		var con_status = "N";
		$(document).on('click', '.view-container-detail', function(e){
			e.preventDefault();
			current_table = ($('#' + $(this).val()+ '_table > tbody').html());
			$('#drModal').html(reset_container_table);
			$('#container_detail > tbody').html(current_table);
			$('#drModal').modal('show');
			$('#containerID').val($(this).closest('tr').find(".containerID").val());
			$('#containerNumber').text($(this).closest('tr').find(".containerNumber").text());
			$('#containerReturnTo').text($(this).closest('tr').find(".containerReturnTo").val());
			$('#containerReturnAddress').text($(this).closest('tr').find(".containerReturnAddress").val());
			$('#containerReturnDate').text($(this).closest('tr').find(".containerReturnDate").val());
			$('#containerReturnTo').text($(this).closest('tr').find(".containerReturnTo").val());
			$('#shippingLine').text($(this).closest('tr').find(".shippingLine").val());
			$('#portOfCfsLocation').text($(this).closest('tr').find(".portOfCfsLocation").val());

			container_status = $(this).closest('tr').find(".containerReturnStatus").text().trim();
			console.log(container_status);

			if($(this).closest('tr').find(".dateReturned").val().trim() === ""){
				$('#remarks').val($(this).closest('tr').find(".remarks").val());
				if($(this).closest('tr').find(".containerReturnStatus").text().trim() === "Pending"){
					$('#no').attr('checked', true);

				}
				else{
					console.log(container_status);
					$('#yes').attr('checked', true);
					$('#actutaldateReturned').removeAttr('disabled');
				}
			}
			else{
				$('#yes').attr('checked', true);
				$('#yes').attr('disabled', true);
				$('#no').attr('disabled', true);
				$('.dateReturned_view').html(return_date_html);
				$('#remarks').val($(this).closest('tr').find(".remarks").val());
				$('#view_return_date').text($(this).closest('tr').find(".dateReturned").val());
			}

		})
		$(document).on('change', '#deliveryStatus', function(e){
			e.preventDefault();
			if($('#deliveryStatus').val() == "C"){
				console.log('aa');
				$('.delivery_remarks_collapse').addClass('in');
				var now = new Date();
				var day = ("0" + now.getDate()).slice(-2);
				var month = ("0" + (now.getMonth() + 1)).slice(-2);
				var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
				$('#deliveryCancel').val(today);
			}
			else
			{
				$('.delivery_remarks_collapse').removeClass('in');
			}

		})

		$(document).on('click', '.save-delivery-information', function(e){
			$.ajax({
				type: 'PUT',
				url: '{{ route("trucking.store") }}/{{ $so_id }}/update_delivery',
				data: {
					'_token' : $('input[name=_token]').val(),
					'status' : $('#deliveryStatus').val(),
					'remarks' : $('#deliveryRemarks').val(),
					'cancelDateTime' : $('#deliveryCancel').val(),
					'delivery_head_id' : {{ $delivery[0]->id }},
					
				},
				success: function(data){
					$('#deliveryModal').modal('hide');
					window.location.reload();
				}	
			})
		})

		$(document).on('click', '.close-container-information', function(e){
			e.preventDefault();
			$('#drModal').modal('hide');

		})
		$(document).on('click', '.save-container-information', function(e){
			e.preventDefault();
			if(con_status == "Y"){
				$('#actutaldateReturned').valid();
				if($('#actutaldateReturned').valid()){-
					$.ajax({
						type: 'PUT',
						url:  '{{ route("trucking.store") }}/{{ $so_id }}/update_container/' + $('#containerID').val(),
						data: {
							'_token' : $('input[name=_token]').val(),
							'containerID' : $('#containerID').val(),
							'dateReturned' : $('#actutaldateReturned').val(),
							'status' :con_status,
							'remarks' : $('#remarks').val(),

						},
						success: function (data){
							$('#drModal').modal('hide');
							window.location.reload();
						}

					})
				}
			}
			else
			{
				$.ajax({
					type: 'PUT',
					url:  '{{ route("trucking.store") }}/{{ $so_id }}/update_container/' + $('#containerID').val(),
					data: {
						'_token' : $('input[name=_token]').val(),
						'containerID' : $('#containerID').val(),
						'dateReturned' : $('#actutaldateReturned').val(),
						'status' :con_status,
						'remarks' : $('#remarks').val(),

					},
					success: function (data){
						$('#drModal').modal('hide');
						window.location.reload();
					}

				})
			}

		})

		$(document).on('change', '#yes', function(e){
			$('#actutaldateReturned').removeAttr('disabled');
			con_status = "Y";
		})
		$(document).on('change', '#no', function(e){
			$('#actutaldateReturned').attr('disabled', true);
			$('#actutaldateReturned').val('');
			con_status = "N";
		})

		$(document).on('click', '.update-delivery-information', function(e){
			e.preventDefault();
			$('#deliveryModal').modal('show');
		})



		$(document).on('click', '.generate_delivery_receipt', function(e){
			window.open("{{ route('trucking.index') }}/{{ $so_id }}/delivery/{{ $delivery[0]->id }}/show_pdf");
		})
	})


function validate_container(){
	var error = "";
	if($('#actutaldateReturned').val() === null){
		error += "Date returned is required.";
	}
}
</script>
@endpush