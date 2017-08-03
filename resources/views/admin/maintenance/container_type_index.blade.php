@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3><img src="/images/bar.png"> Maintenance | Container Volume</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#ctModal" style = "width: 100%;">New Container Volume</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table" id = "ch_table" style="text-align:center">
					<thead>
						<tr>
							<td style="width: 15%;">
								Name
							</td>
							<td style="width: 10%;">
								Length<br>
								(meters)
							</td>
							<td style="width: 10%;">
								Width<br>
								(meters)
							</td>
							<td style="width: 10%;">
								Height<br>
								(meters)
							</td>
							<td style="width: 20%;">
								Description
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
		<form role="form" method = "POST" id = "commentForm">
			{{ csrf_field() }}
			<div class="modal fade" id="ctModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Container Volume</h4>
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

							<div class="form-group ">
								<label class = "control-label" style = "text-align: center">Volume </label>
								<br>
								<div class="form-group required">
									<label class = "control-label">Length: </label>
									<div class = "form-group input-group">
										<input type = "text" class = "form-control money" style= "text-align: right" 
										value ="0" name = "length" id = "length"  data-rule-required="true" /><span class = "input-group-addon">meters</span>
									</div>
								</div>
								<div class="form-group required">
									<label class = "control-label">Width: </label>
									<div class = "form-group input-group">
										<input type = "text" class = "form-control money"  style= "text-align: right"
										value ="0" name = "width" id = "width"  data-rule-required="true" /><span class = "input-group-addon">meters</span>
									</div>
								</div>
								<div class="form-group required">
									<label class = "control-label">Height: </label>
									<div class = "form-group input-group">
										<input type = "text" class = "form-control money"  style= "text-align: right"
										value ="0" name = "height" id = "height"  data-rule-required="true" /><span class = "input-group-addon">meters</span>
									</div>
								</div>
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
@endsection
@push('styles')
<style>
	.class-container-type
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
	var temp_name = null;
	var temp_desc = null;
	var temp_length = null;
	var temp_width = null;
	var temp_height = null
	$(document).ready(function(){
		var cttable = $('#ch_table').DataTable({
			scrollX: true,
			processing: true,
			serverSide: true,
			ajax: 'http://localhost:8000/admin/ctData',
			columns: [
			{ data: 'name'},
			{ data: 'length',
			"render" : function( data, type, full ) {
				return format_container_volume(data); }},
				{ data: 'width',
				"render" : function( data, type, full ) {
					return format_container_volume(data); }},
					{ data: 'height' ,
					"render" : function( data, type, full ) {
						return format_container_volume(data); }},
						{ data: 'description' },
						{ data: 'action', orderable: false, searchable: false }

						],	"order": [[ 0, "desc" ]],
					});

		$("#commentForm").validate({
			rules: 
			{
				name:
				{
					required: true,
					minlength: 3,
					maxlength: 50,
				},
				description:
				{
					maxlength: 150,
				},
				length:
				{
					required:true,

				},
				width:
				{
					required:true,

				},
				height:
				{
					required:true,

				},

			},
			onkeyup: function(element) {$(element).valid()}, 
			submitHandler: function (form) {
				return false;
			}
		});


		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Container Volume');
			$('#description').val("");
			$('#name').val("");
			$('#length').val("");
			$('#width').val("");
			$('#height').val("");
			$('#ctModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			var ct_id = $(this).val();
			data = cttable.row($(this).parents()).data();

			$('#description').val(data.description);
			$('#name').val(data.name);
			$('#length').val(data.length);
			$('#width').val(data.width);
			$('#height').val(data.height);
			temp_name = data.name;
			temp_desc = data.description;
			temp_length = data.description;
			temp_width = data.description;
			temp_height = data.description;


			$('.modal-title').text('Update Container Volume');
			$('#ctModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			var ct_id = $(this).val();
			data = cttable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});



		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/container_type/' + data.id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					cttable.ajax.reload();
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
			$('#length').valid();
			$('#width').valid();
			$('#height').valid();


			if(title == "New Container Volume")
			{
				if($('#name').valid() && $('#description').valid() && $('#length').valid() &&	$('#width').valid() && $('#height').valid()){

					$('#btnSave').attr('disabled', 'true');
					$.ajax({
						type: 'POST',
						url:  '/admin/container_type',
						data: {
							'_token' : $('input[name=_token]').val(),
							'name' : $('#name').val(),
							'description' : $('#description').val(),
							'length' : $('#length').inputmask('unmaskedvalue'),
							'width' : $('#width').inputmask('unmaskedvalue'),
							'height' : $('#height').inputmask('unmaskedvalue'),
						},
						success: function (data)
						{
							if(typeof(data) === "object"){
								cttable.ajax.reload();
								$('#ctModal').modal('hide');
								$('#name').val("");
								$('#description').val("");
								$('#length').val("");
								$('#width').val("");
								$('#height').val("");
								$('.modal-title').text('New Container Volume');


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
			else
			{
				if($('#name').valid() && $('#description').valid() && $('#length').valid() && $('#width').valid() && $('#height').valid())
				{

					if($('#name').val() === temp_name &&
						$('#description').val() === temp_desc && 
						$('#length').inputmask("unmaskedvalue") === temp_length && 
						$('#width').inputmask("unmaskedvalue")=== temp_width &&
						$('#height').inputmask("unmaskedvalue") === temp_height )
					{
						$('#name').val("");
						$('#description').val("");
						$('#length').val("");
						$('#width').val("");
						$('#height').val("");
						$('#btnSave').removeAttr('disabled');
						$('#ctModal').modal('hide');
					}
					else
					{
						$('#btnSave').attr('disabled', 'true');

						$.ajax({
							type: 'PUT',
							url:  '/admin/container_type/' + data.id,
							data: {
								'_token' : $('input[name=_token]').val(),
								'name' : $('#name').val(),
								'description' : $('#description').val(),
								'length' : $('#length').inputmask("unmaskedvalue"),
								'width' : $('#width').inputmask("unmaskedvalue"),
								'height' : $('#height').inputmask("unmaskedvalue"),

							},
							success: function (data)
							{
								if(typeof(data) === "object"){
									cttable.ajax.reload();
									$('#ctModal').modal('hide');
									$('#description').val("");
									$('#length').val("");
									$('#width').val("");
									$('#height').val("");
									$('.modal-title').text('New Container Volume');



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