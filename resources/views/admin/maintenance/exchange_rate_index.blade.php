@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3><img src="/images/bar.png"> Maintenance | Exchange Rate</h3>
		<hr>
		<h5>Current Exchange Rate: P </h5>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#erModal" style = "width: 100%;">New Exchange Rate</button>
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
								Actions
							</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>

	<section class="content">
		<form role="form" method = "POST">
			{{ csrf_field() }}
			<div class="modal fade" id="erModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Exchange Rate</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group">
								<label>Description *</label>
								<input type = "text" class = "form-control" name = "description" id = "description" required />
							</div>
							<div class="form-group">
								<label>Current Rate: </label>
								<input type = "text" class = "form-control" value = "P 0.00" style = "text-align: right" />
							</div>
							<div class="form-group">
								<label>Rate *</label>
								<input type = "text" class = "form-control" name = "rate" id = "rate" />
							</div>
							<div class="form-group">
								<label>Date Effective</label>
								<input type = "date" class = "form-control" name = "dateEffective" id="dateEffective" />
							</div>
							<input type="hidden" name = "currentRate" value = "0" />
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
							<button class = "btn btn-danger	" id = "btnDelete" >Deactivate</button>
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
	.class-exchange-rate{
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
		var ertable = $('#er_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: 'http://localhost:8000/admin/erData',
			columns: [
			{ data: 'id' },
			{ data: 'description' },
			{ data: 'rate' },
			{ data: 'dateEffective' },
			{ data: 'created_at'},
			{ data: 'action', orderable: false, searchable: false }

			]
		});
		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Exchange Rate');
			$('#description').val("");
			$('#erModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			var ct_id = $(this).val();
			data = ertable.row($(this).parents()).data();
			$('#description').val(data.description);
			$('#rate').val(data.rate);
			$('#dateEffective').val(data.dateEffective);
			$('.modal-title').text('Edit Exchange Rate');
			$('#erModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			var ct_id = $(this).val();
			data = ertable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});



// Confirm Delete Button
$('#btnDelete').on('click', function(e){
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
	if(title == "New Exchange Rate")
	{
		$.ajax({
			type: 'POST',
			url:  '/admin/exchange_rate',
			data: {
				'_token' : $('input[name=_token]').val(),
				'description' : $('input[name=description]').val(),
				'rate' : $('input[name=rate]').val(),
				'dateEffective' : $('input[name=dateEffective]').val(),
				'currentRate' : $('input[name=currentRate]').val(),
			},
			success: function (data)
			{
				
				ertable.ajax.reload();
				$('#erModal').modal('hide');
				$('#description').val("");
				$('.modal-title').text('New Exchange Rate');

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
			})
	}
	else
	{
		$.ajax({
			type: 'PUT',
			url:  '/admin/exchange_rate/' + data.id,
			data: {
				'_token' : $('input[name=_token]').val(),
				'description' : $('input[name=description]').val(),
				'rate' : $('input[name=rate]').val(),
				'dateEffective' : $('input[name=dateEffective]').val(),
				'currentRate' : $('input[name=currentRate]').val(),
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

				ertable.ajax.reload();
				$('#erModal').modal('hide');
				$('#description').val("");
				$('.modal-title').text('New Exchange Rate');
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