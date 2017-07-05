@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<h3><img src="/images/bar.png"> Maintenance | Vehicles</h3>
	<hr>
	<div class = "row">
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#vModal" style = "width: 100%;">New Vehicle</button>
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
								Actions
							</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<section class="content">
		<form role="form" method = "POST" class="form-group">
			{{ csrf_field() }}
			<div class="modal fade" id="vModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Vehicle</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group">
								<label>Vehicle Type *</label>
								<select class = "form-control" name = "vehicle_types_id" id = "vehicle_types_id">
									<option>

									</option>
									@forelse($vts as $vt)
									<option value = "{{ $vt->id }}">
										{{ $vt->description }}
									</option>
									@empty
									@endforelse
								</select>
							</div>
						</div>
						<div class="modal-body">			
							<div class="form-group">
								<label>Plate Number *</label>
								<input type = "text" class = "form-control" name = "plateNumber" id = "plateNumber" required />
							</div>
						</div>
						<div class="modal-body">			
							<div class="form-group">
								<label>Model *</label>
								<input type = "text" class = "form-control" name = "model" id = "model" required />
							</div>
						</div>
						<div class="modal-body">			
							<div class="form-group">
								<label>Date Registered *</label>
								<input type = "date" class = "form-control" name = "dateRegistered" id = "dateRegistered" required />
							</div>
						</div>
						<div class="modal-footer">
							<input id = "btnSave" type = "submit" class="btn btn-success" value = "Save" />
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>				
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
	.class-vehicle
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
			$('.modal-title').text('Edit Vehicle');
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