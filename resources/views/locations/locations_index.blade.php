@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp; Locations</h2>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn but btn-md new"  style = "width: 100%;">New Location</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table table-striped table-bordered cell-border" id = "ch_table" style="width: 100%;">
					<thead>
						<tr>
							<td >
								Name
							</td>
							<td>
								Block No./Lot No./Street
							</td>
							<td >
								City
							</td>
							<td >
								Province
							</td>
							<td >
								Zip
							</td>
							<td>
								Actions
							</td>
						</tr>
					</thead>
					<tbody>
						@forelse($locations as $loc)
						<tr>
							<td>
								{{ $loc->location_name }}
							</td>
							<td>
								{{ $loc->location_address }}
							</td>
							<td>
								{{ $loc->city_name }}
							</td>
							<td>
								{{ $loc->province_name}}
							</td>
							<td>
								{{ $loc->zipCode}}
							</td>
							<td>
								<button value = "{{ $loc->location_id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button>
								<button value = "{{ $loc->location_id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
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
		<div class="modal fade" id="chModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">New Location</h4>
					</div>
					<div class="modal-body">
						<form id="commentForm" class = "form-horizontal">
							{{ csrf_field() }}	
							<div class="form-group required">
								<label class = "control-label col-md-3">Name: </label>
								<div class = "col-md-9">
									<input type = "text" class = "form-control" name = "name" id = "name" minlength = "3" required data-rule-required="true" />
								</div>
							</div>
							<div class="form-group required">
								<label class = "control-label col-md-3">Block No./Lot No./Street: </label>
								<div class = "col-md-9">
									<textarea class = "form-control" id = "address" name = "address"  data-rule-required="true"></textarea>
								</div>
							</div>
							<div class="form-group required">
								<label class = "control-label col-md-3">Province: </label>
								<div class = "col-md-9">
									<select name = "loc_province" id="loc_province" class = "form-control"  data-rule-required="true">
										@forelse($provinces as $province)
										<option value = "{{ $province->id }}">{{ $province->name }}</option>
										@empty

										@endforelse
									</select>     
								</div>
							</div>
							<div class="form-group required">
								<label class = "control-label col-md-3">City: </label>
								<div class = "col-md-9">
									<select name = "cities_id" id="cities_id" class = "form-control"  data-rule-required="true" required>
									</select>
								</div>
							</div>
							<div class="form-group required">
								<label class = "control-label col-md-3">ZIP: </label>
								<div class = "col-md-9">
									<input type = "text" class = "form-control" name = "zipCode" id = "zipCode" minlength = "3"  data-rule-required="true"/>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type = "submit" class="btn btn-success btnSave" >Save</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>				
					</div>
				</div>
			</div>
		</div>
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
</div>

@endsection

