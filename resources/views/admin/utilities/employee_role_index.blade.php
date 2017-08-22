@extends('layouts.utilities')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3><img src="/images/bar.png"> Utilities | Employee Role</h3>
		<hr>
	</div>
	<div class = "row">
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#roleModal" style = "width: 100%;">New Role</button>
		</div>
	</div>
	<br />
	<div class = "container-fluid">
		<div class = "row">
			<div class = "col-md-10 col-md-offset-1">
				<div class = "panel-default panel">
					<div class = "panel-heading">
						<h3>Employee Roles</h3>
						<h4>{{ $data->firstName . " " . "$data->lastName" }}</h4>
					</div>
					<div class = "panel-body">
						<table class = "table-responsive table" id = "role_table">
							<thead>
								<tr>
									<td>
										Role
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
		</div>
	</div>

	<section class="content">
		<form role="form" method = "POST">
			{{ csrf_field() }}
			<div class="modal fade" id="roleModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="roleModal-title">New Role</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group required">
								<label class = "control-label">Role</label>
								<select name =  "employee_types_id" id = "employee_types_id" class = "form-control">
									<option>
										
									</option>
									@forelse($employee_types as $employee_type)
									<option value = "{{ $employee_type->id }} ">
										{{ $employee_type->name }}
									</option>
									@empty
									@endforelse
								</select>
							</div>
							<div class = "form-group">
								<button  id = "new_et" class = " new_et btn btn-md btn-info pull-right" data-toggle = 'modal' data-target = "#etModal"  >New employee type </button>
								<br>
							</div>	
						</div>
						<div class="modal-footer">
							<input id = "btnSave" type = "submit" class="btn btn-success" value = "Save" />
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>				
						</div>

					</div>
				</div>
			</div>
		</form>
	</section>
	<section class="content">
		<form role="form" method = "POST" id="commentForm">
			{{ csrf_field() }}
			<div class="modal fade" id="etModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Employee Type</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group required">
								<label class = "control-label">Name: </label>
								<input type = "text" class = "form-control" name = "name" id = "name"  required />
							</div>
							<div class="form-group">
								<label class = "control-label">Description: </label>
								<textarea class = "form-control" name = "description" id = "description"></textarea>
							</div>
						</div>
						<div class="modal-footer">
							<input id = "btnSave_et" type = "submit" class="btn btn-success" value = "Save" />
							<button class = "btn btn-danger	" data-dismiss= "modal">Close</button>				
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
							Deactivate
						</div>
						<div class="modal-body">
							Confirm Deactivating
						</div>
						<div class="modal-footer">
							<button class = "btn btn-danger	" id = "btnDelete" >Deactivate</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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
	.utilities
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
	$(document).ready(function(){
		var emtable = $('#role_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '/admin/emp_roleData/{{ $employee_id }}/data',
			columns: [

			{ data: 'name' },
			{ data: 'action', orderable: false, searchable: false }

			]
		});


		$("#commentForm").validate({
			rules: 
			{
				name:
				{
					required: true,
					minlength: 3,
					maxlength: 50,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},
					regex: /^[A-Za-z0-9  ]+$/,
				},

				description:
				{
					maxlength: 150,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},
					regex: /^[A-Za-z0-9.,  ]+$/,
				},

			},
			onkeyup: function(element) {$(element).valid()}, 
		});


		$(document).on('click', '.new_et', function(e){
			e.preventDefault();
			resetErrors();
			$('#etModal').modal('show');

		});


		$(document).on('click', '.new', function(e){
			e.preventDefault();
			resetErrors();
			$('.roleModal-title').text('New Role');
			$('#roleModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			e.preventDefault();
			resetErrors();
			var ch_id = $(this).val();
			data = emtable.row($(this).parents()).data();
			$('.roleModal-title').text('Edit Employee Details');
			$('#roleModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			e.preventDefault();
			var ch_id = $(this).val();
			data = emtable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});


		$('#btnSave_et').on('click', function(e){
			e.preventDefault();
			var title = $('.modal-title').text();

			$('#name').valid();
			$('#description').valid();

			if(title == "New Employee Type")
			{
				if($('#name').valid() && $('#description').valid()){

					$('#btnSave').attr('disabled', 'true');

					$.ajax({
						type: 'POST',
						url:  '/utilities/employee_type',
						data: {
							'_token' : $('input[name=_token]').val(),
							'name' : $('#name').val(),
							'description' : $('#description').val(),
						},
						success: function (data)
						{
							if(typeof(data) === "object"){
								$('#employee_types_id').append($('<option>', {
									value: data.id,
									text: data.name
								}));
								$('#employee_types_id').val(data.id);
								$('#etModal').modal('hide');
								$('#description').val("");
								$('#name').val("");
								$('.modal-title').text('New Employee Type');


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


							}
							else{
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
			}
		});





// Confirm Delete Button
$('#btnDelete').on('click', function(e){
	e.preventDefault();
	$.ajax({
		type: 'DELETE',
		url:  '/utilities/employee/{{ $employee_id }}/view/' + data.id,
		data: {
			'_token' : $('input[name=_token').val()
		},
		success: function (data)
		{
			emtable.ajax.reload();
			$('#confirm-delete').modal('hide');

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
			toastr["success"]("Record deactivated successfully")
		}
	})
});






// Confirm Save Button
$('#btnSave').on('click', function(e){
	e.preventDefault();
	var title = $('.roleModal-title').text();
	if(title == "New Role")
	{
		$.ajax({
			type: 'POST',
			url:  '/utilities/employee/{{ $employee_id }}/view',
			data: {
				'_token' : $('input[name=_token]').val(),
				'employee_type_id' : $('#employee_types_id').val(),
				'employee_id' : {{ $employee_id }},
			},
			success: function (data)
			{
				if(typeof(data) === "object"){
					emtable.ajax.reload();
					$('#roleModal').modal('hide');
					$('#description').val("");
					$('.roleModal-title').text('New Role');

					//Show success

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
					toastr["success"]("Record addded successfully")
				}
				else{
					resetErrors();
					var invdata = JSON.parse(data);
					$.each(invdata, function(i, v) {
	        console.log(i + " => " + v); // view in console for error messages
	        var msg = '<label class="error" for="'+i+'">'+v+'</label>';
	        $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
	    });
					
				}
			},
			
		})
	}
	else
	{
		$.ajax({
			type: 'PUT',
			url:  '/utilities/employee/' + data.id,
			data: {
				'_token' : $('input[name=_token]').val(),
				'firstName' : $('input[name=firstName]').val(),
				'middleName' : $('input[name=middleName]').val(),
				'lastName' : $('input[name=lastName]').val(),
				
			},
			success: function (data)
			{
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
				toastr["success"]("Record updated successfully")

				emtable.ajax.reload();
				$('#roleModal').modal('hide');
				$('#description').val("");
				$('.roleModal-title').text('New Role');
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