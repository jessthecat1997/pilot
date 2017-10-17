@extends('layouts.maintenance')
@section('content')

<div class = "container-fluid">
	<div class = "row">
		<h3>&nbsp;Maintenance | Delivery | Province</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#sotModal" style = "width: 100%;">New Province</button>
		</div>
	</div>

	<br />
	<div class = "container-fluid">
		<div class = "row">
			<div class = "col-md-10 col-md-offset-1">
				<div class = "panel-default panel">
					<div class = "panel-body">
						<table class = "table-responsive table table-striped cell-border table-bordered" id = "lp_table">
							<thead>
								<tr>
									<td >
										Province Name
									</td>
									<td >
										Actions
									</td>
								</tr>
							</thead>
							<tbody>
								@forelse($provinces as $province)
								<tr>
									<td>
										{{ $province->name }}
									</td>
									<td>
										<button value = "{{ $province->id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button>
										<button value = "{{ $province->id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
									</td>
								</tr>
								@empty
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div> 
		</div>
	</div>

	<section class="content">
		<form role="form" method = "POST" id = "commentForm">
			{{ csrf_field() }}
			<div class="modal fade" id="lpModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Province</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group required">
								<label class = "control-label">Name:</label>
								<input type = "text" class = "form-control" name = "name" id = "name"  minlength = "2" data-rule-required="true" />
								
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
							Confirm Deactivating
						</div>
						<div class="modal-footer">
							
							<button class = "btn btn-danger	" id = "btnDelete" >Deactivate</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					</div>
				</div>
			</div>
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
.class-province
{
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
	$('#deliverycollapse').addClass('in');
	$('#collapse2').addClass('in');
	var data;
	var p_id;
	$(document).ready(function(){
		var lptable = $('#lp_table').DataTable({
			"dom": '<"toolbar">frtip',
			processing: false,
			serverSide: false,
			deferRender: true,
			columns: [
			{ data: 'name' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "asc" ]],
		});
		$("div.toolbar").html('<div class = "col-md-3"><input type = "checkbox" class = "check_deac"/>   Show Deactivated</div>');
		$('.check_deac').on('change', function(e)
		{
			e.preventDefault();
			if($(this).is(':checked')){
				lptable.ajax.url( '{{ route("lp.data") }}/1').load();
			}
			else{
				lptable.ajax.url( '{{ route("lp.data") }}').load();
			}
		})

		$(document).on('click', '.activate', function(e){
			var bst_id = $(this).val();
			data = lptable.row($(this).parents()).data();
			$('#confirm-activate').modal('show');
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

		$(document).ready(function() {
			$("#commentForm").validate({
				rules: 
				{
					name:
					{
						required: true,
						minlength: 2,
						maxlength: 50,
						normalizer: function(value) {
							value = value.replace("something", "new thing");
							return $.trim(value)
						},
						lettersonly:true,

					},

				},
				onkeyup: function(element) {$(element).valid()}, 
				submitHandler: function (form) {
					return false;
				}


			});

			$('#commentForm input').on('keyup blur', function () {
				if ($('#commentForm').valid()) {
					$('button.submit').prop('disabled', false);
				} else {
					$('button.submit').prop('disabled', 'disabled');
				}
			});



		});


		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Province');
			$('#name').val("");
			$('#lpModal').modal('show');

		});
		
		$(document).on('click', '.edit',function(e){
			resetErrors();
			p_id = $(this).val();
			data = lptable.row($(this).parents()).data();
			$('#name').val(data.name);
			$('.modal-title').text('Update Province');
			$('#lpModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			p_id = $(this).val();
			data = lptable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});



		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/location_province/' + p_id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					lptable.ajax.url( '{{ route("lp.data") }}' ).load();
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
					toastr["success"]("Record deactivated successfully");
				}
			})
		});

		$('#btnSave').on('click', function(e){
			e.preventDefault();
			var title = $('.modal-title').text();
			$('#name').valid();

			if(title == "New Province")
			{
				if($('#name').valid())
				{
					$.ajax({
						type: 'POST',
						url:  '/admin/location_province',
						data: {
							'_token' : $('input[name=_token]').val(),
							'name' : $('input[name=name]').val(),
						},
						success: function (data)
						{
							if(typeof(data) === "object"){
								lptable.ajax.url( '{{ route("lp.data") }}' ).load();
								$('#lpModal').modal('hide');
								$('#name').val("");
								$('.modal-title').text('New Province');


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
								toastr["success"]("Record added successfully")
							}
							else{
								resetErrors();
								var invdata = JSON.parse(data);
								$.each(invdata, function(i, v) {
									console.log(i + " => " + v);
									var msg = '<label class="error" for="'+i+'">'+v+'</label>';
									$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
								});

							}
						}

					})
				}
			}
			else
			{
				if($('#name').valid())
				{
					$.ajax({
						type: 'PUT',
						url:  '/admin/location_province/' + p_id,
						data: {
							'_token' : $('input[name=_token]').val(),
							'name' : $('input[name=name]').val(),
						},
						success: function (data)
						{
							if(typeof(data) === "object"){
								lptable.ajax.url( '{{ route("lp.data") }}' ).load();
								$('#lpModal').modal('hide');
								$('#name').val("");
								$('.modal-title').text('New Province');


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
								toastr["success"]("Record added successfully")
							}
							else{
								resetErrors();
								var invdata = JSON.parse(data);
								$.each(invdata, function(i, v) {
									console.log(i + " => " + v);
									var msg = '<label class="error" for="'+i+'">'+v+'</label>';
									$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
								});

							}
						}
					})
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