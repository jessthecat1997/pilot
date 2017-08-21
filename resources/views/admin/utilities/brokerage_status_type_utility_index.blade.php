@extends('layouts.utilities')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3><img src="/images/bar.png"> Utilities | Brokerage Status Type </h3>
		<hr>
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
	<div class = "container-fluid">
		<div class = "row">
			<div class = "col-md-10 col-md-offset-1">
				<div class = "panel-default panel">
					<div class = "panel-body">
						<table class = "table-responsive table" id = "bst_table">
							<thead>
								<tr>
									<td>
										Status
									</td>

									<td>
										Description
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
							<button class = "btn btn-success" id = "btnActivate" >Activate</button>
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
	var filter = 0;
	$(document).ready(function(){
		var bsttable = $('#bst_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: 'http://localhost:8000//utilities/brokerage_status_type_deactivated/' + filter,
			columns: [
			{ data: 'status'},
			{ data: 'description' },
			{ data: 'action', orderable: false, searchable: false }

			],
			"order": [[ 4, "desc" ]],

		});
		
		$(document).on('click', '.deactivate', function(e){
			var bst_id = $(this).val();
			data = bsttable.row($(this).parents()).data();
			$('#confirm-deactivate').modal('show');
		});

		$(document).on('click', '.activate', function(e){
			var bst_id = $(this).val();
			data = bsttable.row($(this).parents()).data();
			$('#confirm-activate').modal('show');
		});



// Confirm Deactivate Button
$('#btnDeactivate').on('click', function(e){
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
			$('#confirm-deactivate').modal('hide');

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


// Confirm Activate Button
$('#btnActivate').on('click', function(e){
	e.preventDefault();
	$.ajax({
		type: 'PUT',
		url:  '/utilities/brokerage_status_type_reactivate/' + data.id,
		data: {
			'_token' : $('input[name=_token').val()
		},
		success: function (data)
		{
			bsttable.ajax.reload();
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
			toastr["success"]("Record deactivated successfully")
		}
	})
});

$(document).on('change', '.change-filter', function(e)
{
	filter = $(this).val();
	$('#bst_table').dataTable().fnDestroy();
	var cdstable = $('#cds_table').DataTable({
		processing: true,
		serverSide: true,
		ajax: 'http://localhost:8000//utilities/brokerage_status_type_deactivated/' + filter,
		columns: [
		{ data: 'id' },
		{ data: 'description' },
		{ data: 'created_at'},
		{ data: 'status'},
		{ data: 'action', orderable: false, searchable: false }

		],
		"order": [[ 4, "desc" ]],

	});
})

});

	function resetErrors() {
		$('form input, form select').removeClass('inputTxtError');
		$('label.error').remove();
	}
</script>
@endpush