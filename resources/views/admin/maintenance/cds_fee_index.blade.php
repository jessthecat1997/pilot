@extends('layouts.maintenance')
@push('styles')
<style>
.class-cds-fee
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
@section('content')

<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance | Brokerage | Customs Documentary Stamp Fee</h2>
		<hr>
		<h5>Current CDS Fee: Php 
			@if($cds_fee_current[0]->fee != null)
			{{ number_format((float)$cds_fee_current[0]->fee, 2) }}
			@else
			0.000000
			@endif
		</h5>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#cdsModal" style = "width: 100%;">New CDS Fee</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table table-striped cell-border table-bordered" id = "cds_table">
					<thead>
						<tr>
							<td>
								Date Effective
							</td>
							<td>
								Fee
							</td>
							<td>
								Actions
							</td>
						</tr>
					</thead>
					<tbody>
						@forelse($cds_fee as $cds)
						<tr>
							<td>
								{{ Carbon\Carbon::parse($cds->dateEffective)->format("F d, Y") }}
							</td>
							<td>
								{{ $cds->fee }}
							</td>
							<td>
								<button value = "{{ $cds->id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button><button value = "{{ $cds->id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
								<input type = "hidden" value = "{{ Carbon\Carbon::parse($cds->dateEffective)->format('m/d/Y') }}"  class = "dateEffective" />
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
			<div class="modal fade" id="cdsModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New CDS Fee</h4>
						</div>
						<div class="modal-body">			

							<div class="form-group required">
								<label class = "control-label">Fee</label>
								<div class = "form-group input-group " >
									<span class = "input-group-addon">Php</span>
									<input type = "text"   class = "form-control money" name = "fee" id = "fee"  data-rule-required="true" value="0.00" />
								</div>
								

							</div>

							<div class="form-group required">
								<label class = "control-label">Date Effective</label>
								<input type = "date" class = "form-control" name = "dateEffective" id="dateEffective" data-rule-required="true"/>
								
							</div>
							
							<input type="hidden" name = "currentFee" value = "0" />

							<small style = "color:red; text-align: left"><i>All field(s) with (*) are required.</i></small>

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

@push('scripts')
<script type="text/javascript">
	$('#brokeragecollapse').addClass('in');
	$('#collapse2').addClass('in');
	var data;
	var cds_id;
	$(document).ready(function(){

		var cdstable = $('#cds_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender:true,
			columns: [
			{ data: 'dateEffective' },
			{ data: 'fee',
			"render" : function( data, type, full ) {
				return formatNumber(data); } },                              
				
				{ data: 'action', orderable: false, searchable: false }

				],	"order": [[ 0, "desc" ]],
			});
		$("#commentForm").validate({
			rules: 
			{
				fee:
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

		$(document).on('keyup keydown keypress', '.money', function (event) {
			var len = $('.money').val();
			var value = $('.money').inputmask('unmaskedvalue');
			if (event.keyCode == 8) {
				if(parseFloat(value) == 0 || value == ""){
					$('.money').val("0.00");
				}
			}
			else
			{
				if(value == ""){
					$('.money').val("0.00");
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
			$('.modal-title').text('New CDS Fee');
			$('#cdsModal').modal('show');
			$('#fee').val("0.00");
			var now = new Date();
			var day = ("0" + now.getDate()).slice(-2);
			var month = ("0" + (now.getMonth() + 1)).slice(-2);
			var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
			$('#dateEffective').val(today);

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			cds_id = $(this).val();
			data = cdstable.row($(this).parents()).data();
			$('#fee').val(data.fee);
			$('#dateEffective').val('.dateEffective');
			$('.modal-title').text('Update CDS Fee');
			$('#cdsModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			cds_id = $(this).val();
			data = cdstable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});

		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/cds_fee/' + cds_id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					cdstable.ajax.url('{{ route("cds.data") }}').load();
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

			var fee_unmask = $('#fee').inputmask('unmaskedvalue');
			var fee_nocomma = parseFloat(fee_unmask);
			
			e.preventDefault();
			var title = $('.modal-title').text();

			if(title == "New CDS Fee")
			{
				if ($('#dateEffective').valid()){

					$.ajax({
						type: 'POST',
						url:  '/admin/cds_fee',
						data: {
							'_token' : $('input[name=_token]').val(),
							'fee' : fee_nocomma,
							'dateEffective' : $('input[name=dateEffective]').val(),
							'currentFee' : $('input[name=currentFee]').val(),
						},
						success: function (data)
						{


							if(typeof(data) === "object"){
								cdstable.ajax.url( '{{ route("cds.data") }}' ).load();
								$('#cdsModal').modal('hide');
								$('.modal-title').text('New CDS Fee');
								$('#fee').val('');
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
			}else{
				if ($('#dateEffective').valid()){
					$.ajax({
						type: 'PUT',
						url:  '/admin/cds_fee/' + cds_id,
						data: {
							'_token' : $('input[name=_token]').val(),
							'fee' : fee_nocomma,
							'dateEffective' : $('input[name=dateEffective]').val(),
							'currentFee' : $('input[name=currentFee]').val(),
						},
						success: function (data)
						{

							if(typeof(data) === "object"){
								cdstable.ajax.url( '{{ route("cds.data") }}' ).load();
								$('#cdsModal').modal('hide');
								$('.modal-title').text('New CDS Fee');
								$('#fee').val('');
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
								toastr["success"]("Record updated successfully");
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