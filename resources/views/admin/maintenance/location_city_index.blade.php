@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3> Maintenance | Delivery | City</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#lcModal" style = "width: 100%;">New City</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table table-striped cell-border table-bordered" id = "lc_table">
					<thead>
						<tr>
							<td>
								Province
							</td>
							<td>
								City
							</td>							
							<td>
								Actions
							</td>
						</tr>
					</thead>
					<tbody>
						@forelse($cities as $ct)
						<tr>
							<td>
								{{ $ct->province }}
							</td>
							<td>
								{{ $ct->city }}
							</td>
							<td>
								<button value = "{{ $ct->id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button>
								<button value = "{{ $ct->id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
							</td>
						</tr>
						@empty
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<section class="content">
	
	<form role="form" method = "POST" id="commentForm">
		{{ csrf_field() }}
		<div class="modal fade" id="lcModal" role="dialog">
			<div class="modal-dialog ">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 id="cModal-title">New City</h4>
					</div>
					<div class="modal-body ">		
						<div class="form-group required">
							<label class="control-label">Province:</label>
							<div class = "input-group " >
								<select name = "loc_province" id="loc_province" class = "form-control " >
									@forelse($provinces as $province)
									<option value="{{ $province->id }}">{{ $province->name }}</option>
									@empty
									@endforelse
								</select> 
								<span class="input-group-btn">
									<button class="btn btn-primary new_province" type="button">+</button>
								</span>
							</div>
						</div>
						<div class="form-group required">
							<label class = "control-label"><strong>City</strong></label>
							<input type = "text" class = "form-control  lc_city_valid"  placeholder="Enter a city" name = "name" id = "name" value=""  data-rule-required="true"/>
						</div>
						<br />
						<small style = "color:red; text-align: left"><i>All field(s) with (*) are required.</i></small>
					</div>
					<div class="modal-footer">
						<button id = "btnSave" type = "submit" class="btn btn-success finalize-lc">Save</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>			
					</div>
				</div>
			</div>
			
		</form>
	</div>
</section>
<section class="content">
	<form role="form" method = "POST" id="provinceForm">
		{{ csrf_field() }}
		<div class="modal fade" id="lpModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">New Province</h4>
					</div>
					<div class="modal-body">			
						<div class="form-group required">
							<label class = "control-label">Name:</label>
							<input type = "text" class = "form-control" name = "provincename" 
							id = "provincename"  minlength = "3" data-rule-required="true" />

						</div>
					</div>
					<div class="modal-footer">
						<input id = "btnSave_province" type = "submit" class="btn btn-success submit" value = "Save" />
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

						
						<button type="button" class="btn btn-danger
						" data-dismiss="modal">Cancel</button>
						<button class = "btn btn-success	" id = "btnActivate" >Activate</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>


