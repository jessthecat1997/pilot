@extends('layouts.app')
@section('content')
<div class = "col-md-12">
	<h2>&nbsp;Orders</h2>
	<hr />
	<div class="row">
		<div class="col-md-9">

		</div>
		<div class="col-md-3">
			<button class="btn btn-info new-order" style="width: 100%;">New Order</button>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">
				List of Orders
			</div>
			<div class="panel-body">
				<table class = "table-responsive table cell-border table-striped table-bordered" id = "order_table">
					<thead>
						<tr>
							<td>
								Consignee Company
							</td>
							<td >
								Consignee Name
							</td>
							<td>
								Created at
							</td>
							<td>
								Processed By
							</td>
							<td>
								Action
							</td>
						</tr>
					</thead>
					<tbody>
						@forelse($orders as $order)
						<tr>
							<td>
								{{ $order->companyName }}
							</td>
							<td>
								{{ $order->consignee }}
							</td>

							<td>
								{{ Carbon\Carbon::parse($order->created_at)->toFormattedDateString() }}
							</td>
							<td>
								{{ $order->employee}}
							</td>
							<td>
								<button class = 'btn btn-info view_order' title = 'Manage'>Manage</button>
								<input type = 'hidden' value = '{{ $order->id }}' class = 'order-id' />
							</td>
						</tr>
						@empty
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<section class="content">
		<form role="form" method = "POST" id ="commentForm" >
			{{ csrf_field() }}
			<div class="modal fade" id="ordModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Order</h4>
						</div>
						<div class="modal-body">	
							<div class = "form-group">
								<label class = "control-label ">Consignee: </label>
								<div class = "input-group" style="width: 100%;">
									<select id = "consignee_id" class = "form-control">
										<option value = "0">Select Consignee</option>
										@forelse($consignees as $consignee)
										<option value = "{{ $consignee->id }}">{{ $consignee->firstName . " " . $consignee->lastName . " - " . $consignee->companyName }}</option>

										@empty

										@endforelse
									</select>
								</div>
							</div>		

							<div class = "form-group">
								<label class = "control-label">Name: </label>
								<div>
									<div class = "col-md-4">
										<input type = "text"  class = "form-control col-md-3" id = "_cfirstName" disabled placeholder="First Name" />
									</div>
									<div class = "col-md-4">

										<input type = "text"  class = "form-control col-md-3" id = "_cmidddleName" disabled placeholder="Middle Name" />
									</div>
									<div class = "col-md-4">

										<input type = "text"  class = "form-control col-md-3" id = "_clastName" disabled placeholder="Last Name" />
									</div>
								</div>
							</div>
							<div class = "form-group" >
								<label class = "control-label">Contact Number: </label>
								<input type = "text"  class = "form-control" id = "_ccontactNumber" disabled placeholder="Contact Number" />

							</div>
							<div class = "form-group">
								<label class = "control-label">Email: </label>
								<input type = "text"  class = "form-control" id = "_cemail" disabled placeholder="Email" />
							</div>
							<div class = "form-group">
								<label class = "control-label">Company Name</label>
								<input type = "text"  class = "form-control" id = "_ccompanyName" disabled placeholder="Company" />
							</div>


							<div class = "form-group">
								<label class = "control-label ">Business Style: </label>
								<input type = "text"  class = "form-control" id = "_cbusinessStyle" disabled placeholder="Business Style" />

							</div>
							<div class = "form-group">
								<label class = "control-label col-md-2">TIN: </label>
								<input type = "text"  class = "form-control" id = "_cTIN" disabled placeholder="TIN" />

							</div>
							<div class="form-group">
								<label class="control-label">Processed by:</label>

								<select name = "processedBy" id = "processedBy" class = "form-control">
									<option value = "0"></option>
									@forelse($employees as $employee)
									<option value = "{{ $employee->id }}">
										{{ $employee->lastName . ", " . $employee->firstName }}
									</option>
									@empty

									@endforelse
								</select>
								
							</div>
						</div>
						<div class="modal-footer">
							<button id = "btnSave" type = "button" class="btn btn-success submit">Save</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>				
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
	var consigneeID;

	$(document).ready(function(){
		$('#collapse1').addClass('in');
		var ordertable = $('#order_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			columns: [
			{ data: 'companyName' },
			{ data: 'consignee' },
			{ data: 'created_at'},
			{ data: 'employee' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 2, "asc" ]],
		});

		$(document).on('click', '.view_order', function(e){
			e.preventDefault();
			window.location.href = "{{ route('orders.index') }}/" + $(this).closest('tr').find('.order-id').val();
		})



		$(document).on('click', '.new-order', function(e){
			e.preventDefault();
			$('#ordModal').modal('show');

		})

		$(document).on('change', '#consignee_id', function(e){
			consigneeID = $('#consignee_id').val();
			console.log(consigneeID);
			if($('#consignee_id').val() != 0){
				$.ajax({
					type: 'GET',
					url: "{{ route('consignee.index')}}/" + $('#consignee_id').val() + "/getConsignee",
					data: {
						'_token' : $('input[name=_token]').val(),
					},
					success: function(data){
						if(typeof(data) == "object"){
							console.log(data);
							$('#_cfirstName').val(data[0].firstName);
							$('#_cmidddleName').val(data[0].middleName);
							$('#_clastName').val(data[0].lastName);
							$('#_ccontactNumber').val(data[0].contactNumber);
							$('#_cemail').val(data[0].email);
							$('#_ccompanyName').val(data[0].companyName);
							$('#_cbusinessStyle').val(data[0].businessStyle);
							$('#_cTIN').val(data[0].TIN);
						}
					},
					error: function(data) {
						if(data.status == 400){
							alert("Nothing found");
						}
					}
				})
			}
			else
			{
				$('#_cfirstName').val("");
				$('#_cmidddleName').val("");
				$('#_clastName').val("");
				$('#_ccontactNumber').val("");
				$('#_cemail').val("");
				$('#_ccompanyName').val("");
				$('#_cbusinessStyle').val("");
				$('#_cTIN').val("");
			}
		})

		$(document).on('click', '.submit', function(e){
			e.preventDefault();
			$('.submit').attr('disabled', 'true');
			console.log($('#consignee_id').val());
			if(validateOrder() == true)
			{
				console.log($('#consignee_id').val());
				$.ajax({
					type: 'POST',
					url: '/orders',
					data: {
						'_token' : $('input[name=_token]').val(),
						'consignees_id' : $('#consignee_id').val(),
						'processedBy' : $('#processedBy').val(),

					},
					success: function(data){
						
						if(typeof(data) == "object"){
							$('#ordModal').modal('hide');
							ordertable.ajax.url( '{{ route("order.data") }}' ).load();
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
							toastr["success"]("Record added successfully");
							$('.submit').removeAttr('disabled');
							
						}
						else
						{
							resetErrors();
							var invdata = JSON.parse(data);
							$.each(invdata, function(i, v) {
								console.log(i + " => " + v); 
								var msg = '<label class="error" for="'+i+'">'+v+'</label>';
								$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
							});
							$('.submit').removeAttr('disabled');
						}
					}
				})
			}
			else{
				$('.submit').removeAttr('disabled');	
			}
		})

		function validateOrder()
		{
			error = "";
			if(consigneeID == null || consigneeID == 0){
				error += "No selected consignee.\n";
				$('#consignee_id').css('border-color', 'red');
			}
			else{
				$('#consignee_id').css('border-color', 'green');
			}
			if($('#processedBy').val() == "0"){
				error += "No processed By";
				$('#processedBy').css('border-color', 'red');
			}
			else{
				$('#processedBy').css('border-color', 'green');
			}
			if(error.length == 0){
				return true;
			}
			else{
				console.log(error);
				return false;
			}
		}
	})

</script>
@endpush