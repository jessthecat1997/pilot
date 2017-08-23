@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance | Delivery | Container Size</h2>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#ctModal" style = "width: 100%;">New Container Size</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table" id = "ch_table" style="text-align:left">
					<thead>
						<tr style="text-align:left">
							<td style="width: 20%;">
								Size
							</td>
							<td style="width: 20%;">
								Maximum Weight Capacity<br>
								(kgs)
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
							<h4 class="modal-title">New Container Size</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group required">

								<label class = "control-label">Size: </label>
								<div class = "form-group input-group">
									<input type = "text" class = "form-control money" name = "name" id = "name" required />
									<span class = "input-group-addon">foot</span>
								</div>
							</div>
							<div class="form-group">
								<label class = "control-label">Description: </label>
								<textarea class = "form-control" name = "description" id = "description"></textarea>
							</div>

							<div class="form-group required">
								<label class = "control-label">Maximum Weight Capacity: </label>
								<div class = "form-group input-group">
									<input type = "text" class = "form-control money" style= "text-align: right" 
									value ="0" name = "maxWeight" id = "maxWeight"  data-rule-required="true" /><span class = "input-group-addon">kgs</span>
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
	.class-container-type
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
@push('scripts')
<script type="text/javascript">
	$('#collapse2').addClass('in');
	var data;
	var temp_name = null;
	var temp_desc = null;
	var temp_maxWeight = null;
	
	$(document).ready(function(){
		var cttable = $('#ch_table').DataTable({
			scrollX: true,
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: 'http://localhost:8000/admin/ctData',
			columns: [
			{ data: 'name',
			"render" : function( data, type, full ) {
				return format_container_size(data); }},
				{ data: 'maxWeight',
				"render" : function( data, type, full ) {
					return format_container_maxweight(data); }},
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
					maxlength: 150,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},
					regex: /^[A-Za-z0-9'-.,  ]+$/,
				},
				maxWeight:
				{
					required:true,

				},


			},
			onkeyup: function(element) {$(element).valid()},
		});


		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Container Volume');
			$('#description').val("");
			$('#name').val("");
			$('#maxWeight').val("");
			
			$('#ctModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			var ct_id = $(this).val();
			data = cttable.row($(this).parents()).data();

			$('#description').val(data.description);
			$('#name').val(data.name);
			$('#maxWeight').val(data.maxWeight);
			
			temp_name = data.name;
			temp_desc = data.description;
			temp_maxWeight = data.description;


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
			$('#maxWeight').valid();
			


			if(title == "New Container Volume")
			{
				if($('#name').valid() && $('#description').valid() && $('#maxWeight').valid() ){

					$('#btnSave').attr('disabled', 'true');
					$.ajax({
						type: 'POST',
						url:  '/admin/container_type',
						data: {
							'_token' : $('input[name=_token]').val(),
							'name' : $('#name').val(),
							'description' : $('#description').val(),
							'maxWeight' : $('#maxWeight').inputmask('unmaskedvalue'),
							
						},
						success: function (data)
						{
							if(typeof(data) === "object"){
								cttable.ajax.reload();
								$('#ctModal').modal('hide');
								$('#name').val("");
								$('#description').val("");
								$('#maxWeight').val("");
								
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
				if($('#name').valid() && $('#description').valid() && $('#maxWeight').valid() )
				{

					if($('#name').val() === temp_name &&
						$('#description').val() === temp_desc && 
						$('#maxWeight').inputmask("unmaskedvalue") === temp_maxWeight  )
					{
						$('#name').val("");
						$('#description').val("");
						$('#maxWeight').val("");
						
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
								'maxWeight' : $('#maxWeight').inputmask("unmaskedvalue"),
								

							},
							success: function (data)
							{
								if(typeof(data) === "object"){
									cttable.ajax.reload();
									$('#ctModal').modal('hide');
									$('#description').val("");
									$('#maxWeight').val("");
									
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