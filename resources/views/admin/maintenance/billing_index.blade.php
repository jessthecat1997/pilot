@extends('layouts.maintenance')
@section('content')

<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance | Bill</h2>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#sotModal" style = "width: 100%;">New Bill</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table  table-striped" id = "bill_table">
					<thead>
						<tr>
							<td style="width: 25%;">
								Name
							</td>
							<td style="width: 10%;">
								Bill Type
							</td>
							<td style="width: 35%;">
								Description
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
		<form role="form" method = "POST" id = "commentForm">
			{{ csrf_field() }}
			<div class="modal fade" id="billModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Billing</h4>
						</div>
						<div class="modal-body">
							<div class="form-group required">
								<label class = "control-label" >Name: </label>
								<input type = "text" class = "form-control" name = "name" id = "name" required />
							</div>	
							<div class="form-group required">
								<label class = "control-label" >Bill Type: </label>
								<label class="radio-inline" id="rev"><input type="radio" name="b_type" id="b_type1" value="R">Revenue</label>
								<label class="radio-inline" id="exp"><input type="radio" name="b_type" id="b_type2" value="E">Expense</label>
							</div>	
							<div class="form-group ">
								<label class = "control-label" >Description: </label>
								<textarea class = "form-control" name = "description" id = "description" ></textarea>
							</div>
						</div>
						<div class="modal-footer">
							<input id = "btnSave" type = "submit" class="btn btn-success" value = "Save" />
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>				
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
	.class-billing
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
	var temp_name = "";
	var temp_desc = "";

	$(document).ready(function(){
		var billtable = $('#bill_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender:true,
			ajax: '{{ route("bill.data") }}',
			columns: [
			{ data: 'name'},
			{ data: 'bill_type' },
			{ data: 'description' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "asc" ]],
		});

		$(document).ready(function() {
			$("#commentForm").validate({
				rules: 
				{
					name:
					{
						required: true,
						minlength: 3,
						maxlength: 50,
					},

					

				},
				onkeyup: false, 
				submitHandler: function (form) {
					return false;
				}
			});
		});



		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Billing');
			$('#description').val("");
			$('#name').val("");
			$('#billModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			var b_id = $(this).val();
			data = billtable.row($(this).parents()).data();

			$('#description').val(data.description);
			$('#name').val(data.name);

			temp_desc = data.description;
			temp_name = data.name;

			$('.modal-title').text('Update Bill');
			$('#billModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			var b_id = $(this).val();
			data = billtable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});


		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '{{ route("billing.store") }}/' + data.id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					billtable.ajax.reload();
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
					toastr["success"]("Record deactivated successfully");
				}
			})
		});


		$('#btnSave').on('click', function(e){
			e.preventDefault();
			var title = $('.modal-title').text();
			var rev = "R";
			var exp = "E";
			$('#description').valid();
			$('#name').valid();

			if(title == "New Billing")
			{
				var ele = document.getElementsByName('b_type');
				var i = ele.length;
				for (var j = 0; j < i; j++) 
				{
					if (ele[j].checked) 
					{
						if (document.getElementById('b_type1').checked) 
						{
							var val = document.getElementById('b_type1').value;
							console.log(val);
							if($('#name').valid() && $('#description').valid())
							{

								$('#btnSave').attr('disabled', 'true');

								$.ajax({
									type: 'POST',
									url:  '{{ route("billing.index") }}',
									data: {
										'_token' : $('input[name=_token]').val(),
										'bill_type' : val,
										'name' : $('#name').val(),
										'description' : $('#description').val(),
									},
									success: function (data)
									{
										if(typeof(data) === "object"){
											billtable.ajax.reload();
											$('#billModal').modal('hide');
											$('#description').val("");
											$('.modal-title').text('New Bill');


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
											toastr["success"]("Record added successfully");

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
						else if (document.getElementById('b_type2').checked) {
							var val = document.getElementById('b_type2').value;
							console.log(val);
							if($('#name').valid() && $('#description').valid()){

								$('#btnSave').attr('disabled', 'true');
								$.ajax({
									type: 'POST',
									url:  '{{ route("billing.index") }}',
									data: {
										'_token' : $('input[name=_token]').val(),
										'bill_type' : exp,
										'name' : $('#name').val(),
										'description' : $('#description').val(),
									},
									success: function (data)
									{
										if(typeof(data) === "object"){
											billtable.ajax.reload();
											$('#billModal').modal('hide');
											$('#description').val("");
											$('.modal-title').text('New Bill');


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
											toastr["success"]("Record added successfully");

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
						$('#billModal').modal('hide');
					}
					else
					{
						$('#btnSave').attr('disabled', 'true');

						$.ajax({
							type: 'PUT',
							url:  '{{ route("billing.store") }}'+ '/' + data.id,
							data: {
								'_token' : $('input[name=_token]').val(),
								'name' : $('#name').val(),
								'description' : $('#description').val(),
							},
							success: function (data)
							{
								if(typeof(data) === "object"){
									billtable.ajax.reload();
									$('#billModal').modal('hide');
									$('#description').val("");
									$('.modal-title').text('New Bill');


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
									toastr["success"]("Record added successfully");

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

function resetErrors() {
	$('form input, form select').removeClass('inputTxtError');
	$('label.error').remove();
}
})
</script>
@endpush