@endsection
@push('styles')
<style>
.class-city
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
	$('#deliverycollapse').addClass('in');
	$('#collapse2').addClass('in');
	var temp_city;
	var lc_id;

	$(document).ready(function(){


		var lctable = $('#lc_table').DataTable({
			"dom": '<"toolbar">frtip',
			processing: false,
			serverSide: false,
			deferRender: true,
			'scrollx': true,
			columns: [

			{ data: 'province' },
			{ data: 'city'},

			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "asc" ]], 


		});
		$("div.toolbar").html('<div class = "col-md-3"><input type = "checkbox" class = "check_deac"/>   Show Deactivated</div>');
		$('.check_deac').on('change', function(e)
		{
			e.preventDefault();
			if($(this).is(':checked')){
				lctable.ajax.url( '{{ route("lc.data") }}/1').load();
			}
			else{
				lctable.ajax.url( '{{ route("lc.data") }}').load();
			}
		})

		$(document).on('click', '.activate', function(e){
			var bst_id = $(this).val();
			data = lctable.row($(this).parents()).data();
			$('#confirm-activate').modal('show');
		});
		$('#btnActivate').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'PUT',
				url:  '/utilities/location_city_reactivate/' + data.id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					lctable.ajax.reload();
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

		$("#commentForm").validate({
			rules: 
			{
				loc_province:
				{
					required: true,
					
				},
				name:
				{
					required: true,
					lettersonly:true,
					minlength: 3,
					maxlength: 50,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},	
				}
			},
			onkeyup: function(element) {$(element).valid()}, 
			
		});
		$("#provinceForm").validate({
			rules: 
			{
				name:
				{
					required: true,
					lettersonly:true,
					minlength: 3,
					maxlength: 50,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},	
				}
			},
			onkeyup: function(element) {$(element).valid()}, 
			
		});

		$(document).on('click', '.new', function(e){
			resetErrors();
			$('#cModal-title').text('New City');
			$('#lcModal').modal('show');

		});

		$(document).on('click', '.edit',function(e){
			resetErrors();
			e.preventDefault();
			lc_id = $(this).val();
			data = lctable.row($(this).parents()).data();
			console.log(data.province);
			$('#cModal-title').text('Update City');
			$("#loc_province option:contains(" + data.province +")").attr("selected", true);
			$('#name').val(data.city);
			$('#lcModal').modal('show');
		});

		$(document).on('click', '.deactivate', function(e){
			lc_id = $(this).val();
			data = lctable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});


		$(document).on('click', '.new_province', function(e){
			resetErrors();
			e.preventDefault();
			$('#provincename').val("");
			$('#lpModal').modal('show');

		});

		$('#btnSave_province').on('click', function(e){
			e.preventDefault();

			$.ajax({
				type: 'POST',
				url:  '/admin/location_city/new_province/',
				data: {
					'_token' : $('input[name=_token]').val(),
					'name' : $('#provincename').val(),
				},
				success: function (data)
				{
					var newOption = $('<option selected value="'+data.id+'">'+data.name+'</option>');
					$('#loc_province').append(newOption);
					if(typeof(data) === "object"){
						$('#lpModal').modal('hide');
						$('#provincename').val("");
						$('.modal-title').text('New Province');

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
						toastr["success"]("Record added new province")
					}
					else{
						resetErrors();
						var invdata = JSON.parse(data);
						$.each(invdata, function(i, v) {
							console.log(i + " => " + v); 
							var msg = '<label class="error" for="'+i+'">'+v+'</label>';
							$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
						});

					}
				},

			})
		});

		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/location_city/' + lc_id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					lctable.ajax.url( '{{ route("lc.data") }}' ).load();
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

		$(document).on('click', '.finalize-lc', function(e){
			e.preventDefault();
			var title = $('#cModal-title').text();
			$('#name').valid();
			$('#loc_province').valid();
			if(title === "New City"){
				if($('#name').valid() && $('#loc_province').valid())
				{

					$.ajax({

						type: 'POST',
						url:  '/admin/location_city',
						data: {
							'_token' : $('input[name=_token]').val(),
							'name' : $('#name').val(),
							'provinces_id' : $('#loc_province').val(),

						},

						success: function (data){
							if(typeof(data) === "object"){
								lctable.ajax.url( '{{ route("lc.data") }}' ).load();
								$('#lcModal').modal('hide');
								$('.modal-title').text('New City');
								$('#name').val("");

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
							}
							else{
								resetErrors();
								var invdata = JSON.parse(data);
								$.each(invdata, function(i, v) {
									console.log(i + " => " + v);
									var msg = '<label class="error" for="'+i+'">'+v+'</label>';
									$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
								});

							}

						}
					})
				}
			}else{
				if($('#name').valid() && $('#loc_province').valid())
				{
					$.ajax({

						type: 'PUT',
						url:  '/admin/location_city/' +lc_id,
						data: {
							'_token' : $('input[name=_token]').val(),
							'name' : $('#name').val(),
							'provinces_id' : $('#loc_province').val(),

						},

						success: function (data){

							lctable.ajax.url( '{{ route("lc.data") }}' ).load();
							$('#lcModal').modal('hide');
							$('.modal-title').text('New City');
							$('#name').val("");

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

						}
					})
				}
			}

		});//submit

	});//end

function resetErrors() {
	$('form input, form select').removeClass('inputTxtError');
	$('label.error').remove();
}
</script>
@endpush