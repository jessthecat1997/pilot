@extends('layouts.utilities')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3><img src="/images/bar.png"> Utilities | Employee Role</h3>
		<hr>
	</div>
	<div class = "row">
		<div class = "col-md-2 col-md-offset-9">
			<button  class="btn btn-success btn-md new" data-toggle="modal" data-target="#roleModal" style = "width: 100%;">New Role</button>
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
										ID
									</td>
									<td>
										Role
									</td>
									<td>
										Created at
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
							<h4 class="modal-title">New Role</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group">
								<label>Role :</label>
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
						</div>
						<div class="modal-footer">
							<input id = "btnSave" type = "submit" class="btn btn-success" value = "Save" />
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>				
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
			{ data: 'id' },
			{ data: 'name' },
			{ data: 'created_at'},
			{ data: 'action', orderable: false, searchable: false }

			]
		});
		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Role');
			$('#roleModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			var ch_id = $(this).val();
			data = emtable.row($(this).parents()).data();
			$('.modal-title').text('Edit Employee Details');
			$('#roleModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			var ch_id = $(this).val();
			data = emtable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
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
	var title = $('.modal-title').text();
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
					$('.modal-title').text('New Role');

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
				$('.modal-title').text('New Role');
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