@push('styles')
<style>
.location
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
	var location_id = null;

	var data;


	$(document).ready(function(){
		var chtable = $('#ch_table').DataTable({
			"dom": '<"toolbar">frtip',
			processing: false,
			deferRender: true,
			serverSide: false,
			columns: [
			{ data: 'location_name' },
			{ data: 'location_address' },
			{ data: 'city_name' },
			{ data: 'province_name' },
			{ data: 'zipCode' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "asc" ]],
		});
		$("div.toolbar").html('<div class = "col-md-3"><input type = "checkbox" class = "check_deac"/>   Show Deactivated</div>');
		$('.check_deac').on('change', function(e)
		{
			e.preventDefault();
			if($(this).is(':checked')){
				chtable.ajax.url( '{{ route("location_data") }}/1').load();
			}
			else{
				chtable.ajax.url( '{{ route("location_data") }}').load();
			}
		})

		$('#commentForm').validate({

			rules: 
			{
				name:
				{
					required: true,
					minlength: 3,
					maxlength: 50,
					
				},
				address:
				{
					required: true,
					minlength: 3,
					NoSpecialCharacters:true,

				}

			},onkeyup: function(element) {$(element).valid()}, 

		});

		Inputmask("9{4}").mask($("#zipCode"));

		$(document).on('click', '.new', function(e){
			resetErrors();
			e.preventDefault();
			$('.modal-title').text("New Location");
			$('#name').val("");
			$('#address').val("");
			$('#loc_province').val("0");
			$('#cities_id').val("0");
			$('#zipCode').val("");

			$('#chModal').modal("show");
		})
		$(document).on('click', '.btnSave', function(e){
			e.preventDefault();
			$('#zipCode').valid();
			$('#name').valid();
			$('#address').valid();
			$('#cities_id').valid();

			if($('#zipCode').valid() && $('#name').valid() && $('#address').valid() && $('#cities_id').valid() && $('#zipCode').val().indexOf("_") == -1 ){
				if($('.modal-title').text() == "New Location")
				{
					$('.btnSave').attr('disabled', 'true');
					$.ajax({
						type: 'POST',
						url: "{{ route('location.index')}}",
						data: {
							'_token' : $('input[name=_token]').val(),
							'name' : $('#name').val(),
							'address' : $('#address').val(),
							'cities_id' : $('#cities_id').val(),
							'zipCode' : $('#zipCode').val(),
						},
						success: function(data){
							if(typeof(data) == "object"){
								$('#chModal').modal('hide');
								chtable.ajax.url( '{{ route("location_data") }}' ).load();
								$('.btnSave').removeAttr('disabled');
								message("Saved successfully");
							}
							else{
								resetErrors();
								var invdata = JSON.parse(data);
								$.each(invdata, function(i, v) {
									console.log(i + " => " + v);
									var msg = '<label class="error" for="'+i+'">'+v+'</label>';
									$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);


								});
								$('.btnSave').removeAttr('disabled');
							}
						},
						error: function(data) {
							if(data.status == 400){
								alert("Nothing found");
							}
						}
					})
				}
				else{
					$('.btnSave').attr('disabled', 'true');
					$.ajax({
						type: 'PUT',
						url: "{{ route('location.index')}}/" + location_id,
						data: {
							'_token' : $('input[name=_token]').val(),
							'name' : $('#name').val(),
							'address' : $('#address').val(),
							'cities_id' : $('#cities_id').val(),
							'zipCode' : $('#zipCode').val(),
						},
						success: function(data){
							if(typeof(data) == "object"){
								$('#chModal').modal('hide');
								chtable.ajax.url( '{{ route("location_data") }}' ).load();
								$('.btnSave').removeAttr('disabled');
								message("Updated successfully");
							}
							else{
								resetErrors();
								var invdata = JSON.parse(data);
								$.each(invdata, function(i, v) {
									console.log(i + " => " + v);
									var msg = '<label class="error" for="'+i+'">'+v+'</label>';
									$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);


								});
								$('.btnSave').removeAttr('disabled');
							}

						},
						error: function(data) {
							if(data.status == 400){
								alert("Nothing found");
							}
						}
					})

				}
			}
			
		})

		$(document).on('click', '.edit', function(e){
			e.preventDefault();
			location_id = $(this).val();

			console.log(location_id);
			$('.modal-title').text("Update Location");

			var data = chtable.row($(this).parents()).data();

			$('#name').val(data.location_name);
			$('#address').val(data.location_address);
			$('#zipCode').val(data.zipCode);
			$("#loc_province option:contains(" + data.province_name +")").attr("selected", true);
			fill_cities(data.city_id);
			$("#cities_id option:contains(" + data.city_name +")").attr("selected", true);
			console.log(data.city_id);
			$('#dateEffective').val($(this).closest('tr').find('.date_Effective').val());
			
			$('#chModal').modal('show');
		})

		$(document).on('click', '.deactivate', function(e){
			e.preventDefault();
			location_id = $(this).closest('tr').find('.location_id').val();
			$('#confirm-delete').modal('show');
		})

		$(document).on('click', '#btnDelete', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url: "{{ route('location.index')}}/" + location_id,
				data: {
					'_token' : $('input[name=_token]').val(),
				},
				success: function(data){
					$('#confirm-delete').modal('hide');
					chtable.ajax.url( '{{ route("location_data") }}' ).load();
					message("Deactivated successfully");   

				},
				error: function(data) {
					if(data.status == 400){
						alert("Nothing found");
					}
				}
			})
		})


		$(document).on('click', '.activate', function(e){
			location_id = $(this).val();
			data = chtable.row($(this).parents()).data();
			$('#confirm-activate').modal('show');
		});

		$('#btnActivate').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'PUT',
				url:  '/utilities/location_reactivate/' + data.id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					chtable.ajax.url( '{{ route("location_data") }}/1' ).load();
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

		$(document).on('change', '#loc_province', function(e){
			fill_cities(0);
		})

		function fill_cities(num)
		{
			console.log(num);
			$.ajax({
				type: 'GET',
				url: "{{ route('get_prov_cities')}}/" + $('#loc_province').val(),
				data: {
					'_token' : $('input[name=_token]').val(),
				},
				success: function(data){
					if(typeof(data) == "object"){
						
						var new_rows = "";
						for(var i = 0; i < data.length; i++){
							new_rows += "<option value = '"+ data[i].id+"'>"+ data[i].name +"</option>";
						}
						$('#cities_id').find('option').not(':first').remove();
						$('#cities_id').html(new_rows);
						
						$('#cities_id').val(num);
					}
				},
				error: function(data) {
					if(data.status == 400){
						alert("Nothing found");
					}
				}
			})
		}
	})
function resetErrors() {
	$('form input, form select').removeClass('inputTxtError');
	$('label.error').remove();
}
function message(mess)
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
	toastr["success"](mess);
}
</script>
@endpush