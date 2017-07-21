@extends('layouts.app')
@section('content')

<div class = "row">
	<div class="col-md-10 col-md-offset-1">
		<div class = "panel-default panel">
			<div class = "panel-heading">
				@if($delivery[0]->status == 'F' || $delivery[0]->status == 'C')
				<h3>Delivery Information: <button  disabled class = "btn btn-primary btn-sm pull-right update-delivery-information" >Update Delivery Status</button></h3>
				@elseif($delivery[0]->status == 'P')
				<h3>Delivery Information: <button  class = "btn btn-primary btn-sm pull-right update-delivery-information" >Update Delivery Status</button></h3>
				@endif
			</div>
			<div class = "panel-body">
				<h4>Basic Information:</h4>
				<hr />
				<div class = "col-md-10">
					<form class="form-horizontal" role="form">
						{{ csrf_field() }}
						<div class="form-group">
							<label class="control-label col-md-5 pull-left" for="deliveryID">Delivery #:</label>
							<span class="control-label col-md-7 pull-right" id = "deliveryID">{{ $delivery[0]->id }}</span>
						</div>
						<div class="form-group">         
							<label class="control-label col-md-5 pull-left" for="deliveryDestination">Destination:</label>
							<span class="control-label col-md-7 pull-right" id ="deliveryDestination" style = "text-align: right;">{{ $delivery[0]->deliveryAddress }}</span>
						</div>
						<div class="form-group">         
							<label class="control-label col-md-5 pull-left" for="deliveryDriver">Driver:</label>
							<span class="control-label col-md-7 pull-right" id ="deliveryDriver" style = "text-align: right;">{{ $delivery[0]->driverName }}</span>
						</div>
						<div class="form-group">         
							<label class="control-label col-md-5 pull-left" for="deliveryHelper">Helper:</label>
							<span class="control-label col-md-7 pull-right" id ="deliveryHelper" style = "text-align: right;">{{ $delivery[0]->helperName }}</span>
						</div>

						<div class="form-group">        
							<label class="control-label col-md-5 pull-left" for="status">Status: </label>
							<span class="control-label col-sm-7 pull-right" id="status">
								@php
								switch($delivery[0]->status){
								case 'C': echo "Cancelled"; break;
								case 'F': echo "Finished"; break;
								case 'P': echo "Pending"; break;
								default : echo "Unknown"; break; }
								@endphp
							</span>
						</div>
					</form>
				</div>
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
					<div class="form-group">
						<label class="control-label col-sm-3" for="deliveryStatus">Delivery Status</label>
						<div class="col-sm-8"> 
							<select class = "form-control" name = "deliveryStatus" id = "deliveryStatus">
								<option value = "P">Pending</option>
								<option value = "C">Cancelled</option>
								<option value = "F">Finished</option>
							</select>
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
						<label class="control-label col-md-5 pull-left" for="containerReturnDate">Date Returned: </label>
						<div class = "col-md-7 dateReturned_view pull-left" style="text-align: left;">
							<input type = "date" name = "actutaldateReturned" id = "actutaldateReturned"  class = "form-control" disabled  required />
						</div>
					</div>
					<table class = "table table-responsive" id = "container_detail">
						<thead>
							<tr>
								<td>
									Description Of Good
								</td>
								<td>
									Gross Weight
								</td>
								<td>
									Supplier
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
	<div class="col-md-10 col-md-offset-1">
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
										Supplier
									</td>
								</tr>
							</thead>
							<tbody>
								@php
								$num = 1
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
</div>
@endif
@if($delivery[0]->withContainer == 1)
<div class = "row">
	<div class="col-md-10 col-md-offset-1">
		<div class = "panel-default panel">
			<div class = "panel-heading">
				<h3>List Of Containers: </h3>
			</div>
			<div class = "panel-body">
				<div class = "col-md-10">
					<form class="form-horizontal" role="form">
						<table id = "detail_table" class = "table table-responsive" style="width: 100%;">
							<thead>
								<tr>
									<td>

									</td>
									<td>
										Container Number
									</td>
									<td>
										Volume
									</td>
									<td>
										Status
									</td>
									<td>
										Container Return Date
									</td>
									<td>
										Actions
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
											case 'Y': echo "Returned"; break;
											case 'N': echo "Pending"; break;
											default : echo "Unknown"; break; }
											@endphp
										</span>
									</td>
									<td>
										<span class = "containerReturnDate">{{ Carbon\Carbon::parse($delivery_container->containerReturnDate)->toFormattedDateString() }}</span>
									</td>

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
</div>
<div class = "row">
	<div class="col-md-10 col-md-offset-1">
		<div class = "panel-default panel">
			<div class = "panel-heading">
				<h3>Container Contents: </h3>
			</div>
			<div class = "panel-body">
				<div class = "col-md-10">
					<form class="form-horizontal" role="form">				
						@forelse($container_with_detail as $container)
						<label class = "control-label">Container Number : {{ $container['container']->containerNumber }}</label>
						<table class = "table table-responsive" id = "{{ $container['container']->id }}_table" style="width: 100%;">
							<thead>	
								<tr>
									<td>

									</td>
									<td>
										Description of Good
									</td>
									<td>
										Gross Weight(kg)
									</td>
									<td>
										Supplier
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
</div>
@endif
<div class = "row">
	<div class = "col-md-10 col-md-offset-1">
		<div class = "col-md-8">

		</div>
		<div class = "col-md-4">
			<button class="btn btn-md btn-primary generate_delivery_receipt" style="width: 90%;">Generate Delivery Receipt</button>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
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
		$(document).on('click', '.close-container-information', function(e){
			e.preventDefault();
			$('#drModal').modal('hide');

		})
		$(document).on('click', '.save-container-information', function(e){
			e.preventDefault();
			if(con_status == "Y"){
				$('#actutaldateReturned').valid();
				if($('#actutaldateReturned').valid()){
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

		$(document).on('click', '.save-delivery-information', function(e){
			$.ajax({
				type: 'PUT',
				url: '{{ route("trucking.store") }}/{{ $so_id }}/update_delivery',
				data: {
					'_token' : $('input[name=_token]').val(),
					'status' : $('#deliveryStatus').val(),
					'delivery_head_id' : $('#deliveryID').text(),
					
				},
				success: function(data){
					window.location.replace('{{ route("trucking.store") }}/{{ $so_id}}/view');
				}	
			})
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