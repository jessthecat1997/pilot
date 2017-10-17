@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3>Maintenance |Brokerage|Tariff Book|Section</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#secModal" style = "width: 100%;">New Section</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table cell-border table-striped table-bordered" id = "sec_table" style="width: 100%;">
					<thead>
						<tr>
							<td >
								Name
							</td>
							<td>
								Description
							</td>
							<td >
								Actions
							</td>
						</tr>
					</thead>
					<tbody>
						@forelse($section as $sec)
						<tr>
							<td>
								{{ $sec->name }}
							</td>
							<td>
								{{ $sec->description }}
							</td>
							<td>
								<button value = "{{ $sec->id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button>
								<button value = "{{ $sec->id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
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
			<div class="modal fade" id="secModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Section</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group required">
								<label class = "control-label">Name: </label>
								<textarea type = "text" class = "form-control" name = "name" id = "name" rows = "3" ></textarea> 
							</div>

							<div class="form-group">
								<label class = "control-label">Description: </label>
								<textarea class = "form-control" name = "description" id = "description" rows ="5"></textarea> 
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
.class-section{
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
	$('#brokeragecollapse').addClass('in');
	$('#tariffcollapse').addClass('in');
	var data;
	var temp_name = null;
	var temp_desc = null;
	var sec_id;
	$(document).ready(function(){
		var sectable = $('#sec_table').DataTable({
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
				sectable.ajax.url( '{{ route("sec.data") }}/1').load();
			}
			else{
				sectable.ajax.url( '{{ route("sec.data") }}').load();
			}
		})


		var validator = $("#commentForm").validate({
			rules: 
			{
				name:
				{
					required: true,
					minlength: 3,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},
					NoSpecialCharacters:true,

				},

				description:
				{
					NoSpecialCharacters:true,
				},

			},
			onkeyup: function(element) {$(element).valid()}, 

		});


		function textAreaAdjust(o) {
			o.style.height = "1px";
			o.style.height = (25+o.scrollHeight)+"px";
		}


		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Section');
			$('#name').val("");
			$('#description').val("");
			$('#secModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			sec_id = $(this).val();
			data = sectable.row($(this).parents()).data();
			$('#name').val(data.name);	
			$('#description').val(data.description);
			temp_name = data.name;
			temp_desc = data.description;
			$('.modal-title').text('Update Section');
			$('#secModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			sec_id = $(this).val();
			data = sectable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});

		$(document).on('click', '.activate', function(e){
			sec_id = $(this).val();
			data = sectable.row($(this).parents()).data();
			$('#confirm-activate').modal('show');
		});
		$('#btnActivate').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'PUT',
				url:  '/utilities/section_reactivate/' + sec_id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					sectable.ajax.url( '{{ route("sec.data") }}/1' ).load();
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



// Confirm Delete Button
$('#btnDelete').on('click', function(e){
	e.preventDefault();
	$.ajax({
		type: 'DELETE',
		url:  '/admin/section/' + sec_id,
		data: {
			'_token' : $('input[name=_token').val()
		},
		success: function (data)
		{
			sectable.ajax.url( '{{ route("sec.data") }}' ).load();
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

	if(title == "New Section")
	{
		if($('#name').valid() && $('#description').valid()){
			
			$('#btnSave').attr('disabled', 'true');

			$.ajax({
				type: 'POST',
				url:  '/admin/section',
				data: {
					'_token' : $('input[name=_token]').val(),
					'name' : $('#name').val(),
					'description' : $('#description').val(),
				},
				success: function (data)
				{
					if(typeof(data) === "object"){
						sectable.ajax.url( '{{ route("sec.data") }}' ).load();
						$('#secModal').modal('hide');
						$('#description').val("");
						$('.modal-title').text('New Section');

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
					toastr["success"]("Record added successfully");

					$('#name').val("");
					$('#description').val("");
					$('#secModal').modal('hide');

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
				$('#secModal').modal('hide');
			}
			else{
				$('#btnSave').attr('disabled', 'true');

				$.ajax({
					type: 'PUT',
					url:  '/admin/section/' + sec_id,
					data: {
						'_token' : $('input[name=_token]').val(),
						'name' : $('#name').val(),
						'description' : $('#description').val(),
					},
					success: function (data)
					{
						if(typeof(data) === "object"){
							sectable.ajax.url( '{{ route("sec.data") }}' ).load();
							$('#secModal').modal('hide');
							$('#description').val("");
							$('.modal-title').text('New Section');

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
					toastr["success"]("Record updated successfully");

					$('#name').val("");
					$('#description').val("");
					$('#secModal').modal('hide');
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