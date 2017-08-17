@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">

		<h3><img src="/images/bar.png">Maintenance|Contract Template</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#ctempModal" style = "width: 100%;">New section</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class  = "col-md-10 col-md-offset-1">
			<div class = "panel default-panel">
				<div class = "panel-body">
					<br />
					<hr />
					<h3>Agreements  <button  type = "submit" style="" class = "btn btn-primary btn-sm update_term_condition pull-right">Update Agreements</button></h3>
					<br />
					<div style = "overflow-y: scroll; overflow-wrap: none; height: 300px;" class="panel-default panel">

						@if($contract[0]->description == null)
						<h5 style="text-align: center;">No specified agreement details</h5>
						@else
						<p>
							<pre class = "actualspecificDetails">{!! $contract[0]->description !!}</pre>
							<input type = "hidden" class = "specificDetails" value="{{ $contract[0]->description }}" />
						</p>

						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	<section class="content">
		<form role="form" method = "POST" id = "commentForm">
			{{ csrf_field() }}
			<div class="modal fade" id="tcModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Update Term &amp; Condition</h4>
						</div>
						<div class="modal-body">			

							<table class="table table-striped" id = "term_table" style="width: 100%;">
								<thead>
									<tr>
										<td style="width: 95%;">
											<strong>Description</strong>
										</td>
										<td style="width: 5%;">
											<strong>Action</strong>
										</td>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
							<div class="row">
								<div class = "col-md-4">
									<button  type = "submit" style="width: 100%;" class = "btn btn-primary btn-sm new_term_rate pull-left">New Term and Condition</button>
								</div>
								<div class = "col-md-8">

								</div>
							</div>
							<br />
						</div>
						<div class="modal-footer">
							<input id = "btnSave" type = "submit" class="btn btn-success update_contract_term_save" value = "Save" />
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
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>
</div>
@endsection
@push('styles')
<style>
	
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	var data;
	var temp_name = "";
	var temp_desc = "";
	$(document).ready(function(){
		var ctemptable = $('#ctemp_table').DataTable({
			scrollX: true,
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: 'http://localhost:8000/admin/ctempData',
			columns: [
			{ data: 'name'},
			{ data: 'description' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "asc" ]],
		});

		$("#commentForm").validate({
			rules: 
			{
				name:
				{
					required: true,
					maxlength: 50,
				},

				description:
				{
					maxlength: 1000,
				},

			},
			onkeyup: function(element) {$(element).valid()},
			submitHandler: function (form) {
				return false;
			}
		});
		$(document).on('click', '.new_term_rate', function(e){
			e.preventDefault();
			if(validate() === true){
				$('#term_table > tbody').append(term_row);
			}
		})

		$(document).on('click', '.update_term_condition', function(e){
			e.preventDefault();
			$('#term_table > tbody').html("");
			var unsplit = $('.specificDetails').val();
			var details = unsplit.split('<br />');
			details.pop();
			var detail_html = "";
			for(var i = 0; i < details.length; i++)
			{
				detail_html += "<tr><td><textarea style= 'border-color: green;' name = 'specificDetails' class = 'form-control'>"+ details[i].substring(3, details[i].length) +"</textarea></td><td><button class = 'btn btn-danger remove_term_row'>x</button></td></tr>"
			}
			$('#term_table > tbody').append(detail_html);
			console.log(details);
			$('#tcModal').modal('show');
		})

		$(document).on('click', '.remove_term_row', function(e){
			e.preventDefault();
			$(this).closest('tr').remove();
		})




		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/contract_template/' + data.id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					ctemptable.ajax.reload();
					$('#confirm-delete').modal('hide');

					toastr.options = {
						"closeButton": false,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"ctempl": false,
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

		$('#btnSave').on('click', function(e){
			e.preventDefault();
			var title = $('.modal-title').text();

			$('#description').valid();
			$('#name').valid();

			if(title == "New Section")
			{
				if($('#name').valid() && $('#description').valid()){

					$('#btnSave').attr('disabled', 'true');
					$.ajax({
						type: 'POST',
						url:  '/admin/contract_template',
						data: {
							'_token' : $('input[name=_token]').val(),
							'name' : $('#name').val(),
							'description' : $('#description').val(),
						},
						success: function (data)
						{
							if(typeof(data) === "object"){
								ctemptable.ajax.reload();
								$('#ctempModal').modal('hide');
								$('#description').val("");
								$('.modal-title').text('New Section');



								toastr.options = {
									"closeButton": false,
									"debug": false,
									"newestOnTop": false,
									"progressBar": false,
									"ctempl": false,
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
				if($('#name').valid() && $('#description').valid())
				{
					if($('#name').val() === temp_name && $('#description').val() === temp_desc)
					{
						$('#name').val("");
						$('#description').val("");
						$('#btnSave').removeAttr('disabled');
						$('#ctempModal').modal('hide');
					} 
					else
					{
						$.ajax({
							type: 'PUT',
							url:  '/admin/contract_template/' + data.id,
							data: {
								'_token' : $('input[name=_token]').val(),
								'name' : $('#name').val(),
								'description' : $('#description').val(),
							},
							success: function (data)
							{
								if(typeof(data) === "object"){
									ctemptable.ajax.reload();
									$('#ctempModal').modal('hide');
									$('#description').val("");
									$('.modal-title').text('New Section');



									toastr.options = {
										"closeButton": false,
										"debug": false,
										"newestOnTop": false,
										"progressBar": false,
										"ctempl": false,
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
							}
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