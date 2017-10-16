@extends('layouts.utilities')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3><img src="/images/bar.png"> Utilites | Archive | Exchange Rate</h3>
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
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table" id = "er_table">
					<thead>
						<tr>
							<td>
								No.
							</td>
							<td>
								Description
							</td>
							<td>
								Rate
							</td>
							<td>
								Date Effective
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
							<button class = "btn btn-success	" id = "btnActivate" >Activate</button>
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

	$('#collapse4').addClass('in');
	$('#archivecollapse').addClass('in');
	$('#archive_brokeragecollapse').addClass('in');
	
	$(document).ready(function(){
		var ertable = $('#er_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: 'http://localhost:8000/utilities/exchange_rate_deactivated/' + filter,
			columns: [
			{ data: 'id' },
			{ data: 'description' },
			{ data: 'rate' },
			{ data: 'dateEffective' },
			{ data: 'created_at'},
			{ data: 'status'},
			{ data: 'action', orderable: false, searchable: false }

			],

			"order": [[ 6, "desc" ]],



		});
		
		$(document).on('click', '.deactivate', function(e){
			var ct_id = $(this).val();
			data = ertable.row($(this).parents()).data();
			$('#confirm-deactivate').modal('show');
		});

		$(document).on('click', '.activate', function(e){
			var ct_id = $(this).val();
			data = ertable.row($(this).parents()).data();
			$('#confirm-activate').modal('show');
		});


		$('#btnDeactivate').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/exchange_rate/' + data.id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					ertable.ajax.reload();
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
		url:  '/utilities/exchange_rate_reactivate/' + data.id,
		data: {
			'_token' : $('input[name=_token').val()
		},
		success: function (data)
		{
			ertable.ajax.reload();
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



$(document).on('change', '.change-filter', function(e)
{
	filter = $(this).val();
	$('#er_table').dataTable().fnDestroy();
	var ertable = $('#er_table').DataTable({
		processing: true,
		serverSide: true,
		ajax: 'http://localhost:8000//utilities/exchange_rate_deactivated/' + filter,
		columns: [
		{ data: 'id' },
		{ data: 'description' },
		{ data: 'rate' },
		{ data: 'dateEffective' },
		{ data: 'created_at'},
		{ data: 'status'},
		{ data: 'action', orderable: false, searchable: false }

		],

		"order": [[ 6, "desc" ]],


	});
})

});

	function resetErrors() {
		$('form input, form select').removeClass('inputTxtError');
		$('label.error').remove();
	}
</script>
@endpush