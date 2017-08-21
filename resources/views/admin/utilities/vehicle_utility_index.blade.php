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
								Make
							</td>
							<td>
								Body Type
							</td>
							<td>
								LTO Date Registered
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
			<div class="modal fade" id="confirm-deactivate" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							Deactivate record
						</div>
						<div class="modal-body">
							Confirm Deactivating
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<button class = "btn btn-danger	" id = "btnDeactivate" >Deactivate</button>
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
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<button class = "btn btn-danger	" id = "btnActivate" >Activate</button>
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
    var filter = 0;
	var data;
	
	$(document).ready(function(){
		var vtable = $('#v_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: 'http://localhost:8000/utilities/vehicle_deactivated/' + filter,
			columns: [
			{ data: 'vehicle_types_id' },
			{ data: 'plateNumber' },
			{ data: 'model' },
			{ data: 'bodyType' },
			{ data: 'dateRegistered' },
			{ data: 'status'},
			{ data: 'action', orderable: false, searchable: false }

			],
			"order": [[ 6 , "desc"]],
		});
		
		$(document).on('click', '.deactivate', function(e){
			data = vtable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});

		$(document).on('click', '.activate', function(e){
			data = vtable.row($(this).parents()).data();
			$('#confirm-activate').modal('show');
		});



// Confirm Delete Button
$('#btnDeactivate').on('click', function(e){
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

$('#btnActivate').on('click', function(e){
	e.preventDefault();
	$.ajax({
		type: 'DELETE',
		url:  '/utilities/vehicle_reactivate/' + data.plateNumber,
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


$(document).on('change', '.change-filter', function(e)
{
	filter = $(this).val();
	$('#v_table').dataTable().fnDestroy();
	var vtable = $('#v_table').DataTable({
		processing: true,
		serverSide: true,
		ajax: 'http://localhost:8000/utilities/vehicle_deactivated/' + filter,
		columns: [
		{ data: 'vehicle_types_id' },
		{ data: 'plateNumber' },
		{ data: 'model' },
		{ data: 'bodyType' },
		{ data: 'dateRegistered' },
		{ data: 'status'},
		{ data: 'action', orderable: false, searchable: false }

		],
		"order": [[ 6 , "desc"]],
	});
})



});

	function resetErrors() {
		$('form input, form select').removeClass('inputTxtError');
		$('label.error').remove();
	}
</script>
@endpush