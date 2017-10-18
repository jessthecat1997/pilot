@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance | Brokerage | Exchange Rate</h2>
		<hr>
		<h5>Current Exchange Rate: Php 
			@if($no_current == "false")
			@if($exchange_rate_current[0]->rate != null)
			{{ number_format((float)$exchange_rate_current[0]->rate, 5) }}
			@else
			0.000000
			@endif
			@else
			0.00
			@endif
		</h5>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#erModal" style = "width: 100%;">New Exchange Rate</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table  table-striped cell-border table-bordered" id = "er_table">
					<thead>
						<tr>
							<td>
								Date Effective
							</td>
							<td>
								Rate
							</td>
							<td>
								Remarks
							</td>
							<td>
								Actions
							</td>
						</tr>
					</thead>
					<tbody>
						@forelse($exchange_rate as $er)
						<tr>
							<td>
								{{ Carbon\Carbon::parse($er->dateEffective)->format("F d, Y") }}
							</td>
							<td>
								{{ $er->rate }}
							</td>
							<td>
								{{ $er->description}}
							</td>
							<td>
								<button value = "{{ $er->id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button><button value = "{{ $er->id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
								<input type = "hidden" value = "{{ Carbon\Carbon::parse($er->dateEffective)->format('Y-m-d') }}"  class = "date_Effective" />
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
		<form role="form" method = "POST" id="commentForm">
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
								<label>Current Rate: </label>
								<input type="hidden" name = "currentRate" value = "0" />
								<input type = "text" class = "form-control" value = 
								@if($no_current == "false")
								@if($exchange_rate_current[0]->rate != null)
								{{ number_format((float)$exchange_rate_current[0]->rate, 5) }}
								@else
								0.000000
								@endif
								@else
								0.00
								@endif
								style = "text-align: right" readonly = "true" />
							</div>
							<div class="form-group  required">
								<label class ="control-label">1 US Dollar equals</label>
								<div class = "form-group input-group " >
									<span class = "input-group-addon">Php</span>
									<input type = "text" class = "form-control money_er" name = "rate" id = "rate" data-rule-required="true" value= "0.0000000"/>
								</div>
							</div>
							<div class="form-group required">
								<label class = "control-label">Date Effective</label>
								<input type = "date" class = "form-control" name = "dateEffective" id="dateEffective" data-rule-required="true" />
							</div>
							<div class="form-group">
								<label class = "form-group">Remarks</label>
								<textarea  row = "6" class = "form-control" id = "description" ></textarea> 
							</div>
							<small style = "color:red; text-align: left"><i>All field(s) with (*) are required.</i></small>
						</div>

						<div class="modal-footer">
							<input id = "btnSave" type = "submit" class="btn btn-success" value = "Save" />
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
.class-exchange-rate{
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
	$('#brokeragecollapse').addClass('in');
	$('#collapse2').addClass('in');
	var data;
	var er_id;
	$(document).ready(function(){
		var ertable = $('#er_table').DataTable({
			"dom": '<"toolbar">frtip',
			processing: false,
			serverSide: false,
			deferRender: true,
			"bSort": false,
			columns: [
			{ data: 'dateEffective' },
			{ data: 'rate' },
			{ data: 'description' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 2, "desc" ]],
		});

		$("div.toolbar").html('<div class = "col-md-3"><input type = "checkbox" class = "check_deac"/>   Show Deactivated</div>');
		$('.check_deac').on('change', function(e)
		{
			e.preventDefault();
			if($(this).is(':checked')){
				ertable.ajax.url( '{{ route("er.data") }}/1').load();
			}
			else{
				ertable.ajax.url( '{{ route("er.data") }}').load();
			}
		})

		$(document).on('click', '.activate', function(e){
			var ct_id = $(this).val();
			data = ertable.row($(this).parents()).data();
			$('#confirm-activate').modal('show');
		});

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
					date:true,
				},


			},
			onkeyup: false, 
			submitHandler: function (form) {
				return false;
			}
		});

		$(document).on('keyup keydown keypress', '.money_er', function (event) {
			var len = $('.money_er').val();
			var value = $('.money_er').inputmask('unmaskedvalue');
			if (event.keyCode == 8) {
				if(parseFloat(value) == 0 || value == ""){
					$('.money_er').val("0.00");
				}
			}
			else
			{
				if(value == ""){
					$('.money_er').val("0.00");
				}
				if(parseFloat(value) <= 9999999.99){
					
				}
				else{
					if(event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 116){

					}
					else{
						return false;
					}
				}
			}
			if(event.keyCode == 189)
			{
				return false;
			}			
		});


		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Exchange Rate');
			var now = new Date();
			var day = ("0" + now.getDate()).slice(-2);
			var month = ("0" + (now.getMonth() + 1)).slice(-2);
			var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
			$('#dateEffective').val(today);

			$("#rate").val("0.00");
			$("#description").val("");

			$('#erModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			er_id = $(this).val();
			data = ertable.row($(this).parents()).data();
			$('#dateEffective').val($(this).closest('tr').find('.date_Effective').val());
			$('#description').val(data.description);
			$('#rate').val(data.rate);
			$('.modal-title').text('Update Exchange Rate');
			$('#erModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			er_id = $(this).val();
			data = ertable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});


		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/exchange_rate/' + er_id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					ertable.ajax.url('{{ route("er.data") }}/1').load();
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
			if(title == "New Exchange Rate")
			{
				if ($('#dateEffective').valid()){

					
					$.ajax({
						type: 'POST',
						url:  '/admin/exchange_rate',
						data: {
							'_token' : $('input[name=_token]').val(),
							'rate' : $('#rate').inputmask("unmaskedvalue"),
							'dateEffective' : $('input[name=dateEffective]').val(),
							'description' : $('input[name=description]').val(),
							'currentRate' : $('input[name=currentRate]').val(),
						},

						success: function (data)
						{
							if(typeof(data) === "object"){
								ertable.ajax.url('{{ route("er.data") }}').load();
								$("#rate").val("0.00");
								$("#description").val("");
								$('#erModal').modal('hide');
								$('.modal-title').text('New Exchange Rate');
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
								$('#btnSave').removeAttr('disabled');
								window.location.reload();
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
						},

					})
					$('#btnSave').removeAttr('disabled');
				}
				
			}
			else
			{

				if($('#dateEffective').valid()){

					

					$.ajax({
						type: 'PUT',
						url:  '/admin/exchange_rate/' + er_id,
						data: {
							'_token' : $('input[name=_token]').val(),
							'description' : $('input[name=description]').val(),
							'rate' : $('#rate').inputmask("unmaskedvalue"),
							'dateEffective' : $('input[name=dateEffective]').val(),
							'currentRate' : $('input[name=currentRate]').val(),
						},
						success: function (data)
						{
							if(typeof(data) === "object"){
								ertable.ajax.url('{{ route("er.data") }}').load();
								$("#rate").val("0.00");
								$("#description").val("");
								$('#erModal').modal('hide');
								$('.modal-title').text('New Exchange Rate');
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
								$('#btnSave').removeAttr('disabled');
								window.location.reload();
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