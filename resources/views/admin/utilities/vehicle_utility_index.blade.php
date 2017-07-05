@extends('layouts.utilities')
@section('content')
<div class = "container-fluid">
	<h3><img src="/images/bar.png"> Utilities | Vehicles</h3>
	<hr>
	<div class = "row">
		<div class="form-group col-md-3 col-md-offset-9">
			<label>Filter</label>
			<select class = "form-control change-filter" id = "filter" name= "filter" style = "width: 100%;">
				<option value="0">All</option>
				<option value="1">Active </option>
				<option value="2">Deactivated</option>
				
			</select>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table" id = "v_table">
					<thead>
						<tr>
							<td>
								Vehicle
							</td>
							<td>
								Plate Number
							</td>
							<td>
								Model
							</td>
							<td>
								Date Registered
							</td>
							<td>
								Created at
							</td>
							<td>
								Status
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
	<section class="content">
		<form role = "form" method = "POST">
			{{ csrf_field() }}
			{{ method_field('DELETE') }}
			<div class="modal fade" id="confirm-delete" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							Delete record
						</div>
						<div class="modal-body">
							Confirm Deleting
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<button class = "btn btn-danger	" id = "btnDelete" >Delete</button>
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
	.utilities
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
		var vtable = $('#v_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: 'http://localhost:8000/admin/vData',
			columns: [
			{ data: 'vehicle_types_id' },
			{ data: 'plateNumber' },
			{ data: 'model' },
			{ data: 'dateRegistered' },
			{ data: 'created_at'},
			{ data: 'action', orderable: false, searchable: false }

			]
		});
		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Vehicle');
			$('#model').val("");
			$('#vModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			data = vtable.row($(this).parents()).data();
			$('#model').val(data.model);
			$('.modal-title').text('Update Vehicle');
			$('#vModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			data = vtable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});



// Confirm Delete Button
$('#btnDelete').on('click', function(e){
	e.preventDefault();
	$.ajax({
		type: 'DELETE',
		url:  '/admin/vehicle/' + data.plateNumber,
		data: {
			'_token' : $('input[name=_token').val()
		},
		success: function (data)
		{
			vtable.ajax.reload();
			$('#confirm-delete').modal('hide');
		}
	})
});

// Confirm Save Button
$('#btnSave').on('click', function(e){
	e.preventDefault();

	var title = $('.modal-title').text();
	var vt_id = $('#vehicle_types_id').val();
	if(title == "New Vehicle")
	{
		$.ajax({
			type: 'POST',
			url:  '/admin/vehicle',
			data: {
				'_token' : $('input[name=_token]').val(),
				'vehicle_types_id' : vt_id,
				'plateNumber' : $('input[name=plateNumber]').val(),
				'model' : $('input[name=model]').val(),
				'dateRegistered' : $('input[name=dateRegistered]').val(),
			},
			success: function (data)
			{
				if(typeof(data) === "object"){
					vtable.ajax.reload();
					$('#vModal').modal('hide');
					$('#model').val("");
					$('.modal-title').text('New Vehicle');
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
		var vt_id = $('#vehicle_types_id').val();
		
		$.ajax({
			type: 'PUT',
			url:  '/admin/vehicle/' + data.plateNumber,
			data: {
				'_token' : $('input[name=_token]').val(),
				'vehicle_types_id' : vt_id,
				'plateNumber' : $('input[name=plateNumber]').val(),
				'model' : $('input[name=model]').val(),
				'dateRegistered' : $('input[name=dateRegistered]').val(),
			},
			success: function (data)
			{
				vtable.ajax.reload();
				$('#vModal').modal('hide');
				$('#model').val("");
				$('.modal-title').text('New Vehicle');
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