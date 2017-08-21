@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3><img src="/images/bar.png"> Maintenance | Vehicle Type</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#vtModal" style = "width: 100%;">New Vehicle Type</button>
		</div>
		<br>
		<br>
	</div>
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table" id = "vtype_table">
					<thead>
						<tr>
							<td style="width: 30%;">
								Name
							</td>
							<td style="width: 10%;">
								With Container
							</td>
							<td style="width: 40%;">
								Description
							</td>
							<td style="width: 15%;">
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
							<h4 class="modal-title">New Vehicle Type</h4>
						</div>
						<div class="modal-body">
							<div class="form-group required">
								<label class = "control-label">Name: </label>
								<input type = "text" class = "form-control" name = "name" id = "name" required />
							</div>	
							<div class="form-group required">
								<label class = "control-label">With Container: </label>
								<input type="radio" name="withContainer" value="0" > With
								<input type="radio" name="withContainer" value="1"> Without
							</div>	
							<div class="form-group">
								<label class = "control-label">Description: </label>
								<textarea class = "form-control" name = "description" id = "description"></textarea>
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
	.class-vehicle-type{
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
	var data;
	var temp_name = null;
	var temp_desc = null;
	var temp_withContainer = null;
	$(document).ready(function(){
		var vtable = $('#vtype_table').DataTable({
			scrollX: true,
			processing: true,
			serverSide: true,
			ajax: '{{ route("vt.data") }}',
			columns: [
			{ data: 'name' },
			{ data: 'withContainer',
			"render" : function( data, type, full ) {
				return formatWithContainer(data); }},
				{ data: 'description' },
				{ data: 'action', orderable: false, searchable: false }

				],	"order": [[ 0, "asc" ]],
			});

		function formatWithContainer(n) { 

			if (n === 0){
				return "with ";
			}else{
				return "without ";
			}

		} 

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
					regex: /^[A-Za-z ]+$/,
				},

				description:
				{
					maxlength: 50,
					regex: /^[A-Za-z0-9-',. ]+$/,

				},

			},
			onkeyup: function(element) {$(element).valid()}, 
		});
		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Vehicle Type');
			$('#description').val("");
			$('#name').val("");
			$('#vtModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			var vt_id = $(this).val();
			data = vtable.row($(this).parents()).data();

			$('#description').val(data.description);
			$('#name').val(data.name);
			$('[name=withContainer].checked').val(data.withContainer);

			temp_name = data.name;
			temp_desc = data.description;
			temp_withContainer = data.withContainer;

			$('.modal-title').text('Edit Vehicle Type');
			$('#vtModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			var vt_id = $(this).val();
			data = vtable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});



		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/vehicletype/' + data.id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					vtable.ajax.reload();
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

			$('#name').valid();
			$('#description').valid();

			if(title == "New Vehicle Type")
			{
				if($('#name').valid() && $('#description').valid()){

					$('#btnSave').attr('disabled', 'true');

					$.ajax({
						type: 'POST',
						url:  '/admin/vehicletype',
						data: {
							'_token' : $('input[name=_token]').val(),
							'name' : $('#name').val(),
							'description' : $('#description').val(),
							'withContainer':$('input[name=withContainer]:checked').val(),
						},
						success: function (data)
						{
							if(typeof(data) === "object"){
								vtable.ajax.reload();
								$('#vtModal').modal('hide');
								$('#description').val("");
								$('.modal-title').text('New Vehicle Type');


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
				if($('#name').valid() && $('#description').valid() ){
					if($('#name').val() === temp_name && $('#description').val() === temp_desc && $('input[name=withContainer]:checked').val() === temp_withContainer){
						$('#name').val("");
						$('#description').val("");
						$('#btnSave').removeAttr('disabled');
						$('#vtModal').modal('hide');
					}
					else{
						$('#btnSave').attr('disabled', 'true');

						$.ajax({
							type: 'PUT',
							url:  '/admin/vehicletype/' + data.id,
							data: {
								'_token' : $('input[name=_token]').val(),
								'name' : $('#name').val(),
								'description' : $('#description').val(),
								'withContainer':$('input[name=withContainer]:checked').val(),
							},
							success: function (data)
							{
								if(typeof(data) === "object"){
									vtable.ajax.reload();
									$('#vtModal').modal('hide');
									$('#description').val("");
									$('.modal-title').text('New Vehicle Type');

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