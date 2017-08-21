
@extends('layouts.utilities')
@section('content')

<div class = "container-fluid">
	<div class = "row">
		<h3><img src="/images/bar.png"> Utilities |Vat Rate</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#vrModal" style = "width: 100%;">New Vate Rate </button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table" id = "vr_table">
					<thead>
						<tr>
							<td>
								No.
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
		<form role="form" method = "POST" id ="commentForm" >
			{{ csrf_field() }}
			<div class="modal fade" id="vrModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New vr rate</h4>
						</div>
						<div class="modal-body">			

							<div class="form-group required">
								<label class = "control-label">rate</label>
								<div class = "form-group input-group " >
									<input type = "number" class = "form-control percentage" name = "rate" id = "rate"  data-rule-required="true" max="100" value="0.00" />
									<span class = "input-group-addon">%</span>
								</div>
								

							</div>

							<div class="form-group required">
								<label class = "control-label">Date Effective</label>
								<input type = "date" class = "form-control" name = "dateEffective" id="dateEffective" data-rule-required="true"/>
								
							</div>
							
							<input type="hidden" name = "currentrate" value = "0" />
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
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
							
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

		var vrtable = $('#vr_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: 'http://localhost:8000/admin/vrData',
			columns: [
			{ data: 'id'},
			{ data: 'rate',
			"render" : function( data, type, full ) {
				return formatNumber(data); } },                              
				{ data: 'dateEffective' },
				{ data: 'created_at'},
				{ data: 'action', orderable: false, searchable: false }

				],	"order": [[ 0, "desc" ]],
			});

		$("#commentForm").validate({
			rules: 
			{
				rate:
				{
					required: true,
				},

				dateEffective:
				{
					required: true,
					date: true,
				}
			},
			onkeyup: false, 
			submitHandler: function (form) {
				return false;
			}
		});
		

		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New vr rate');
			$('#vrModal').modal('show');
			$('#rate').val("");
			$('#dateEffective').val("");
			var now = new Date();
			var day = ("0" + now.getDate()).slice(-2);
			var month = ("0" + (now.getMonth() + 1)).slice(-2);
			var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
			$('#dateEffective').val(today);

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			var ct_id = $(this).val();
			data = vrtable.row($(this).parents()).data();
			$('#rate').val(data.rate);
			$('#dateEffective').val(data.dateEffective);
			$('.modal-title').text('Update vr rate');
			$('#vrModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			var ct_id = $(this).val();
			data = vrtable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});


		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/vr_rate/' + data.id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					vrtable.ajax.reload();
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


		$('#btnSave').on('click', function(e){



			var rate_nocomma = $('#rate').inputmask('unmaskedvalue');
			if (rate_nocomma == "0.00"){
				rate_nocomma = "";
			}

			e.preventDefault();
			var title = $('.modal-title').text();

			if(title == "New vr rate")
			{
				$.ajax({
					type: 'POST',
					url:  '{{ route("vat_rate.store") }}',
					data: {
						'_token' : $('input[name=_token]').val(),
						'rate' : rate_nocomma,
						'dateEffective' : $('input[name=dateEffective]').val(),
						'currentrate' : 0,
					},
					success: function (data)
					{

						if(typeof(data) === "object"){
							vrtable.ajax.reload();
							$('#vrModal').modal('hide');
							$('.modal-title').text('New vr rate');
							$('#rate').val('');
							$('#dateEffective').val('');



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
						}else{

							resetErrors();
							var invdata = JSON.parse(data);
							$.each(invdata, function(i, v) {
								console.log(i + " => " + v); 
								var msg = '<label class="error" for="'+i+'">'+v+'</label>';
								$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
							});

						}
					},

				})
			}
			else
			{


				$.ajax({
					type: 'PUT',
					url:  '/admin/vr_rate/' + data.id,
					data: {
						'_token' : $('input[name=_token]').val(),
						'rate' : rate_nocomma,
						'dateEffective' : $('input[name=dateEffective]').val(),
						'currentrate' : $('input[name=currentrate]').val(),
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

						vrtable.ajax.reload();
						$('#vrModal').modal('hide');
						$('#rate').val("");
						$('#dateEffective').val("");
						$('.modal-title').text('New vr rate');
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