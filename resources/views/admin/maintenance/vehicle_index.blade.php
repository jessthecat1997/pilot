@extends('layouts.maintenance')
@push('styles')
<style>
.class-vehicle
{
	border-left: 10px solid #8ddfcc;
	background-color:rgba(128,128,128,0.1);
	color: #fff;
}
.maintenance
{
	border-left: 10px solid #8ddfcc;
	background-color:rgba(128,128,128,0.1);
	color: #fff;
}
</style>
@endpush
@section('content')
<div class = "container-fluid">
	<h2>&nbsp;Maintenance | Delivery | Vehicles</h2>
	<hr>
	<div class = "row">
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#vModal" style = "width: 100%;">New Vehicle</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table table-striped cell-border table-bordered" id = "v_table">
					<thead>
						<tr>
							<td style="width: 15%;">
								Vehicle
							</td>
							<td style="width: 15%;">
								Plate Number
							</td>
							<td style="width: 20%;">
								Make
							</td>
							<td style="width: 15%;">
								Body Type
							</td>
							<td style="width: 15%;">
								LTO Registered
							</td>
							<td style="width: 20%;">
								Actions
							</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<section class="content">
		<form role="form" method = "POST" >
			{{ csrf_field() }}
			<div class="modal fade" id="vtModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title" id = "vtModal-title">New Vehicle Type</h4>
						</div>
						<div class="modal-body">
							<div class="form-group required">
								<label class = "control-label">Name: </label>
								<input type = "text" class = "form-control" name = "name" id = "name" required />
							</div>

							<div class="form-group">
								<label class = "control-label">Description: </label>
								<textarea class = "form-control" name = "description" id = "description"></textarea>
							</div>
							<small style = "color:red; text-align: left"><i>All field(s) with (*) are required.</i></small>
						</div>
						<div class="modal-footer">
							<input id = "btnSave_sub" type = "submit" class="btn btn-success" value = "Save" />
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>				
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
	<section class="content">
		<form role="form" method = "POST" class="form-group" id = "commentForm">
			{{ csrf_field() }}
			<div class="modal fade" id="vModal" role="dialog">
				<div class="modal-dialog ">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 id="vModal-title">New Vehicle</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group required">
								<label class = "control-label">Vehicle Type</label>
								<div class="col-md-12">
									<div class="collapse in" id = "vt_collapse1">
										<select class = "form-control vehicle_types_id select2"  id = "vehicle_types_id" style="width: 100%;">
										</select>
									</div>
									<div class="collapse" id = "vt_collapse2">
										<input type="text" class="form-control" readonly= "readonly" id = "vt_name" />
									</div>
								</div>
							</div>

							<br/>
							<div><button  id = "nvt" class = "btn btn-md btn-info new_vehicle_type pull-right" data-toggle = 'modal' data-target = "#vtModal"  >New Vehicle Type </button></div>
						</div>

						<div class="modal-body">			
							<div class="form-group required">
								<label class = "control-label">Plate Number</label>
								<input type = "text" class = "form-control" name = "plateNumber" id = "plateNumber"   data-rule-required="true"/>
							</div>
						</div>
						<div class="modal-body">			
							<div class="form-group required">
								<label class = "control-label">Make</label>
								<input type = "text" class = "form-control" name = "model" id = "model"  data-rule-required="true"  />
							</div>
						</div>
						<div class="modal-body">			
							<div class="form-group required">
								<label class = "control-label">Body Type</label>
								<input type = "text" class = "form-control" name = "bodyType"  data-rule-required="true" id = "bodyType" "  />
							</div>
						</div>
						<div class="modal-body">			
							<div class="form-group required">
								<label class = "control-label">LTO Date Registered</label>
								<input type = "date" class = "form-control"   data-rule-required="true" name = "dateRegistered" id = "dateRegistered" />
							</div>
							<small style = "color:red; text-align: left"><i>All field(s) with (*) are required.</i></small>
						</div>
						<div class="modal-footer">
							<input id = "btnSave" type = "submit" class="btn btn-success submit" value = "Save" />
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>				
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>

	<section class="content">
		<form role = "form" method = "POST">
			{{ csrf_field() }}
			{{ method_field('DELETE') }}
			<div class="modal fade" id="confirm-deactivate" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							Deactivate record
						</div>
						<div class="modal-body">
							Confirm Deactivating
						</div>
						<div class="modal-footer">

							<button class = "btn btn-danger	" id = "btnDeactivate" >Deactivate</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>
