@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3><img src="/images/bar.png"> Maintenance | Brokerage Status</h3>
		<hr>
	</div>
	<br />
	<div class = "row">
		<div class = "col-md-2 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#bstModal" style = "width: 100%;">New Brokerage Status</button>
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
										Description
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
			<div class="modal fade" id="bstModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Brokerage Status</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group required">
								<label class = "control-label">Description</label>
								<input type = "text" class = "form-control" name = "description" id = "description" required />
							</div>
						</div>
						<div class="modal-footer">
							<input id = "btnSave" type = "submit" class="btn btn-success submit" value = "Save" />
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
		var bsttable = $('#bst_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: 'http://localhost:8000/admin/bstData',
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
						minlength: 3,
						maxlength: 50,
					},

				},
        onkeyup: false, //turn off auto validate whilst typing
        submitHandler: function (form) {
        	return false;
        }
    });
		});

		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Brokerage Status');
			$('#description').val("");
			$('#bstModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			var bst_id = $(this).val();
			data = bsttable.row($(this).parents()).data();
			$('#description').val(data.description);
			$('.modal-title').text('Edit Brokerage Status');
			$('#bstModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			var bst_id = $(this).val();
			data = bsttable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});



// Confirm Delete Button
$('#btnDelete').on('click', function(e){
	e.preventDefault();
	$.ajax({
		type: 'DELETE',
		url:  '/admin/brokerage_status_type/' + data.id,
		data: {
			'_token' : $('input[name=_token').val()
		},
		success: function (data)
		{
			bsttable.ajax.reload();
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

	$("#commentForm").validate({
				rules: 
				{
					description:
					{
						required: true,
						minlength: 3,
						maxlength: 50,
					},

				},
        
        submitHandler: function (form) {
        	return false;
        }
    });




	e.preventDefault();
	var title = $('.modal-title').text();
	if(title == "New Brokerage Status")
	{
		$.ajax({
			type: 'POST',
			url:  '/admin/brokerage_status_type',
			data: {
				'_token' : $('input[name=_token]').val(),
				'description' : $('input[name=description]').val(),
			},
			success: function (data)
			{
				if(typeof(data) === "object"){
					bsttable.ajax.reload();
					$('#bstModal').modal('hide');
					$('#description').val("");
					$('.modal-title').text('New Brokerage Status');

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
			url:  '/admin/brokerage_status_type/' + data.id,
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

				bsttable.ajax.reload();
				$('#bstModal').modal('hide');
				$('#description').val("");
				$('.modal-title').text('New Brokerage Status');
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