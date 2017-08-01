@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<h3><img src="/images/bar.png"> Maintenance | Vehicles</h3>
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
				<table class = "table-responsive table" id = "v_table">
					<thead>
						<tr>
							<td>
								Vehicle
							</td>
							<td>
								Plate Number
							</td>
							<td>
								Make
							</td>
							<td>
								Body Type
							</td>
							<td>
								LTO Date Registered
							</td>
							<td>
								Actions
							</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<section class="content">
		<form role="form" method = "POST" id="commentForm">
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
						</div>
						<div class="modal-footer">
							<input id = "btnSave_sub" type = "submit" class="btn btn-success" value = "Save" />
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>				
						</div>
					</div>
				</div>
			</div>
		</form>
		</sectio
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
									<select class = "form-control vehicle_types_id"  id = "vehicle_types_id">
									</select>
								</div>
								<div><button  id = "nvt" class = "btn btn-md btn-info new_vehicle_type pull-right" data-toggle = 'modal' data-target = "#vtModal"  >New Vehicle Type </button></div>
							</div>

							<div class="modal-body">			
								<div class="form-group required">
									<label class = "control-label">Plate Number</label>
									<input type = "text" class = "form-control" name = "plateNumber" id = "plateNumber"  />
								</div>
							</div>
							<div class="modal-body">			
								<div class="form-group required">
									<label class = "control-label">Make</label>
									<input type = "text" class = "form-control" name = "model" id = "model"  />
								</div>
							</div>
							<div class="modal-body">			
								<div class="form-group required">
									<label class = "control-label">Body Type</label>
									<input type = "text" class = "form-control" name = "bodyType" id = "bodyType" min="5"  />
								</div>
							</div>
							<div class="modal-body">			
								<div class="form-group required">
									<label class = "control-label">LTO Date Registered</label>
									<input type = "date" class = "form-control" name = "dateRegistered" id = "dateRegistered" />
								</div>
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
				<div class="modal fade" id="confirm-delete" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								Deactivate record
							</div>
							<div class="modal-body">
								Confirm Deactivating
							</div>
							<div class="modal-footer">

								<button class = "btn btn-danger	" id = "btnDelete" >Deactivate</button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</section>
	</div>
	@endsection
	@push('styles')
	<style>
		.class-vehicle
		{
			border-left: 10px solid #2ad4a5;
			background-color:rgba(128,128,128,0.1);
			color: #fff;
		}
		.maintenance
		{
			border-left: 10px solid #2ad4a5;
			background-color:rgba(128,128,128,0.1);
			color: #fff;
		}
	</style>
	@endpush
	@push('scripts')
	<script type="text/javascript">
		var data;

		var vehicle_type =[
		@forelse($vts as $vt)
		{ id: {{$vt->id}}, text:'{{ $vt->name }}' }, 
		@empty
		@endforelse
		];

		$(document).ready(function()
		{
			var vtable = $('#v_table').DataTable({
				processing: true,
				serverSide: true,
				ajax: 'http://localhost:8000/admin/vData',
				columns: [
				{ data: 'name' },
				{ data: 'plateNumber' },
				{ data: 'model' },
				{ data: 'bodyType'},
				{ data: 'dateRegistered' },
				{ data: 'action', orderable: false, searchable: false }

				],	"order": [[ 0, "desc" ]],
			});

			$.validator.addMethod("valueNotEquals", function(value, element, arg){
				return arg != value;
			}, "Value must not equal arg.");


			Inputmask("A{3} 9{4}").mask($("#plateNumber"));


			var now = new Date();

			var day = ("0" + now.getDate()).slice(-2);
			var month = ("0" + (now.getMonth() + 1)).slice(-2);

			var today = now.getFullYear()+"-"+(month)+"-"+(day) ;


			$('#dateRegistered').val(today);
			

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

			$("#commentForm").validate({
				rules: 
				{
					plateNumber:
					{
						required: true,
						maxlength: 20,
					},

					model:{
						required: true,
						minlength: 5,

					},
					dateRegistered:{
						required: true,
					},
					SelectName: 
					{ 
						valueNotEquals: "default" 
					},
					bodyType:{
						required: true,
						minlength:5,
					}
				},

				messages: 
				{
					SelectName: 
					{ 
						valueNotEquals: "Please select a vehicle type!"
					}
				}, 

				onkeyup: function(element) {$(element).valid()}, 
				submitHandler: function (form) {
					return false;
				}
			});


			$(document).on('click', '.new', function(e){
				resetErrors();
				$('#vModal-title').text('New Vehicle');
				$('#model').val("");
				$('#bodyType').val("");
				$('#dateRegistered').val("");
				$('#vModal').modal('show');

			});
			$(document).on('click', '.edit',function(e){
				resetErrors();
				data = vtable.row($(this).parents()).data();
				$('#plateNumber').val(data.plateNumber)
				$('#model').val(data.model);
				$('#bodyType').val(data.bodyType);
				$('#dateRegistered').val(data.dateRegistered);
				$('#vModal-title').text('Update Vehicle');
				$('#vModal').modal('show');
			});
			$(document).on('click', '.deactivate', function(e){
				data = vtable.row($(this).parents()).data();
				$('#confirm-delete').modal('show');
			});

			$(document).on('click', '.new_vehicle_type', function(e){
				resetErrors();
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






// Confirm Save Button
$('#btnSave').on('click', function(e){
	
	e.preventDefault();
	var title = $('#vModal-title').text();
	console.log("hihiho" + title);
	var vt_id = $('#vehicle_types_id').val();
	if(title == 'New Vehicle')
	{
		
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
				}
				
			}
			
		})
	}
	else
	{
		var vt_id = $('#vehicle_types_id').val();
		console.log(title);
		$.ajax({
			type: 'PUT',
			url:  '/admin/vehicle/' + data.plateNumber,
			data: {
				'_token' : $('input[name=_token]').val(),
				'vehicle_types_id' : vt_id,
				'plateNumber' : $('input[name=plateNumber]').val(),
				'model' : $('input[name=model]').val(),
				'dateRegistered' : $('input[name=dateRegistered]').val(),
				'bodyType' :$('input[name=bodyType]').val(),
			},
			success: function (data)
			{
				vtable.ajax.reload();
				$('#vModal').modal('hide');
				$('#model').val("");
				$('.modal-title').text('New Vehicle');
			}
		})
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



