@extends('layouts.utilities')
@section('content')
@push('styles')
<style>
	.class-province
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
	.utilities
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Utilities | Archive | Province</h2>
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
						<table class = "table-responsive table" id = "lp_table">
							<thead>
								<tr>
									<td style="width: 40%;">
										Province Name
									</td>
									<td style="width: 20%;">
										Status
									</td>
									<td style="width: 20%;">
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
							
							<button class = "btn btn-danger	" id = "btnDeactivate" >Deactivate</button>
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
							
							<button class = "btn btn-success	" id = "btnActivate" >Activate</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	var data;
	var filter = 0;

	$('#collapse4').addClass('in');
	$('#archivecollapse').addClass('in');
	$('#archive_deliverycollapse').addClass('in');
	
	$(document).ready(function(){
		var lptable = $('#lp_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: 'http://localhost:8000/utilities/location_province_deactivated/' + filter,
			columns: [
			{ data: 'name' },
			{ data: 'status'},
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "asc" ]],
		});


		$(document).on('click', '.deactivate', function(e){
			var bst_id = $(this).val();
			data = lptable.row($(this).parents()).data();
			$('#confirm-deactivate').modal('show');
		});

		$(document).on('click', '.activate', function(e){
			var bst_id = $(this).val();
			data = lptable.row($(this).parents()).data();
			$('#confirm-activate').modal('show');
		});



		$('#btnDeactivate').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/location_province/' + data.id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					lptable.ajax.reload();
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
					toastr["success"]("Record deactivated successfully");
				}
			})
		});

		$('#btnActivate').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'PUT',
				url:  '/utilities/location_province_reactivate/' + data.id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					lptable.ajax.reload();
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
					toastr["success"]("Record reactivated successfully");
				}
			})
		});


		$(document).on('change', '.change-filter', function(e)
		{
			filter = $(this).val();
			$('#lp_table').dataTable().fnDestroy();
			var lptable = $('#lp_table').DataTable({
				processing: false,
				serverSide: false,
				deferRender: true,
				ajax: 'http://localhost:8000/utilities/location_province_deactivated/' + filter,
				columns: [
				{ data: 'name' },
				{ data: 'status'},
				{ data: 'action', orderable: false, searchable: false }

				],	"order": [[ 0, "asc" ]],
			});
		})

		

	});

	function resetErrors() {
		$('form input, form select').removeClass('inputTxtError');
		$('label.error').remove();
	}
</script>
@endpush