<section class="content">
	<form role = "form" method = "POST">
		{{ csrf_field() }}
		{{ method_field('DELETE') }}
		<div class="modal fade" id="confirm-activate" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Activate record
					</div>
					<div class="modal-body">
						Confirm Activating
					</div>
					<div class="modal-footer">

						<button class = "btn btn-success	" id = "btnActivate" >Activate</button>
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
	$('#deliverycollapse').addClass('in');
	$('#collapse2').addClass('in');
	var data;
	var temp_plateNumber = null;
	var temp_model = null;
	var temp_bodyType = null;
	var temp = dateRegistered = null;
	var vehicle_type =[
	@forelse($vts as $vt)
	{ id: {{$vt->id}}, text:'{{ $vt->name }}' }, 
	@empty
	@endforelse
	];

	$(document).ready(function()
	{

		var vtable = $('#v_table').DataTable({
			"dom": '<"toolbar">frtip',
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: '/admin/vData',
			columns: [
			{ data: 'name' },
			{ data: 'plateNumber' },
			{ data: 'model' },
			{ data: 'bodyType'},
			{ data: 'dateRegistered' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 1, "asc" ]],
		});
		$("div.toolbar").html('<div class = "col-md-3"><input type = "checkbox" class = "check_deac"/>   Show Deactivated</div>');
		$('.check_deac').on('change', function(e)
		{
			e.preventDefault();
			if($(this).is(':checked')){
				vtable.ajax.url( '{{ route("v.data") }}/1').load();
			}
			else{
				vtable.ajax.url( '{{ route("v.data") }}').load();
			}
		})
		$('#btnDeactivate').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/vehicle/' + data.plateNumber,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					vtable.ajax.url( '{{ route("v.data") }}').load();
					$('#confirm-deactivate').modal('hide');
				}
			})
		});

		$(document).on('click', '.activate', function(e){
			data = vtable.row($(this).parents()).data();
			$('#confirm-activate').modal('show');
		});

		$('#btnActivate').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'PUT',
				url:  '/utilities/vehicle_reactivate/' + data.plateNumber,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					vtable.ajax.url( '{{ route("v.data") }}/1').load();
					$('#confirm-activate').modal('hide');
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
					toastr["success"]("Record activated successfully")
				}

			})
		});

		

		Inputmask("A{3} 9{4}").mask($("#plateNumber"));

		$("#vehicle_types_id").select2({
			data: vehicle_type,
			sorter: function(data) {
				return data.sort(function (a, b) {
					if (a.text > b.text) {
						return 1;
					}
					if (a.text < b.text) {
						return -1;
					}
					return 0;
				});
			},
		});



		$(document).on('click', '.new', function(e){
			resetErrors();
			e.preventDefault();
			$('#vt_collapse1').addClass('in');
			$('#vt_collapse2').removeClass('in');
			$('#vModal-title').text('New Vehicle');
			$('#model').val("");
			$('#bodyType').val("");
			var now = new Date();
			var day = ("0" + now.getDate()).slice(-2);
			var month = ("0" + (now.getMonth() + 1)).slice(-2);
			var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
			$('#dateRegistered').val(today);
			$('#vModal').modal('show');
			$('#plateNumber').val("");
			$('#plateNumber').removeAttr('readonly');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			$('#vt_collapse2').addClass('in');
			$('#vt_collapse1').removeClass('in');
			data = vtable.row($(this).parents()).data();
			$('#plateNumber').val(data.plateNumber)
			$('#model').val(data.model);
			$('#bodyType').val(data.bodyType);
			$('#dateRegistered').val(data.dateRegistered);
			$('#vModal-title').text('Update Vehicle');
			temp_model = data.model;
			temp_bodyType = data.bodyType;
			temp_plateNumber = data.plateNumber;
			temp_dateRegistered = data.dateRegistered;
			$('#vt_name').val(data.name);
			$('#vModal').modal('show');
			$('#plateNumber').attr('readonly', 'true');
			$('#vehicle_types_id').attr('disabled', 'true');
		});
		$(document).on('click', '.deactivate', function(e){
			data = vtable.row($(this).parents()).data();
			$('#confirm-deactivate').modal('show');
		});

		$(document).on('click', '.new_vehicle_type', function(e){
			resetErrors();
			e.preventDefault();

			$('vtModal-title').text('New Vehicle Type');
			$('#name').val("");
			$('#vtModal').modal('show');
		});





		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/vehicle/' + data.plateNumber,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					vtable.ajax.reload();
					$('#confirm-delete').modal('hide');
				}
			})
		});


		$('#btnSave').on('click', function(e){

			e.preventDefault();


			var title = $('#vModal-title').text();
			var vt_id = $('#vehicle_types_id').val();

			if(title == 'New Vehicle' && vt_id)
			{
				if($('#plateNumber').valid() && $('#model').valid() && $('#dateRegistered').valid() && $('#bodyType').valid() && $('#plateNumber').val().indexOf("_") == -1 ){
					$('#btnSave').attr('disabled', 'true');


					$.ajax({
						type: 'POST',
						url:  '/admin/vehicle',
						data: {
							'_token' : $('input[name=_token]').val(),
							'vehicle_types_id' : vt_id,
							'plateNumber' : $('input[name=plateNumber]').val(),
							'model' : $('input[name=model]').val(),
							'dateRegistered' : $('input[name=dateRegistered]').val(),
							'bodyType': $('input[name=bodyType]').val(),
						},
						success: function (data)
						{
							if(typeof(data) === "object"){
								vtable.ajax.reload();
								$('#vModal').modal('hide');
								$('#model').val("");
								$('#dateRegistered').val("");
								$('#bodyType').val("");
								$('.modal-title').text('New Vehicle');

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
								toastr["success"]("Record addded successfully");

								$('#btnSave').removeAttr('disabled');
							}else{
								resetErrors();
								var invdata = JSON.parse(data);
								$.each(invdata, function(i, v) {
									console.log(i + " => " + v); 
									var msg = '<label class="error" for="'+i+'">'+v+'</label>';
									$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
								});

								$('#btnSave').removeAttr('disabled');

							}
						},
					})

				}


			}else{


				if($('#plateNumber').valid() && $('#model').valid() && $('#dateRegistered').valid() && $('#bodyType').valid()){
					if ($('#plateNumber').val() === temp_plateNumber && $('#model').val() === temp_model && $('#dateRegistered').val() === temp_dateRegistered && $('#bodyType').val() === temp_bodyType){
						$("model").val("");
						$("#bodyType").val("");
						$('#plateNumber').val("");
						$('#btnSave').removeAttr('disabled');
						$('#vModal').modal("hide");
					}else{


						var vt_id = $('#vehicle_types_id').val();
						console.log(data.plateNumber);
						$.ajax({
							type: 'PUT',
							url:  '{{ route("vehicle.index") }}/0/' + data.plateNumber,
							data: {
								'_token' : $('input[name=_token]').val(),
								'vehicle_types_id' : vt_id,
								'plateNumber' : $('input[name=plateNumber]').val(),
								'model' : $('input[name=model]').val(),
								'dateRegistered' : $('input[name=dateRegistered]').val(),
								'bodyType' : $('input[name=bodyType]').val(),
							},
							success: function (data)
							{
								console.log(data);
								vtable.ajax.reload();
								$('#vModal').modal('hide');
								$('#model').val("");
								$('.modal-title').text('New Vehicle');


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
								toastr["success"]("Record updated successfully");
							}
						})


					}
				}




			}

		});




