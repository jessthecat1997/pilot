@extends('layouts.maintenance')
@section('content')

<div class = "container-fluid">
	<div class = "row">
		<h3><img src="/images/bar.png">Maintenance| Billing| Vat Rate</h3>
		<hr>
		Current Vat Rate: 
		@if($vat_rate_current[0]->rate != null)
		{{ number_format((float)$vat_rate_current[0]->rate, 3) }}%
		@else
		0.00 %
		@endif
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#vrModal" style = "width: 100%;">New Vat Rate</button>
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
								Date Effective
							</td>
							<td>
								Rate
							</td>
							
							<td>
								Actions
							</td>
						</tr>
					</thead>
					<tbody>
						@forelse($vat_rate as $vr)
						<tr>
							<td>
								{{ Carbon\Carbon::parse($vr->dateEffective)->format("F d, Y") }}
							</td>
							<td>
								{{ $vr->rate }}
							</td>
							<td>
								<button value = "{{ $vr->id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button>
								<button value = "{{ $vr->id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
								<input type = "hidden" value = "{{ Carbon\Carbon::parse($vr->dateEffective)->format('Y-m-d') }}"  class = "date_Effective" />
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
		<form role="form" method = "POST" id ="commentForm" >
			{{ csrf_field() }}
			<div class="modal fade" id="vrModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New VAT Rate</h4>
						</div>
						<div class="modal-body">			

							<div class="form-group required">
								<label class = "control-label">Rate</label>
								<div class = "form-group input-group " >
									<input type = "number" class = "form-control percentage" name = "rate" id = "rate"  data-rule-required="true" max="100" value="0.00" style="text-align: right" />
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
.maintenance
{
	border-left: 10px solid #2ad4a5;
	background-color:rgba(128,128,128,0.1);
	color: #fff;
}
.class-vat-rate
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
	var vr_id;
	$('#collapse2').addClass('in');
	$('#billingcollapse').addClass('in');
	
	$(document).ready(function(){

		var vrtable = $('#vr_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			columns: [
			{ data: 'dateEffective' },
			{ data: 'rate' },                              
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
			$('.modal-title').text('New VAT Rate');
			$('#vrModal').modal('show');
			$('#rate').val("0.00");
			var now = new Date();
			var day = ("0" + now.getDate()).slice(-2);
			var month = ("0" + (now.getMonth() + 1)).slice(-2);
			var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
			$('#dateEffective').val(today);

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			vr_id = $(this).val();
			data = vrtable.row($(this).parents()).data();
			$('#rate').val(data.rate);
			$('#dateEffective').val($(this).closest('tr').find('.date_Effective').val());
			$('.modal-title').text('Update VAT Rate');
			$('#vrModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			vr_id = $(this).val();
			data = vrtable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});


		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/vat_rate/' + vr_id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					vrtable.ajax.url('{{ route("vr.data") }}').load();
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

			e.preventDefault();
			var title = $('.modal-title').text();


			if(title == "New VAT Rate")
			{
				if($('#rate').valid() && $('#dateEffective').valid()){
					$('#btnSave').attr('disabled', 'true');

					$.ajax({
						type: 'POST',
						url:  '{{ route("vat_rate.store") }}',
						data: {
							'_token' : $('input[name=_token]').val(),
							'rate' : $('#rate').val(),
							'dateEffective' : $('#dateEffective').val(),
							'currentRate' : 0,
							'description' : '',

						},
						success: function (data)
						{

							if(typeof(data) === "object"){
								vrtable.ajax.url('{{ route("vr.data") }}').load();
								$('#vrModal').modal('hide');
								$('.modal-title').text('New VAT Rate');
								$('#rate').val('0.00');
								



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
								toastr["success"]("Record added successfully");
								$('#btnSave').removeAttr('disabled');
								window.location.reload();
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
				
			}
			else
			{
				if($('#rate').valid() && $('#dateEffective').valid()){

					$('#btnSave').attr('disabled', 'true');

					$.ajax({
						type: 'PUT',
						url:  '{{ route("vat_rate.index") }}/' + vr_id,
						data: {
							'_token' : $('input[name=_token]').val(),
							'rate' : $('#rate').val(),
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

							vrtable.ajax.ajax.url('{{ route("vr.data") }}').load();
							$('#vrModal').modal('hide');
							$('#rate').val("");
							$('#dateEffective').val("");
							$('.modal-title').text('New vr rate');
							$('#btnSave').removeAttr('disabled');
							window.location.reload();
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