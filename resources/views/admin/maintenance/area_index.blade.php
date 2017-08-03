@extends('layouts.maintenance')
@section('content')

<div class = "container-fluid">
	<div class = "row">
		<h3><img src="/images/bar.png"> Maintenance | Area</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#sotModal" style = "width: 100%;">New Area</button>
		</div>
	</div>

	<br />
	<div class = "container-fluid">
		<div class = "row">
			<div class = "col-md-10 col-md-offset-1">
				<div class = "panel-default panel">
					<div class = "panel-body">
						<table class = "table-responsive table" id = "bst_table">
							<thead>
								<tr>
									<td>
										No.
									</td>
									<td>
										Destination
									</td>
									<td>
										Created at
									</td>
									<td>
										Actions
									</td>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div> 
		</div>
	</div>

	<section class="content">
		<form role="form" method = "POST" id = "commentForm">
			{{ csrf_field() }}
			<div class="modal fade" id="arModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Area</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group required">
								<label>The default pick-up point is Pier. Set the destination rates.  </label>
								<label class = "control-label">Destination:</label>
								<input type = "text" class = "form-control" name = "description" id = "description"  minlength = "2" data-rule-required="true" />
								
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
	$(document).ready(function(){
		var artable = $('#bst_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: 'http://localhost:8000/admin/arData',
			columns: [
			{ data: 'id' },
			{ data: 'description' },
			{ data: 'created_at'},
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "desc" ]],
		});

		$(document).ready(function() {
			$("#commentForm").validate({
				rules: 
				{
					description:
					{
						required: true,
						minlength: 2,
						maxlength: 50,
					},

				},


			});

			$('#commentForm input').on('keyup blur', function () {
				if ($('#commentForm').valid()) {
					$('button.submit').prop('disabled', false);
				} else {
					$('button.submit').prop('disabled', 'disabled');
				}
			});



		});


		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Area');
			$('#description').val("");
			$('#arModal').modal('show');

		});
		
		$(document).on('click', '.edit',function(e){
			resetErrors();
			var bst_id = $(this).val();
			data = artable.row($(this).parents()).data();
			$('#description').val(data.description);
			$('.modal-title').text('Update Area');
			$('#arModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			var bst_id = $(this).val();
			data = artable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});



// Confirm Delete Button
$('#btnDelete').on('click', function(e){
	e.preventDefault();
	$.ajax({
		type: 'DELETE',
		url:  '/admin/area/' + data.id,
		data: {
			'_token' : $('input[name=_token').val()
		},
		success: function (data)
		{
			artable.ajax.reload();
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
	if(title == "New Area")
	{
		$.ajax({
			type: 'POST',
			url:  '/admin/area',
			data: {
				'_token' : $('input[name=_token]').val(),
				'description' : $('input[name=description]').val(),
			},
			success: function (data)
			{
				if(typeof(data) === "object"){
					artable.ajax.reload();
					$('#arModal').modal('hide');
					$('#description').val("");
					$('.modal-title').text('New Area');

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
					toastr["success"]("Record addded successfully")
				}
				else{
					resetErrors();
					var invdata = JSON.parse(data);
					$.each(invdata, function(i, v) {
	        console.log(i + " => " + v); // view in console for error messages
	        var msg = '<label class="error" for="'+i+'">'+v+'</label>';
	        $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
	    });
					
				}
			},
			
		})
	}
	else
	{
		$.ajax({
			type: 'PUT',
			url:  '/admin/area/' + data.id,
			data: {
				'_token' : $('input[name=_token]').val(),
				'description' : $('input[name=description]').val(),
			},
			success: function (data)
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
				toastr["success"]("Record updated successfully")

				artable.ajax.reload();
				$('#arModal').modal('hide');
				$('#description').val("");
				$('.modal-title').text('New Area');
			}
		})
	}
});

});

function resetErrors() {
	$('form input, form select').removeClass('inputTxtError');
	$('label.error').remove();
}
</script>
@endpush