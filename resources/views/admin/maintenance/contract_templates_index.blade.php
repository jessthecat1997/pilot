@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">

		<h3><img src="/images/bar.png">Maintenance|Contract Template</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#ctempModal" style = "width: 100%;">New section</button>
		</div>
	</div>
	<br />
	<div class = "container-fluid">
		<div class = "row">
			<div class = "panel-default panel">
				<div class = "panel-body">
					<table class = "table-responsive table" id = "ctemp_table">
						<thead>
							<tr>
								<td style="width: 20%;">
									Section Name
								</td>
								<td style="width: 40%;">
									Section Description
								</td>
								<td style="width: 25%;">
									Actions
								</td>
							</tr>
						</thead>
					</table>
				</div>
			</div> 
		</div>

		<section class="content">
			<form role="form" method = "POST"  id = "commentForm">
				{{ csrf_field() }}
				<div class="modal fade" id="ctempModal" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">New Section</h4>
							</div>
							<div class="modal-body">
								<div class="form-group required">
									<label class = "control-label">Section Name: </label>
									<input type = "text" class = "form-control" name = "name" id = "name" required />
								</div>			
								<div class="form-group">
									<label class = "control-label">Section Description: </label>
									<textarea  rows= "10" class = "form-control" name = "description" id = "description"></textarea>
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
</div>
@endsection
@push('styles')
<style>
	
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	var data;
	var temp_name = "";
	var temp_desc = "";
	$(document).ready(function(){
		var ctemptable = $('#ctemp_table').DataTable({
			scrollX: true,
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: 'http://localhost:8000/admin/ctempData',
			columns: [
			{ data: 'name'},
			{ data: 'description' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "asc" ]],
		});

		$("#commentForm").validate({
			rules: 
			{
				name:
				{
					required: true,
					maxlength: 50,
				},

				description:
				{
					maxlength: 1000,
				},

			},
			onkeyup: function(element) {$(element).valid()},
			submitHandler: function (form) {
				return false;
			}
		});
		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Section');
			$('#description').val("");
			$('#name').val("");
			$('#ctempModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			var ch_id = $(this).val();
			data = ctemptable.row($(this).parents()).data();
			$('#description').val(data.description);
			$('#name').val(data.name);

			temp_name = data.name;
			temp_desc = data.description;

			$('.modal-title').text('Update Section');
			$('#ctempModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			var ch_id = $(this).val();
			data = ctemptable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});




		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/contract_template/' + data.id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					ctemptable.ajax.reload();
					$('#confirm-delete').modal('hide');

					toastr.options = {
						"closeButton": false,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"ctempl": false,
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

			$('#description').valid();
			$('#name').valid();

			if(title == "New Section")
			{
				if($('#name').valid() && $('#description').valid()){

					$('#btnSave').attr('disabled', 'true');
					$.ajax({
						type: 'POST',
						url:  '/admin/contract_template',
						data: {
							'_token' : $('input[name=_token]').val(),
							'name' : $('#name').val(),
							'description' : $('#description').val(),
						},
						success: function (data)
						{
							if(typeof(data) === "object"){
								ctemptable.ajax.reload();
								$('#ctempModal').modal('hide');
								$('#description').val("");
								$('.modal-title').text('New Section');



								toastr.options = {
									"closeButton": false,
									"debug": false,
									"newestOnTop": false,
									"progressBar": false,
									"ctempl": false,
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
			else
			{
				if($('#name').valid() && $('#description').valid())
				{
					if($('#name').val() === temp_name && $('#description').val() === temp_desc)
					{
						$('#name').val("");
						$('#description').val("");
						$('#btnSave').removeAttr('disabled');
						$('#ctempModal').modal('hide');
					} 
					else
					{
						$.ajax({
							type: 'PUT',
							url:  '/admin/contract_template/' + data.id,
							data: {
								'_token' : $('input[name=_token]').val(),
								'name' : $('#name').val(),
								'description' : $('#description').val(),
							},
							success: function (data)
							{
								if(typeof(data) === "object"){
									ctemptable.ajax.reload();
									$('#ctempModal').modal('hide');
									$('#description').val("");
									$('.modal-title').text('New Section');



									toastr.options = {
										"closeButton": false,
										"debug": false,
										"newestOnTop": false,
										"progressBar": false,
										"ctempl": false,
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