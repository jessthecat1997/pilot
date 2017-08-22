@extends('layouts.app')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Utilities | Archive | Locations</h2>
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
				<table class = "table-responsive table" id = "ch_table">
					<thead>
						<tr>
							<td style="width: 20%;">
								Name
							</td>
							<td style="width: 35%;">
								Block No./Lot No./Street
							</td>
							<td style="width: 15%;">
								City
							</td>
							<td style="width: 15%;">
								Province
							</td>
							<td style="width: 5%;">
								Zip
							</td>
							<td style="width: 5%;">
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

@push('styles')
<style>
	.location
	{
		border-left: 10px solid #8ddfcc;
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
		var chtable = $('#ch_table').DataTable({
			processing: false,
			deferRender: true,
			serverSide: false,
			ajax: 'http://localhost:8000/utilities/locations_deactivated/' + filter,
			columns: [
			
			{ data: 'location_name' },
			{ data: 'location_address' },
			{ data: 'city_name' },
			{ data: 'province_name' },
			{ data: 'zipCode' },
			{ data: 'status' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 5, "desc" ]],
		});

		
		$(document).on('click', '.deactivate', function(e){
			e.preventDefault();
			var bst_id = $(this).val();
			data = chtable.row($(this).parents()).data();
			$('#confirm-deactivate').modal('show');
		})
		$(document).on('click', '.activate', function(e){
			e.preventDefault();
			var bst_id = $(this).val();
			data = chtable.row($(this).parents()).data();
			$('#confirm-activate').modal('show');
		})

		$(document).on('click', '#btnDeactivate', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url: "{{ route('location.index')}}/" + data.id,
				data: {
					'_token' : $('input[name=_token]').val(),
				},
				success: function(data){
					$('#confirm-deactivate').modal('hide');
					chtable.ajax.reload();

				},
				error: function(data) {
					if(data.status == 400){
						alert("Nothing found");
					}
				}
			})
		})

		$(document).on('click', '#btnActivate', function(e){
			e.preventDefault();
			$.ajax({
				type: 'PUT',
				url:  '/utilities/locations_reactivate/' + data.id,
				data: {
					'_token' : $('input[name=_token]').val(),
				},
				success: function(data){
					$('#confirm-activate').modal('hide');
					chtable.ajax.reload();

				},
				error: function(data) {
					if(data.status == 400){
						alert("Nothing found");
					}
				}
			})
		});


		$(document).on('change', '.change-filter', function(e)
		{
			filter = $(this).val();
			$('#ch_table').dataTable().fnDestroy();
			var chtable = $('#ch_table').DataTable({
				processing: false,
				deferRender: true,
				serverSide: false,
				ajax: 'http://localhost:8000/utilities/locations_deactivated/' + filter,
				columns: [

				{ data: 'location_name' },
				{ data: 'location_address' },
				{ data: 'city_name' },
				{ data: 'province_name' },
				{ data: 'zipCode' },
				{ data: 'status'},
				{ data: 'action', orderable: false, searchable: false }

				],	"order": [[ 5, "desc" ]],
			});


		});
	});


	function resetErrors() {
		$('form input, form select').removeClass('inputTxtError');
		$('label.error').remove();
	}


</script>
@endpush