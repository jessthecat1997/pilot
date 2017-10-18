@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3> Maintenance |Brokerage|Tariff Book|Category</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#catModal" style = "width: 100%;">New Category</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table cell-border table-striped table-bordered" id = "cat_table" style="width: 100%;">
					<thead>
						<tr>
							<td>
								Section
							</td>
							<td >
								Category Name
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
						@forelse($category as $cat)
						<tr>
							<td>
								{{ $cat->section }}
							</td>
							<td>
								{{ $cat->category}}
							</td>
							<td>
								{{ $cat->description }}
							</td>
							
							<td>
								<button value = "{{ $cat->id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button>
								<button value = "{{ $cat->id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
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
			<div class="modal fade" id="catModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Category</h4>
						</div>
						<div class="modal-body">	
							<div class = "form-group required" >
								<label class = "control-label">Section: </label>
								<select class = "form-control" id = "sections_id" name="sections_id" >
									@forelse($sections as $section)
									<option value = "{{ $section->id }}">{{ $section->name }}</option>
									@empty
									@endforelse
								</select>

							</div>		
							<div class="form-group required">
								<label class = "control-label">Category Name: </label>
								<input type = "text" class = "form-control" name = "name" id = "name" required />
							</div>

							<div class="form-group">
								<label class = "control-label">Description: </label>
								<input class = "form-control" name = "description" id = "description">
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
@endsection
@push('styles')
<style>
.class-category{
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
	var data;
	var temp_name = null;
	var temp_desc = null;
	var temp_section = null;
	var cat_id;
	$(document).ready(function(){
		var cattable = $('#cat_table').DataTable({
			scrollX: true,
			processing: false,
			serverSide: false,
			deferRender: true,
			columns: [
			{ data: 'section'},
			{ data: 'category' },
			{ data: 'description' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "asc" ]],
		});


		var validator = $("#commentForm").validate({
			rules: 
			{
				name:
				{
					required: true,
					maxlength: 50,
					minlength: 3,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},
					lettersonly:true,

				},

				description:
				{
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},
				},
				sections_id:
				{
					required: true,
				}

			},
			onkeyup: function(element) {$(element).valid()}, 

		});

		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Category');
			$('#name').val("");
			$('#description').val("");
			$('#catModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			cat_id = $(this).val();
			data = cattable.row($(this).parents()).data();
			$('#name').val(data.category);	
			$('#description').val(data.description);
			$("#sections_id option:contains(" + data.section +")").attr("selected", true);
			temp_name = data.category;
			temp_desc = data.description;
			temp_section = $('#sections_id').val();
			$('.modal-title').text('Update category');
			$('#catModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			cat_id = $(this).val();
			data = cattable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});



// Confirm Delete Button
$('#btnDelete').on('click', function(e){
	e.preventDefault();
	$.ajax({
		type: 'DELETE',
		url:  '/admin/category/' + cat_id,
		data: {
			'_token' : $('input[name=_token').val()
		},
		success: function (data)
		{
			cattable.ajax.url( '{{ route("cat.data") }}' ).load();
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

	if(title == "New Category")
	{
		if($('#name').valid() && $('#description').valid()){
			
			$('#btnSave').attr('disabled', 'true');

			$.ajax({
				type: 'POST',
				url:  '/admin/category',
				data: {
					'_token' : $('input[name=_token]').val(),
					'name' : $('#name').val(),
					'description' : $('#description').val(),
					'sections_id': $('#sections_id').val(),
				},
				success: function (data)
				{
					if(typeof(data) === "object"){
						cattable.ajax.url( '{{ route("cat.data") }}' ).load();
						$('#catModal').modal('hide');
						$('#description').val("");
						$('.modal-title').text('New Category');

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
					$('#catModal').modal('hide');

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
				$('#catModal').modal('hide');
			}
			else{
				$('#btnSave').attr('disabled', 'true');

				$.ajax({
					type: 'PUT',
					url:  '/admin/category/' + cat_id,
					data: {
						'_token' : $('input[name=_token]').val(),
						'name' : $('#name').val(),
						'sections_id': $('#sections_id').val(),
						'description' : $('#description').val(),
					},
					success: function (data)
					{
						if(typeof(data) === "object"){
							cattable.ajax.url( '{{ route("cat.data") }}' ).load();
							$('#catModal').modal('hide');
							$('#description').val("");
							$('.modal-title').text('New Category');

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
					$('#catModal').modal('hide');
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