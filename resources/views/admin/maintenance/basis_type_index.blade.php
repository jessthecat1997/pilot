@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3> Maintenance |Basis Types</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#btModal" style = "width: 100%;">New Basis Type</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table cell-border table-striped table-bordered" id = "bt_table" style="width: 100%;">
					<thead>
						<tr>
							<td >
								Name
							</td>
							<td>
								Abbreviation
							</td>
							<td >
								Actions
							</td>
						</tr>
					</thead>
					<tbody>
						@forelse($basis_type as $bt)
						<tr>
							<td>
								{{ $bt->name }}
							</td>
							<td>
								{{ $bt->abbreviation }}
							</td>
							<td>
								<button value = "{{ $bt->id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button>
								<button value = "{{ $bt->id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
							</td>
						</tr>
						@empty
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<section class="content">
		<form role="form" method = "POST" id = "commentForm">
			{{ csrf_field() }}
			<div class="modal fade" id="btModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Basis Type</h4>
						</div>
						<div class="modal-body">
							<div class="form-group required">
								<label class = "control-label">Name: </label>
								<input type = "text" class = "form-control" name = "name" id = "name" required />
							</div>

							<div class="form-group required">
								<label class = "control-label">Abbreviation: </label>
								<input class = "form-control" name = "abbreviation" id = "abbreviation">
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
							Confirm Deactivate
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
					<button class = "btn btn-success" id = "btnActivate" >Activate</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style>
.class-basis-type{
	border-left: 10px solid #8ddfcc;
	background-color:rgba(128,128,128,0.1);
	color: #fff;
}
.maintenance
{
	border-left: 10px solid #8ddfcc;
	background-color:rgba(128,128,128,0.1);
	color: #fff;
}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	$('#collapse2').addClass('in');
	$('#brokeragecollapse').addClass('in');
	var data;
	var temp_name = null;
	var temp_desc = null;
	var bt_id;
	$(document).ready(function(){
		var bttable = $('#bt_table').DataTable({
			"dom": '<"toolbar">frtip',
			processing: false,
			serverSide: false,
			deferRender: true,
			columns: [
			{ data: 'name' },
			{ data: 'abbreviation' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "asc" ]],
		});

		$("div.toolbar").html('<div class = "col-md-3"><input type = "checkbox" class = "check_deac"/>   Show Deactivated</div>');
		$('.check_deac').on('change', function(e)
		{
			e.preventDefault();
			if($(this).is(':checked')){
				bttable.ajax.url( '{{ route("bt.data") }}/1').load();
			}
			else{
				bttable.ajax.url( '{{ route("bt.data") }}').load();
			}
		})


		$(document).on('click', '.activate', function(e){
			bt_id = $(this).val();
			data = bttable.row($(this).parents()).data();
			$('#confirm-activate').modal('show');
		});
		$('#btnActivate').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'PUT',
				url:  '/utilities/bt_reactivate/' + bt_id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					bttable.ajax.url( '{{ route("bt.data") }}/1' ).load();
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


		var validator = $("#commentForm").validate({
			rules:
			{
				name:
				{
					required: true,
					maxlength: 50,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},
					lettersonly:true,

				},

				abbreviation:
				{
					required:true,
					maxlength: 5,
				},

			},
			onkeyup: function(element) {$(element).valid()},

		});

		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Basis Type');
			$('#name').val("");
			$('#abbreviation').val("");
			$('#btModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			bt_id = $(this).val();
			data = bttable.row($(this).parents()).data();
			$('#name').val(data.name);
			$('#abbreviation').val(data.abbreviation);
			temp_name = data.name;
			temp_desc = data.abbreviation;
			$('.modal-title').text('Update Basis Type');
			$('#btModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			bt_id = $(this).val();
			data = bttable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});



// Confirm Delete Button
$('#btnDelete').on('click', function(e){
	e.preventDefault();
	$.ajax({
		type: 'DELETE',
		url:  '/admin/basis_type/' + bt_id,
		data: {
			'_token' : $('input[name=_token').val()
		},
		success: function (data)
		{
			bttable.ajax.url( '{{ route("bt.data") }}' ).load();
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

	if(title == "New Basis Type")
	{
		if($('#name').valid() && $('#abbreviation').valid()){

			$('#btnSave').attr('disabled', 'true');

			$.ajax({
				type: 'POST',
				url:  '/admin/basis_type',
				data: {
					'_token' : $('input[name=_token]').val(),
					'name' : $('#name').val(),
					'abbreviation' : $('#abbreviation').val(),
				},
				success: function (data)
				{
					if(typeof(data) === "object"){
						bttable.ajax.url( '{{ route("bt.data") }}' ).load();
						$('#btModal').modal('hide');
						$('#abbreviation').val("");
						$('.modal-title').text('New Basis Type');

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
					toastr["success"]("Record addded successfully");

					$('#name').val("");
					$('#abbreviation').val("");
					$('#btModal').modal('hide');

					$('#btnSave').removeAttr('disabled');
				}
				else{
					resetErrors();
					var invdata = JSON.parse(data);
					$.each(invdata, function(i, v) {
						console.log(i + " => " + v);
						var msg = '<label class="error" for="'+i+'">'+v+'</label>';
						$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
					});

					$('#btnSave').removeAttr('disabled');

				}
			},

		})
		}
	}
	else
	{
		if($('#name').valid() && $('#abbreviation').valid()){
			if($('#name').val() === temp_name && $('#abbreviation').val() === temp_desc){
				$('#name').val("");
				$('#abbreviation').val("");
				$('#btnSave').removeAttr('disabled');
				$('#btModal').modal('hide');
			}
			else{
				$('#btnSave').attr('disabled', 'true');

				$.ajax({
					type: 'PUT',
					url:  '/admin/basis_type/' + bt_id,
					data: {
						'_token' : $('input[name=_token]').val(),
						'name' : $('#name').val(),
						'abbreviation' : $('#abbreviation').val(),
					},
					success: function (data)
					{
						if(typeof(data) === "object"){
							bttable.ajax.url( '{{ route("bt.data") }}' ).load();
							$('#btModal').modal('hide');
							$('#abbreviation').val("");
							$('.modal-title').text('New Basis Type');

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
					toastr["success"]("Record updated successfully");

					$('#name').val("");
					$('#abbreviation').val("");
					$('#btModal').modal('hide');
					$('#btnSave').removeAttr('disabled');
				}
				else{
					resetErrors();
					var invdata = JSON.parse(data);
					$.each(invdata, function(i, v) {
						console.log(i + " => " + v);
						var msg = '<label class="error" for="'+i+'">'+v+'</label>';
						$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
					});

					$('#btnSave').removeAttr('disabled');

				}
			},

		})
			}
		}
	}
});

});

function resetErrors() {
	$('form input, form select').removeClass('inputTxtError');
	$('label.error').remove();
}
</script>
@endpush
