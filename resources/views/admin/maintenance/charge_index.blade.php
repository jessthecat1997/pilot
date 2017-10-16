@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance | Billing | Charges</h2>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#chModal" style = "width: 100%;">New Charge</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table table-striped cell-border table-bordered" id = "ch_table">
					<thead>
						<tr>
							<td>
								Name
							</td>
							<td>
								Description
							</td>
							<td>
								Charge Type
							</td>
							<td>
								Amount
							</td>
							<td>
								Actions
							</td>
						</tr>
					</thead>
					<tbody>
						@forelse($charges as $ch)
						<tr>
							<td>
								{{ $ch->name }}
							</td>
							<td>
								{{ $ch->description }}
							</td>
							<td>
								{{ $ch->bill_type }}
							</td>
							<td>
								{{ $ch->amount}}
							</td>
							<td>
								<button value = "{{ $ch->id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button>
								<button value = "{{ $ch->id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
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
			<div class="modal fade" id="chModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Charge</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group required">
								<label class = "control-label">Name: </label>
								<input type = "text" class = "form-control" name = "name" id = "name" minlength = "3"/>
							</div>
							<div class="form-group">
								<label class = "control-label">Description: </label>
								<textarea class = "form-control" name = "description" id = "description"></textarea>
							</div>
							<div class="form-group required">
								<label class = "control-label" >Charge Type: &nbsp;</label>
								<label class="radio-inline" id="rev"><input type="radio" name="b_type" id="b_type1" checked = "checked" value="R">Bill</label>
								<label class="radio-inline" id="exp"><input type="radio" name="b_type" id="b_type2" value="E">Refundable</label>
							</div>
							<div class="form-group" >
								<div style="display: none;">
									<label class = "control-label">Charge Type: &nbsp;</label>
									<input type="radio" name="chargeType" value="0"  checked = "checked"> Fixed
									<input type="radio" name="chargeType" value="1">Rate
									<br/>
								</div>
								<div class="form-group required">
									
									<label class = "control-label">Amount: </label>
									<div class = "form-group input-group " >
										<span class = "input-group-addon">Php</span>
										<input type = "text" class = "form-control money" name = "amount" id = "amount" data-rule-required="true" value= "0.00"/>
									</div>
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
		<div class="modal fade" id="confirm-activate" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Activate Record
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
	.class-charges{
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
	$('#billingcollapse').addClass('in');
	var data;
	var ch_id;
	var temp_name = null;
	var temp_desc = null;
	var temp_amount = null;
	var temp_chargeType = null;
	$(document).ready(function(){
		var chtable = $('#ch_table').DataTable({
			"dom": '<"toolbar">frtip',
			processing: false,
			serverSide: false,
			deferRender: true,
			columns: [
			{ data: 'name' },
			{ data: 'description' },
			{ data: 'bill_type',
			"render" : function( data, type, full ) {
				return formatWithBillType(data); }},
				
				{ data: 'amount' },
				{ data: 'action', orderable: false, searchable: false }

				],	"order": [[ 0, "desc" ]],
			});
		$("div.toolbar").html('<div class = "col-md-3"><input type = "checkbox" class = "check_deac"/>   Show Deactivated</div>');
		$('.check_deac').on('change', function(e)
		{
			e.preventDefault();
			if($(this).is(':checked')){
				chtable.ajax.url( '{{ route("ch.data") }}/1' ).load();
			}
			else{
				chtable.ajax.url( '{{ route("ch.data") }}' ).load();
			}
		})

		$(document).on('click', '.activate', function(e){
			var ch_id = $(this).val();
			data = chtable.row($(this).parents()).data();
			$('#confirm-activate').modal('show');
		});
		$('#btnActivate').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'PUT',
				url:  '/utilities/charge_reactivate/' + data.id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					chtable.ajax.reload();
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


		function formatWithBillType(e) { 

			if (e == 'R'){
				return "Bill";
			}else{
				return "Refundable";
			}

		}

		jQuery.validator.addMethod("notEqual", function(value, element, param) {
			return this.optional(element) || value != param;
		}, "This field is required");

		$("#commentForm").validate({
			rules: 
			{
				name:
				{
					required: true,
					minlength: 3,
					maxlength: 50,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},
					regex: /^[A-Za-z'-.,  ]+$/,
				},

				description:
				{
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},
					regex: /^[A-Za-z0-9'-.,  ]+$/,
				},

				amount:
				{
					required:true,

				},
			},
			onkeyup: function(element) {$(element).valid()}, 
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
			$('.modal-title').text('New Charge');
			$('#amount').val("0.00");
			$('#name').val("");
			$('#description').val("");
			$('#chModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			ch_id = $(this).val();
			data = chtable.row($(this).parents()).data();
			$('#description').val(data.description);
			$('#name').val(data.name);
			$('#amount').val(data.amount);
			temp_chargeType = data.chargeType;
			temp_name = data.name;
			temp_desc = data.description;
			temp_amount = data.amount;

			$('.modal-title').text('Update Charge');
			$('#chModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			ch_id = $(this).val();
			data = chtable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});



		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/charge/' + ch_id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					chtable.ajax.url( '{{ route("ch.data") }}' ).load();
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
			var rev = "R";
			var exp = "E";
			$('#name').valid();
			$('#description').valid();
			$('#amount').valid();

			var final_amount;
			
			final_amount = $('#amount').inputmask('unmaskedvalue');
			
			if(title == "New Charge")
			{
				var ele = document.getElementsByName('b_type');
				var i = ele.length;
				for (var j = 0; j < i; j++) 
				{
					if (ele[j].checked) 
					{
						if (document.getElementById('b_type1').checked) 
						{
							var val = document.getElementById('b_type1').value;
							console.log(val);
							if($('#name').valid() && $('#description').valid())
							{

								$('#btnSave').attr('disabled', 'true');

								$.ajax({
									type: 'POST',
									url:  '/admin/charge',
									data: {
										'_token' : $('input[name=_token]').val(),
										'name' : $('#name').val(),
										'description' : $('#description').val(),
										'amount':final_amount,
										'bill_type' : val,
										'chargeType': $('input[name=chargeType]:checked').val(),
									},
									success: function (data)
									{
										if(typeof(data) === "object"){
											chtable.ajax.url( '{{ route("ch.data") }}' ).load();
											$('#chModal').modal('hide');
											$('#name').val("");
											$('#description').val("");
											$('#amount').val("");
											$('.modal-title').text('New Charge');



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

											$('#btnSave').removeAttr('disabled');

										}
										else{
											resetErrors();
											var invdata = JSON.parse(data);
											$.each(invdata, function(i, v) {
												console.log(i + " => " + v); 
												var msg = '<label class="error" for="'+i+'">'+v+'</label>';
												$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);

												$('#btnSave').removeAttr('disabled');
											});

										}
									},

								})
							}
						}
						else if (document.getElementById('b_type2').checked) {
							var val = document.getElementById('b_type2').value;
							console.log(val);
							if($('#name').valid() && $('#description').valid()){

								$('#btnSave').attr('disabled', 'true');

								$.ajax({
									type: 'POST',
									url:  '/admin/charge',
									data: {
										'_token' : $('input[name=_token]').val(),
										'name' : $('#name').val(),
										'description' : $('#description').val(),
										'amount':final_amount,
										'bill_type' : val,
										'chargeType': $('input[name=chargeType]:checked').val(),
									},
									success: function (data)
									{
										if(typeof(data) === "object"){
											chtable.ajax.url( '{{ route("ch.data") }}' ).load();
											$('#chModal').modal('hide');
											$('#name').val("");
											$('#description').val("");
											$('#amount').val("");
											$('.modal-title').text('New Charge');



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

											$('#btnSave').removeAttr('disabled');

										}
										else{
											resetErrors();
											var invdata = JSON.parse(data);
											$.each(invdata, function(i, v) {
												console.log(i + " => " + v); 
												var msg = '<label class="error" for="'+i+'">'+v+'</label>';
												$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);

												$('#btnSave').removeAttr('disabled');
											});

										}
									},

								})
							}

						}
					}
				}
			}
			else
			{
				if($('#name').valid() && $('#description').valid())
				{
					if($('#name').val() == temp_name && $('#description').val() == temp_desc && final_amount == temp_amount  )
					{
						console.log("yey");
						$('#name').val("");
						$('#description').val("");
						$('#amount').val("0.00");
						$('#btnSave').removeAttr('disabled');
						$('#chModal').modal('hide');
					}
					else
					{
						$('#btnSave').attr('disabled', 'true');
						type_bill = null;

						$.ajax({
							type: 'PUT',
							url:  '/admin/charge/' + ch_id,
							data: {
								'_token' : $('input[name=_token]').val(),
								'name' : $('#name').val(),
								'description' : $('#description').val(),
								'amount':final_amount,
								'bill_type' :$('input[name=b_type]:checked').val(),
								'chargeType': $('input[name=chargeType]:checked').val(),
							},
							success: function (data)
							{
								if(typeof(data) === "object"){
									chtable.ajax.url( '{{ route("ch.data") }}' ).load();
									$('#chModal').modal('hide');
									$('#name').val("");
									$('#description').val("");
									$('#amount').val("");
									$('.modal-title').text('New Charge');



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

								}
								else{
									resetErrors();
									var invdata = JSON.parse(data);
									$.each(invdata, function(i, v) {
										console.log(i + " => " + v); 
										var msg = '<label class="error" for="'+i+'">'+v+'</label>';
										$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);

										$('#btnSave').removeAttr('disabled');
									});

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