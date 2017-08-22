@extends('layouts.utilities')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3><img src="/images/bar.png"> Utilities | Employee</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#emModal" style = "width: 100%;">New Employee</button>
		</div>
	</div>
	<br />

	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table" id = "em_table">
					<thead>
						<tr>
							<td>
								First Name
							</td>
							<td>
								Middle Name
							</td>
							<td>
								Last Name
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
		<form role="form" method = "POST" id="commentForm" >
			{{ csrf_field() }}
			<div class="modal fade" id="emModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Employee</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group required">
								<label class = "control-label">First Name</label>
								<input type = "text" class = "form-control" name = "firstName" id = "firstName"  />
							</div>
							<div class="form-group">
								<label>Middle Name</label>
								<input type = "text" class = "form-control" name = "middleName" id = "middleName"  />
							</div>
							<div class="form-group required">
								<label class ="control-label">Last Name</label>
								<input type = "text" class = "form-control" name = "lastName" id = "lastName" />
							</div>
							<small style = "color:red; text-align: left"><i>All field(s) with (*) are required.</i></small>
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
							Confirm Deactivate
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
	var temp_first = null;
	var temp_middle = null;
	var temp_last = null;
	$(document).ready(function(){
		var emtable = $('#em_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: '{{ route("em.data") }}',
			columns: [
			{ data: 'firstName' },
			{ data: 'middleName' },
			{ data: 'lastName' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "asc" ]],
		});

		$("#commentForm").validate({
			rules: 
			{
				firstName:
				{
					required: true,
					maxlength: 50,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},
					regex: /^[A-Za-z0-9  ]+$/,
				},
				lastName:
				{
					required: true,
					maxlength: 50,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},
					regex: /^[A-Za-z0-9  ]+$/,
				},
				middleName:
				{
					maxlength: 50,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},
					regex: /^[A-Za-z0-9  ]+$/,
				},

			},
			onkeyup: function(element) {$(element).valid()}, 
		});



		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Employee');
			$('#firstName').val("");
			$('#middleName').val("");
			$('#lastName').val("");
			$('#emModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			var ch_id = $(this).val();
			data = emtable.row($(this).parents()).data();
			$('#firstName').val(data.firstName);
			$('#middleName').val(data.middleName);
			$('#lastName').val(data.lastName);
			temp_first = data.firstName;
			temp_last = data.lastName;
			temp_middle = data.middleName;
			$('.modal-title').text('Update Employee Details');
			$('#emModal').modal('show');
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
		url:  '/utilities/employee/' + data.id,
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
	if(title == "New Employee")
	{
		if($('#firstName').valid() && $('#lastName').valid() && $('#middleName').valid()){

			$('#btnSave').attr('disabled', 'true');

			$.ajax({  
				type: 'POST',
				url:  '/utilities/employee',
				data: {
					'_token' : $('input[name=_token]').val(),
					'firstName' : $('input[name=firstName]').val(),
					'middleName' : $('input[name=middleName]').val(),
					'lastName' : $('input[name=lastName]').val(),


				},
				success: function (data)
				{
					if(typeof(data) === "object"){
						emtable.ajax.reload();
						
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

					
					$('#firstName').val("");
					$('#lastName').val("");
					$('#middleName').val("");
					$('.modal-title').text('New Employee');
					$('#emModal').modal('hide');
					$('#btnSave').removeAttr('disabled');

				}else{
					resetErrors();
					var invdata = JSON.parse(data);
					$.each(invdata, function(i, v) 
					{

					console.log(i + " => " + v); // view in console for error messages
					var msg = '<label class="error" for="'+i+'">'+v+'</label>';
					$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
					$('#btnSave').removeAttr('disabled');
				});
					
				}
			},
			
		})
		}
	}
	else
	{

		if($('#firstName').valid() && $('#lastName').valid() && $('#middleName').valid())
		{


			if($('#firstName').val() === temp_first && $('#lastName').val() === temp_last &&
				$('#middleName').val() === temp_middle )
			{

				$('#firstName').val("");
				$('#middleName').val("");
				$('#lastName').val("");
				$('#btnSave').removeAttr('disabled');
				$('#emModal').modal('hide');
			}
			else
			{

				$('#btnSave').attr('disabled', 'true');

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
						$('#emModal').modal('hide');
						$('#description').val("");
						$('.modal-title').text('New Employee');
						$('#btnSave').removeAttr('disabled');
					}
				})
			}
		}
	}
});

});

function resetErrors() {
	$('form input, form select').removeClass('inputTxtError');
	$('label.error').remove();
}
</script>
@endpush