$('#btnSave_sub').on('click', function(e){
	e.preventDefault();

	var title = $('#vtModal-title').text();

	$('#name').valid();
	$('#description').valid();

	if(title == "New Vehicle Type")

		if($('#name').valid() && $('#description').valid()){

			$('#btnSave_sub').attr('disabled', 'true');

			$.ajax({
				type: 'POST',
				url:  '{{route("vehicletype.store")}}',
				data: {
					'_token' : $('input[name=_token]').val(),
					'name' : $('#name').val(),
					'description' : $('#description').val(),

				},
				success: function (data)
				{
					if(typeof(data) === "object"){
						var vtdata = $('#vehicle_types_id').select2('data');


						vehicle_type.push({id:data.id,text:data.name});

						$("#vehicle_types_id").select2({
							data: vehicle_type,
						});

						$('#vtModal').modal('hide');
						$('#description').val("");
						$('.modal-title').text('New Vehicle Type');
						$('#name').val("");
						$('#description').val("");
						$('#btnSave').removeAttr('disabled');




					}else{
						resetErrors();
						var invdata = JSON.parse(data);
						$.each(invdata, function(i, v) {
							console.log(i + " => " + v);
							var msg = '<label class="error" for="'+i+'">'+v+'</label>';
							$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);

						});
						$('#btnSave_sub').removeAttr('disabled');

					}
				}

			})
		}
	});


});
function resetErrors() {
	$('form input, form select').removeClass('inputTxtError');
	$('label.error').remove();
}
</script>
@endpush



