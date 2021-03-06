@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3> Maintenance | Attachment Type</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#reqModal" style = "width: 100%;">New Attachment Type</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table table-striped cell-border table-bordered" id = "req_table" style="width: 100%;">
					<thead>
						<tr>
							<td >
								Name
							</td>
							<td >
								Description
							</td>
							<td >
								Actions
							</td>
						</tr>
					</thead>
					<tbody>
						@forelse($reqs as $req)
						<tr>
							<td>
								{{ $req->name}}
							</td>
							<td>
								{{ $req->description }}
							</td>
							<td>
								<button value = "{{ $req->id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button>
								<button value = "{{ $req->id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
								
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
		<form role="form" method = "POST" id = "commentForm">
			{{ csrf_field() }}
			<div class="modal fade" id="reqModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Attachment Type</h4>
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
					
					<button class = "btn btn-success" id = "btnActivate" >Activate</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
@endsection
@push('styles')
<style>
.class-attachment{
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
@push('scripts')
<script type="text/javascript">
	$('#collapse2').addClass('in');
	var data;
	var temp_name = null;
	var temp_desc = null;
	var req_id;
	$(document).ready(function(){
		var reqtable = $('#req_table').DataTable({
			"dom": '<"toolbar">frtip',
			processing: false,
			serverSide: false,
			deferRender: true,
			columns: [
			{ data: 'name' },
			{ data: 'description' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "asc" ]],
		});

		$("div.toolbar").html('<div class = "col-md-3"><input type = "checkbox" class = "check_deac"/>   Show Deactivated</div>');
		$('.check_deac').on('change', function(e)
		{
			e.preventDefault();
			if($(this).is(':checked')){
				reqtable.ajax.url( '{{ route("req.data") }}/1').load();
			}
			else{
				reqtable.ajax.url( '{{ route("req.data") }}').load();
			}
		})


		var validator = $("#commentForm").validate({
			rules: 
			{
				name:
				{
					required: true,
					
					maxlength: 50,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},
				},
				description:
				{
					NoSpecialCharacters:true,
				}

				

			},
			onkeyup: function(element) {$(element).valid()}, 

		});

		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Attachment Type');
			$('#name').val("");
			$('#description').val("");
			$('#reqModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			req_id = $(this).val();
			data = reqtable.row($(this).parents()).data();
			$('#name').val(data.name);	
			$('#description').val(data.description);
			temp_name = data.name;
			temp_desc = data.description;
			$('.modal-title').text('Update Attachment Type');
			$('#reqModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			req_id = $(this).val();
			data = reqtable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});


		$(document).on('click', '.activate', function(e){
			req_id = $(this).val();
			data = reqtable.row($(this).parents()).data();
			$('#confirm-activate').modal('show');
		});
		$('#btnActivate').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'PUT',
				url:  '/utilities/attachment_type_reactivate/' + req_id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					reqtable.ajax.url( '{{ route("req.data") }}/1').load();
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




$('#btnDelete').on('click', function(e){
	e.preventDefault();
	$.ajax({
		type: 'DELETE',
		url:  '/admin/attachment_type/' + req_id,
		data: {
			'_token' : $('input[name=_token').val()
		},
		success: function (data)
		{
			reqtable.ajax.url( '{{ route("req.data") }}').load();
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


$('#btnSave').on('click', function(e){
	e.preventDefault();
	var title = $('.modal-title').text();

	if(title == "New Attachment Type")
	{
		if($('#name').valid() && $('#description').valid()){
			
			$('#btnSave').attr('disabled', 'true');

			$.ajax({
				type: 'POST',
				url:  '/admin/attachment_type',
				data: {
					'_token' : $('input[name=_token]').val(),
					'name' : $('#name').val(),
					'description' : $('#description').val(),
				},
				success: function (data)
				{
					if(typeof(data) === "object"){
						reqtable.ajax.url( '{{ route("req.data") }}').load();
						$('#reqModal').modal('hide');
						$('#description').val("");
						$('.modal-title').text('New Attachment Type');

			

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

					$('#name').val("");
					$('#description').val("");
					$('#reqModal').modal('hide');

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
	else
	{
		if($('#name').valid() && $('#description').valid()){
			if($('#name').val() === temp_name && $('#description').val() === temp_desc){
				$('#name').val("");
				$('#description').val("");
				$('#btnSave').removeAttr('disabled');
				$('#reqModal').modal('hide');
			}
			else{
				$('#btnSave').attr('disabled', 'true');

				$.ajax({
					type: 'PUT',
					url:  '/admin/attachment_type/' + req_id,
					data: {
						'_token' : $('input[name=_token]').val(),
						'name' : $('#name').val(),
						'description' : $('#description').val(),
					},
					success: function (data)
					{
						if(typeof(data) === "object"){
							reqtable.ajax.url( '{{ route("req.data") }}').load();
							$('#reqModal').modal('hide');
							$('#description').val("");
							$('.modal-title').text('New Attachment Type');

					

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

					$('#name').val("");
					$('#description').val("");
					$('#reqModal').modal('hide');
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
	}
});

});

function resetErrors() {
	$('form input, form select').removeClass('inputTxtError');
	$('label.error').remove();
}
</script>
@endpush